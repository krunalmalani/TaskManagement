<?php

namespace App\Http\Controllers\Api\V1\sadmin;

use App\Http\Controllers\Api\V1\BaseController;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Session;

class SuperAdminCountryApiController extends BaseController
{
    /**
     * Get all countries via API (for DataTables)
     */
    public function index(Request $request)
    {
        try {
            $query = Country::where('is_deleted', 0);

            // Search functionality
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('code', 'like', '%' . $search . '%')
                      ->orWhere('short_name', 'like', '%' . $search . '%');
                });
            }

            // Filter by status (is_active)
            if ($request->has('is_active') && $request->is_active != '') {
                $statusValues = explode(',', $request->is_active);
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
                
                if (strpos($dateRange, ' to ') !== false) {
                    [$startDate, $endDate] = explode(' to ', $dateRange);
                    $startDate = trim($startDate);
                    $endDate = trim($endDate);
                    
                    $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
                }
            }

            // Sorting
            $sortColumn = $request->get('sort', 'created_at');
            $sortOrder = $request->get('order', 'desc');
            $query->orderBy($sortColumn, $sortOrder);

            // Pagination
            $perPage = $request->get('per_page', 10);
            $countries = $query->paginate($perPage);

            $data = [
                'data' => $countries->items(),
                'total' => $countries->total(),
                'per_page' => $countries->perPage(),
                'current_page' => $countries->currentPage(),
                'last_page' => $countries->lastPage(),
            ];

            return $this->sendResponse($data, 'Countries retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve countries: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created country
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:10|unique:countries,code,NULL,id,is_deleted,0',
                'short_name' => 'nullable|string|max:10',
            ]);

            $validated['is_active'] = 1;
            
            // Get authenticated user ID
            $auth = Session::get('user');
            if ($auth && isset($auth->id)) {
                $validated['created_by'] = $auth->id;
            } else {
                $validated['created_by'] = auth()->id() ?? null;
            }

            $country = Country::create($validated);

            return $this->sendResponse($country, 'Country created successfully', 201);
        } catch (\Exception $e) {
            return $this->sendError('Failed to create country: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Display the specified country
     */
    public function show($id)
    {
        try {
            $country = Country::where('is_deleted', 0)->findOrFail($id);
            return $this->sendResponse($country, 'Country retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Country not found', 404);
        }
    }

    /**
     * Update the specified country
     */
    public function update(Request $request, $id)
    {
        try {
            // Only update non-deleted countries
            $country = Country::where('is_deleted', 0)->findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:10|unique:countries,code,' . $id . ',id,is_deleted,0',
                'short_name' => 'nullable|string|max:10',
                'is_active' => 'required|in:0,1',
            ]);

            // Convert string values to integers
            $validated['is_active'] = (int) $validated['is_active'];

            // Get authenticated user ID
            $auth = Session::get('user');
            if ($auth && isset($auth->id)) {
                $validated['updated_by'] = $auth->id;
            } else {
                $validated['updated_by'] = auth()->id() ?? null;
            }

            $country->update($validated);

            return $this->sendResponse($country, 'Country updated successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to update country: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Delete the specified country (soft delete)
     */
    public function destroy($id)
    {
        try {
            $country = Country::where('is_deleted', 0)->findOrFail($id);

            // Soft delete
            $country->is_deleted = 1;
            $country->deleted_at = now();
            
            // Get authenticated user ID from session or auth guard
            $auth = Session::get('user');
            if ($auth && isset($auth->id)) {
                $country->deleted_by = $auth->id;
            } else {
                $country->deleted_by = auth()->id() ?? null;
            }
            
            $country->save();

            return $this->sendResponse(null, 'Country deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete country: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Bulk delete multiple countries (soft delete)
     */
    public function bulkDestroy(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            
            if (empty($ids) || !is_array($ids)) {
                return $this->sendError('No IDs provided', 400);
            }
            
            // Get authenticated user ID
            $deletedBy = null;
            $auth = Session::get('user');
            if ($auth && isset($auth->id)) {
                $deletedBy = $auth->id;
            } else {
                $deletedBy = auth()->id() ?? null;
            }
            
            // Soft delete multiple countries (only non-deleted records)
            $count = Country::where('is_deleted', 0)->whereIn('id', $ids)
                        ->update([
                            'is_deleted' => 1,
                            'deleted_at' => now(),
                            'deleted_by' => $deletedBy,
                        ]);
            
            return $this->sendResponse(null, "$count countries deleted successfully", 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete countries: ' . $e->getMessage(), 400);
        }
    }
}
