<?php 
    $userData = Session::get('user');
?>
@extends('layouts.master', ['title' => 'Manage Users'])

@section('title')
    <title>Manage Users | Task Management</title>
@endsection

@section('css')
    @php
        $token = Session::get('jwt_token');
    @endphp
    @if($token)
        <meta name="auth-token" content="{{ $token }}">
    @endif
@endsection

@section('content')
<div class="content pb-0">

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
        <div>
            <h4 class="mb-1">Manage Users<span class="badge badge-soft-primary ms-2" id="userCount">0</span></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('super-admin-dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Manage Users</li>
                </ol>
            </nav>
        </div>
        <div class="gap-2 d-flex align-items-center flex-wrap">
            <div class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-light px-2 shadow" data-bs-toggle="dropdown"><i class="ti ti-package-export me-2"></i>Export</a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="ti ti-file-type-pdf me-2"></i>Export as PDF
                    </a>
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="ti ti-file-type-xls me-2"></i>Export as Excel
                    </a>
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="ti ti-file-type-csv me-2"></i>Export as CSV
                    </a>
                </div>
            </div>
            <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
            <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Collapse" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-transition-top"></i></a>
        </div>
    </div>                
    <!-- End Page Header -->
    
    <!-- card start -->
    <div class="card border-0 rounded-0">
        <div class="card-header d-flex align-items-center justify-content-between gap-2 flex-wrap">
            <div class="input-icon input-icon-start position-relative">
                <span class="input-icon-addon text-dark"><i class="ti ti-search"></i></span>
                <input type="text" class="form-control" id="searchUsers" placeholder="Search">
            </div>
            <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add User</a>
        </div>
        <div class="card-body">

            <!-- table header -->
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <!-- Delete All Button (Hidden by default, shows when items checked) -->
                    <a href="javascript:void(0);" class="btn btn-danger px-2 d-none" id="bulkDeleteBtn" title="Delete selected users">
                        <i class="ti ti-trash me-1"></i>Delete All
                    </a>
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-light px-2 shadow" data-bs-toggle="dropdown"><i class="ti ti-sort-ascending-2 me-2"></i>Sort By</a>
                        <div class="dropdown-menu">
                            <ul>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item sort-option" data-order="desc">
                                        <i class="ti ti-arrow-down me-1"></i>Newest
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item sort-option" data-order="asc">
                                        <i class="ti ti-arrow-up me-1"></i>Oldest
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="reportrange" class="btn btn-outline-light px-2 shadow d-flex align-items-center" style="cursor: pointer;">
                        <i class="ti ti-calendar-due text-dark fs-14 me-2"></i>
                        <span class="reportrange-picker-field">Today</span>
                        <i class="ti ti-chevron-down ms-2" style="font-size: 12px;"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="btn btn-outline-light shadow px-2" data-bs-toggle="dropdown" data-bs-auto-close="outside"><i class="ti ti-filter me-2"></i>Filter<i class="ti ti-chevron-down ms-2"></i></a>
                        <div class="filter-dropdown-menu dropdown-menu dropdown-menu-lg p-0">
                            <div class="filter-header d-flex align-items-center justify-content-between border-bottom">
                                <h6 class="mb-0"><i class="ti ti-filter me-1"></i>Filter by Status</h6>
                                <button type="button" class="btn-close close-filter-btn" data-bs-dismiss="dropdown-menu" aria-label="Close"></button>
                            </div>
                            <div class="filter-set-view p-3">
                                <!-- Status Filter -->
                                <div class="filter-content-list">
                                    <h6 class="mb-2">Status</h6>
                                    <ul class="mb-0">
                                        <li>
                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                <input class="form-check-input m-0 me-2 status-filter" type="checkbox" value="1" id="filterActive">
                                                <span>Active</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                <input class="form-check-input m-0 me-2 status-filter" type="checkbox" value="0" id="filterInactive">
                                                <span>Inactive</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Reset Button (Behind Filter) -->
                    <a href="javascript:void(0);" class="btn btn-outline-light shadow px-2" id="quickReset" title="Reset all filters">
                        <i class="ti ti-refresh me-1"></i>Reset
                    </a>
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="btn bg-soft-indigo px-2 border-0" data-bs-toggle="dropdown" data-bs-auto-close="outside"><i class="ti ti-columns-3 me-2"></i>Manage Columns</a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-md p-3">
                            <ul>
                                <li class="gap-1 d-flex align-items-center mb-2">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>Name</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>
                                        </label>
                                    </div>
                                </li>
                                <li class="gap-1 d-flex align-items-center mb-2">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>Email</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>
                                        </label>
                                    </div>
                                </li>
                                <li class="gap-1 d-flex align-items-center mb-2">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>Phone</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>
                                        </label>
                                    </div>
                                </li>
                                <li class="gap-1 d-flex align-items-center mb-2">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>Status</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>
                                        </label>
                                    </div>
                                </li>
                                <li class="gap-1 d-flex align-items-center mb-2">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>Date</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>
                                        </label>
                                    </div>
                                </li>
                                <li class="gap-1 d-flex align-items-center mb-2">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>Actions</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- table header -->

            <!-- Contact List -->
            <div class="table-responsive custom-table">
                <table class="table table-nowrap" id="manage-users-list">
                    <thead>
                        <tr>
                            <th>
                                <div class="form-check form-check-md d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" id="checkboxAll">
                                    <label class="form-check-label" for="checkboxAll"></label>
                                </div>
                            </th>
                            <th class="col-name sort-column" data-sort-field="full_name" style="cursor: pointer;">
                                <div class="d-flex align-items-center gap-2">
                                    <span>Name</span>
                                    <i class="ti ti-arrow-up text-muted sort-icon"></i>
                                </div>
                            </th>
                            <th class="col-email sort-column" data-sort-field="email" style="cursor: pointer;">
                                <div class="d-flex align-items-center gap-2">
                                    <span>Email</span>
                                    <i class="ti ti-arrow-up text-muted sort-icon"></i>
                                </div>
                            </th>
                            <th class="col-phone sort-column" data-sort-field="mobile" style="cursor: pointer;">
                                <div class="d-flex align-items-center gap-2">
                                    <span>Phone</span>
                                    <i class="ti ti-arrow-up text-muted sort-icon"></i>
                                </div>
                            </th>
                            <th class="col-status sort-column" data-sort-field="is_active" style="cursor: pointer;">
                                <div class="d-flex align-items-center gap-2">
                                    <span>Status</span>
                                    <i class="ti ti-arrow-up text-muted sort-icon"></i>
                                </div>
                            </th>
                            <th class="col-date sort-column" data-sort-field="created_at" style="cursor: pointer;">
                                <div class="d-flex align-items-center gap-2">
                                    <span>Date</span>
                                    <i class="ti ti-arrow-down text-primary sort-icon"></i>
                                </div>
                            </th>
                            <th class="col-actions text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <!-- Data loaded via AJAX/DataTables -->
                    </tbody>
                </table>
            </div>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 fs-14 text-muted"><span id="paginationStart">0</span> to <span id="paginationEnd">0</span> of <span id="totalUsers">0</span> entries</p>
                </div>
                <div class="col-md-6">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm justify-content-end" id="paginationContainer">
                            <!-- Pagination controls updated via AJAX -->
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /Contact List -->
                 
        </div>
    </div>
    <!-- card end -->

</div>

    <!-- Add User Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Add New User</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="addUserForm" enctype="multipart/form-data">
                @csrf
                <div>
                    <!-- Basic Info -->
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar avatar-xxl border border-dashed me-3 flex-shrink-0">
                                        <img id="addUserImagePreview" src="{{ asset('assets/img/users/user-01.jpg') }}" alt="img" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                    </div>
                                    <div class="d-inline-flex flex-column align-items-start">
                                        <div class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                            <i class="ti ti-file-broken me-1"></i>Upload file
                                            <input type="file" id="addUserProfileImage" class="form-control" accept="image/*" name="profile">
                                        </div>
                                        <span>JPG, GIF or PNG. Max size of 800K</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="addUserFirstName" name="first_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="addUserLastName" name="last_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="addUserMiddleName" name="middle_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="addUserEmail" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Mobile <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="addUserMobile" name="mobile" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-flat pass-group">
                                        <input type="password" class="form-control pass-input" id="addUserPassword" name="password" required>
                                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                                            <i class="ti ti-eye-off"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-flat pass-group">
                                        <input type="password" class="form-control pass-input" id="addUserPasswordConfirm" name="password_confirmation" required>
                                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                                            <i class="ti ti-eye-off"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Basic Info -->
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <a href="javascript:void(0);" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit User Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_edit">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Edit User</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="editUserForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="editUserId" name="user_id">
                <div>
                    <!-- Basic Info -->
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar avatar-xxl border border-dashed me-3 flex-shrink-0">
                                        <img id="editUserImagePreview" src="{{ asset('assets/img/users/user-01.jpg') }}" alt="img" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                    </div>
                                    <div class="d-inline-flex flex-column align-items-start">
                                        <div class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                            <i class="ti ti-file-broken me-1"></i>Upload file
                                            <input type="file" id="editUserProfileImage" class="form-control" accept="image/*" name="profile">
                                        </div>
                                        <span>JPG, GIF or PNG. Max size of 800K</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="editUserFirstName" name="first_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="editUserLastName" name="last_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="editUserMiddleName" name="middle_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="editUserEmail" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Mobile <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="editUserMobile" name="mobile" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="editUserStatus" name="is_active" value="1">
                                        <label class="form-check-label" for="editUserStatus">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Password (Leave blank to keep current)</label>
                                    <div class="input-group input-group-flat pass-group">
                                        <input type="password" class="form-control pass-input" id="editUserPassword" name="password">
                                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                                            <i class="ti ti-eye-off"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <div class="input-group input-group-flat pass-group">
                                        <input type="password" class="form-control pass-input" id="editUserPasswordConfirm" name="password_confirmation">
                                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                                            <i class="ti ti-eye-off"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Basic Info -->
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <a href="javascript:void(0);" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="delete_user">
        <div class="modal-dialog modal-dialog-centered modal-sm rounded-0">
            <div class="modal-content rounded-0">
                <div class="modal-body p-4 text-center position-relative">
                    <div class="mb-3 position-relative z-1">
                        <span class="avatar avatar-xl badge-soft-danger border-0 text-danger rounded-circle">
                            <i class="ti ti-trash fs-24"></i>
                        </span>
                    </div>
                    <h5 class="mb-1">Delete Confirmation</h5>
                    <p class="mb-3">Are you sure you want to delete this user?</p>
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-light position-relative z-1 me-2 w-100" data-bs-dismiss="modal">Cancel</a>
                        <a id="confirmDeleteBtn" class="btn btn-primary position-relative z-1 w-100" data-bs-dismiss="modal">Yes, Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script>
        // ========================================
        // 🎯 USERS MODULE CONFIGURATION
        // ========================================

        // Datatable Configuration for Users
        const usersDatatableConfig = {
            containerId: 'manage-users-list',
            apiEndpoint: '/api/v1/super-admin/users',
            perPage: 10,
            defaultSort: 'created_at',
            defaultOrder: 'desc',
            columns: [
                {
                    field: 'full_name',
                    header: 'Name',
                    className: 'col-name',
                    render: (value, item) => {
                        const profileImg = item.profile ? `/storage/${item.profile}` : '{{ asset("assets/img/users/user-01.jpg") }}';
                        return `
                            <div class="d-flex align-items-center">
                                <span class="avatar avatar-md rounded-circle me-2">
                                    <img src="${profileImg}" class="rounded-circle" alt="img" style="width: 40px; height: 40px;">
                                </span>
                                <div>
                                    <h6 class="mb-0">${item.full_name}</h6>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    field: 'email',
                    header: 'Email',
                    className: 'col-email'
                },
                {
                    field: 'mobile',
                    header: 'Phone',
                    className: 'col-phone'
                },
                {
                    field: 'is_active',
                    header: 'Status',
                    className: 'col-status',
                    type: 'boolean'
                },
                {
                    field: 'created_at',
                    header: 'Date',
                    className: 'col-date',
                    type: 'date'
                },
                {
                    field: 'actions',
                    header: 'Actions',
                    render: (value, item) => {
                        return `
                            <div class="d-flex align-items-center justify-content-end">
                                <div class="dropdown">
                                    <button class="btn btn-icon btn-sm rounded-circle dropdown-toggle drop-arrow-none" 
                                            data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item edit-item-btn" href="javascript:void(0);" data-id="${item.id}">
                                            <i class="ti ti-pencil me-2"></i>Edit
                                        </a>
                                        <a class="dropdown-item delete-item-btn" href="javascript:void(0);" data-id="${item.id}">
                                            <i class="ti ti-trash me-2"></i>Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                }
            ]
        };

        let deleteUserId = null;
        let editModuleConfig = {
            modalId: '#offcanvas_edit',
            formId: 'editUserForm',
            apiEndpoint: '/api/v1/super-admin/users'
        };
        let addModuleConfig = {
            modalId: '#offcanvas_add',
            formId: 'addUserForm',
            apiEndpoint: '/api/v1/super-admin/users'
        };

        // ========================================
        // 🔧 INITIALIZE PAGE
        // ========================================

        // Initialize page
        $(document).ready(function() {
            // ========================================
            // 📋 STEP 1: Initialize Core Components
            // ========================================
            
            // Initialize datatable with AJAX loading
            initDatatable(usersDatatableConfig);

            // Setup password toggle for all password fields in forms
            setupPasswordToggle();

            // Setup file previews for add/edit forms
            handleFilePreview('#addUserProfileImage', '#addUserImagePreview');
            handleFilePreview('#editUserProfileImage', '#editUserImagePreview');

            // Setup search functionality with debounce
            handleSearch('#searchUsers');

            // ========================================
            // 📋 STEP 2: Initialize Form Handlers
            // ========================================
            
            // Handle add user form submission (POST request)
            handleFormSubmit({
                formId: 'addUserForm',
                apiEndpoint: '/api/v1/super-admin/users',
                method: 'POST',
                onSuccess: function() {
                    // Close offcanvas modal after successful creation
                    const offcanvas = bootstrap.Offcanvas.getInstance(document.querySelector('#offcanvas_add'));
                    if (offcanvas) offcanvas.hide();
                    // Reset form and preview image
                    $('#addUserForm')[0].reset();
                    $('#addUserImagePreview').attr('src', '{{ asset("assets/img/users/user-01.jpg") }}');
                }
            });

            // Handle edit user form submission (PUT request)
            handleFormSubmit({
                formId: 'editUserForm',
                apiEndpoint: '/api/v1/super-admin/users',
                method: 'PUT',
                onSuccess: function() {
                    // Close offcanvas modal after successful update
                    const offcanvas = bootstrap.Offcanvas.getInstance(document.querySelector('#offcanvas_edit'));
                    if (offcanvas) offcanvas.hide();
                }
            });

            // ========================================
            // 📋 STEP 3: Initialize Delete Handler
            // ========================================
            
            // Handle delete action with confirmation
            handleDelete({
                deleteButtonSelector: '.delete-item-btn',
                confirmSelector: '#delete_user',
                confirmButtonId: 'confirmDeleteBtn',
                apiEndpoint: '/api/v1/super-admin/users'
            });

            // Handle bulk delete with confirmation
            handleBulkDelete({
                buttonSelector: '#bulkDeleteBtn',
                confirmSelector: '#delete_user',
                confirmButtonId: 'confirmDeleteBtn',
                apiEndpoint: '/api/v1/super-admin/users'
            });

            // ========================================
            // 📋 STEP 4: Initialize Action Handlers
            // ========================================

            // Handle edit button click - Load user data into edit form
            $(document).on('click', '.edit-item-btn', function() {
                const itemId = $(this).data('id');
                loadItemForEdit(itemId, editModuleConfig);
            });

            // Function to toggle Delete All button visibility
            function updateDeleteAllButtonVisibility() {
                const checkedCount = $('#usersTableBody input[type="checkbox"]:checked').length;
                const bulkDeleteBtn = $('#bulkDeleteBtn');
                
                if (checkedCount > 0) {
                    bulkDeleteBtn.removeClass('d-none').show();
                } else {
                    bulkDeleteBtn.addClass('d-none').hide();
                }
            }

            // Handle select all checkbox - Select/deselect all rows in datatable
            $('#checkboxAll').on('change', function() {
                const isChecked = $(this).is(':checked');
                $('#usersTableBody input[type="checkbox"]').prop('checked', isChecked);
                updateDeleteAllButtonVisibility();
            });

            // Handle individual row checkbox changes - Update select-all checkbox state
            $(document).on('change', '#usersTableBody input[type="checkbox"]', function() {
                const totalCheckboxes = $('#usersTableBody input[type="checkbox"]').length;
                const checkedCheckboxes = $('#usersTableBody input[type="checkbox"]:checked').length;
                $('#checkboxAll').prop('checked', totalCheckboxes === checkedCheckboxes && totalCheckboxes > 0);
                updateDeleteAllButtonVisibility();
            });

            // ========================================
            // 📋 STEP 5: Initialize Column Management
            // ========================================

            // Handle manage columns toggle - Show/hide columns with persistence
            $('.switchCheckDefault').on('change', function() {
                const label = $(this).closest('label').find('span:first').text().trim().toLowerCase();
                const isChecked = $(this).is(':checked');
                const table = $('#manage-users-list');
                
                // Map dropdown labels to actual column classes in HTML
                const columnMapping = {
                    'name': 'col-name',
                    'email': 'col-email',
                    'phone': 'col-phone',
                    'status': 'col-status',
                    'date': 'col-date',
                    'actions': 'col-actions'
                };
                
                const columnClass = columnMapping[label];
                
                // Hide or show the column in the table
                if (columnClass) {
                    const elements = table.find(`th.${columnClass}, td.${columnClass}`);
                    if (isChecked) {
                        elements.removeClass('d-none').show();
                    } else {
                        elements.addClass('d-none').hide();
                    }
                }
                
                // Store preference in localStorage for persistence across page reloads
                let columnPreferences = JSON.parse(localStorage.getItem('userColumnPreferences') || '{}');
                columnPreferences[columnClass] = isChecked;
                localStorage.setItem('userColumnPreferences', JSON.stringify(columnPreferences));
            });

            // ========================================
            // 📋 STEP 6: Initialize Utility Buttons
            // ========================================

            // Handle refresh button - Reload datatable data from API
            $('a[data-bs-original-title="Refresh"]').on('click', function() {
                if (window.datatableInstance) {
                    window.datatableInstance.refresh();
                    showToast('Data refreshed', 'info');
                }
            });

            // ========================================
            // 📋 STEP 7: Initialize Filter Handlers
            // ========================================

            // Auto-apply filter when checkbox changes
            $(document).on('change', '.status-filter', function() {
                // Get selected status values
                const selectedStatus = [];
                $('.status-filter:checked').each(function() {
                    selectedStatus.push($(this).val());
                });

                // Build filter params
                const filterParams = {};
                if (selectedStatus.length > 0) {
                    filterParams.is_active = selectedStatus.join(',');
                }

                // Apply filter by reloading datatable with filter params
                if (window.datatableInstance) {
                    window.datatableInstance.filters = filterParams;
                    window.datatableInstance.currentPage = 1;
                    window.datatableInstance.load();
                    showToast('Filter applied', 'success');
                }
            });

            // Handle quick reset button (outside dropdown)
            $('#quickReset').on('click', function() {
                // Uncheck all checkboxes
                $('.status-filter').prop('checked', false);
                
                // Reset filter params and reload datatable
                if (window.datatableInstance) {
                    window.datatableInstance.filters = {};
                    window.datatableInstance.currentPage = 1;
                    window.datatableInstance.load();
                    showToast('All filters reset', 'success');
                    
                    // Reset date range to Today
                    const today = moment().format('YYYY-MM-DD');
                    $('.reportrange-picker-field').text('Today');
                }
            });

            // ========================================
            // 📋 STEP 7.5: Initialize Date Range Picker
            // ========================================

            /**
             * Apply date range filter
             */
            function applyDateRangeFilter(startDate, endDate, label) {
                if (!window.datatableInstance) return;

                // Format dates as YYYY-MM-DD
                const formattedStart = startDate.format('YYYY-MM-DD');
                const formattedEnd = endDate.format('YYYY-MM-DD');
                const dateRange = formattedStart + ' to ' + formattedEnd;

                // Update filters
                window.datatableInstance.filters.date_range = dateRange;
                window.datatableInstance.currentPage = 1;
                window.datatableInstance.load();

                // Update display text
                $('.reportrange-picker-field').text(label || (formattedStart + ' - ' + formattedEnd));

                showToast('Date filter applied: ' + label, 'success');
                log(`Filtered by date range: ${dateRange}`, 'info');
            }

            // Initialize daterangepicker
            $('#reportrange').daterangepicker({
                startDate: moment().startOf('day'),
                endDate: moment().endOf('day'),
                ranges: {
                    'Today': [moment().startOf('day'), moment().endOf('day')],
                    'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
                    'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                    'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                    format: 'MMM D, YYYY'
                },
                autoUpdateInput: true,
                showDropdowns: true
            }, function(start, end, label) {
                // Apply date range filter when selection changes
                applyDateRangeFilter(start, end, label);
            });

            // ========================================
            // 📋 STEP 8: Initialize Sort Handlers
            // ========================================

            // Handle Sort By dropdown (Newest/Oldest)
            $(document).on('click', '.sort-option', function(e) {
                e.preventDefault();
                const order = $(this).data('order');
                
                if (!window.datatableInstance) return;
                
                // Sort by date with selected order
                window.datatableInstance.sort('created_at', order);
                
                const orderText = order === 'desc' ? 'Newest' : 'Oldest';
                log(`Sorted by ${orderText}`, 'info');
                showToast(`Sorted by ${orderText}`, 'success');
            });

            // Handle column header clicks for sorting (arrow on headers)
            $(document).on('click', '.sort-column', function() {
                const sortField = $(this).data('sort-field');
                if (!sortField || !window.datatableInstance) return;

                // Determine new sort order
                let newOrder = 'asc';
                
                // If clicking the same column, toggle the order
                if (window.datatableInstance.currentSort === sortField) {
                    newOrder = window.datatableInstance.currentOrder === 'asc' ? 'desc' : 'asc';
                }

                // Update all sort icons
                $('.sort-column .sort-icon').removeClass('ti-arrow-up ti-arrow-down text-primary').addClass('ti-arrow-up text-muted');

                // Update current column icon
                const currentIcon = $(this).find('.sort-icon');
                currentIcon.removeClass('text-muted').addClass('text-primary');
                if (newOrder === 'asc') {
                    currentIcon.removeClass('ti-arrow-down').addClass('ti-arrow-up');
                } else {
                    currentIcon.removeClass('ti-arrow-up').addClass('ti-arrow-down');
                }

                // Apply sort
                window.datatableInstance.sort(sortField, newOrder);
                log(`Sorted by ${sortField} (${newOrder})`, 'info');
            });

            // Highlight the currently sorted column on page load
            if (window.datatableInstance) {
                const currentSortIcon = $(`.sort-column[data-sort-field="${window.datatableInstance.currentSort}"] .sort-icon`);
                currentSortIcon.removeClass('text-muted').addClass('text-primary');
                if (window.datatableInstance.currentOrder === 'desc') {
                    currentSortIcon.removeClass('ti-arrow-up').addClass('ti-arrow-down');
                }
            }
        });

        // ========================================
        // 🔧 HELPER FUNCTIONS - Module Specific
        // ========================================

        /**
         * Setup password toggle functionality
         * 
         * Enables password field visibility toggle in forms (add/edit modals).
         * Converts password input to text and vice versa on button click.
         * Used for: Add User Form, Edit User Form (password fields)
         */
        function setupPasswordToggle() {
            $(document).on('click', '.toggle-password', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const $this = $(this);
                const $input = $this.closest('.input-group').find('input[type="password"], input[type="text"]');
                const $icon = $this.find('i');
                
                if (!$input.length) return;
                
                const currentType = $input.attr('type');
                const newType = currentType === 'password' ? 'text' : 'password';
                
                // Store current value
                const currentValue = $input.val();
                
                // Remove the input from DOM temporarily
                const $inputClone = $input.clone();
                $inputClone.attr('type', newType);
                $inputClone.val(currentValue);
                
                // Replace the old input with new type
                $input.replaceWith($inputClone);
                
                // Update icon
                if (newType === 'text') {
                    $icon.removeClass('ti-eye-off').addClass('ti-eye');
                } else {
                    $icon.removeClass('ti-eye').addClass('ti-eye-off');
                }
                
                console.log(`Toggled password visibility: ${currentType} → ${newType}`);
                
                // Re-attach event handlers to the new input if needed
                setupPasswordToggle();
            });
        }

        // Load item data for editing
        function loadItemForEdit(itemId, moduleConfig) {
            // Step 1: Make API request to fetch item details
            apiGet(`${moduleConfig.apiEndpoint}/${itemId}`)
                .then(response => {
                    // Step 2: Extract item data from response
                    const user = response.data.data;

                    // Step 3: Populate form fields with item data
                    $('#editUserId').val(user.id);
                    $('#editUserFirstName').val(user.first_name || '');
                    $('#editUserLastName').val(user.last_name || '');
                    $('#editUserMiddleName').val(user.middle_name || '');
                    $('#editUserEmail').val(user.email || '');
                    $('#editUserMobile').val(user.mobile || '');
                    
                    // Set status checkbox
                    if (user.is_active === 1 || user.is_active === true || user.is_active === '1') {
                        $('#editUserStatus').prop('checked', true);
                    } else {
                        $('#editUserStatus').prop('checked', false);
                    }

                    // Step 4: Load profile image if available
                    if (user.profile) {
                        $('#editUserImagePreview').attr('src', `/storage/${user.profile}`);
                    }

                    // Step 5: Open edit offcanvas modal
                    const editOffcanvas = new bootstrap.Offcanvas(document.querySelector(moduleConfig.modalId));
                    editOffcanvas.show();
                })
                .catch(error => {
                    // Error handling
                    console.error('Error loading item:', error);
                    showToast('Failed to load item data', 'error');
                });
        }
    </script>
@endsection
        
