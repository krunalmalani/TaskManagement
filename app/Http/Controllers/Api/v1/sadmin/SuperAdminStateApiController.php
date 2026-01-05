<?php

namespace App\Http\Controllers\Api\V1\sadmin;
use App\Http\Controllers\Api\V1\BaseController;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Facades\Session;

class SuperAdminStateApiController extends BaseController
{
    /**
     * Get all states via API (for DataTables)
     */
    public function index(Request $request)
    {
        try {
            $query = State::where('is_deleted', 0)->with('country');

            // Search functionality
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
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
            if ($request->has('country_id') && $request->country_id != '') {
                $query->where('country_id', $request->country_id);
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
            $states = $query->paginate($perPage);

            $data = [
                'data' => $states->items(),
                'total' => $states->total(),
                'per_page' => $states->perPage(),
                'current_page' => $states->currentPage(),
                'last_page' => $states->lastPage(),
            ];

            return $this->sendResponse($data, 'States retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve states: ' . $e->getMessage(), 400);
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
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('states', 'name')
                        ->where('country_id', $request->country_id)
                        ->where('is_deleted', 0)
                ],
                'is_active' => 'sometimes|in:0,1',
            ]);

            // Set is_active default to 1 if not provided
            if (!isset($validated['is_active'])) {
                $validated['is_active'] = 1;
            } else {
                $validated['is_active'] = (int) $validated['is_active'];
            }
            
            // Get authenticated user ID
            $auth = Session::get('user');
            if ($auth && isset($auth->id)) {
                $validated['created_by'] = $auth->id;
            } else {
                $validated['created_by'] = auth()->id() ?? null;
            }

            $state = State::create($validated);
            $state->load('country');

            return $this->sendResponse($state, 'State created successfully', 201);
        } catch (\Exception $e) {
            return $this->sendError('Failed to create state: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Display the specified state
     */
    public function show($id)
    {
        try {
            $state = State::where('is_deleted', 0)->with('country')->findOrFail($id);
            return $this->sendResponse($state, 'State retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('State not found', 404);
        }
    }

    /**
     * Update the specified state
     */
    public function update(Request $request, $id)
    {

        try {
            // Only update non-deleted states
            $state = State::where('is_deleted', 0)->findOrFail($id);

            $validated = $request->validate([
                'country_id' => 'required|exists:countries,id,is_deleted,0',
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('states', 'name')
                        ->ignore($id, 'id')
                        ->where('country_id', $request->country_id)
                        ->where('is_deleted', 0)
                ],
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

            $state->update($validated);
            $state->load('country');

            return $this->sendResponse($state, 'State updated successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to update state: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Delete the specified state (soft delete)
     */
    public function destroy($id)
    {
        try {
            $state = State::where('is_deleted', 0)->findOrFail($id);

            // Soft delete
            $state->is_deleted = 1;
            $state->deleted_at = now();
            
            // Get authenticated user ID from session or auth guard
            $auth = Session::get('user');
            if ($auth && isset($auth->id)) {
                $state->deleted_by = $auth->id;
            } else {
                $state->deleted_by = auth()->id() ?? null;
            }
            
            $state->save();

            return $this->sendResponse(null, 'State deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete state: ' . $e->getMessage(), 400);
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
            $count = State::where('is_deleted', 0)->whereIn('id', $ids)
                        ->update([
                            'is_deleted' => 1,
                            'deleted_at' => now(),
                            'deleted_by' => $deletedBy,
                        ]);
            
            return $this->sendResponse(null, "$count states deleted successfully", 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete states: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Get all countries for dropdown (GET countries)
     */
    public function getCountries()
    {
        try {
            $countries = Country::where('is_deleted', 0)
                ->where('is_active', 1)
                ->orderBy('name', 'asc')
                ->select('id', 'name')
                ->get();

            return $this->sendResponse($countries, 'Countries retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve countries: ' . $e->getMessage(), 400);
        }
    }
}
