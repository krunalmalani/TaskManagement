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
@php
    $tableConfig = [
        'containerId' => 'manage-users-list',
        'searchFieldId' => 'searchManageUsersList',
        'apiEndpoint' => '/api/v1/super-admin/users',
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
            'field' => 'full_name',
            'header' => 'Name',
            'className' => 'col-name',
            'sortable' => true
        ],
        [
            'field' => 'email',
            'header' => 'Email',
            'className' => 'col-email',
            'sortable' => true
        ],
        [
            'field' => 'mobile',
            'header' => 'Phone',
            'className' => 'col-phone',
            'sortable' => true
        ],
        [
            'field' => 'is_active',
            'header' => 'Status',
            'className' => 'col-status',
            'sortable' => true,
            'type' => 'boolean'
        ],
        [
            'field' => 'created_at',
            'header' => 'Date',
            'className' => 'col-date',
            'sortable' => true,
            'type' => 'date'
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
        ],
        'dateRange' => true
    ];
    
    $sortOptions = [
        ['order' => 'desc', 'icon' => 'down', 'label' => 'Newest'],
        ['order' => 'asc', 'icon' => 'up', 'label' => 'Oldest']
    ];
    
    $breadcrumb = [
        ['url' => route('super-admin-dashboard'), 'label' => 'Dashboard'],
        ['label' => 'Manage Users']
    ];
@endphp

<x-datatable 
    :config="$tableConfig"
    :columns="$columns"
    title="Manage Users"
    :breadcrumb="$breadcrumb"
    :filters="$filters"
    :sortOptions="$sortOptions"
    searchPlaceholder="Search users..."
/>

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

@endsection

