<?php 
    $userData = Session::get('user');
?>
@extends('layouts.master', ['title' => 'Manage Countries'])

@section('title')
    <title>{{ __('country_index_page_title') }}</title>
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
            'field' => 'short_name',
            'header' => __('country_index_table_short_name'),
            'className' => 'col-short-name',
            'sortable' => true
        ],
        [
            'field' => 'is_active',
            'header' => __('table_status'),
            'className' => 'col-status',
            'sortable' => true,
            'type' => 'boolean'
        ]
    ];
    
    $filters = [
        'status' => [
            'type' => 'checkbox',
            'label' => __('status'),
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
        ['url' => route('super-admin-countries-index'), 'label' => __('country_index_breadcrumb_parent')],
        ['label' => __('country_index_breadcrumb_current')]
    ];
@endphp

<x-datatable 
    :config="$tableConfig"
    :columns="$columns"
    title="{{ __('country_index_title') }}"
    :breadcrumb="$breadcrumb"
    :filters="$filters"
    :sortOptions="$sortOptions"
    searchPlaceholder="{{ __('country_index_search_placeholder') }}"
/>
 <!-- Add Country Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">{{ __('country_index_add_modal_title') }}</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="addCountryForm">
                <div>
                    <!-- Basic Info -->
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('country_index_form_country_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter country name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('country_index_form_country_code') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="code" class="form-control" placeholder="e.g., 91" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('country_index_form_short_name') }}</label>
                                    <input type="text" name="short_name" class="form-control" placeholder="e.g., IND">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('status') }}</label>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="is_active" value="0">
                                        <input class="form-check-input" type="checkbox" id="addCountryStatus" name="is_active" value="1" checked>
                                        <label class="form-check-label" for="addCountryStatus">{{ __('active') }}</label>
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

    <!-- Edit Country Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_edit">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">{{ __('country_index_edit_modal_title') }}</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="editCountryForm">
                <input type="hidden" name="id" id="editCountryId">
                <div class="mb-3">
                    <label class="form-label">{{ __('country_index_form_country_name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="editCountryName" class="form-control" placeholder="Enter country name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('country_index_form_country_code') }} <span class="text-danger">*</span></label>
                    <input type="text" name="code" id="editCountryCode" class="form-control" placeholder="e.g., 91" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('country_index_form_short_name') }}</label>
                    <input type="text" name="short_name" id="editCountryShortName" class="form-control" placeholder="e.g., USA, GBR">
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('status') }}</label>
                    <div class="form-check form-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" id="editCountryStatus" name="is_active" value="1">
                        <label class="form-check-label" for="editCountryStatus">{{ __('active') }}</label>
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
    <div class="modal fade" id="delete_country">
        <div class="modal-dialog modal-dialog-centered modal-sm rounded-0">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('country_index_delete_modal_title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('country_index_delete_modal_message') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteCountryBtn">{{ __('delete') }}</button>
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
                    header: "{{ __('table_name') }}",
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
                    header: "{{ __('code') }}",
                    className: 'col-code'
                },
                {
                    field: 'short_name',
                    header: 'Short Name',
                    className: 'col-short-name'
                },
                {
                    field: 'is_active',
                    header: "{{ __('table_status') }}",
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

            // Handle add country form
            handleFormSubmit({
                formId: 'addCountryForm',
                apiEndpoint: '/api/v1/super-admin/countries',
                method: 'POST',
                onSuccess: function() {
                    const offcanvas = bootstrap.Offcanvas.getInstance(document.querySelector('#offcanvas_add'));
                    if (offcanvas) offcanvas.hide();
                    $('#addCountryForm')[0].reset();
                    $('#addCountryStatus').prop('checked', true);
                    window.datatableInstance.refresh();
                }
            });

            // Handle edit country form
            handleFormSubmit({
                formId: 'editCountryForm',
                apiEndpoint: '/api/v1/super-admin/countries',
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

            // Handle edit button click
            $(document).on('click', '.edit-item-btn', function() {
                const itemId = $(this).data('id');
                loadItemForEdit(itemId, {
                    modalId: '#offcanvas_edit',
                    formId: 'editCountryForm',
                    apiEndpoint: '/api/v1/super-admin/countries'
                });
            });

            // Handle column management
            $('.column-toggle').on('change', function() {
                const columnClass = $(this).data('column');
                const isChecked = $(this).is(':checked');
                const table = $(`#${countriesDatatableConfig.containerId}`);
                
                const elements = table.find(`th.${columnClass}, td.${columnClass}`);
                if (isChecked) {
                    elements.removeClass('d-none').show();
                } else {
                    elements.addClass('d-none').hide();
                }
            });

            // Handle status filter
            $(document).on('change', '.status-filter', function() {
                const selectedStatus = [];
                $('.status-filter:checked').each(function() {
                    selectedStatus.push(parseInt($(this).val()));
                });

                if (selectedStatus.length > 0) {
                    window.datatableInstance.applyFilter('is_active', selectedStatus.join(','));
                } else {
                    delete window.datatableInstance.filters.is_active;
                    window.datatableInstance.currentPage = 1;
                    window.datatableInstance.load();
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
                window.datatableInstance.resetFilters();
                showToast("{{ __('filter_reset') }}", 'success');
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
    // Helper functions
        function loadItemForEdit(itemId, moduleConfig) {
            apiGet(`${moduleConfig.apiEndpoint}/${itemId}`)
                .then(response => {
                    const country = response.data.data;

                    $('#editCountryId').val(country.id);
                    $('#editCountryForm input[name="name"]').val(country.name || '');
                    $('#editCountryForm input[name="code"]').val(country.code || '');
                    $('#editCountryForm input[name="short_name"]').val(country.short_name || '');
                    
                    if (country.is_active === 1 || country.is_active === true || country.is_active === '1') {
                        $('#editCountryStatus').prop('checked', true);
                    } else {
                        $('#editCountryStatus').prop('checked', false);
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