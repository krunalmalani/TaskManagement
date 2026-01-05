<?php

namespace App\Http\Controllers\Api\V1\sadmin;
use App\Http\Controllers\Api\V1\BaseController;

use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\Country;
use Illuminate\Support\Facades\Session;

class SuperAdminCurrencyApiController extends BaseController
{
    /**
     * Get all currencies via API (for DataTables)
     */
    public function index(Request $request)
    {
        try {
            $query = Currency::where('is_deleted', 0)->with('country');

            // Search functionality
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('code', 'like', '%' . $search . '%')
                      ->orWhere('symbol', 'like', '%' . $search . '%')
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
            $currencies = $query->paginate($perPage);

            $data = [
                'data' => $currencies->items(),
                'total' => $currencies->total(),
                'per_page' => $currencies->perPage(),
                'current_page' => $currencies->currentPage(),
                'last_page' => $currencies->lastPage(),
            ];

            return $this->sendResponse($data, 'Currencies retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve currencies: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created currency
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'country_id' => 'required|exists:countries,id,is_deleted,0',
                'name' => 'required|string|max:255|unique:currencies,name,NULL,id,country_id,' . $request->country_id . ',is_deleted,0',
                'code' => 'required|string|max:30',
                'symbol' => 'required|string|max:30',
            ]);

            $validated['is_active'] = 1;
            
            // Get authenticated user ID
            $auth = Session::get('user');
            if ($auth && isset($auth->id)) {
                $validated['created_by'] = $auth->id;
            } else {
                $validated['created_by'] = auth()->id() ?? null;
            }

            $currency = Currency::create($validated);
            $currency->load('country');

            return $this->sendResponse($currency, 'Currency created successfully', 201);
        } catch (\Exception $e) {
            return $this->sendError('Failed to create currency: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Display the specified currency
     */
    public function show($id)
    {
        try {
            $currency = Currency::where('is_deleted', 0)->with('country')->findOrFail($id);
            return $this->sendResponse($currency, 'Currency retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Currency not found', 404);
        }
    }

    /**
     * Update the specified currency
     */
    public function update(Request $request, $id)
    {
        try {
            // Only update non-deleted currencies
            $currency = Currency::where('is_deleted', 0)->findOrFail($id);

            $validated = $request->validate([
                'country_id' => 'required|exists:countries,id,is_deleted,0',
                'name' => 'required|string|max:255|unique:currencies,name,' . $id . ',id,country_id,' . $request->country_id . ',is_deleted,0',
                'code' => 'required|string|max:30',
                'symbol' => 'required|string|max:30',
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

            $currency->update($validated);
            $currency->load('country');

            return $this->sendResponse($currency, 'Currency updated successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to update currency: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Delete the specified currency (soft delete)
     */
    public function destroy($id)
    {
        try {
            $currency = Currency::where('is_deleted', 0)->findOrFail($id);

            // Soft delete
            $currency->is_deleted = 1;
            $currency->deleted_at = now();
            
            // Get authenticated user ID from session or auth guard
            $auth = Session::get('user');
            if ($auth && isset($auth->id)) {
                $currency->deleted_by = $auth->id;
            } else {
                $currency->deleted_by = auth()->id() ?? null;
            }
            
            $currency->save();

            return $this->sendResponse(null, 'Currency deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete currency: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Bulk delete multiple currencies (soft delete)
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
            
            // Soft delete multiple currencies (only non-deleted records)
            $count = Currency::where('is_deleted', 0)->whereIn('id', $ids)
                        ->update([
                            'is_deleted' => 1,
                            'deleted_at' => now(),
                            'deleted_by' => $deletedBy,
                        ]);
            
            return $this->sendResponse(null, "$count currencies deleted successfully", 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete currencies: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Get all countries for dropdown
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
