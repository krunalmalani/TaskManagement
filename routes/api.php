<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AdminAuthApiController;

use App\Http\Controllers\Api\V1\SuperAdminUserApiController;

Route::prefix('v1')->group(function () {
    // Public authentication routes (no middleware required)
    Route::post('/register', [AdminAuthApiController::class, 'register']);
    Route::post('/login', [AdminAuthApiController::class, 'login']);
    Route::post('/logout', [AdminAuthApiController::class, 'logout']); // Logout doesn't require valid token
    Route::post('/logout-session', [AdminAuthApiController::class, 'logoutSession']); // Session logout

    // Protected routes (JWT middleware required)
    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AdminAuthApiController::class, 'me']);
        Route::post('/refresh', [AdminAuthApiController::class, 'refresh']);

        // Super Admin User Management APIs
        Route::prefix('super-admin')->group(function () {
            // Collection routes (no {id} parameter)
            Route::get('/users', [SuperAdminUserApiController::class, 'index'])->name('api.super-admin-users-index');
            Route::post('/users', [SuperAdminUserApiController::class, 'store'])->name('api.super-admin-users-store');
            Route::post('/users/bulk-delete', [SuperAdminUserApiController::class, 'bulkDestroy'])->name('api.super-admin-users-bulk-delete');
            Route::get('/users/{id}', [SuperAdminUserApiController::class, 'show'])->name('api.super-admin-users-show');
            Route::put('/users/{id}', [SuperAdminUserApiController::class, 'update'])->name('api.super-admin-users-update');
            Route::post('/users/{id}', [SuperAdminUserApiController::class, 'update'])->name('api.super-admin-users-update-post');
            Route::delete('/users/{id}', [SuperAdminUserApiController::class, 'destroy'])->name('api.super-admin-users-destroy');
        });
    });
});