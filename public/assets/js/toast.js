/**
 * Toast.js - Advanced Toast Notification System
 * Uses Bootstrap 5 native toast component
 * 
 * Features:
 * - Multiple toast types (success, error, info, warning, primary)
 * - Auto-dismiss with configurable duration
 * - Smooth animations
 * - Click to dismiss
 * - Stacking support
 */

// ========================================
// 🎯 TOAST UTILITIES
// ========================================

/**
 * Show success toast
 * @param {string} message - Toast message
 * @param {number} duration - Auto-dismiss duration (default: 1000ms)
 */
function showSuccessToast(message, duration = 1000) {
    showToast(message, 'success', duration);
}

/**
 * Show error toast
 * @param {string} message - Toast message
 * @param {number} duration - Auto-dismiss duration (default: 1000ms)
 */
function showErrorToast(message, duration = 1000) {
    showToast(message, 'error', duration);
}

/**
 * Show info toast
 * @param {string} message - Toast message
 * @param {number} duration - Auto-dismiss duration (default: 1000ms)
 */
function showInfoToast(message, duration = 1000) {
    showToast(message, 'info', duration);
}

/**
 * Show warning toast
 * @param {string} message - Toast message
 * @param {number} duration - Auto-dismiss duration (default: 1000ms)
 */
function showWarningToast(message, duration = 1000) {
    showToast(message, 'warning', duration);
}

/**
 * Show persistent toast (doesn't auto-dismiss)
 * @param {string} message - Toast message
 * @param {string} type - Toast type: 'success', 'error', 'info', 'warning', 'primary'
 */
function showPersistentToast(message, type = 'info') {
    showToast(message, type, 0); // 0 duration = no auto-dismiss
}

/**
 * Clear all toasts
 */
function clearAllToasts() {
    const container = document.getElementById('toastContainer');
    if (container) {
        const toasts = container.querySelectorAll('.toast');
        toasts.forEach(toast => {
            const bsToast = bootstrap.Toast.getInstance(toast);
            if (bsToast) {
                bsToast.hide();
            }
        });
    }
}

/**
 * Get toast count
 * @returns {number} Number of active toasts
 */
function getToastCount() {
    const container = document.getElementById('toastContainer');
    if (container) {
        return container.querySelectorAll('.toast').length;
    }
    return 0;
}

// ========================================
// 📦 TOAST INITIALIZATION
// ========================================

/**
 * Initialize toast system on page load
 * Ensures toast container exists
 */
function initToastSystem() {
    let toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toastContainer';
        toastContainer.className = 'toast-container-custom';
        toastContainer.setAttribute('aria-live', 'polite');
        toastContainer.setAttribute('aria-atomic', 'true');
        document.body.appendChild(toastContainer);
    }
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initToastSystem);
} else {
    initToastSystem();
}
