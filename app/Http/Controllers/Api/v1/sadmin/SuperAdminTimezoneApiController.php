<?php

namespace App\Http\Controllers\Api\V1\sadmin;

use App\Http\Controllers\Api\V1\BaseController;
use Illuminate\Http\Request;
use App\Models\Timezone;
use App\Models\Country;
use Illuminate\Support\Facades\Session;

class SuperAdminTimezoneApiController extends BaseController
{
    /**
     * Get all timezones via API (for DataTables)
     */
    public function index(Request $request)
    {
        try {
            $query = Timezone::where('is_deleted', 0)->with('country');

            // Search functionality
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('timezone', 'like', "%{$search}%")
                      ->orWhere('utc', 'like', "%{$search}%");
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

            // Filter by country_id
            if ($request->has('country_id') && $request->country_id != '') {
                $query->where('country_id', $request->country_id);
            }



            // Sorting
            $sortColumn = $request->get('sort', 'created_at');
            $sortOrder = $request->get('order', 'desc');
            $query->orderBy($sortColumn, $sortOrder);

            // Pagination
            $perPage = $request->get('per_page', 10);
            $timezones = $query->paginate($perPage);

            $data = [
                'data' => $timezones->items(),
                'total' => $timezones->total(),
                'per_page' => $timezones->perPage(),
                'current_page' => $timezones->currentPage(),
                'last_page' => $timezones->lastPage(),
            ];

            return $this->sendResponse($data, 'Timezones retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve timezones: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created timezone
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:timezones,name,NULL,id,is_deleted,0',
                'timezone' => 'required|string|max:255|unique:timezones,timezone,NULL,id,is_deleted,0',
                'country_id' => 'required|exists:countries,id,is_deleted,0',
                'utc' => 'nullable|string|max:50',
            ]);

            $validated['is_active'] = $request->input('is_active', 1) ? 1 : 0;

            
            // Get authenticated user ID
            $auth = Session::get('user');
            if ($auth && isset($auth->id)) {
                $validated['created_by'] = $auth->id;
            } else {
                $validated['created_by'] = auth()->id() ?? null;
            }

            $timezone = Timezone::create($validated);
            $timezone->load('country');

            return $this->sendResponse($timezone, 'Timezone created successfully', 201);
        } catch (\Exception $e) {
            return $this->sendError('Failed to create timezone: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Display the specified timezone
     */
    public function show($id)
    {
        try {
            $timezone = Timezone::where('is_deleted', 0)->with('country')->findOrFail($id);
            return $this->sendResponse($timezone, 'Timezone retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Timezone not found', 404);
        }
    }

    /**
     * Update the specified timezone
     */
    public function update(Request $request, $id)
    {
        try {
            // Only update non-deleted timezones
            $timezone = Timezone::where('is_deleted', 0)->findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:timezones,name,' . $id,
                'timezone' => 'required|string|max:255|unique:timezones,timezone,' . $id,
                'country_id' => 'required|exists:countries,id,is_deleted,0',
                'utc' => 'nullable|string|max:50',
                'is_active' => 'required|in:0,1',
            ]);

            // Convert string values to integers
            $validated['is_active'] = (int) $validated['is_active'];

            // Get authenticated user ID from session or auth guard
            $userId = null;
            $auth = Session::get('user');
            if ($auth && isset($auth->id)) {
                $userId = $auth->id;
            } else {
                $userId = auth()->id() ?? null;
            }

            $validated['updated_by'] = $userId;

            $timezone->update($validated);
            $timezone->load('country');

            return $this->sendResponse($timezone, 'Timezone updated successfully', 200);
        } catch (\Exception $e) {
            \Log::error('Update timezone error: ' . $e->getMessage(), [
                'id' => $id ?? 'unknown',
                'exception' => $e
            ]);
            return $this->sendError('Failed to update timezone: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Delete the specified timezone (soft delete)
     */
    public function destroy($id)
    {
        try {
            $timezone = Timezone::where('is_deleted', 0)->findOrFail($id);

            // Soft delete
            $timezone->is_deleted = 1;
            $timezone->deleted_at = now();
            
            // Get authenticated user ID from session or auth guard
            $auth = Session::get('user');
            if ($auth && isset($auth->id)) {
                $timezone->deleted_by = $auth->id;
            } else {
                $timezone->deleted_by = auth()->id() ?? null;
            }
            
            $timezone->save();

            return $this->sendResponse(null, 'Timezone deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete timezone: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Bulk delete multiple timezones (soft delete)
     */
    public function bulkDestroy(Request $request)
    {
        try {
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
            
            // Soft delete multiple timezones
            $count = Timezone::whereIn('id', $ids)
                        ->where('is_deleted', 0)
                        ->update([
                            'is_deleted' => 1,
                            'deleted_at' => now(),
                            'deleted_by' => $deletedBy
                        ]);
            
            return $this->sendResponse(null, "$count timezones deleted successfully", 200);
        } catch (\Exception $e) {
            \Log::error('Bulk delete error: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return $this->sendError('Failed to delete timezones: ' . $e->getMessage(), 400);
        }
    }

   
}
