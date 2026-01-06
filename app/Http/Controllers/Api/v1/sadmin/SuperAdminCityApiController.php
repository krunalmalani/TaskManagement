<?php

namespace App\Http\Controllers\Api\V1\sadmin;
use App\Http\Controllers\Api\V1\BaseController;

use App\Models\City;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Facades\Session;

class SuperAdminCityApiController extends BaseController
{
    /**
     * Get all states via API (for DataTables)
     */
    public function index(Request $request)
    {
        try {
            $query = City::where('is_deleted', 0)->with('state', 'country');

            // Search functionality
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhereHas('state', function($stateQuery) use ($search) {
                          $stateQuery->where('name', 'like', '%' . $search . '%');
                      })
                      ->orWhereHas('country', function($countryQuery) use ($search) {
                          $countryQuery->where('name', 'like', '%' . $search . '%');
                      });
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

            // Filter by country
            if ($request->has('state_id') && $request->state_id != '') {
                $query->where('state_id', $request->state_id);
            }

            // Sorting
            $sortColumn = $request->get('sort', 'created_at');
            $sortOrder = $request->get('order', 'desc');
            $query->orderBy($sortColumn, $sortOrder);

            // Pagination
            $perPage = $request->get('per_page', 10);
            $cities = $query->paginate($perPage);

            $data = [
                'data' => $cities->items(),
                'total' => $cities->total(),
                'per_page' => $cities->perPage(),
                'current_page' => $cities->currentPage(),
                'last_page' => $cities->lastPage(),
            ];

            return $this->sendResponse($data, 'Cities retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve cities: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created state
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'country_id' => 'required|exists:countries,id,is_deleted,0',
                'state_id' => 'required|exists:states,id,is_deleted,0',
                'name' => 'required|string|max:255|unique:cities,name,NULL,id,state_id,' . $request->state_id . ',is_deleted,0',
            ]);

            $validated['is_active'] = $request->input('is_active', 1) ? 1 : 0;
            
            // Get authenticated user ID
            $auth = Session::get('user');
            if ($auth && isset($auth->id)) {
                $validated['created_by'] = $auth->id;
            } else {
                $validated['created_by'] = auth()->id() ?? null;
            }

            $city = City::create($validated);
            $city->load('state');

            return $this->sendResponse($city, 'City created successfully', 201);
        } catch (\Exception $e) {
            return $this->sendError('Failed to create city: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Display the specified city
     */
    public function show($id)
    {
        try {
            $city = City::where('is_deleted', 0)->with('state')->findOrFail($id);
            return $this->sendResponse($city, 'City retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('City not found', 404);
        }
    }

    /**
     * Update the specified state
     */
    public function update(Request $request, $id)
    {
        try {
            // Only update non-deleted states
            $city = City::where('is_deleted', 0)->findOrFail($id);

            $validated = $request->validate([
                'country_id' => 'required|exists:countries,id,is_deleted,0',
                'state_id' => 'required|exists:states,id,is_deleted,0',
                'name' => 'required|string|max:255|unique:cities,name,' . $id . ',id,state_id,' . $request->state_id . ',is_deleted,0',
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

            $city->update($validated);
            $city->load('state');

            return $this->sendResponse($city, 'City updated successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to update city: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Delete the specified state (soft delete)
     */
    public function destroy($id)
    {
        try {
            $city = City::where('is_deleted', 0)->findOrFail($id);

            // Soft delete
            $city->is_deleted = 1;
            $city->deleted_at = now();
            
            // Get authenticated user ID from session or auth guard
            $auth = Session::get('user');
            if ($auth && isset($auth->id)) {
                $city->deleted_by = $auth->id;
            } else {
                $city->deleted_by = auth()->id() ?? null;
            }
            
            $city->save();

            return $this->sendResponse(null, 'City deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete city: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Bulk delete multiple states (soft delete)
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
            
            // Soft delete multiple states (only non-deleted records)
            $count = City::where('is_deleted', 0)->whereIn('id', $ids)
                        ->update([
                            'is_deleted' => 1,
                            'deleted_at' => now(),
                            'deleted_by' => $deletedBy,
                        ]);
            
            return $this->sendResponse(null, "$count cities deleted successfully", 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete cities: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Get all countries for dropdown (GET states)
     */
    public function getStates()
    {
        try {
            $states = State::where('is_deleted', 0)
                ->where('is_active', 1)
                ->orderBy('name', 'asc')
                ->select('id', 'name')
                ->get();

            return $this->sendResponse($states, 'States retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve states: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Get all states by country (for dependent dropdown)
     */
    public function getStatesByCountry($country_id)
    {
        try {
            $states = State::where('is_deleted', 0)
                ->where('is_active', 1)
                ->where('country_id', $country_id)
                ->orderBy('name', 'asc')
                ->select('id', 'name')
                ->get();

            return $this->sendResponse($states, 'States retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve states: ' . $e->getMessage(), 400);
        }
    }
}
