<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminSessionController;
use App\Http\Controllers\AdminRolePermissionController;
use App\Http\Controllers\AdminCompanyController;
use App\Http\Controllers\AdminBranchController;
use App\Http\Controllers\AdminDepartmentController;

use App\Http\Controllers\sadmin\SuperAdminDashboardController;
use App\Http\Controllers\sadmin\SuperAdminUserController;

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('register');
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPassword'])->name('forgot-password');

    // Protected routes - require valid JWT token
    Route::middleware(['auth'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');
        Route::get('/list_role', [AdminAuthController::class, 'list_role'])->name('list_role');
        
        Route::get('/list_company', [AdminCompanyController::class, 'list_company'])->name('list_company');
        Route::get('/list_branch', [AdminBranchController::class, 'list_branch'])->name('list_branch');
        Route::get('/list_department', [AdminDepartmentController::class, 'list_department'])->name('list_department');
    });
});

// Super Admin Routes with separate prefix
Route::prefix('super-admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'superAdminDashboard'])->name('super-admin-dashboard');
    Route::get('/users', [SuperAdminUserController::class, 'index'])->name('super-admin-users-index');
    Route::get('/countries', [SuperAdminUserController::class, 'country'])->name('super-admin-countries-index');
});

Route::post('/store-session', [AdminSessionController::class, 'store']);