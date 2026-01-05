<?php 
    $userData = Session::get('user');
?>
@extends('layouts.master', ['title' => 'Manage Currencies'])

@section('title')
    <title>{{ __('currency_index_page_title') }}</title>
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
        'containerId' => 'manage-currencies-list',
        'apiEndpoint' => '/api/v1/super-admin/currencies',
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
            'field' => 'code',
            'header' => __('code'),
            'className' => 'col-code',
            'sortable' => true
        ],
        [
            'field' => 'symbol',
            'header' => __('symbol'),
            'className' => 'col-symbol',
            'sortable' => true
        ],
        [
            'field' => 'country',
            'header' => __('table_country'),
            'className' => 'col-country',
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
        ['url' => route('super-admin-dashboard'), 'label' => __('currency_index_breadcrumb_parent')],
        ['label' => __('currency_index_breadcrumb_current')]
    ];
@endphp

<x-datatable 
    :config="$tableConfig"
    :columns="$columns"
    title="{{ __('currency_index_title') }}"
    :breadcrumb="$breadcrumb"
    :filters="$filters"
    :sortOptions="$sortOptions"
    searchPlaceholder="{{ __('currency_index_search_placeholder') }}"
/>

    <!-- Add Currency Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">{{ __('currency_index_add_modal_title') }}</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="addCurrencyForm">
                <div>
                    <!-- Basic Info -->
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('currency_index_form_country_id') }} <span class="text-danger">*</span></label>
                                    <select name="country_id" class="form-select select2" required>
                                        <option value="">Select Country</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('currency_index_form_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter currency name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('currency_index_form_code') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="code" class="form-control" placeholder="{{ __('currency_index_form_code_placeholder') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('currency_index_form_symbol') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="symbol" class="form-control" placeholder="{{ __('currency_index_form_symbol_placeholder') }}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('status') }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="addCurrencyStatus" name="is_active" value="1" checked>
                                        <label class="form-check-label" for="addCurrencyStatus">{{ __('currency_index_form_active') }}</label>
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

    <!-- Edit Currency Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_edit">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">{{ __('currency_index_edit_modal_title') }}</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="editCurrencyForm">
                <input type="hidden" name="id" id="editCurrencyId">
                <div class="mb-3">
                    <label class="form-label">{{ __('currency_index_form_country_id') }} <span class="text-danger">*</span></label>
                    <select name="country_id" class="form-select select2" required>
                        <option value="">Select Country</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('currency_index_form_name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Enter currency name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('currency_index_form_code') }} <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control" placeholder="{{ __('currency_index_form_code_placeholder') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('currency_index_form_symbol') }} <span class="text-danger">*</span></label>
                    <input type="text" name="symbol" class="form-control" placeholder="{{ __('currency_index_form_symbol_placeholder') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('status') }}</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="editCurrencyStatus" name="is_active" value="1">
                        <label class="form-check-label" for="editCurrencyStatus">{{ __('currency_index_form_active') }}</label>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <button type="submit" class="btn btn-primary">{{ __('update') }}</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ __('close') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="delete_currency">
        <div class="modal-dialog modal-dialog-centered modal-sm rounded-0">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('currency_index_delete_modal_title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('currency_index_delete_modal_message') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteCurrencyBtn">{{ __('delete') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/datatable.js') }}"></script>
