<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminSessionController;

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('register');
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPassword'])->name('forgot-password');

    // Protected routes - require valid JWT token
    Route::middleware(['auth'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');
        Route::get('/super-admin-dashboard', [AdminAuthController::class, 'superAdminDashboard'])->name('super-admin-dashboard');
    });
});

Route::post('/store-session', [AdminSessionController::class, 'store']);