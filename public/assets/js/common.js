/**
 * Common.js - Shared Utilities & Variables
 * Used across all modules and pages
 */

// ========================================
// 🔑 GLOBAL VARIABLES
// ========================================

const appConfig = {
    baseUrl: window.location.origin,
    apiBaseUrl: '/api/v1',
    tokenKey: 'token',
    userKey: 'user',
    tokenTypeKey: 'token_type'
};

// ========================================
// 🔐 TOKEN MANAGEMENT
// ========================================

/**
 * Get JWT token from various storage locations
 * @returns {string|null} JWT token or null
 */
function getToken() {
    let token = localStorage.getItem(appConfig.tokenKey);
    
    if (!token) {
        // Try sessionStorage
        token = sessionStorage.getItem(appConfig.tokenKey);
    }
    
    if (!token) {
        // Try meta tag (set by blade template)
        const metaToken = document.querySelector('meta[name="auth-token"]')?.getAttribute('content');
        if (metaToken) {
            localStorage.setItem(appConfig.tokenKey, metaToken);
            return metaToken;
        }
    }
    
    return token || null;
}

/**
 * Get stored user object
 * @returns {object|null} User object or null
 */
function getUser() {
    const userJson = localStorage.getItem(appConfig.userKey);
    try {
        return userJson ? JSON.parse(userJson) : null;
    } catch (e) {
        console.error('Error parsing user JSON:', e);
        return null;
    }
}

/**
 * Setup default axios headers with authentication
 * @returns {void}
 */
function setupAxiosHeaders() {
    // Wait for axios to be available
    if (typeof axios === 'undefined') {
        console.warn('Axios library not yet loaded. Waiting...');
        setTimeout(setupAxiosHeaders, 500);
        return;
    }
    
    const token = getToken();
    if (token) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.headers.common['Accept'] = 'application/json';
    }
}

/**
 * Clear all authentication data
 * @returns {void}
 */
function clearAuthData() {
    localStorage.removeItem(appConfig.tokenKey);
    localStorage.removeItem(appConfig.userKey);
    localStorage.removeItem(appConfig.tokenTypeKey);
    sessionStorage.clear();
}

// ========================================
// 📱 NOTIFICATIONS & TOASTS
// ========================================

/**
 * Show toast notification with Bootstrap styling
 * @param {string} message - Toast message
 * @param {string} type - 'success', 'error', 'info', 'warning', 'primary'
 * @param {number} duration - Duration in milliseconds (default: 1000ms = 1s)
 * @returns {void}
 * 
 * Usage:
 *   showToast('User created successfully', 'success');
 *   showToast('Error occurred', 'error');
 *   showToast('Info message', 'info');
 */
