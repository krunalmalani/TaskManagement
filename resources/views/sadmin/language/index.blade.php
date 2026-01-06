<?php 
    $userData = Session::get('user');
?>
@extends('layouts.master', ['title' => 'Manage Languages'])

@section('title')
    <title>{{ __('language_index_page_title') }}</title>
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
        'containerId' => 'manage-languages-list',
        'apiEndpoint' => '/api/v1/super-admin/languages',
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
            'field' => 'short_name',
            'header' => __('language_index_table_short_name'),
            'className' => 'col-short-name',
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
        ['url' => route('super-admin-dashboard'), 'label' => __('language_index_breadcrumb_parent')],
        ['label' => __('language_index_breadcrumb_current')]
    ];
@endphp

<x-datatable 
    :config="$tableConfig"
    :columns="$columns"
    title="{{ __('language_index_title') }}"
    :breadcrumb="$breadcrumb"
    :filters="$filters"
    :sortOptions="$sortOptions"
    searchPlaceholder="{{ __('language_index_search_placeholder') }}"
/>

<!-- Add Language Offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add">
    <div class="offcanvas-header border-bottom">
        <h5 class="fw-semibold">{{ __('language_index_add_modal_title') }}</h5>
        <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="ti ti-x"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <form id="addLanguageForm">
            <div>
                <!-- Basic Info -->
                <div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{ __('language_index_form_name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="e.g., English" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{ __('language_index_form_short_name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="short_name" class="form-control" placeholder="e.g., EN" maxlength="2" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{ __('status') }}</label>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="addLanguageActive" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="addLanguageActive">{{ __('active') }}</label>
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

<!-- Edit Language Offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_edit">
    <div class="offcanvas-header border-bottom">
        <h5 class="fw-semibold">{{ __('language_index_edit_modal_title') }}</h5>
        <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="ti ti-x"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <form id="editLanguageForm">
            <input type="hidden" id="editLanguageId" name="language_id">
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('language_index_form_name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., English" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('language_index_form_short_name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="short_name" class="form-control" placeholder="e.g., EN" maxlength="2" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('status') }}</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="editLanguageActive" name="is_active" value="1">
                                <label class="form-check-label" for="editLanguageActive">{{ __('active') }}</label>
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
<div class="modal fade" id="delete_language">
    <div class="modal-dialog modal-dialog-centered modal-sm rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('language_index_delete_modal_title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('language_index_delete_modal_message') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteLanguageBtn">{{ __('delete') }}</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script src="{{ asset('assets/js/datatable.js') }}"></script>
    <script>
        // ========================================
        // 🎯 LANGUAGES MODULE CONFIGURATION
        // ========================================

        const languagesDatatableConfig = {
            containerId: 'manage-languages-list',
            apiEndpoint: '/api/v1/super-admin/languages',
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
                    field: 'short_name',
                    header: "{{ __('language_index_table_short_name') }}",
                    className: 'col-short-name',
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
            formId: 'editLanguageForm',
            apiEndpoint: '/api/v1/super-admin/languages'
        };

        // ========================================
        // 🔧 INITIALIZE PAGE
        // ========================================

        $(document).ready(function() {
            // Initialize datatable
            window.datatableInstance = new Datatable(languagesDatatableConfig);

            // Handle add language form
            handleFormSubmit({
                formId: 'addLanguageForm',
                apiEndpoint: '/api/v1/super-admin/languages',
                method: 'POST',
                onSuccess: function() {
                    const offcanvas = bootstrap.Offcanvas.getInstance(document.querySelector('#offcanvas_add'));
                    if (offcanvas) offcanvas.hide();
                    $('#addLanguageForm')[0].reset();
                    $('#addLanguageActive').prop('checked', true);
                    window.datatableInstance.refresh();
                }
            });

            // Handle edit language form - direct API call
            $('#editLanguageForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                const languageId = $('#editLanguageId').val();
                
                if (!languageId) {
                    showToast('Language ID not found', 'error');
                    return;
                }
                
                const formData = {
                    name: $('#editLanguageForm input[name="name"]').val(),
                    short_name: $('#editLanguageForm input[name="short_name"]').val(),
                    is_active: $('#editLanguageActive').is(':checked') ? 1 : 0
                };
                
                apiPut(`/api/v1/super-admin/languages/${languageId}`, formData)
                    .then(response => {
                        showToast('Language updated successfully', 'success');
                        const offcanvas = bootstrap.Offcanvas.getInstance(document.querySelector('#offcanvas_edit'));
                        if (offcanvas) offcanvas.hide();
                        window.datatableInstance.refresh();
                    })
                    .catch(error => {
                        console.error('Error updating language:', error);
                        showToast('Failed to update language', 'error');
                    });
            });

            // Handle delete
            handleDelete({
                deleteButtonSelector: '.delete-item-btn',
                confirmSelector: '#delete_language',
                confirmButtonId: 'confirmDeleteLanguageBtn',
                apiEndpoint: '/api/v1/super-admin/languages',
                onSuccess: () => window.datatableInstance.refresh()
            });

            // Handle bulk delete
            handleBulkDelete({
                buttonSelector: '#bulkDeleteBtn',
                confirmSelector: '#delete_language',
                confirmButtonId: 'confirmDeleteLanguageBtn',
                apiEndpoint: '/api/v1/super-admin/languages',
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
                
                const preferences = JSON.parse(localStorage.getItem('languageColumnPreferences') || '{}');
                preferences[columnClass] = isVisible;
                localStorage.setItem('languageColumnPreferences', JSON.stringify(preferences));
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
            const preferences = JSON.parse(localStorage.getItem('languageColumnPreferences') || '{}');
            Object.keys(preferences).forEach(columnClass => {
                const isVisible = preferences[columnClass];
                const toggle = $(`.column-toggle[data-column="${columnClass}"]`);
                toggle.prop('checked', isVisible).trigger('change');
            });
        });

        // Helper functions
        function loadItemForEdit(itemId, moduleConfig) {
            apiGet(`${moduleConfig.apiEndpoint}/${itemId}`)
                .then(response => {
                    console.log('Language response:', response);
                    const language = response.data.data;

                    $('#editLanguageId').val(language.id);
                    $('#editLanguageForm input[name="name"]').val(language.name || '');
                    $('#editLanguageForm input[name="short_name"]').val(language.short_name || '');
                    
                    if (language.is_active === 1 || language.is_active === true || language.is_active === '1') {
                        $('#editLanguageActive').prop('checked', true);
                    } else {
                        $('#editLanguageActive').prop('checked', false);
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
