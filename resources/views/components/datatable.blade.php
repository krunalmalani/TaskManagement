{{-- resources/views/components/datatable.blade.php --}}
@props([
    'config' => [],
    'columns' => [],
    'title' => 'Manage Data',
    'breadcrumb' => [],
    'addButton' => true,
    'exportButton' => true,
    'refreshButton' => true,
    'collapseButton' => true,
    'filters' => [],
    'sortOptions' => [],
    'columnManagement' => true,
    'bulkActions' => true,
    'searchPlaceholder' => 'Search...'
])

<div class="content pb-0">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
        <div>
            <h4 class="mb-1">{{ $title }}<span class="badge badge-soft-primary ms-2" id="{{ $config['containerId'] ?? 'table' }}Count">0</span></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    @foreach($breadcrumb as $item)
                        @if(isset($item['url']))
                            <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                        @else
                            <li class="breadcrumb-item active">{{ $item['label'] }}</li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        </div>
        <div class="gap-2 d-flex align-items-center flex-wrap">
            @if($exportButton)
            <div class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-light px-2 shadow" data-bs-toggle="dropdown">
                    <i class="ti ti-package-export me-2"></i>Export
                </a>
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
            @endif
            
            @if($refreshButton)
            <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" 
               data-bs-toggle="tooltip" data-bs-placement="top" 
               title="Refresh" id="refreshTableBtn">
                <i class="ti ti-refresh"></i>
            </a>
            @endif
            
            @if($collapseButton)
            <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" 
               data-bs-toggle="tooltip" data-bs-placement="top" 
               title="Collapse" id="collapse-header">
                <i class="ti ti-transition-top"></i>
            </a>
            @endif
        </div>
    </div>
    
    <!-- card start -->
    <div class="card border-0 rounded-0">
        <div class="card-header d-flex align-items-center justify-content-between gap-2 flex-wrap">
            <div class="input-icon input-icon-start position-relative">
                <span class="input-icon-addon text-dark"><i class="ti ti-search"></i></span>
                <input type="text" class="form-control" id="{{ $config['searchFieldId'] ?? 'search' . ucfirst($config['containerId'] ?? 'table') }}" placeholder="{{ $searchPlaceholder }}">
            </div>
            
            @if($addButton && isset($config['addModalId']))
            <a href="javascript:void(0);" class="btn btn-primary" 
               data-bs-toggle="offcanvas" data-bs-target="{{ $config['addModalId'] }}">
                <i class="ti ti-square-rounded-plus-filled me-1"></i>Add {{ str_replace('Manage ', '', $title) }}
            </a>
            @endif
        </div>
        <div class="card-body">
            <!-- table header -->
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    @if($bulkActions)
                    <!-- Delete All Button -->
                    <a href="javascript:void(0);" class="btn btn-danger px-2 d-none" 
                       id="bulkDeleteBtn" title="Delete selected items">
                        <i class="ti ti-trash me-1"></i>Delete All
                    </a>
                    @endif
                    
                    @if(!empty($sortOptions))
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-light px-2 shadow" 
                           data-bs-toggle="dropdown">
                            <i class="ti ti-sort-ascending-2 me-2"></i>Sort By
                        </a>
                        <div class="dropdown-menu">
                            <ul>
                                @foreach($sortOptions as $option)
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item sort-option" 
                                       data-order="{{ $option['order'] }}">
                                        <i class="ti ti-arrow-{{ $option['icon'] }} me-1"></i>{{ $option['label'] }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                    
                    @if(isset($filters['dateRange']))
                    <div id="reportrange" class="btn btn-outline-light px-2 shadow d-flex align-items-center" 
                         style="cursor: pointer;">
                        <i class="ti ti-calendar-due text-dark fs-14 me-2"></i>
                        <span class="reportrange-picker-field">Today</span>
                        <i class="ti ti-chevron-down ms-2" style="font-size: 12px;"></i>
                    </div>
                    @endif
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    @if(!empty($filters))
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="btn btn-outline-light shadow px-2" 
                           data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="ti ti-filter me-2"></i>Filter<i class="ti ti-chevron-down ms-2"></i>
                        </a>
                        <div class="filter-dropdown-menu dropdown-menu dropdown-menu-lg p-0">
                            <div class="filter-header d-flex align-items-center justify-content-between border-bottom">
                                <h6 class="mb-0"><i class="ti ti-filter me-1"></i>Filter</h6>
                                <button type="button" class="btn-close close-filter-btn" 
                                        data-bs-dismiss="dropdown-menu" aria-label="Close"></button>
                            </div>
                            <div class="filter-set-view p-3">
                                @foreach($filters as $key => $filter)
                                @if(is_array($filter) && $filter['type'] === 'checkbox')
                                <div class="filter-content-list">
                                    <h6 class="mb-2">{{ $filter['label'] }}</h6>
                                    <ul class="mb-0">
                                        @foreach($filter['options'] as $option)
                                        <li>
                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                <input class="form-check-input m-0 me-2 {{ $key }}-filter" 
                                                       type="checkbox" value="{{ $option['value'] }}" 
                                                       id="filter{{ ucfirst($option['value']) }}">
                                                <span>{{ $option['label'] }}</span>
                                            </label>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Reset Button -->
                    <a href="javascript:void(0);" class="btn btn-outline-light shadow px-2" 
                       id="quickReset" title="Reset all filters">
                        <i class="ti ti-refresh me-1"></i>Reset
                    </a>
                    
                    @if($columnManagement)
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="btn bg-soft-indigo px-2 border-0" 
                           data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="ti ti-columns-3 me-2"></i>Manage Columns
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-md p-3">
                            <ul>
                                @foreach($columns as $column)
                                <li class="gap-1 d-flex align-items-center mb-2">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>{{ $column['header'] }}</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto column-toggle" 
                                                   type="checkbox" role="switch" 
                                                   data-column="{{ $column['className'] }}" checked>
                                        </label>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <!-- table header -->

            <!-- Table -->
            <div class="table-responsive custom-table">
                <table class="table table-nowrap" id="{{ $config['containerId'] ?? 'dataTable' }}">
                    <thead>
                        <tr>
                            @if($bulkActions)
                            <th>
                                <div class="form-check form-check-md d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" id="checkboxAll">
                                    <label class="form-check-label" for="checkboxAll"></label>
                                </div>
                            </th>
                            @endif
                            
                            @foreach($columns as $column)
                            <th class="{{ $column['className'] }} @if($column['sortable']) sort-column @endif" 
                                @if($column['sortable']) data-sort-field="{{ $column['field'] }}" style="cursor: pointer;" @endif>
                                <div class="d-flex align-items-center gap-2">
                                    <span>{{ $column['header'] }}</span>
                                    @if($column['sortable'])
                                    <i class="ti ti-arrow-up text-muted sort-icon"></i>
                                    @endif
                                </div>
                            </th>
                            @endforeach
                            
                            <th class="col-actions text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="{{ $config['containerId'] ?? 'table' }}Body">
                        <!-- Data loaded via AJAX/DataTables -->
                    </tbody>
                </table>
            </div>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 fs-14 text-muted">
                        <span id="paginationStart">0</span> to <span id="paginationEnd">0</span> 
                        of <span id="totalItems">0</span> entries
                    </p>
                </div>
                <div class="col-md-6">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm justify-content-end" id="paginationContainer">
                            <!-- Pagination controls updated via AJAX -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>