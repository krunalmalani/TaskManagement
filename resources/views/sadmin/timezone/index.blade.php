<?php 
    $userData = Session::get('user');
?>
@extends('layouts.master', ['title' => 'Manage Timezones'])

@section('title')
    <title>{{ __('timezone_index_page_title') }}</title>
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
        'containerId' => 'manage-timezones-list',
        'apiEndpoint' => '/api/v1/super-admin/timezones',
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
            'header' => __('table_name'),
            'className' => 'col-name',
            'sortable' => true
        ],
        [
            'field' => 'timezone',
            'header' => __('timezone_index_table_timezone'),
            'className' => 'col-timezone',
            'sortable' => true
        ],
        [
            'field' => 'utc',
            'header' => __('timezone_index_table_utc'),
            'className' => 'col-utc',
            'sortable' => true
        ],
        [
            'field' => 'is_active',
            'header' => __('table_status'),
            'className' => 'col-status',
            'sortable' => true,
            'type' => 'boolean'
        ],
        [
            'field' => 'created_at',
            'header' => __('table_date'),
            'className' => 'col-date',
            'sortable' => true,
            'type' => 'date'
        ]
    ];
    
    $filters = [
        'status' => [
            'type' => 'checkbox',
            'label' => __('table_status'),
            'options' => [
                ['value' => '1', 'label' => __('active')],
                ['value' => '0', 'label' => __('inactive')]
            ]
        ]
    ];
    
    $sortOptions = [
        ['order' => 'desc', 'icon' => 'down', 'label' => 'Newest'],
        ['order' => 'asc', 'icon' => 'up', 'label' => 'Oldest']
    ];
    
    $breadcrumb = [
        ['url' => route('super-admin-dashboard'), 'label' => __('timezone_index_breadcrumb_parent')],
        ['label' => __('timezone_index_breadcrumb_current')]
    ];
@endphp

<x-datatable 
    :config="$tableConfig"
    :columns="$columns"
    title="{{ __('timezone_index_title') }}"
    :breadcrumb="$breadcrumb"
    :filters="$filters"
    :sortOptions="$sortOptions"
    searchPlaceholder="{{ __('timezone_index_search_placeholder') }}"
/>

