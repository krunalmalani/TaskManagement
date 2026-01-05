
<?php 
    $userData = Session::get('user');
?>
@extends('layouts.master', ['title' => 'Manage Cities'])

@section('title')
    <title>{{ __('city_index_page_title') }}</title>
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
        'containerId' => 'manage-states-list',
        'apiEndpoint' => '/api/v1/super-admin/cities',
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
            'field' => 'state',
            'header' => __('state'),
            'className' => 'col-state',
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
        ['url' => route('super-admin-dashboard'), 'label' => __('city_index_breadcrumb_parent')],
        ['label' => __('city_index_breadcrumb_current')]
    ];
@endphp

<x-datatable 
    :config="$tableConfig"
    :columns="$columns"
    title="{{ __('city_index_title') }}"
    :breadcrumb="$breadcrumb"
    :filters="$filters"
    :sortOptions="$sortOptions"
    searchPlaceholder="{{ __('city_index_search_placeholder') }}"
/>

    <!-- Add City Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">{{ __('city_index_add_modal_title') }}</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="addCityForm">
                <div>
                    <!-- Basic Info -->
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('city_index_form_state_id') }} <span class="text-danger">*</span></label>
                                    <select name="state_id" class="form-select select2" required>
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('city_index_form_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter city name" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('status') }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="addCityStatus" name="is_active" value="1" checked>
                                        <label class="form-check-label" for="addCityStatus">{{ __('city_index_form_active') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Basic Info -->
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <a href="javascript:void(0);" class="btn btn-light me-2" data-bs-dismiss="offcanvas">{{ __('city_index_buttons_cancel') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('city_index_buttons_create') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit City Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_edit">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">{{ __('city_index_edit_modal_title') }}</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="editCityForm">
                <input type="hidden" name="id" id="editStateId">
                <div class="mb-3">
                    <label class="form-label">{{ __('city_index_form_state_id') }} <span class="text-danger">*</span></label>
                    <select name="state_id" class="form-select select2" required>
                        <option value="">Select State</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('city_index_form_name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Enter city name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('status') }}</label>
                    <div class="form-check form-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" id="editCityStatus" name="is_active" value="1">
                        <label class="form-check-label" for="editCityStatus">{{ __('city_index_form_active') }}</label>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <button type="submit" class="btn btn-primary">{{ __('city_index_buttons_update') }}</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ __('city_index_buttons_close') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="delete_city">
        <div class="modal-dialog modal-dialog-centered modal-sm rounded-0">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('city_index_delete_modal_title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('city_index_delete_modal_message') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('city_index_buttons_cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteCityBtn">{{ __('city_index_buttons_delete') }}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script src="{{ asset('assets/js/datatable.js') }}"></script>
<script>
// ========================================
// 🎯 STATES MODULE CONFIGURATION
// ========================================

const statesDatatableConfig = {
    containerId: 'manage-states-list',
    apiEndpoint: '/api/v1/super-admin/cities',
    perPage: 10,
    defaultSort: 'created_at',
    defaultOrder: 'desc',
    columns: [
        {
            field: 'name',
            header: "{{ __('table_name') }}",
            className: 'col-name',
            type: 'text'
        },
        {
            field: 'state',
            header: "{{ __('state') }}",
            className: 'col-state',
            type: 'text',
            render: function(value, item) {
                return item.state ? item.state.name : 'N/A';
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
    ],
    bulkActions: true,
    actions: {
        edit: true,
        delete: true
    }
};

let editModuleConfig = {
    modalId: '#offcanvas_edit',
    formId: 'editCityForm',
    apiEndpoint: '/api/v1/super-admin/cities'
};

// ========================================
// 🔧 INITIALIZE PAGE
// ========================================

$(document).ready(function() {
    // Load states for dropdowns
    loadStatesForDropdowns();

    // Initialize datatable
    window.datatableInstance = new Datatable(statesDatatableConfig);

    // Handle add state form
    handleFormSubmit({
        formId: 'addCityForm',
        apiEndpoint: '/api/v1/super-admin/cities',
        method: 'POST',
        onSuccess: function() {
            const offcanvas = bootstrap.Offcanvas.getInstance(document.querySelector('#offcanvas_add'));
            if (offcanvas) offcanvas.hide();
            $('#addCityForm')[0].reset();
            // Reset Select2
            $('#addCityForm select[name="state_id"]').val(null).trigger('change');
            $('#addCityStatus').prop('checked', true);
            window.datatableInstance.refresh();
        }
    });

    // Handle edit City form
    handleFormSubmit({
        formId: 'editCityForm',
        apiEndpoint: '/api/v1/super-admin/cities',
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
        confirmSelector: '#delete_city',
        confirmButtonId: 'confirmDeleteCityBtn',
        apiEndpoint: '/api/v1/super-admin/cities',
        onSuccess: () => window.datatableInstance.refresh()
    });

    // Handle bulk delete
    handleBulkDelete({
        buttonSelector: '#bulkDeleteBtn',
        confirmSelector: '#delete_city',
        confirmButtonId: 'confirmDeleteCityBtn',
        apiEndpoint: '/api/v1/super-admin/cities',
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
        
        const preferences = JSON.parse(localStorage.getItem('stateColumnPreferences') || '{}');
        preferences[columnClass] = isVisible;
        localStorage.setItem('stateColumnPreferences', JSON.stringify(preferences));
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
    const preferences = JSON.parse(localStorage.getItem('stateColumnPreferences') || '{}');
    Object.keys(preferences).forEach(columnClass => {
        const isVisible = preferences[columnClass];
        const toggle = $(`.column-toggle[data-column="${columnClass}"]`);
        toggle.prop('checked', isVisible).trigger('change');
    });
});


function loadStatesForDropdowns() {
    apiGet('/api/v1/super-admin/get-states')
        .then(response => {
            const states = response.data.data;

            const addstateSelect = $('#addCityForm select[name="state_id"]');
            const editstateSelect = $('#editCityForm select[name="state_id"]');

            // Destroy previous Select2
            if (addstateSelect.hasClass("select2-hidden-accessible")) {
                addstateSelect.select2('destroy');
            }
            if (editstateSelect.hasClass("select2-hidden-accessible")) {
                editstateSelect.select2('destroy');
            }

            // Reset options
            addstateSelect.html('<option value="">Select State</option>');
            editstateSelect.html('<option value="">Select State</option>');

            states.forEach(state => {
                addstateSelect.append(
                    `<option value="${state.id}">${state.name}</option>`
                );
                editstateSelect.append(
                    `<option value="${state.id}">${state.name}</option>`
                );
            });

            // Init Select2 (Add)
            addstateSelect.select2({
                placeholder: 'Select State',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#offcanvas_add')
            });

            // Init Select2 (Edit)
            editstateSelect.select2({
                placeholder: 'Select State',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#offcanvas_edit')
            });
        })
        .catch(error => {
            console.error('Error loading states:', error);
            showToast('Failed to load states', 'error');
        });
}

function loadItemForEdit(itemId, moduleConfig) {
    apiGet(`${moduleConfig.apiEndpoint}/${itemId}`)
        .then(response => {
            const state = response.data.data;

            $('#editStateId').val(state.id);
            
            // Set Select2 value properly
            const stateSelect = $('#editCityForm select[name="state_id"]');
            stateSelect.val(state.state_id || null).trigger('change');
            
            $('#editCityForm input[name="name"]').val(state.name || '');
            
            if (state.is_active === 1 || state.is_active === true || state.is_active === '1') {
                $('#editCityStatus').prop('checked', true);
            } else {
                $('#editCityStatus').prop('checked', false);
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

