@extends('layouts.master', ['title' => 'Company Management'])

@section('title')
    <title>Company Management | Task Management</title>
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
        'containerId' => 'manage-companies-list',
        'searchFieldId' => 'searchManageCompaniesList',
        'apiEndpoint' => '/api/v1/companies',
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
            'field' => 'name',
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
            'field' => 'phone',
            'header' => 'Phone',
            'className' => 'col-phone',
            'sortable' => true
        ],
        [
            'field' => 'country',
            'header' => 'Location',
            'className' => 'col-location',
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
        ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ['label' => 'Companies']
    ];
@endphp

<x-datatable 
    :config="$tableConfig"
    :columns="$columns"
    title="Companies"
    :breadcrumb="$breadcrumb"
    :filters="$filters"
    :sortOptions="$sortOptions"
    searchPlaceholder="Search companies..."
/>

<!-- Add Company Offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add">
    <div class="offcanvas-header border-bottom">
        <h5 class="fw-semibold">Add New Company</h5>
        <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="ti ti-x"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <form id="addCompanyForm" enctype="multipart/form-data">
            @csrf
            <div>
                <!-- Basic Info -->
                <div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-xxl border border-dashed me-3 flex-shrink-0">
                                    <img id="addCompanyImagePreview" src="{{ asset('assets/img/users/user-01.jpg') }}" alt="img" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                                <div class="d-inline-flex flex-column align-items-start">
                                    <div class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                        <i class="ti ti-file-broken me-1"></i>Upload file
                                        <input type="file" id="addCompanyLogo" class="form-control" accept="image/*" name="logo">
                                    </div>
                                    <span>JPG, GIF or PNG. Max size of 800K</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="addCompanyName" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Company Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="addCompanyCode" name="code" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="addCompanyEmail" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="addCompanyPhone" name="phone" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Website</label>
                                <input type="text" class="form-control" id="addCompanyWebsite" name="website">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tax ID</label>
                                <input type="text" class="form-control" id="addCompanyTaxId" name="tax_id">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Registration Number</label>
                                <input type="text" class="form-control" id="addCompanyRegNumber" name="registration_number">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Street Address</label>
                                <input type="text" class="form-control" id="addCompanyAddress" name="address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" class="form-control" id="addCompanyCountry" name="country">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">State / Province</label>
                                <input type="text" class="form-control" id="addCompanyState" name="state">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" id="addCompanyCity" name="city">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Zip Code</label>
                                <input type="text" class="form-control" id="addCompanyZipCode" name="zip_code">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Registration Date</label>
                                <input type="date" class="form-control" id="addCompanyRegDate" name="registration_date">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="addCompanyDescription" name="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="addCompanyStatus" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="addCompanyStatus">
                                        Active
                                    </label>
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

