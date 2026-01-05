/**
 * Custom.js - Datatable & CRUD Operations
 * Used for managing users, products, etc. with common datatable functionality
 */

// ========================================
// 📊 DATATABLE CONFIG
// ========================================

const datatableConfig = {
    perPage: 10,
    currentPage: 1,
    currentSort: 'created_at',
    currentOrder: 'desc',
    currentSearch: '',
    searchDebounceTimer: null,
    searchDebounceDelay: 500
};

// ========================================
// 🎯 DATATABLE INITIALIZATION
// ========================================

/**
 * Initialize datatable for a module
 * @param {object} config - Configuration object
 *  - containerId: ID of table container
 *  - apiEndpoint: API endpoint URL
 *  - columns: Array of column definitions
 *  - actions: Object with create, edit, delete functions
 * @returns {void}
 */
function initDatatable(config) {
    window.datatableInstance = {
        containerId: config.containerId,
        apiEndpoint: config.apiEndpoint,
        columns: config.columns || [],
        actions: config.actions || {},
        perPage: config.perPage || datatableConfig.perPage,
        currentPage: 1,
        currentSort: config.defaultSort || 'created_at',
        currentOrder: config.defaultOrder || 'desc',
        currentSearch: '',
        filters: {}, // Initialize empty filters object
        
        /**
         * Load data from API and render table
         */
        load: function(page = 1) {
            this.currentPage = page;
            
            const token = getToken();
            if (!token) {
                showToast('Session expired. Please login again.', 'error');
                return;
            }
            
            // log(`Loading ${config.apiEndpoint} (page: ${page})`, 'info');
            
            // Build params object with filters
            const params = {
                search: this.currentSearch,
                sort: this.currentSort,
                order: this.currentOrder,
                page: page,
                per_page: this.perPage
            };
            
            // Add filter parameters if they exist
            if (this.filters) {
                Object.assign(params, this.filters);
            }
            
            apiGet(this.apiEndpoint, { params: params })
            .then(response => {
                if (response.data.data) {
                    this.render(response.data.data);
                    // log('Data loaded successfully', 'info');
                } else {
                    showToast('Invalid response from server', 'error');
                }
            })
            .catch(error => {
                log('Failed to load data: ' + error.message, 'error');
            });
        },
        
        /**
         * Render table with data
         */
        render: function(apiData) {
            const tableBody = document.querySelector(`#${this.containerId} tbody`);
            if (!tableBody) return;
            
            const data = apiData.data || [];
            const total = apiData.total || 0;
            const perPage = apiData.per_page || this.perPage;
            const lastPage = apiData.last_page || 1;
            const currentPageNum = apiData.current_page || 1;
            
            // Update counter
            const countElement = document.querySelector('[id*="Count"]');
            if (countElement) countElement.textContent = total;
            
            // Update pagination info
            const start = (currentPageNum - 1) * perPage + 1;
            const end = Math.min(currentPageNum * perPage, total);
            
            const startElement = document.querySelector('[id*="Start"]');
            const endElement = document.querySelector('[id*="End"]');
            const totalElement = document.querySelector('[id*="Total"]');
            
            if (startElement) startElement.textContent = start;
            if (endElement) endElement.textContent = end;
            if (totalElement) totalElement.textContent = total;
            
            // Render rows
            let html = '';
            
            if (data.length > 0) {
                data.forEach(item => {
                    html += this.renderRow(item);
                });
            } else {
                html = `<tr><td colspan="${this.columns.length + 1}" class="text-center py-4 text-muted">No data found</td></tr>`;
            }
            
            tableBody.innerHTML = html;
            
            // Re-attach event listeners
            this.attachEventListeners();
            
            // Render pagination
            this.renderPagination(currentPageNum, lastPage);
        },
        
        /**
         * Render single table row
         */
        renderRow: function(item) {
            let html = '<tr>';
            
            // Checkbox column
            html += `<td><input class="form-check-input" type="checkbox" data-id="${item.id}"></td>`;
            
            // Data columns
            this.columns.forEach(column => {
                const value = this.getCellValue(item, column);
                html += `<td ${column.className ? `class="${column.className}"` : ''}>${value}</td>`;
            });
            
            html += '</tr>';
            return html;
        },
        
        /**
         * Get cell value from item (supports nested properties)
         */
        getCellValue: function(item, column) {
            if (column.render) {
                return column.render(item[column.field], item);
            }
            
            const value = item[column.field];
            
            if (column.type === 'date') {
                return formatDate(value, 'short');
            } else if (column.type === 'boolean') {
                return value ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
            } else if (column.type === 'truncate') {
                return truncateText(value, column.length || 50);
            }
            
            return value || 'N/A';
        },
        
        /**
         * Render pagination controls
         */
        renderPagination: function(currentPage, lastPage) {
            const paginationContainer = document.querySelector('[id*="Pagination"]');
            if (!paginationContainer) return;
            
            let html = '';
            
            // Previous button
            if (currentPage > 1) {
                html += `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="datatableInstance.load(${currentPage - 1})">Previous</a></li>`;
            } else {
                html += '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
            }
            
            // Page numbers
            const startPage = Math.max(1, currentPage - 2);
            const endPage = Math.min(lastPage, currentPage + 2);
            
            if (startPage > 1) {
                html += '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="datatableInstance.load(1)">1</a></li>';
                if (startPage > 2) html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            
            for (let i = startPage; i <= endPage; i++) {
                if (i === currentPage) {
                    html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
                } else {
                    html += `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="datatableInstance.load(${i})">${i}</a></li>`;
                }
            }
            
            if (endPage < lastPage) {
                if (endPage < lastPage - 1) html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                html += `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="datatableInstance.load(${lastPage})">${lastPage}</a></li>`;
            }
            
            // Next button
            if (currentPage < lastPage) {
                html += `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="datatableInstance.load(${currentPage + 1})">Next</a></li>`;
            } else {
                html += '<li class="page-item disabled"><span class="page-link">Next</span></li>';
            }
            
            paginationContainer.innerHTML = html;
        },
        
        /**
         * Attach event listeners to table elements
         */
        attachEventListeners: function() {
            const self = this;
            
            // Edit button
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;
                    if (self.actions.onEdit) {
                        self.actions.onEdit(id);
                    }
                });
            });
            
            // Delete button
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;
                    if (self.actions.onDelete) {
                        self.actions.onDelete(id);
                    }
                });
            });
        },
        
        /**
         * Search/filter data
         */
        search: function(query) {
            this.currentSearch = query;
            this.currentPage = 1;
            this.load();
        },
        
        /**
         * Sort data
         */
        sort: function(field, order = 'asc') {
            this.currentSort = field;
            this.currentOrder = order;
            this.currentPage = 1;
            this.load();
        },
        
        /**
         * Refresh data
         */
        refresh: function() {
            this.load(this.currentPage);
        }
    };
    
    // Load initial data
    window.datatableInstance.load();
}