function showToast(message, type = 'info', duration = 1000) {
    // Map toast types to Bootstrap bg colors (text-white for all, border-0 for all)
    const typeColorMap = {
        'success': 'bg-success text-white',
        'error': 'bg-danger text-white',
        'info': 'bg-info text-white',
        'warning': 'bg-warning text-white',
        'primary': 'bg-primary text-white'
    };
    
    const colorClass = typeColorMap[type] || typeColorMap['info'];
    const toastId = 'toast-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
    
    // Create toast HTML matching ui-toasts.html template structure
    const toastHTML = `
        <div id="${toastId}" class="toast align-items-center text-white border-0 ${colorClass}" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    // Get or create toast container
    let toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toastContainer';
        toastContainer.className = 'position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        toastContainer.setAttribute('aria-live', 'polite');
        toastContainer.setAttribute('aria-atomic', 'true');
        document.body.appendChild(toastContainer);
    }
    
    // Add toast to container
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    
    // Get the toast element
    const toastElement = document.getElementById(toastId);
    
    if (toastElement) {
        // Initialize Bootstrap toast with auto-hide
        const bsToast = new bootstrap.Toast(toastElement, {
            autohide: true,
            delay: duration
        });
        
        // Show the toast (Bootstrap handles visibility)
        bsToast.show();
        
        // Remove toast element from DOM after it's hidden
        toastElement.addEventListener('hidden.bs.toast', function() {
            setTimeout(() => {
                toastElement.remove();
            }, 300);
        });
    }
}

// ========================================
// 🔄 API HELPERS
// ========================================

/**
 * Make GET request with error handling
 * @param {string} url - API endpoint
 * @param {object} config - Axios config
 * @returns {Promise} Axios promise
 */
function apiGet(url, config = {}) {
    if (typeof axios === 'undefined') {
        const error = new Error('Axios library is not loaded');
        handleApiError(error);
        return Promise.reject(error);
    }
    
    const token = getToken();
    if (!token) {
        showToast('Session expired. Please login again.', 'error');
        setTimeout(() => {
            window.location.href = appConfig.baseUrl + '/admin/login';
        }, 1000);
        return Promise.reject('No token');
    }
    
    return axios.get(url, config)
        .catch(error => {
            handleApiError(error);
            throw error;
        });
}

/**
 * Make POST request with error handling
 * @param {string} url - API endpoint
 * @param {object} data - Request data
 * @param {object} config - Axios config
 * @returns {Promise} Axios promise
 */
function apiPost(url, data = {}, config = {}) {
    if (typeof axios === 'undefined') {
        const error = new Error('Axios library is not loaded');
        handleApiError(error);
        return Promise.reject(error);
    }
    
    const token = getToken();
    if (!token) {
        showToast('Session expired. Please login again.', 'error');
        setTimeout(() => {
            window.location.href = appConfig.baseUrl + '/admin/login';
        }, 1000);
        return Promise.reject('No token');
    }
    
    return axios.post(url, data, config)
        .catch(error => {
            handleApiError(error);
            throw error;
        });
}

/**
 * Make PUT request with error handling
 * Supports both JSON objects and FormData
 * @param {string} url - API endpoint
 * @param {object|FormData} data - Request data (object or FormData)
 * @param {object} config - Axios config
 * @returns {Promise} Axios promise
 */
function apiPut(url, data = {}, config = {}) {
    if (typeof axios === 'undefined') {
        const error = new Error('Axios library is not loaded');
        handleApiError(error);
        return Promise.reject(error);
    }
    
    const token = getToken();
    if (!token) {
        showToast('Session expired. Please login again.', 'error');
        setTimeout(() => {
            window.location.href = appConfig.baseUrl + '/admin/login';
        }, 1000);
        return Promise.reject('No token');
    }
    
    // If data is FormData, ensure we don't override content-type
    if (data instanceof FormData) {
        // FormData with PUT needs to explicitly use POST with _method spoofing
        config.headers = config.headers || {};
        // Delete Content-Type to let axios set it automatically for FormData
        delete config.headers['Content-Type'];
        
        // Use POST with _method: PUT for proper form data handling
        return axios.post(url, data, config)
            .catch(error => {
                handleApiError(error);
                throw error;
            });
    }
    
    return axios.put(url, data, config)
        .catch(error => {
            handleApiError(error);
            throw error;
        });
}

/**
 * Make DELETE request with error handling
 * @param {string} url - API endpoint
 * @param {object} config - Axios config
 * @returns {Promise} Axios promise
 */
function apiDelete(url, config = {}) {
    if (typeof axios === 'undefined') {
        const error = new Error('Axios library is not loaded');
        handleApiError(error);
        return Promise.reject(error);
    }
    
    const token = getToken();
    if (!token) {
        showToast('Session expired. Please login again.', 'error');
        setTimeout(() => {
            window.location.href = appConfig.baseUrl + '/admin/login';
        }, 1000);
        return Promise.reject('No token');
    }
    
    return axios.delete(url, config)
        .catch(error => {
            handleApiError(error);
            throw error;
        });
}

/**
 * Handle API errors
 * @param {object} error - Axios error object
 * @returns {void}
 */
function handleApiError(error) {
    let errorMsg = 'An error occurred';
    
    if (error.response) {
        if (error.response.status === 401) {
            errorMsg = 'Unauthorized - Session expired';
            clearAuthData();
            setTimeout(() => {
                window.location.href = appConfig.baseUrl + '/admin/login';
            }, 2000);
        } else if (error.response.status === 403) {
            errorMsg = 'Forbidden - Permission denied';
        } else if (error.response.status === 404) {
            errorMsg = 'Not found';
        } else if (error.response.status === 422) {
            // Validation errors
            const errors = error.response.data.errors;
            if (errors) {
                errorMsg = Object.values(errors).flat().join(', ');
            }
        } else if (error.response.status === 500) {
            errorMsg = 'Server error - Please try again later';
        } else if (error.response.data && error.response.data.message) {
            errorMsg = error.response.data.message;
        }
    } else if (error.message) {
        errorMsg = error.message;
    }
    
    showToast(errorMsg, 'error');
}

// ========================================
// 🎨 DOM UTILITIES
// ========================================

/**
 * Format date to readable format
 * @param {string|Date} date - Date to format
 * @param {string} format - Format type: 'short', 'long', 'iso'
 * @returns {string} Formatted date
 */
function formatDate(date, format = 'short') {
    if (!date) return 'N/A';
    
    const dateObj = new Date(date);
    
    if (format === 'short') {
        return dateObj.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    } else if (format === 'long') {
        return dateObj.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
    
    return date;
}

/**
 * Truncate text to specified length
 * @param {string} text - Text to truncate
 * @param {number} length - Max length
 * @returns {string} Truncated text
 */
function truncateText(text, length = 50) {
    if (!text) return '';
    return text.length > length ? text.substring(0, length) + '...' : text;
}

// ========================================
// ✅ FORM UTILITIES
// ========================================

/**
 * Reset form to initial state
 * @param {string|Element} form - Form selector or element
 * @returns {void}
 */
function resetForm(form) {
    const formElement = typeof form === 'string' ? document.querySelector(form) : form;
    if (formElement) {
        formElement.reset();
    }
}

/**
 * Set button state (disabled/enabled)
 * @param {string} selector - Button selector
 * @param {boolean} isLoading - True to disable, false to enable
 * @returns {void}
 */
function setButtonState(selector, isLoading) {
    const button = document.querySelector(selector);
    if (button) {
        if (isLoading) {
            button.disabled = true;
            button.style.opacity = '0.6';
            button.style.pointerEvents = 'none';
        } else {
            button.disabled = false;
            button.style.opacity = '1';
            button.style.pointerEvents = 'auto';
        }
    }
}

/**
 * Log message with styling
 * @param {string} message - Message to log
 * @param {string} type - 'log', 'info', 'warn', 'error'
 * @returns {void}
 */
function log(message, type = 'log') {
    const timestamp = new Date().toLocaleTimeString();
    const prefix = `[${timestamp}]`;
    
    if (type === 'info') {
        console.log(`%c${prefix} ℹ ${message}`, 'color: blue; font-weight: bold;');
    } else if (type === 'warn') {
        console.warn(`%c${prefix} ⚠ ${message}`, 'color: orange; font-weight: bold;');
    } else if (type === 'error') {
        console.error(`%c${prefix} ❌ ${message}`, 'color: red; font-weight: bold;');
    } else {
        console.log(`%c${prefix} ✓ ${message}`, 'color: green; font-weight: bold;');
    }
}

// ========================================
// 🔄 INITIALIZATION
// ========================================

/**
 * Initialize common utilities on page load
 * @returns {void}
 */
function initCommon() {
    // Setup axios headers
    setupAxiosHeaders();
    
    // Log initialization
    // log('Common utilities initialized', 'info');
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCommon);
} else {
    initCommon();
}