@section('script')
    <script src="{{ asset('assets/js/datatable.js') }}"></script>
    <script>
        // ========================================
        // 🎯 USERS MODULE CONFIGURATION
        // ========================================

        const usersDatatableConfig = {
            containerId: 'manage-users-list',
            apiEndpoint: '/api/v1/super-admin/users',
            perPage: 10,
            defaultSort: 'created_at',
            defaultOrder: 'desc',
            searchFieldId: 'searchManageUsersList',
            columns: [
                {
                    field: 'full_name',
                    header: 'Name',
                    className: 'col-name',
                    sortable: true,
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
                    className: 'col-email',
                    sortable: true
                },
                {
                    field: 'mobile',
                    header: 'Phone',
                    className: 'col-phone',
                    sortable: true
                },
                {
                    field: 'is_active',
                    header: 'Status',
                    className: 'col-status',
                    sortable: true,
                    type: 'boolean'
                },
                {
                    field: 'created_at',
                    header: 'Date',
                    className: 'col-date',
                    sortable: true,
                    type: 'date'
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
            window.datatableInstance = new Datatable(usersDatatableConfig);

            // Setup form handlers
            setupPasswordToggle();
            handleFilePreview('#addUserProfileImage', '#addUserImagePreview');
            handleFilePreview('#editUserProfileImage', '#editUserImagePreview');

            // Handle add user form
            handleFormSubmit({
                formId: 'addUserForm',
                apiEndpoint: '/api/v1/super-admin/users',
                method: 'POST',
                onSuccess: function() {
                    const offcanvas = bootstrap.Offcanvas.getInstance(document.querySelector('#offcanvas_add'));
                    if (offcanvas) offcanvas.hide();
                    $('#addUserForm')[0].reset();
                    $('#addUserImagePreview').attr('src', '{{ asset("assets/img/users/user-01.jpg") }}');
                    window.datatableInstance.refresh();
                }
            });

            // Handle edit user form
            handleFormSubmit({
                formId: 'editUserForm',
                apiEndpoint: '/api/v1/super-admin/users',
                method: 'PUT',
                onSuccess: function() {
                    const offcanvas = bootstrap.Offcanvas.getInstance(document.querySelector('#offcanvas_edit'));
                    if (offcanvas) offcanvas.hide();
                    window.datatableInstance.refresh();
                }
            });

            // Initialize common delete handler for single item delete
            handleCommonDelete({
                deleteButtonSelector: '.delete-item-btn',
                apiEndpoint: '/api/v1/super-admin/users',
                itemName: 'user',
                onSuccess: () => window.datatableInstance.refresh()
            });

            // Handle bulk delete using common function
            handleBulkDelete({
                buttonSelector: '#bulkDeleteBtn',
                confirmSelector: '#commonDeleteModal',
                confirmButtonId: 'commonDeleteConfirmBtn',
                apiEndpoint: '/api/v1/super-admin/users',
                itemName: 'user',
                onSuccess: () => {
                    // Show bulk delete confirmation modal
                    const selectedIds = window.datatableInstance.selectedItems;
                    if (selectedIds.length > 0) {
                        showCommonBulkDeleteConfirmation(selectedIds, 'user', '/api/v1/super-admin/users');
                    }
                }
            });

            // Handle edit button click
            $(document).on('click', '.edit-item-btn', function() {
                const itemId = $(this).data('id');
                loadItemForEdit(itemId, {
                    modalId: '#offcanvas_edit',
                    formId: 'editUserForm',
                    apiEndpoint: '/api/v1/super-admin/users'
                });
            });

            // Handle column management
            $('.column-toggle').on('change', function() {
                const columnClass = $(this).data('column');
                const isChecked = $(this).is(':checked');
                const table = $(`#${usersDatatableConfig.containerId}`);
                
                const elements = table.find(`th.${columnClass}, td.${columnClass}`);
                if (isChecked) {
                    elements.removeClass('d-none').show();
                } else {
                    elements.addClass('d-none').hide();
                }
                
                // Store preferences
                let preferences = JSON.parse(localStorage.getItem('userColumnPreferences') || '{}');
                preferences[columnClass] = isChecked;
                localStorage.setItem('userColumnPreferences', JSON.stringify(preferences));
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
                
                // Clear search field
                const searchFieldId = usersDatatableConfig.searchFieldId || 'searchManageUsersList';
                $(`#${searchFieldId}`).val('');
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
                    locale: {
                        format: 'MMM D, YYYY'
                    },
                    autoUpdateInput: true,
                    showDropdowns: true
                }, function(start, end, label) {
                    // Apply date range filter when selection changes
                    applyDateRangeFilter(start, end, label);
                });
                
                // Set default label to "Last 30 Days"
                $('.reportrange-picker-field').text('Last 30 Days');
            }

            // Handle sort options dropdown
            $(document).on('click', '.sort-option', function() {
                const sortOrder = $(this).data('order');
                window.datatableInstance.sort(window.datatableInstance.currentSort, sortOrder);
            });

            // Load column preferences
            const preferences = JSON.parse(localStorage.getItem('userColumnPreferences') || '{}');
            Object.keys(preferences).forEach(columnClass => {
                const isVisible = preferences[columnClass];
                const toggle = $(`.column-toggle[data-column="${columnClass}"]`);
                toggle.prop('checked', isVisible).trigger('change');
            });
        });

        // ========================================
        // 📋 DATE RANGE FILTER FUNCTION
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
        }
        
        // Apply default "Last 30 Days" filter on page load
        $(document).ready(function() {
            setTimeout(function() {
                if (window.datatableInstance && $('#reportrange').length) {
                    const startDate = moment().subtract(29, 'days').startOf('day');
                    const endDate = moment().endOf('day');
                    applyDateRangeFilter(startDate, endDate, 'Last 30 Days');
                }
            }, 500);
        });

        // Helper functions (keep from your original code)
        // function setupPasswordToggle() {
        //     $(document).on('click', '.toggle-password', function(e) {
        //         e.preventDefault();
        //         const $this = $(this);
        //         const $input = $this.closest('.input-group').find('input');
        //         const $icon = $this.find('i');
                
        //         const type = $input.attr('type') === 'password' ? 'text' : 'password';
        //         $input.attr('type', type);
        //         $icon.toggleClass('ti-eye-off ti-eye');
        //     });
        // }

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

        function handleFilePreview(inputSelector, previewSelector) {
            $(inputSelector).on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $(previewSelector).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        function loadItemForEdit(itemId, moduleConfig) {
            apiGet(`${moduleConfig.apiEndpoint}/${itemId}`)
                .then(response => {
                    console.log('Edit response:', response);
                    
                    // Handle API response structure: response.data.data (axios wraps it, then our API wraps it)
                    let user = null;
                    
                    if (response.data && response.data.data && response.data.data.data) {
                        // response.data.data.data is the user object
                        user = response.data.data.data;
                    } else if (response.data && response.data.data) {
                        // response.data.data is the user object
                        user = response.data.data;
                    } else {
                        console.error('Unexpected response structure:', response);
                        showToast('Invalid response format', 'error');
                        return;
                    }
                    
                    $('#editUserId').val(user.id);
                    $('#editUserFirstName').val(user.first_name || '');
                    $('#editUserLastName').val(user.last_name || '');
                    $('#editUserMiddleName').val(user.middle_name || '');
                    $('#editUserEmail').val(user.email || '');
                    $('#editUserMobile').val(user.mobile || '');
                    $('#editUserStatus').prop('checked', user.is_active == 1);
                    
                    if (user.profile) {
                        $('#editUserImagePreview').attr('src', `/storage/${user.profile}`);
                    }

                    const editOffcanvas = new bootstrap.Offcanvas(document.querySelector(moduleConfig.modalId));
                    editOffcanvas.show();
                })
                .catch(error => {
                    console.error('Error loading item:', error);
                    showToast('Failed to load item data', 'error');
                });
        }
    </script>
@endsection