// ========================================
// ✏️ FORM HANDLING
// ========================================

/**
 * Handle form submission (Create/Edit)
 * @param {object} config - Configuration object
 *  - formId: Form element ID
 *  - apiEndpoint: API endpoint for create
 *  - method: 'POST' for create, 'PUT' for edit
 *  - onSuccess: Callback function on success
 * @returns {void}
 */
function handleFormSubmit(config) {
    const form = document.querySelector(`#${config.formId}`);
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const method = config.method || 'POST';
        let endpoint = config.apiEndpoint;
        
        // For edit, append ID to endpoint
        if (method === 'PUT') {
            // Try to find id from multiple possible field names
            let id = document.querySelector(`#${config.formId} [name="id"]`)?.value ||
                     document.querySelector(`#${config.formId} [name="user_id"]`)?.value;
            if (id) {
                endpoint = `${config.apiEndpoint}/${id}`;
            }
            
            // For PUT requests with FormData, add _method field for Laravel method spoofing
            formData.append('_method', 'PUT');
        }
        
        log(`Submitting ${config.formId} via ${method}`, 'info');
        setButtonState(`#${config.formId} [type="submit"]`, true);
        
        if (method === 'POST') {
            apiPost(endpoint, formData)
                .then(response => {
                    console.log('Response:', response);
                    showToast(response.data.message || 'Success', 'success');
                    resetForm(form);
                    if (config.onSuccess) config.onSuccess(response.data);
                    if (window.datatableInstance) {
                        window.datatableInstance.refresh();
                    }
                })
                .catch((error) => {
                    console.error('POST Error:', error);
                    setButtonState(`#${config.formId} [type="submit"]`, false);
                });
        } else if (method === 'PUT') {
            apiPut(endpoint, formData)
                .then(response => {
                    console.log('Response:', response);
                    showToast(response.data.message || 'Updated successfully', 'success');
                    resetForm(form);
                    if (config.onSuccess) config.onSuccess(response.data);
                    if (window.datatableInstance) {
                        window.datatableInstance.refresh();
                    }
                })
                .catch((error) => {
                    console.error('PUT Error:', error);
                    setButtonState(`#${config.formId} [type="submit"]`, false);
                });
        }
    });
}

