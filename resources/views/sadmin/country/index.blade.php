<?php 
    $userData = Session::get('user');
?>
@extends('layouts.master', ['title' => 'Manage Countries'])

@section('title')
    <title>Manage Countries | Task Management</title>
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
@php
    $tableConfig = [
        'containerId' => 'manage-countries-list',
        'apiEndpoint' => '/api/v1/super-admin/countries',
        'perPage' => 10,
        'defaultSort' => 'created_at',
        'defaultOrder' => 'desc',
        'addModalId' => '#offcanvas_add',
        'bulkActions' => true,
        'actions' => [
            'edit' => true,
            'delete' => true
        ]
    ];
    
    $columns = [
        [
            'field' => 'country_name',
            'header' => 'Name',
            'className' => 'col-name',
            'sortable' => true
        ],
        [
            'field' => 'code',
            'header' => 'Code',
            'className' => 'col-code',
            'sortable' => true
        ],
        [
            'field' => 'short_name',
            'header' => 'Short Name',
            'className' => 'col-short-name',
            'sortable' => true
        ],
        [
            'field' => 'is_active',
            'header' => 'Status',
            'className' => 'col-status',
            'sortable' => true,
            'type' => 'boolean'
        ]
    ];
    
    $filters = [
        'status' => [
            'type' => 'checkbox',
            'label' => 'Status',
            'options' => [
                ['value' => '1', 'label' => 'Active'],
                ['value' => '0', 'label' => 'Inactive']
            ]
        ]
    ];
    
    $sortOptions = [
        ['order' => 'desc', 'icon' => 'down', 'label' => 'Newest'],
        ['order' => 'asc', 'icon' => 'up', 'label' => 'Oldest']
    ];
    
    $breadcrumb = [
        ['url' => route('super-admin-countries-index'), 'label' => 'Country'],
        ['label' => 'Manage Countries']
    ];
@endphp

<x-datatable 
    :config="$tableConfig"
    :columns="$columns"
    title="Manage Countries"
    :breadcrumb="$breadcrumb"
    :filters="$filters"
    :sortOptions="$sortOptions"
    searchPlaceholder="Search countries..."
/>

<!-- Add Country Offcanvas -->
    {{-- <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Add New Country</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="addCountryForm" enctype="multipart/form-data">
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

    <!-- Delete Modal (Keep your existing delete modal) -->
    <div class="modal fade" id="delete_user">
        <!-- ... Keep your existing delete modal code ... -->
    </div> --}}

@endsection

@section('script')
    <script src="{{ asset('assets/js/datatable.js') }}"></script>
    <script>
        // ========================================
        // 🎯 COUNTRIES MODULE CONFIGURATION
        // ========================================

        const countriesDatatableConfig = {
            containerId: 'manage-countries-list',
            apiEndpoint: '/api/v1/super-admin/countries',
            perPage: 10,
            defaultSort: 'created_at',
            defaultOrder: 'desc',
            columns: [
                {
                    field: 'country_name',
                    header: 'Name',
                    className: 'col-name',
                    render: (value, item) => {
                        return `
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">${item.country_name || item.name}</h6>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    field: 'code',
                    header: 'Code',
                    className: 'col-code'
                },
                {
                    field: 'short_name',
                    header: 'Short Name',
                    className: 'col-short-name'
                },
                {
                    field: 'is_active',
                    header: 'Status',
                    className: 'col-status',
                    type: 'boolean'
                }
            ],
            bulkActions: true,
            actions: {
                edit: true,
                delete: true
            }
        };

        // ========================================
        // 🔧 INITIALIZE PAGE
        // ========================================

        $(document).ready(function() {
            // Initialize datatable
            window.datatableInstance = new Datatable(countriesDatatableConfig);

            // Initialize common delete handler for single item delete
            handleCommonDelete({
                deleteButtonSelector: '.delete-item-btn',
                apiEndpoint: '/api/v1/super-admin/countries',
                itemName: 'country',
                onSuccess: () => window.datatableInstance.refresh()
            });

            // Handle bulk delete using common function
            handleBulkDelete({
                buttonSelector: '#bulkDeleteBtn',
                confirmSelector: '#commonDeleteModal',
                confirmButtonId: 'commonDeleteConfirmBtn',
                apiEndpoint: '/api/v1/super-admin/countries',
                itemName: 'country',
                onSuccess: () => {
                    // Show bulk delete confirmation modal
                    const selectedIds = window.datatableInstance.selectedItems;
                    if (selectedIds.length > 0) {
                        showCommonBulkDeleteConfirmation(selectedIds, 'country', '/api/v1/super-admin/countries');
                    }
                }
            });

            // Handle status filter
            $(document).on('change', '.status-filter', function() {
                const selectedStatus = [];
                $('.status-filter:checked').each(function() {
                    selectedStatus.push($(this).val());
                });

                if (selectedStatus.length > 0) {
                    window.datatableInstance.applyFilter('is_active', selectedStatus.join(','));
                } else {
                    delete window.datatableInstance.filters.is_active;
                    window.datatableInstance.currentPage = 1;
                    window.datatableInstance.load();
                }
            });

            // Handle quick reset
            $('#quickReset').on('click', function() {
                $('.status-filter').prop('checked', false);
                window.datatableInstance.resetFilters();
                showToast('All filters reset', 'success');
            });

            // Handle date range filter
            if ($('#reportrange').length) {
                $('#reportrange').daterangepicker({
                    startDate: moment().subtract(29, 'days').startOf('day'),
                    endDate: moment().endOf('day'),
                    ranges: {
                        'Today': [moment().startOf('day'), moment().endOf('day')],
                        'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
                        'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                        'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    locale: { format: 'MMM D, YYYY' },
                    autoUpdateInput: true
                }, function(start, end, label) {
                    const formattedStart = start.format('YYYY-MM-DD');
                    const formattedEnd = end.format('YYYY-MM-DD');
                    window.datatableInstance.applyFilter('date_range', `${formattedStart} to ${formattedEnd}`);
                    $('.reportrange-picker-field').text(label || `${formattedStart} - ${formattedEnd}`);
                });

                // Set default date range (Last 30 Days)
                setTimeout(() => {
                    const startDate = moment().subtract(29, 'days').startOf('day');
                    const endDate = moment().endOf('day');
                    const formattedStart = startDate.format('YYYY-MM-DD');
                    const formattedEnd = endDate.format('YYYY-MM-DD');
                    window.datatableInstance.applyFilter('date_range', `${formattedStart} to ${formattedEnd}`);
                    $('.reportrange-picker-field').text('Last 30 Days');
                }, 100);
            }
        });
    </script>
@endsection