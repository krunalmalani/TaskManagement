<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\UserCompany;
use Illuminate\Support\Facades\Auth;

class AdminCompanyApiController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized',
                    'data' => null
                ], 401);
            }

            // Get pagination parameters
            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            $search = $request->get('search', '');
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');

            // Get companies through user_company relationship
            $query = Company::whereHas('userCompanies', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('is_deleted', 0);

            // Apply search filter
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            }

            // Apply status filter
            if ($request->has('is_active')) {
                $query->where('is_active', $request->get('is_active'));
            }

            // Apply sorting
            $query->orderBy($sortBy, strtoupper($sortOrder));

            // Get paginated results
            $companies = $query->paginate($perPage, ['*'], 'page', $page);

            $data = [
                'data' => $companies->items(),
                'total' => $companies->total(),
                'per_page' => $companies->perPage(),
                'current_page' => $companies->currentPage(),
                'last_page' => $companies->lastPage(),
            ];

            return response()->json([
                'status' => true,
                'message' => 'Companies retrieved successfully',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Index companies error: ' . $e->getMessage(), ['exception' => $e]);
            return $this->sendError('Failed to retrieve companies: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Get a specific company
     */
    public function show($id)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return $this->sendError('Unauthorized', 401);
            }

            $company = Company::whereHas('userCompanies', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->firstOrFail();

            return $this->sendResponse($company, 'Company retrieved successfully', 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::warning('Company not found', ['id' => $id, 'user_id' => Auth::id()]);
            return $this->sendError('Company not found', 404);
        } catch (\Exception $e) {
            \Log::error('Show company error: ' . $e->getMessage(), ['id' => $id, 'exception' => $e]);
            return $this->sendError('Failed to retrieve company: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Store a new company
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return $this->sendError('Unauthorized', 401);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'nullable|string|max:50|unique:companies,code',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'website' => 'nullable|string|max:255',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'country' => 'nullable|string|max:100',
                'zip_code' => 'nullable|string|max:20',
                'tax_id' => 'nullable|string|max:100',
                'registration_number' => 'nullable|string|max:100',
                'registration_date' => 'nullable|date',
                'description' => 'nullable|string',
                'is_active' => 'nullable|in:0,1'
            ]);

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('companies', $filename, 'public');
                $validated['logo'] = 'companies/' . $filename;
            }

            // Generate unique company code if not provided
            if (empty($validated['code'])) {
                $validated['code'] = 'COM-' . strtoupper(uniqid());
            }

            $validated['created_by'] = $user->id;
            $validated['is_active'] = isset($validated['is_active']) && $validated['is_active'] ? 1 : 0;

            $company = Company::create($validated);

            // Associate company with user
            UserCompany::create([
                'user_id' => $user->id,
                'company_id' => $company->id
            ]);

            return $this->sendResponse($company, 'Company created successfully', 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Store validation error', ['errors' => $e->errors()]);
            return $this->sendError('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->sendError('Failed to create company: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Update a company
     */
    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return $this->sendError('Unauthorized', 401);
            }

            $company = Company::whereHas('userCompanies', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->firstOrFail();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:50|unique:companies,code,' . $id,
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'website' => 'nullable|string|max:255',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'country' => 'nullable|string|max:100',
                'zip_code' => 'nullable|string|max:20',
                'tax_id' => 'nullable|string|max:100',
                'registration_number' => 'nullable|string|max:100',
                'registration_date' => 'nullable|date',
                'description' => 'nullable|string',
                'is_active' => 'nullable|in:0,1'
            ]);

            // Handle logo upload
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($company->logo && \Storage::disk('public')->exists($company->logo)) {
                    \Storage::disk('public')->delete($company->logo);
                }

                $file = $request->file('logo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('companies', $filename, 'public');
                $validated['logo'] = 'companies/' . $filename;
            }

            $validated['updated_by'] = $user->id;
            $validated['is_active'] = isset($validated['is_active']) && $validated['is_active'] ? 1 : 0;

            $company->update($validated);

            return $this->sendResponse($company, 'Company updated successfully', 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::warning('Company not found for update', ['id' => $id, 'user_id' => Auth::id()]);
            return $this->sendError('Company not found', 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Update validation error', ['id' => $id, 'errors' => $e->errors()]);
            return $this->sendError('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            \Log::error('Update company error: ' . $e->getMessage(), [
                'id' => $id ?? 'unknown',
                'user_id' => Auth::id(),
                'exception' => $e
            ]);
            return $this->sendError('Failed to update company: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Delete a company (soft delete)
     */
    public function destroy($id)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return $this->sendError('Unauthorized', 401);
            }

            $company = Company::whereHas('userCompanies', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->firstOrFail();

            // Soft delete
            $company->update([
                'is_deleted' => 1,
                'deleted_at' => now(),
                'deleted_by' => $user->id
            ]);

            return $this->sendResponse(null, 'Company deleted successfully', 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::warning('Company not found for delete', ['id' => $id, 'user_id' => Auth::id()]);
            return $this->sendError('Company not found', 404);
        } catch (\Exception $e) {
            \Log::error('Delete company error: ' . $e->getMessage(), ['id' => $id, 'exception' => $e]);
            return $this->sendError('Failed to delete company: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Bulk delete companies
     */
    public function bulkDestroy(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return $this->sendError('Unauthorized', 401);
            }

            $ids = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'required|integer'
            ])['ids'];

            $companies = Company::whereHas('userCompanies', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->whereIn('id', $ids)
            ->where('is_deleted', 0)
            ->get();

            if ($companies->isEmpty()) {
                return $this->sendError('No companies found to delete', 404);
            }

            $companies->each(function ($company) use ($user) {
                $company->update([
                    'is_deleted' => 1,
                    'deleted_at' => now(),
                    'deleted_by' => $user->id
                ]);
            });

            return $this->sendResponse([
                'deleted_count' => $companies->count()
            ], 'Companies deleted successfully', 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Bulk delete validation error', ['errors' => $e->errors()]);
            return $this->sendError('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            \Log::error('Bulk delete companies error: ' . $e->getMessage(), ['user_id' => Auth::id(), 'exception' => $e]);
            return $this->sendError('Failed to delete companies: ' . $e->getMessage(), 400);
        }
    }
}
