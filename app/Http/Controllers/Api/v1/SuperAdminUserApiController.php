<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use function Symfony\Component\Clock\now;

class SuperAdminUserApiController extends BaseController
{
    /**
     * Get all admin users via API (for DataTables)
     */
    public function index(Request $request)
    {
        try {
            $query = User::where('user_type', 'admin')
                         ->where('is_deleted', 0);

            // Search functionality
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('full_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('mobile', 'like', "%{$search}%");
                });
            }

            // Filter by status (is_active)
            if ($request->has('is_active') && $request->is_active != '') {
                $statusValues = explode(',', $request->is_active);
                // Convert string values to integers (1 for active, 0 for inactive)
                $statusValues = array_map('intval', array_filter($statusValues, function($v) {
                    return $v !== '';
                }));
                
                if (!empty($statusValues)) {
                    $query->whereIn('is_active', $statusValues);
                }
            }

            // Filter by date range (created_at)
            if ($request->has('date_range') && $request->date_range != '') {
                $dateRange = $request->date_range;
                
                // Parse date range format: "YYYY-MM-DD to YYYY-MM-DD"
                if (strpos($dateRange, ' to ') !== false) {
                    list($startDate, $endDate) = explode(' to ', $dateRange);
                    $startDate = trim($startDate);
                    $endDate = trim($endDate);
                    
                    // Add end of day time to endDate for inclusive filtering
                    $query->whereBetween('created_at', [
                        $startDate . ' 00:00:00',
                        $endDate . ' 23:59:59'
                    ]);
                }
            }

            // Sorting
            $sortColumn = $request->get('sort', 'created_at');
            $sortOrder = $request->get('order', 'desc');
            $query->orderBy($sortColumn, $sortOrder);

            // Pagination
            $perPage = $request->get('per_page', 10);
            $users = $query->paginate($perPage);

            $data = [
                'data' => $users->items(),
                'total' => $users->total(),
                'per_page' => $users->perPage(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
            ];

            return $this->sendResponse($data, 'Users retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve users: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'email' => 'required|email|unique:users,email',
                'mobile' => 'required|string|max:20',
                'password' => 'required|string|min:6|confirmed',
                'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle file upload
            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('profile_images', $filename, 'public');
                $validated['profile'] = 'profile_images/' . $filename;
            }

            // Generate unique user code
            $validated['user_code'] = 'USR-' . strtoupper(uniqid());
            
            $validated['password'] = bcrypt($validated['password']);
            $validated['user_type'] = 'admin';
            $validated['is_active'] = 1;
            
            // Generate full name
            $validated['full_name'] = trim(
                $validated['first_name'] . ' ' .
                ($validated['middle_name'] ?? '') . ' ' .
                $validated['last_name']
            );

            $user = User::create($validated);

            return $this->sendResponse($user, 'User created successfully', 201);
        } catch (\Exception $e) {
            return $this->sendError('Failed to create user: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Display the specified user
     */
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return $this->sendResponse($user, 'User retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('User not found', 404);
        }
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        try {
            \Log::info('Update user request', [
                'id' => $id,
                'method' => $request->method(),
                'path' => $request->path(),
                'all_data' => $request->all()
            ]);
            
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'mobile' => 'required|string|max:20',
                'password' => 'nullable|string|min:6|confirmed',
                'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'nullable|boolean',
            ]);

            // Handle file upload
            if ($request->hasFile('profile')) {
                // Delete old image if exists
                if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                    Storage::disk('public')->delete($user->profile);
                }

                $file = $request->file('profile');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('profile_images', $filename, 'public');
                $validated['profile'] = 'profile_images/' . $filename;
            }

            // Only update password if provided
            if ($request->filled('password')) {
                $validated['password'] = bcrypt($validated['password']);
            } else {
                unset($validated['password']);
            }

            // Update full name
            $validated['full_name'] = trim(
                $validated['first_name'] . ' ' .
                ($validated['middle_name'] ?? '') . ' ' .
                $validated['last_name']
            );

            $user->update($validated);

            return $this->sendResponse($user, 'User updated successfully', 200);
        } catch (\Exception $e) {
            \Log::error('Update user error: ' . $e->getMessage(), [
                'id' => $id ?? 'unknown',
                'exception' => $e
            ]);
            return $this->sendError('Failed to update user: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Delete the specified user (soft delete)
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Soft delete
            $user->is_deleted = 1;
            $user->deleted_at = now();
            
            // Get authenticated user ID from session or auth guard
            $auth = Session::get('user');
            if ($auth && isset($auth->id)) {
                $user->deleted_by = $auth->id;
            } else {
                // Fallback: try to get from auth guard
                $user->deleted_by = auth()->id() ?? null;
            }
            
            $user->save();

            return $this->sendResponse(null, 'User deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete user: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Bulk delete multiple users (soft delete)
     */
    public function bulkDestroy(Request $request)
    {
        try {
            \Log::info('Bulk delete request received', [
                'path' => $request->path(),
                'method' => $request->method(),
                'all_data' => $request->all(),
                'ids_input' => $request->input('ids', [])
            ]);
            
            $ids = $request->input('ids', []);
            
            if (empty($ids) || !is_array($ids)) {
                return $this->sendError('No IDs provided', 400);
            }
            
            // Get authenticated user ID from session or auth guard
            $deletedBy = null;
            $auth = Session::get('user');
            if ($auth && isset($auth->id)) {
                $deletedBy = $auth->id;
            } else {
                $deletedBy = auth()->id() ?? null;
            }
            
            // Soft delete multiple users
            $count = User::whereIn('id', $ids)
                        ->where('user_type', 'admin')
                        ->where('is_deleted', 0)
                        ->update([
                            'is_deleted' => 1,
                            'deleted_at' => now(),
                            'deleted_by' => $deletedBy
                        ]);
            
            return $this->sendResponse(null, "$count users deleted successfully", 200);
        } catch (\Exception $e) {
            \Log::error('Bulk delete error: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return $this->sendError('Failed to delete users: ' . $e->getMessage(), 400);
        }
    }
}
