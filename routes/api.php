<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AdminAuthApiController;
use App\Http\Controllers\Api\V1\AdminCompanyApiController;

use App\Http\Controllers\Api\V1\sadmin\SuperAdminUserApiController;
use App\Http\Controllers\Api\V1\sadmin\SuperAdminCountryApiController;
use App\Http\Controllers\Api\V1\sadmin\SuperAdminStateApiController;
use App\Http\Controllers\Api\V1\sadmin\SuperAdminCityApiController;
use App\Http\Controllers\Api\V1\sadmin\SuperAdminCurrencyApiController;

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
            Route::post('/countries', [SuperAdminCountryApiController::class, 'store']);
            Route::post('/countries/bulk-delete', [SuperAdminCountryApiController::class, 'bulkDestroy']);
            Route::get('/countries/{id}', [SuperAdminCountryApiController::class, 'show']);
            Route::put('/countries/{id}', [SuperAdminCountryApiController::class, 'update']);
            Route::delete('/countries/{id}', [SuperAdminCountryApiController::class, 'destroy']);

            Route::get('/states', [SuperAdminStateApiController::class, 'index']);
            Route::post('/states', [SuperAdminStateApiController::class, 'store']);
            Route::post('/states/bulk-delete', [SuperAdminStateApiController::class, 'bulkDestroy']);
            Route::get('/states/{id}', [SuperAdminStateApiController::class, 'show']);
            Route::put('/states/{id}', [SuperAdminStateApiController::class, 'update']);
            Route::delete('/states/{id}', [SuperAdminStateApiController::class, 'destroy']);
            Route::get('/get-countries', [SuperAdminStateApiController::class, 'getCountries']);

            Route::get('/cities', [SuperAdminCityApiController::class, 'index']);
            Route::post('/cities', [SuperAdminCityApiController::class, 'store']);
            Route::post('/cities/bulk-delete', [SuperAdminCityApiController::class, 'bulkDestroy']);
            Route::get('/cities/{id}', [SuperAdminCityApiController::class, 'show']);
            Route::put('/cities/{id}', [SuperAdminCityApiController::class, 'update']);
            Route::delete('/cities/{id}', [SuperAdminCityApiController::class, 'destroy']);
            Route::get('/get-states', [SuperAdminCityApiController::class, 'getStates']);

            Route::get('/currencies', [SuperAdminCurrencyApiController::class, 'index']);
            Route::post('/currencies', [SuperAdminCurrencyApiController::class, 'store']);
            Route::post('/currencies/bulk-delete', [SuperAdminCurrencyApiController::class, 'bulkDestroy']);
            Route::get('/currencies/{id}', [SuperAdminCurrencyApiController::class, 'show']);
            Route::put('/currencies/{id}', [SuperAdminCurrencyApiController::class, 'update']);
            Route::delete('/currencies/{id}', [SuperAdminCurrencyApiController::class, 'destroy']);
            Route::get('/get-currencies-countries', [SuperAdminCurrencyApiController::class, 'getCountries']);
        });
    });
});