// ========================================
// 🗑️ DELETE HANDLING
// ========================================

/**
 * Common handler for bulk delete across all modules
 * @param {object} config - Configuration object
 *  - buttonSelector: Selector for bulk delete button
 *  - confirmSelector: ID of confirmation modal
 *  - confirmButtonId: ID of confirm button in modal
 *  - apiEndpoint: API endpoint for bulk delete
 *  - itemName: Singular name for items (default: 'item')
 *  - onSuccess: Callback function on success
 * @returns {void}
 */
function handleBulkDelete(config) {
    const bulkDeleteBtn = document.querySelector(config.buttonSelector);
    if (!bulkDeleteBtn) return;
    
    // Get configuration defaults
    const itemName = config.itemName || 'item';
    const itemsName = itemName + (itemName.endsWith('s') ? 'es' : 's');
    
    // Handle bulk delete button click
    bulkDeleteBtn.addEventListener('click', function() {
        // Get selected items from datatable instance
        let selectedIds = [];
        
        if (window.datatableInstance && window.datatableInstance.selectedItems) {
            selectedIds = window.datatableInstance.selectedItems;
        } else {
            // Fallback: get from checkboxes if datatable instance not available
            const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            selectedIds = Array.from(checkedBoxes).map(box => box.value || box.dataset.id);
        }
        
        if (selectedIds.length === 0) {
            showToast(`Please select at least one ${itemName}`, 'warning');
            return;
        }
        
        log(`Selected ${selectedIds.length} ${itemsName} for deletion`, 'info');
        
        // Show confirmation modal
        const modal = document.querySelector(config.confirmSelector);
        if (modal) {
            // Update modal text to show count
            const modalBody = modal.querySelector('.modal-body p');
            if (modalBody) {
                const itemWord = selectedIds.length === 1 ? itemName : itemsName;
                modalBody.textContent = `Are you sure you want to delete ${selectedIds.length} selected ${itemWord}? This action cannot be undone.`;
            }
            new bootstrap.Modal(modal).show();
            
            // Store IDs for confirmation handler
            modal.dataset.bulkIds = JSON.stringify(selectedIds);
            modal.dataset.isBulk = 'true';
        }
    });
    
    // Handle confirmation
    const confirmBtn = document.querySelector(`#${config.confirmButtonId}`);
    if (confirmBtn) {
        // Use event delegation to avoid multiple listeners
        confirmBtn.removeEventListener('click', confirmBtn._bulkDeleteHandler);
        
        confirmBtn._bulkDeleteHandler = function() {
            const modal = document.querySelector(config.confirmSelector);
            const bulkIds = JSON.parse(modal.dataset.bulkIds || '[]');
            
            if (bulkIds.length === 0) return;
            
            log(`Deleting ${bulkIds.length} ${itemsName}`, 'info');
            setButtonState(config.buttonSelector, true);
            
            // Send bulk delete request
            apiPost(`${config.apiEndpoint}/bulk-delete`, { ids: bulkIds })
                .then(response => {
                    showToast(response.data.message || `${bulkIds.length} ${itemsName} deleted successfully`, 'success');
                    if (config.onSuccess) config.onSuccess();
                    if (window.datatableInstance) {
                        window.datatableInstance.selectedItems = [];
                        window.datatableInstance.refresh();
                    }
                    // Close modal
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) modalInstance.hide();
                    setButtonState(config.buttonSelector, false);
                })
                .catch(() => {
                    log('Bulk delete failed', 'error');
                    setButtonState(config.buttonSelector, false);
                });
        };
        
        confirmBtn.addEventListener('click', confirmBtn._bulkDeleteHandler);
    }
}