<!-- Add Timezone Offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add">
    <div class="offcanvas-header border-bottom">
        <h5 class="fw-semibold">{{ __('timezone_index_add_modal_title') }}</h5>
        <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="ti ti-x"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <form id="addTimezoneForm">
            <div>
                <!-- Basic Info -->
                <div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{ __('timezone_index_form_country_id') }} <span class="text-danger">*</span></label>
                                <select name="country_id" class="form-select select2" required>
                                    <option value="">{{ __('country') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{ __('timezone_index_form_name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="e.g., Eastern Standard Time" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{ __('timezone_index_form_timezone') }} <span class="text-danger">*</span></label>
                                <input type="text" name="timezone" class="form-control" placeholder="e.g., America/New_York" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{ __('timezone_index_form_utc') }}</label>
                                <input type="text" name="utc" class="form-control" placeholder="{{ __('timezone_index_form_utc_placeholder') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{ __('status') }}</label>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="addTimezoneActive" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="addTimezoneActive">{{ __('active') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Basic Info -->
            </div>
            <div class="d-flex align-items-center justify-content-end">
                <a href="javascript:void(0);" class="btn btn-light me-2" data-bs-dismiss="offcanvas">{{ __('cancel') }}</a>
                <button type="submit" class="btn btn-primary">{{ __('create') }}</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Timezone Offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_edit">
    <div class="offcanvas-header border-bottom">
        <h5 class="fw-semibold">{{ __('timezone_index_edit_modal_title') }}</h5>
        <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="ti ti-x"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <form id="editTimezoneForm">
            <input type="hidden" id="editTimezoneId" name="timezone_id">
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('timezone_index_form_country_id') }} <span class="text-danger">*</span></label>
                            <select name="country_id" class="form-select select2" required>
                                <option value="">{{ __('country') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('timezone_index_form_name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., Eastern Standard Time" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('timezone_index_form_timezone') }} <span class="text-danger">*</span></label>
                            <input type="text" name="timezone" class="form-control" placeholder="e.g., America/New_York" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('timezone_index_form_utc') }}</label>
                            <input type="text" name="utc" class="form-control" placeholder="{{ __('timezone_index_form_utc_placeholder') }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('status') }}</label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" id="editTimezoneActive" name="is_active" value="1">
                                <label class="form-check-label" for="editTimezoneActive">{{ __('active') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-end">
                <a href="javascript:void(0);" class="btn btn-light me-2" data-bs-dismiss="offcanvas">{{ __('cancel') }}</a>
                <button type="submit" class="btn btn-primary">{{ __('update') }}</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="delete_timezone">
    <div class="modal-dialog modal-dialog-centered modal-sm rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('timezone_index_delete_modal_title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('timezone_index_delete_modal_message') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteTimezoneBtn">{{ __('delete') }}</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/datatable.js') }}"></script>
<script>
    // ========================================
    // 🎯 TIMEZONES MODULE CONFIGURATION
    // ========================================

    const timezonesDatatableConfig = {
        containerId: 'manage-timezones-list',
        apiEndpoint: '/api/v1/super-admin/timezones',
        perPage: 10,
        defaultSort: 'created_at',
        defaultOrder: 'desc',
        bulkActions: true,
        actions: {
            edit: true,
            delete: true
        },
        columns: [
            {
                field: 'name',
                header: "{{ __('table_name') }}",
                className: 'col-name',
                type: 'text'
            },
            {
                field: 'timezone',
                header: "{{ __('timezone_index_table_timezone') }}",
                className: 'col-timezone',
                type: 'text'
            },
            {
                field: 'utc',
                header: "{{ __('timezone_index_table_utc') }}",
                className: 'col-utc',
                type: 'text'
            },
            {
                field: 'is_active',
                header: "{{ __('table_status') }}",
                className: 'col-status',
                type: 'boolean'
            },
            {
                field: 'created_at',
                header: "{{ __('table_date') }}",
                className: 'col-date',
                type: 'date'
            }
        ]
    };

    let editModuleConfig = {
        modalId: '#offcanvas_edit',
        formId: 'editTimezoneForm',
        apiEndpoint: '/api/v1/super-admin/timezones'
    };

    // ========================================
    // 🔧 INITIALIZE PAGE
    // ========================================

    $(document).ready(function() {
        // Load countries for dropdowns
        loadCountriesForDropdowns();

        // Initialize datatable
        window.datatableInstance = new Datatable(timezonesDatatableConfig);

        // Handle add timezone form
        handleFormSubmit({
            formId: 'addTimezoneForm',
            apiEndpoint: '/api/v1/super-admin/timezones',
            method: 'POST',
            onSuccess: function() {
                const offcanvas = bootstrap.Offcanvas.getInstance(document.querySelector('#offcanvas_add'));
                if (offcanvas) offcanvas.hide();
                $('#addTimezoneForm')[0].reset();
                // Reset Select2
                $('#addTimezoneForm select[name="country_id"]').val(null).trigger('change');
                $('#addTimezoneActive').prop('checked', true);
                window.datatableInstance.refresh();
            }
        });

        // Handle edit timezone form - direct API call
        $('#editTimezoneForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            const timezoneId = $('#editTimezoneId').val();
            
            if (!timezoneId) {
                showToast('Timezone ID not found', 'error');
                return;
            }
            
            const formData = {
                country_id: $('#editTimezoneForm input[name="country_id"]').val() || $('#editTimezoneForm select[name="country_id"]').val(),
                name: $('#editTimezoneForm input[name="name"]').val(),
                timezone: $('#editTimezoneForm input[name="timezone"]').val(),
                utc: $('#editTimezoneForm input[name="utc"]').val(),
                is_active: $('#editTimezoneActive').is(':checked') ? 1 : 0
            };
            
            apiPut(`/api/v1/super-admin/timezones/${timezoneId}`, formData)
                .then(response => {
                    showToast('Timezone updated successfully', 'success');
                    const offcanvas = bootstrap.Offcanvas.getInstance(document.querySelector('#offcanvas_edit'));
                    if (offcanvas) offcanvas.hide();
                    window.datatableInstance.refresh();
                })
                .catch(error => {
                    console.error('Error updating timezone:', error);
                    showToast('Failed to update timezone', 'error');
                });
        });

        // Handle delete
        handleDelete({
            deleteButtonSelector: '.delete-item-btn',
            confirmSelector: '#delete_timezone',
            confirmButtonId: 'confirmDeleteTimezoneBtn',
            apiEndpoint: '/api/v1/super-admin/timezones',
            onSuccess: () => window.datatableInstance.refresh()
        });

        // Handle bulk delete
        handleBulkDelete({
            buttonSelector: '#bulkDeleteBtn',
            confirmSelector: '#delete_timezone',
            confirmButtonId: 'confirmDeleteTimezoneBtn',
            apiEndpoint: '/api/v1/super-admin/timezones',
            onSuccess: () => window.datatableInstance.refresh()
        });

        // Handle edit button click
        $(document).on('click', '.edit-item-btn', function() {
            const itemId = $(this).data('id');
            loadItemForEdit(itemId, editModuleConfig);
        });

        // Handle column management
        $('.column-toggle').on('change', function() {
            const columnClass = $(this).data('column');
            const isVisible = $(this).is(':checked');
            
            if (isVisible) {
                $(`.${columnClass}`).removeClass('d-none');
            } else {
                $(`.${columnClass}`).addClass('d-none');
            }
            
            const preferences = JSON.parse(localStorage.getItem('timezoneColumnPreferences') || '{}');
            preferences[columnClass] = isVisible;
            localStorage.setItem('timezoneColumnPreferences', JSON.stringify(preferences));
        });

        // Handle status filter
        $(document).on('change', '.status-filter', function() {
            const selectedStatus = [];
            $('.status-filter:checked').each(function() {
                selectedStatus.push(parseInt($(this).val()));
            });

            const filterParams = {};
            if (selectedStatus.length > 0) {
                filterParams.is_active = selectedStatus.join(',');
            }

            if (window.datatableInstance) {
                window.datatableInstance.filters = filterParams;
                window.datatableInstance.currentPage = 1;
                window.datatableInstance.load();
                showToast("{{ __('filter_applied') }}", 'success');
            }
        });

        // Handle sort options
        $(document).on('click', '.sort-option', function(e) {
            e.preventDefault();
            const order = $(this).data('order');
            if (window.datatableInstance) {
                window.datatableInstance.sort('created_at', order);
                showToast('Sorted by ' + (order === 'asc' ? 'Oldest' : 'Newest'), 'success');
            }
        });

        // Handle quick reset
        $('#quickReset').on('click', function() {
            $('.status-filter').prop('checked', false);
            
            if (window.datatableInstance) {
                window.datatableInstance.filters = {};
                window.datatableInstance.currentPage = 1;
                window.datatableInstance.load();
                showToast("{{ __('filter_reset') }}", 'success');
            }
        });

        // Load column preferences
        const preferences = JSON.parse(localStorage.getItem('timezoneColumnPreferences') || '{}');
        Object.keys(preferences).forEach(columnClass => {
            const isVisible = preferences[columnClass];
            const toggle = $(`.column-toggle[data-column="${columnClass}"]`);
            toggle.prop('checked', isVisible).trigger('change');
        });
    });




function loadCountriesForDropdowns() {
    apiGet('/api/v1/super-admin/get-countries')
        .then(response => {
            const countries = response.data.data;
            console.log('Countries loaded:', countries);

            const addCountrySelect = $('#addTimezoneForm select[name="country_id"]');
            const editCountrySelect = $('#editTimezoneForm select[name="country_id"]');

            // Destroy previous Select2
            if (addCountrySelect.hasClass("select2-hidden-accessible")) {
                addCountrySelect.select2('destroy');
            }
            if (editCountrySelect.hasClass("select2-hidden-accessible")) {
                editCountrySelect.select2('destroy');
            }

            // Reset options
            addCountrySelect.html('<option value="">Select Country</option>');
            editCountrySelect.html('<option value="">Select Country</option>');

            countries.forEach(country => {
                addCountrySelect.append(
                    `<option value="${country.id}">${country.name}</option>`
                );
                editCountrySelect.append(
                    `<option value="${country.id}">${country.name}</option>`
                );
            });

            // Select2 Configuration
            const select2Config = {
                placeholder: 'Select Country',
                allowClear: true,
                width: '100%',
                templateSelection: function(data) {
                    return data.text;
                }
            };

            // Init Select2 (Add)
            addCountrySelect.select2({
                ...select2Config,
                dropdownParent: $('#offcanvas_add')
            });

            // Init Select2 (Edit)
            editCountrySelect.select2({
                ...select2Config,
                dropdownParent: $('#offcanvas_edit')
            });

            // Handle clear button click for Add form
            addCountrySelect.on('select2:clearing', function() {
                addCountrySelect.val(null).trigger('change');
            });

            // Handle clear button click for Edit form
            editCountrySelect.on('select2:clearing', function() {
                editCountrySelect.val(null).trigger('change');
            });

        })
        .catch(error => {
            console.error('Error loading countries:', error);
            showToast('Failed to load countries', 'error');
        });
}

function loadItemForEdit(itemId, moduleConfig) {
    apiGet(`${moduleConfig.apiEndpoint}/${itemId}`)
        .then(response => {
            const timezone = response.data.data;

            $('#editTimezoneId').val(timezone.id);
            
            // Set Select2 value properly
            const countrySelect = $('#editTimezoneForm select[name="country_id"]');
            countrySelect.val(timezone.country_id || null).trigger('change');
            
            $('#editTimezoneForm input[name="name"]').val(timezone.name || '');
            $('#editTimezoneForm input[name="timezone"]').val(timezone.timezone || '');
            $('#editTimezoneForm input[name="utc"]').val(timezone.utc || '');
            
            if (timezone.is_active === 1 || timezone.is_active === true || timezone.is_active === '1') {
                $('#editTimezoneActive').prop('checked', true);
            } else {
                $('#editTimezoneActive').prop('checked', false);
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
