<?php

namespace App\Http\Controllers\Api\V1\sadmin;
use App\Http\Controllers\Api\V1\BaseController;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Language;
use Illuminate\Support\Facades\Session;

class SuperAdminLanguageApiController extends BaseController
{
    /**
     * Get all languages via API (for DataTables)
     */
    public function index(Request $request)
    {
        try {
            $query = Language::where('is_deleted', 0);

            // Search functionality
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
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
            $languages = $query->paginate($perPage);

            $data = [
                'data' => $languages->items(),
                'total' => $languages->total(),
                'per_page' => $languages->perPage(),
                'current_page' => $languages->currentPage(),
                'last_page' => $languages->lastPage(),
            ];

            return $this->sendResponse($data, 'Languages retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve languages: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created language
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('languages', 'name')->where('is_deleted', 0)
                ],
                'short_name' => [
                    'required',
                    'string',
                    'max:2',
                    Rule::unique('languages', 'short_name')->where('is_deleted', 0)
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

            $language = Language::create($validated);

            return $this->sendResponse($language, 'Language created successfully', 201);
        } catch (\Exception $e) {
            return $this->sendError('Failed to create language: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Display the specified language
     */
    public function show($id)
    {
        try {
            $language = Language::where('is_deleted', 0)->findOrFail($id);
            return $this->sendResponse($language, 'Language retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Language not found', 404);
        }
    }

    /**
     * Update the specified language
     */
    public function update(Request $request, $id)
    {
        try {
            // Only update non-deleted languages
            $language = Language::where('is_deleted', 0)->findOrFail($id);

            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('languages', 'name')
                        ->ignore($id, 'id')
                        ->where('is_deleted', 0)
                ],
                'short_name' => [
                    'required',
                    'string',
                    'max:2',
                    Rule::unique('languages', 'short_name')
                        ->ignore($id, 'id')
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

            $language->update($validated);

            return $this->sendResponse($language, 'Language updated successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to update language: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Delete the specified language (soft delete)
     */
    public function destroy($id)
    {
        try {
            $language = Language::where('is_deleted', 0)->findOrFail($id);

            // Soft delete
            $language->is_deleted = 1;
            $language->deleted_at = now();
            
            // Get authenticated user ID from session or auth guard
            $auth = Session::get('user');
            if ($auth && isset($auth->id)) {
                $language->deleted_by = $auth->id;
            } else {
                $language->deleted_by = auth()->id() ?? null;
            }
            
            $language->save();

            return $this->sendResponse(null, 'Language deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete language: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Bulk delete multiple languages (soft delete)
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
            
            // Soft delete multiple languages (only non-deleted records)
            $count = Language::where('is_deleted', 0)->whereIn('id', $ids)
                        ->update([
                            'is_deleted' => 1,
                            'deleted_at' => now(),
                            'deleted_by' => $deletedBy,
                        ]);
            
            return $this->sendResponse(null, "$count languages deleted successfully", 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete languages: ' . $e->getMessage(), 400);
        }
    }
}