/**
 * Common delete handler for single and bulk delete operations
 * Uses the common modal from master layout (#commonDeleteModal)
 * @param {object} config - Configuration object
 *  - deleteButtonSelector: Selector for delete buttons (e.g., '.delete-item-btn')
 *  - apiEndpoint: API endpoint base (e.g., '/api/v1/super-admin/users')
 *  - itemName: Singular name for items (default: 'item')
 *  - onSuccess: Callback function on success
 * @returns {void}
 */
function handleCommonDelete(config) {
    const itemName = config.itemName || 'item';
    const itemsName = itemName + (itemName.endsWith('s') ? 'es' : 's');
    
    // Handle individual delete button clicks
    $(document).on('click', config.deleteButtonSelector, function() {
        const itemId = $(this).data('id');
        
        // Update modal message
        const modalMessage = document.getElementById('commonDeleteMessage');
        if (modalMessage) {
            modalMessage.innerHTML = `<p>Are you sure you want to delete this ${itemName}? This action cannot be undone.</p>`;
        }
        
        // Store delete info in modal data attributes
        const modal = document.getElementById('commonDeleteModal');
        modal.dataset.ids = JSON.stringify([itemId]);
        modal.dataset.isBulk = 'false';
        modal.dataset.apiEndpoint = config.apiEndpoint;
        modal.dataset.itemName = itemName;
        modal.dataset.itemsName = itemsName;
        
        // Show modal
        new bootstrap.Modal(modal).show();
    });
    
    // Handle bulk delete confirmation
    $(document).on('click', '#commonDeleteConfirmBtn', function() {
        const modal = document.getElementById('commonDeleteModal');
        const ids = JSON.parse(modal.dataset.ids || '[]');
        const isBulk = modal.dataset.isBulk === 'true';
        const apiEndpoint = modal.dataset.apiEndpoint;
        const itemsName = modal.dataset.itemsName;
        
        if (ids.length === 0) return;
        
        // Construct URL and method
        const url = isBulk ? `${apiEndpoint}/bulk-delete` : `${apiEndpoint}/${ids[0]}`;
        const method = isBulk ? 'POST' : 'DELETE';
        const data = isBulk ? { ids: ids } : {};
        
        // Execute delete
        const apiCall = method === 'POST' ? apiPost(url, data) : apiDelete(url);
        
        apiCall.then(response => {
            // Close modal
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) modalInstance.hide();
            
            // Show success message
            showToast(response.data.message || `${ids.length} ${itemsName} deleted successfully`, 'success');
            
            // Execute callback
            if (config.onSuccess) config.onSuccess();
            
            // Refresh datatable if available
            if (window.datatableInstance) {
                window.datatableInstance.selectedItems = [];
                window.datatableInstance.refresh();
            }
            
            // Clear checkboxes
            $('.row-checkbox').prop('checked', false);
            $('#checkboxAll').prop('checked', false);
            if (window.datatableInstance) {
                window.datatableInstance.updateBulkActions();
            }
        }).catch(error => {
            showToast('Failed to delete', 'error');
        });
    });
}

/**
 * Show common delete confirmation for bulk delete
 * Used with handleCommonDelete for bulk operations
 * @param {array} ids - Array of IDs to delete
 * @param {string} itemName - Singular name for items
 * @param {string} apiEndpoint - API endpoint base
 * @returns {void}
 */