<script>
    // ========================================
    // 🎯 CURRENCIES MODULE CONFIGURATION
    // ========================================

    const currenciesDatatableConfig = {
        containerId: 'manage-currencies-list',
        apiEndpoint: '/api/v1/super-admin/currencies',
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
                field: 'code',
                header: "{{ __('code') }}",
                className: 'col-code',
                type: 'text'
            },
            {
                field: 'symbol',
                header: "{{ __('symbol') }}",
                className: 'col-symbol',
                type: 'text'
            },
            {
                field: 'country',
                header: "{{ __('table_country') }}",
                className: 'col-country',
                type: 'text',
                render: function(value, item) {
                    return item.country ? item.country.name : 'N/A';
                }
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
        formId: 'editCurrencyForm',
        apiEndpoint: '/api/v1/super-admin/currencies'
    };

    // ========================================
    // 🔧 INITIALIZE PAGE
    // ========================================

    $(document).ready(function() {
        // Load countries for dropdowns
        loadCountriesForDropdowns();

        // Initialize datatable
        window.datatableInstance = new Datatable(currenciesDatatableConfig);

        // Handle add currency form
        handleFormSubmit({
            formId: 'addCurrencyForm',
            apiEndpoint: '/api/v1/super-admin/currencies',
            method: 'POST',
            onSuccess: function() {
                const offcanvas = bootstrap.Offcanvas.getInstance(document.querySelector('#offcanvas_add'));
                if (offcanvas) offcanvas.hide();
                $('#addCurrencyForm')[0].reset();
                // Reset Select2
                $('#addCurrencyForm select[name="country_id"]').val(null).trigger('change');
                $('#addCurrencyStatus').prop('checked', true);
                window.datatableInstance.refresh();
            }
        });

        // Handle edit currency form
        handleFormSubmit({
            formId: 'editCurrencyForm',
            apiEndpoint: '/api/v1/super-admin/currencies',
            method: 'PUT',
            onSuccess: function() {
                const offcanvas = bootstrap.Offcanvas.getInstance(document.querySelector('#offcanvas_edit'));
                if (offcanvas) offcanvas.hide();
                window.datatableInstance.refresh();
            }
        });

        // Handle delete
        handleDelete({
            deleteButtonSelector: '.delete-item-btn',
            confirmSelector: '#delete_currency',
            confirmButtonId: 'confirmDeleteCurrencyBtn',
            apiEndpoint: '/api/v1/super-admin/currencies',
            onSuccess: () => window.datatableInstance.refresh()
        });

        // Handle bulk delete
        handleBulkDelete({
            buttonSelector: '#bulkDeleteBtn',
            confirmSelector: '#delete_currency',
            confirmButtonId: 'confirmDeleteCurrencyBtn',
            apiEndpoint: '/api/v1/super-admin/currencies',
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
            
            const preferences = JSON.parse(localStorage.getItem('currencyColumnPreferences') || '{}');
            preferences[columnClass] = isVisible;
            localStorage.setItem('currencyColumnPreferences', JSON.stringify(preferences));
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
        const preferences = JSON.parse(localStorage.getItem('currencyColumnPreferences') || '{}');
        Object.keys(preferences).forEach(columnClass => {
            const isVisible = preferences[columnClass];
            const toggle = $(`.column-toggle[data-column="${columnClass}"]`);
            toggle.prop('checked', isVisible).trigger('change');
        });
    });

    // Helper functions
    function loadCountriesForDropdowns() {
        apiGet('/api/v1/super-admin/get-currencies-countries')
            .then(response => {
                const countries = response.data.data;

                const addCountrySelect = $('#addCurrencyForm select[name="country_id"]');
                const editCountrySelect = $('#editCurrencyForm select[name="country_id"]');

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
                const currency = response.data.data;

                $('#editCurrencyId').val(currency.id);
                
                // Set Select2 value properly
                const countrySelect = $('#editCurrencyForm select[name="country_id"]');
                countrySelect.val(currency.country_id || null).trigger('change');
                
                $('#editCurrencyForm input[name="name"]').val(currency.name || '');
                $('#editCurrencyForm input[name="code"]').val(currency.code || '');
                $('#editCurrencyForm input[name="symbol"]').val(currency.symbol || '');
                
                if (currency.is_active === 1 || currency.is_active === true || currency.is_active === '1') {
                    $('#editCurrencyStatus').prop('checked', true);
                } else {
                    $('#editCurrencyStatus').prop('checked', false);
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