<!-- Edit Company Offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_edit">
    <div class="offcanvas-header border-bottom">
        <h5 class="fw-semibold">Edit Company</h5>
        <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="ti ti-x"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <form id="editCompanyForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="editCompanyId" name="company_id">
            <div>
                <!-- Basic Info -->
                <div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-xxl border border-dashed me-3 flex-shrink-0">
                                    <img id="editCompanyImagePreview" src="{{ asset('assets/img/users/user-01.jpg') }}" alt="img" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                                <div class="d-inline-flex flex-column align-items-start">
                                    <div class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                        <i class="ti ti-file-broken me-1"></i>Upload file
                                        <input type="file" id="editCompanyLogo" class="form-control" accept="image/*" name="logo">
                                    </div>
                                    <span>JPG, GIF or PNG. Max size of 800K</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editCompanyName" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Company Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editCompanyCode" name="code" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="editCompanyEmail" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editCompanyPhone" name="phone" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Website</label>
                                <input type="text" class="form-control" id="editCompanyWebsite" name="website">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tax ID</label>
                                <input type="text" class="form-control" id="editCompanyTaxId" name="tax_id">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Registration Number</label>
                                <input type="text" class="form-control" id="editCompanyRegNumber" name="registration_number">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Street Address</label>
                                <input type="text" class="form-control" id="editCompanyAddress" name="address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" class="form-control" id="editCompanyCountry" name="country">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">State / Province</label>
                                <input type="text" class="form-control" id="editCompanyState" name="state">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" id="editCompanyCity" name="city">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Zip Code</label>
                                <input type="text" class="form-control" id="editCompanyZipCode" name="zip_code">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Registration Date</label>
                                <input type="date" class="form-control" id="editCompanyRegDate" name="registration_date">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="editCompanyDescription" name="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="editCompanyStatus" name="is_active" value="1">
                                    <label class="form-check-label" for="editCompanyStatus">
                                        Active
                                    </label>
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
        // 🏢 COMPANY MODULE CONFIGURATION
        // ========================================

        const companyDatatableConfig = {
            containerId: 'manage-companies-list',
            apiEndpoint: '/api/v1/companies',
            perPage: 10,
            defaultSort: 'created_at',
            defaultOrder: 'desc',
            searchFieldId: 'searchManageCompaniesList',
            columns: [
                {
                    field: 'name',
                    header: 'Name',
                    className: 'col-name',
                    sortable: true,
                    render: (value, item) => {
                        const logoImg = item.logo ? `/storage/${item.logo}` : '{{ asset("assets/img/users/user-01.jpg") }}';
                        return `
                            <div class="d-flex align-items-center">
                                <span class="avatar avatar-md rounded-circle me-2">
                                    <img src="${logoImg}" class="rounded-circle" alt="img" style="width: 40px; height: 40px;">
                                </span>
                                <div>
                                    <h6 class="mb-0">${item.name || '-'}</h6>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    field: 'email',
                    header: 'Email',
                    className: 'col-email',
                    sortable: true,
                    render: (value) => value || '-'
                },
                {
                    field: 'phone',
                    header: 'Phone',
                    className: 'col-phone',
                    sortable: true,
                    render: (value) => value || '-'
                },
                {
                    field: 'country',
                    header: 'Location',
                    className: 'col-location',
                    sortable: true,
                    render: (value) => value || '-'
                },
                {
                    field: 'is_active',
                    header: 'Status',
                    className: 'col-status',
                    sortable: true,
                    type: 'boolean',
                    render: (value) => {
                        if (value === 1 || value === true) {
                            return '<span class="badge badge-soft-success">Active</span>';
                        } else {
                            return '<span class="badge badge-soft-danger">Inactive</span>';
                        }
                    }
                },
                {
                    field: 'created_at',
                    header: 'Date',
                    className: 'col-date',
                    sortable: true,
                    type: 'date',
                    render: (value) => {
                        if (!value) return '-';
                        const date = new Date(value);
                        return date.toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        });
                    }
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
            window.datatableInstance = new Datatable(companyDatatableConfig);

            // Setup form handlers
            handleFilePreview('#addCompanyLogo', '#addCompanyImagePreview');
            handleFilePreview('#editCompanyLogo', '#editCompanyImagePreview');

            // Handle add company form
            handleFormSubmit({
                formId: 'addCompanyForm',
                apiEndpoint: '/api/v1/companies',
                method: 'POST',
                onSuccess: function() {
                    const offcanvas = bootstrap.Offcanvas.getInstance(document.querySelector('#offcanvas_add'));
                    if (offcanvas) offcanvas.hide();
                    $('#addCompanyForm')[0].reset();
                    $('#addCompanyImagePreview').attr('src', '{{ asset("assets/img/users/user-01.jpg") }}');
                    window.datatableInstance.refresh();
                }
            });

            // Handle edit company form - Using the SAME pattern as your user code
            $(document).on('submit', '#editCompanyForm', function(e) {
                e.preventDefault();
                
                const companyId = $('#editCompanyId').val();
                
                if (!companyId) {
                    showToast('Company ID not found', 'error');
                    return;
                }
                
                // Use the company ID in the API endpoint for update
                handleFormSubmit({
                    formId: 'editCompanyForm',
                    apiEndpoint: `/api/v1/companies/${companyId}`, // Include ID in URL
                    method: 'PUT',
                    onSuccess: function() {
                        const offcanvas = bootstrap.Offcanvas.getInstance(document.querySelector('#offcanvas_edit'));
                        if (offcanvas) offcanvas.hide();
                        window.datatableInstance.refresh();
                    }
                });
            });

            // Initialize common delete handler for single item delete
            handleCommonDelete({
                deleteButtonSelector: '.delete-item-btn',
                apiEndpoint: '/api/v1/companies',
                itemName: 'company',
                onSuccess: () => window.datatableInstance.refresh()
            });

            // Handle bulk delete using common function
            handleBulkDelete({
                buttonSelector: '#bulkDeleteBtn',
                confirmSelector: '#commonDeleteModal',
                confirmButtonId: 'commonDeleteConfirmBtn',
                apiEndpoint: '/api/v1/companies',
                itemName: 'company',
                onSuccess: () => {
                    // Show bulk delete confirmation modal
                    const selectedIds = window.datatableInstance.selectedItems;
                    if (selectedIds.length > 0) {
                        showCommonBulkDeleteConfirmation(selectedIds, 'company', '/api/v1/companies');
                    }
                }
            });

            // Handle edit button click
            $(document).on('click', '.edit-item-btn', function() {
                const itemId = $(this).data('id');
                loadItemForEdit(itemId, {
                    modalId: '#offcanvas_edit',
                    formId: 'editCompanyForm',
                    apiEndpoint: '/api/v1/companies'
                });
            });

            // Handle column management
            $('.column-toggle').on('change', function() {
                const columnClass = $(this).data('column');
                const isChecked = $(this).is(':checked');
                const table = $(`#${companyDatatableConfig.containerId}`);
                
                const elements = table.find(`th.${columnClass}, td.${columnClass}`);
                if (isChecked) {
                    elements.removeClass('d-none').show();
                } else {
                    elements.addClass('d-none').hide();
                }
                
                // Store preferences
                let preferences = JSON.parse(localStorage.getItem('companyColumnPreferences') || '{}');
                preferences[columnClass] = isChecked;
                localStorage.setItem('companyColumnPreferences', JSON.stringify(preferences));
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
                const searchFieldId = companyDatatableConfig.searchFieldId || 'searchManageCompaniesList';
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
            const preferences = JSON.parse(localStorage.getItem('companyColumnPreferences') || '{}');
            Object.keys(preferences).forEach(columnClass => {
                const isVisible = preferences[columnClass];
                const toggle = $(`.column-toggle[data-column="${columnClass}"]`);
                toggle.prop('checked', isVisible).trigger('change');
            });

            setTimeout(function() {
                if (window.datatableInstance && $('#reportrange').length) {
                    const startDate = moment().subtract(29, 'days').startOf('day');
                    const endDate = moment().endOf('day');
                    applyDateRangeFilter(startDate, endDate, 'Last 30 Days');
                }
            }, 500);
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
        }

        // ========================================
        // 🔧 HELPER FUNCTIONS
        // ========================================

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
                    
                    // Handle API response structure
                    let company = null;
                    
                    if (response.data && response.data.data && response.data.data.data) {
                        company = response.data.data.data;
                    } else if (response.data && response.data.data) {
                        company = response.data.data;
                    } else {
                        console.error('Unexpected response structure:', response);
                        showToast('Invalid response format', 'error');
                        return;
                    }
                    
                    $('#editCompanyId').val(company.id);
                    $('#editCompanyName').val(company.name || '');
                    $('#editCompanyCode').val(company.code || '');
                    $('#editCompanyEmail').val(company.email || '');
                    $('#editCompanyPhone').val(company.phone || '');
                    $('#editCompanyWebsite').val(company.website || '');
                    $('#editCompanyTaxId').val(company.tax_id || '');
                    $('#editCompanyRegNumber').val(company.registration_number || '');
                    $('#editCompanyAddress').val(company.address || '');
                    $('#editCompanyCountry').val(company.country || '');
                    $('#editCompanyState').val(company.state || '');
                    $('#editCompanyCity').val(company.city || '');
                    $('#editCompanyZipCode').val(company.zip_code || '');
                    $('#editCompanyRegDate').val(company.registration_date || '');
                    $('#editCompanyDescription').val(company.description || '');
                    $('#editCompanyStatus').prop('checked', company.is_active == 1);
                    
                    if (company.logo) {
                        $('#editCompanyImagePreview').attr('src', `/storage/${company.logo}`);
                    } else {
                        $('#editCompanyImagePreview').attr('src', '{{ asset("assets/img/users/user-01.jpg") }}');
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