<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AdminAuthApiController;
use App\Http\Controllers\Api\V1\AdminCompanyApiController;

use App\Http\Controllers\Api\V1\sadmin\SuperAdminUserApiController;
use App\Http\Controllers\Api\V1\sadmin\SuperAdminCountryApiController;

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

        // Admin Company Management APIs
        Route::get('/companies', [AdminCompanyApiController::class, 'index']);
        Route::post('/companies', [AdminCompanyApiController::class, 'store']);
        Route::post('/companies/bulk-delete', [AdminCompanyApiController::class, 'bulkDestroy']);
        Route::get('/companies/{id}', [AdminCompanyApiController::class, 'show']);
        Route::put('/companies/{id}', [AdminCompanyApiController::class, 'update']);
        Route::post('/companies/{id}', [AdminCompanyApiController::class, 'update']);
        Route::delete('/companies/{id}', [AdminCompanyApiController::class, 'destroy']);

        // Super Admin User Management APIs
        Route::prefix('super-admin')->group(function () {
            // Collection routes (no {id} parameter)
            Route::get('/users', [SuperAdminUserApiController::class, 'index']);
            Route::post('/users', [SuperAdminUserApiController::class, 'store']);
            Route::post('/users/bulk-delete', [SuperAdminUserApiController::class, 'bulkDestroy']);
            Route::get('/users/{id}', [SuperAdminUserApiController::class, 'show']);
            Route::post('/users/{id}', [SuperAdminUserApiController::class, 'update']);
            Route::delete('/users/{id}', [SuperAdminUserApiController::class, 'destroy']);

            Route::get('/countries', [SuperAdminCountryApiController::class, 'index']);
        });
    });
});