function showCommonBulkDeleteConfirmation(ids, itemName, apiEndpoint) {
    const itemsName = itemName + (itemName.endsWith('s') ? 'es' : 's');
    
    // Update modal message
    const modalMessage = document.getElementById('commonDeleteMessage');
    if (modalMessage) {
        const itemWord = ids.length === 1 ? itemName : itemsName;
        modalMessage.innerHTML = `<p>Are you sure you want to delete ${ids.length} selected ${itemWord}? This action cannot be undone.</p>`;
    }
    
    // Store delete info in modal data attributes
    const modal = document.getElementById('commonDeleteModal');
    modal.dataset.ids = JSON.stringify(ids);
    modal.dataset.isBulk = 'true';
    modal.dataset.apiEndpoint = apiEndpoint;
    modal.dataset.itemName = itemName;
    modal.dataset.itemsName = itemsName;
    
    // Show modal
    new bootstrap.Modal(modal).show();
}

/**
 * Handle delete action with confirmation
 * @param {object} config - Configuration object
 *  - confirmSelector: ID of confirmation modal
 *  - confirmButtonId: ID of confirm button
 *  - apiEndpoint: API endpoint for delete
 *  - onSuccess: Callback function on success
 * @returns {void}
 */
function handleDelete(config) {
    let deleteId = null;
    
    // Store ID when delete is clicked
    document.addEventListener('click', function(e) {
        if (e.target.matches(config.deleteButtonSelector || '.delete-btn')) {
            deleteId = e.target.dataset.id;
            // Show confirmation modal
            const modal = document.querySelector(config.confirmSelector);
            if (modal) {
                new bootstrap.Modal(modal).show();
            }
        }
    });
    
    // Handle confirmation
    const confirmBtn = document.querySelector(`#${config.confirmButtonId}`);
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            if (!deleteId) return;
            
            log(`Deleting ID: ${deleteId}`, 'info');
            
            apiDelete(`${config.apiEndpoint}/${deleteId}`)
                .then(response => {
                    showToast(response.data.message || 'Deleted successfully', 'success');
                    if (config.onSuccess) config.onSuccess();
                    if (window.datatableInstance) {
                        window.datatableInstance.refresh();
                    }
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.querySelector(config.confirmSelector));
                    if (modal) modal.hide();
                })
                .catch(() => {
                    log('Delete failed', 'error');
                });
        });
    }
}

// ========================================
// 🔍 SEARCH HANDLING
// ========================================

/**
 * Handle search input with debounce
 * @param {string} searchInputSelector - Search input selector
 * @returns {void}
 */
function handleSearch(searchInputSelector) {
    const searchInput = document.querySelector(searchInputSelector);
    if (!searchInput) return;
    
    searchInput.addEventListener('keyup', function(e) {
        clearTimeout(datatableConfig.searchDebounceTimer);
        
        datatableConfig.searchDebounceTimer = setTimeout(() => {
            const query = this.value;
            log(`Searching for: "${query}"`, 'info');
            
            if (window.datatableInstance) {
                window.datatableInstance.search(query);
            }
        }, datatableConfig.searchDebounceDelay);
    });
}

// ========================================
// 📸 FILE UPLOAD PREVIEW
// ========================================

/**
 * Handle file input preview
 * @param {string} fileInputSelector - File input selector
 * @param {string} previewSelector - Preview image selector
 * @returns {void}
 */
function handleFilePreview(fileInputSelector, previewSelector) {
    const fileInput = document.querySelector(fileInputSelector);
    const preview = document.querySelector(previewSelector);
    
    if (!fileInput) return;
    
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                if (preview) {
                    preview.src = event.target.result;
                }
            };
            reader.readAsDataURL(file);
        }
    });
}

// ========================================
// 🔐 PASSWORD TOGGLE
// ========================================

/**
 * Setup password toggle functionality (defined in module-specific files)
 * Note: Use setupPasswordToggle() from index.blade.php instead
 */

// ========================================
// ✅ INITIALIZATION
// ========================================

/**
 * Initialize custom utilities on page load
 * @returns {void}
 */
function initCustom() {
    // log('Custom utilities initialized', 'info');
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCustom);
} else {
    initCustom();
}
