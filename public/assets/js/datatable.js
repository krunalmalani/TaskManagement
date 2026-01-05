// public/js/datatable.js
class Datatable {
    constructor(config) {
        this.config = config;
        this.currentPage = 1;
        this.perPage = config.perPage || 10;
        this.currentSort = config.defaultSort || 'created_at';
        this.currentOrder = config.defaultOrder || 'desc';
        this.filters = {};
        this.selectedItems = [];
        
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.load();
    }
    
    setupEventListeners() {
        // Search with debounce - use custom searchFieldId if provided, otherwise generate one
        const searchFieldId = this.config.searchFieldId || `search${this.config.containerId.charAt(0).toUpperCase() + this.config.containerId.slice(1)}`;
        const searchInput = $(`#${searchFieldId}`);
        
        if (searchInput.length) {
            searchInput.on('input', debounce(() => this.search(searchFieldId), 300));
        }
        
        // Sort
        $(document).on('click', '.sort-column', (e) => {
            const sortField = $(e.currentTarget).data('sort-field');
            if (sortField) this.sort(sortField);
        });
        
        // Refresh
        $('#refreshTableBtn').on('click', () => this.refresh());
        
        // Bulk actions
        $('#checkboxAll').on('change', (e) => this.toggleSelectAll(e.target.checked));
        $(document).on('change', `#${this.config.containerId}Body input[type="checkbox"]`, () => this.updateBulkActions());
    }
    
    async load() {
        try {
            const params = {
                page: this.currentPage,
                per_page: this.perPage,
                sort: this.currentSort,
                order: this.currentOrder,
                ...this.filters
            };
            
            const response = await apiGet(this.config.apiEndpoint, { params });
            
            console.log('API Response:', response);
            
            // Handle API response structure: { data: { success: true, message: '...', data: {...} } }
            let paginationData = null;
            
            if (response.data && response.data.data && response.data.data.data) {
                // Check if response.data.data.data is the pagination object or if it needs unwrapping
                const innerData = response.data.data.data;
                
                if (innerData.data && Array.isArray(innerData.data)) {
                    // Pagination object with data array
                    paginationData = innerData;
                } else if (Array.isArray(innerData)) {
                    // Plain array
                    paginationData = { data: innerData, total: innerData.length };
                }
            } else if (response.data && response.data.data && Array.isArray(response.data.data)) {
                // Direct pagination object with data array
                paginationData = { data: response.data.data, total: response.data.total || 0 };
            } else if (Array.isArray(response.data)) {
                // Plain array response
                paginationData = { data: response.data, total: response.total || 0 };
            } else {
                console.error('Unexpected response structure:', response);
                showToast('Invalid data format', 'error');
                return;
            }
            
            console.log('Pagination Data:', paginationData);
            this.render(paginationData);
        } catch (error) {
            console.error('Error loading data:', error);
            showToast('Failed to load data', 'error');
        }
    }
    
    render(data) {
        this.updateCount(data.total);
        this.renderTable(data.data);
        this.renderPagination(data);
        this.updateBulkActions();
    }
    
    renderTable(items) {
        const tbody = $(`#${this.config.containerId}Body`);
        tbody.empty();
        
        // Handle case where items might not be an array
        if (!items || !Array.isArray(items)) {
            console.error('Items is not an array:', items);
            tbody.append('<tr><td colspan="100%" class="text-center">No data found</td></tr>');
            return;
        }
        
        if (items.length === 0) {
            tbody.append('<tr><td colspan="100%" class="text-center">No records found</td></tr>');
            return;
        }
        
        items.forEach(item => {
            const row = this.createTableRow(item);
            tbody.append(row);
        });
    }
    
    createTableRow(item) {
        const row = $('<tr></tr>');
        
        // Checkbox for bulk actions
        if (this.config.bulkActions !== false) {
            row.append(`
                <td>
                    <div class="form-check form-check-md d-flex align-items-center">
                        <input class="form-check-input row-checkbox" type="checkbox" value="${item.id}">
                    </div>
                </td>
            `);
        }
        
        // Data columns
        this.config.columns.forEach(column => {
            let content = '';
            
            if (column.render) {
                content = column.render(item[column.field], item);
            } else if (column.type === 'boolean') {
                content = this.renderBoolean(item[column.field]);
            } else if (column.type === 'date') {
                content = this.formatDate(item[column.field]);
            } else {
                content = item[column.field] || '';
            }
            
            row.append(`<td class="${column.className}">${content}</td>`);
        });
        
        // Actions column
        row.append(this.renderActions(item));
        
        return row;
    }
    
    renderBoolean(value) {
        const isActive = value === true || value === 1 || value === '1';
        return `
            <span class="badge ${isActive ? 'bg-success' : 'bg-danger'} rounded-0">
                ${isActive ? 'Active' : 'Inactive'}
            </span>
        `;
    }
    
    formatDate(dateString) {
        if (!dateString) return '';
        return moment(dateString).format('MMM D, YYYY');
    }
    
