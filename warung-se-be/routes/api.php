<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\DetailPesananController;
use App\Http\Controllers\StokMenuController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Responses\ApiResponse;


// ========================
// PUBLIC ROUTES
// ========================

Route::post('/register/user', [AuthController::class, 'registerUser']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');



// ========================
// USER ROUTES
// ========================

Route::middleware(['auth:sanctum', 'role:user'])->prefix('user')->group(function () {

    Route::get('/dashboard', function () {
        return ApiResponse::success(
            ['user' => auth('user')->user()], 
            'Dashboard user'
        );
    });

    Route::get('/menu', [MenuController::class, 'index']);
    Route::get('/menu/{id}', [MenuController::class, 'show']);

    Route::apiResource('/pesanan', PesananController::class);
    Route::apiResource('/detail-pesanan', DetailPesananController::class);
});



// ========================
// ADMIN ROUTES
// ========================

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return ApiResponse::success(
            ['admin' => auth()->user()],
            'Dashboard admin'
        );
    });

    Route::apiResource('/menu', MenuController::class);
    Route::apiResource('/pesanan', PesananController::class);
    Route::apiResource('/detail-pesanan', DetailPesananController::class);
    Route::apiResource('/stok-menu', StokMenuController::class);
    Route::apiResource('/driver', DriverController::class);
});



// ========================
// SUPERADMIN ROUTES
// ========================

Route::middleware(['auth:sanctum', 'role:superadmin'])->prefix('superadmin')->group(function () {

    Route::get('/dashboard', function () {
        return ApiResponse::success(
            ['super_admin' => auth()->user()],
            'Dashboard super admin'
        );
    });

    Route::apiResource('/menu', MenuController::class);
    Route::apiResource('/pesanan', PesananController::class);
    Route::apiResource('/detail-pesanan', DetailPesananController::class);
    Route::apiResource('/stok-menu', StokMenuController::class);
    Route::apiResource('/driver', DriverController::class);

    Route::apiResource('/admin', AdminController::class);
    Route::apiResource('/user', UserController::class);

    // Super admin menambah admin manual
    Route::post('/add-admin', [AuthController::class, 'addAdmin']);
});