    renderActions(item) {
        return `
            <td class="col-actions text-end">
                <div class="d-flex align-items-center justify-content-end">
                    <div class="dropdown">
                        <button class="btn btn-icon btn-sm rounded-circle dropdown-toggle drop-arrow-none" 
                                data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            ${this.config.actions?.edit ? `
                            <a class="dropdown-item edit-item-btn" href="javascript:void(0);" data-id="${item.id}">
                                <i class="ti ti-pencil me-2"></i>Edit
                            </a>
                            ` : ''}
                            ${this.config.actions?.delete ? `
                            <a class="dropdown-item delete-item-btn" href="javascript:void(0);" data-id="${item.id}" id="delete-item">
                                <i class="ti ti-trash me-2"></i>Delete
                            </a>
                            ` : ''}
                        </div>
                    </div>
                </div>
            </td>
        `;
    }
    
    renderPagination(data) {
        const totalPages = Math.ceil(data.total / this.perPage);
        const pagination = $('#paginationContainer');
        pagination.empty();
        
        // Calculate from and to for pagination display
        const from = (this.currentPage - 1) * this.perPage + 1;
        const to = Math.min(this.currentPage * this.perPage, data.total);
        
        // Update counters
        $('#paginationStart').text(data.from || from);
        $('#paginationEnd').text(data.to || to);
        $('#totalItems').text(data.total || 0);
        
        // Previous button
        pagination.append(`
            <li class="page-item ${this.currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0);" ${this.currentPage > 1 ? `onclick="window.datatableInstance.goToPage(${this.currentPage - 1})"` : ''}>
                    <i class="ti ti-chevron-left"></i>
                </a>
            </li>
        `);
        
        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= this.currentPage - 2 && i <= this.currentPage + 2)) {
                pagination.append(`
                    <li class="page-item ${i === this.currentPage ? 'active' : ''}">
                        <a class="page-link" href="javascript:void(0);" onclick="window.datatableInstance.goToPage(${i})">${i}</a>
                    </li>
                `);
            } else if (i === this.currentPage - 3 || i === this.currentPage + 3) {
                pagination.append('<li class="page-item disabled"><span class="page-link">...</span></li>');
            }
        }
        
        // Next button
        pagination.append(`
            <li class="page-item ${this.currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0);" ${this.currentPage < totalPages ? `onclick="window.datatableInstance.goToPage(${this.currentPage + 1})"` : ''}>
                    <i class="ti ti-chevron-right"></i>
                </a>
            </li>
        `);
    }
    
    goToPage(page) {
        this.currentPage = page;
        this.load();
    }
    
    sort(field, order = null) {
        if (!order) {
            order = this.currentSort === field && this.currentOrder === 'asc' ? 'desc' : 'asc';
        }
        
        this.currentSort = field;
        this.currentOrder = order;
        this.currentPage = 1;
        
        // Update sort icons
        $('.sort-column .sort-icon').removeClass('ti-arrow-up ti-arrow-down text-primary').addClass('ti-arrow-up text-muted');
        
        const currentIcon = $(`.sort-column[data-sort-field="${field}"] .sort-icon`);
        currentIcon.removeClass('text-muted').addClass('text-primary');
        currentIcon.removeClass('ti-arrow-up ti-arrow-down').addClass(`ti-arrow-${order === 'asc' ? 'up' : 'down'}`);
        
        this.load();
    }
    
    search(searchFieldId) {
        const searchFieldIdToUse = searchFieldId || this.config.searchFieldId || `search${this.config.containerId.charAt(0).toUpperCase() + this.config.containerId.slice(1)}`;
        const searchTerm = $(`#${searchFieldIdToUse}`).val() || '';
        
        if (searchTerm !== (this.filters.search || '')) {
            if (searchTerm.trim()) {
                this.filters.search = searchTerm;
            } else {
                delete this.filters.search;
            }
            this.currentPage = 1;
            this.load();
        }
    }
    
    refresh() {
        this.load();
        showToast('Data refreshed', 'info');
    }
    
    toggleSelectAll(checked) {
        $(`#${this.config.containerId}Body .row-checkbox`).prop('checked', checked);
        this.updateBulkActions();
    }
    
    updateSelectedItems() {
        this.selectedItems = [];
        // Only get row-checkbox elements from the tbody, exclude the header checkbox
        $(`#${this.config.containerId}Body .row-checkbox:checked`).each((_, checkbox) => {
            this.selectedItems.push($(checkbox).val());
        });
        console.log('Updated selected items:', this.selectedItems);
    }
    
    updateBulkActions() {
        this.updateSelectedItems();
        const bulkDeleteBtn = $('#bulkDeleteBtn');
        
        if (this.selectedItems.length > 0) {
            bulkDeleteBtn.removeClass('d-none');
        } else {
            bulkDeleteBtn.addClass('d-none');
        }
    }
    
    updateCount(total) {
        $(`#${this.config.containerId}Count`).text(total || 0);
    }
    
    applyFilter(key, value) {
        this.filters[key] = value;
        this.currentPage = 1;
        this.load();
    }
    
    resetFilters() {
        this.filters = {};
        this.currentPage = 1;
        this.load();
    }
}

// Utility functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}