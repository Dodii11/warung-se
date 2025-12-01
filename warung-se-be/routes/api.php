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
// PUBLIC ROUTES (Tanpa Auth)
// ========================

// -------- USER ROUTES --------
Route::post('/register/user', [AuthController::class, 'registerUser']);
Route::post('/login/user', [AuthController::class, 'loginUser']);

// -------- ADMIN ROUTES --------
Route::post('/login/admin', [AuthController::class, 'loginAdmin']);

// -------- SUPER ADMIN ROUTES --------
Route::post('/login/superadmin', [AuthController::class, 'loginSuperAdmin']);

// -------- LOGOUT ROUTES --------
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// ========================
// PROTECTED ROUTES (Membutuhkan Auth)
// ========================

// -------- USER ROUTES --------
Route::middleware(['auth:sanctum', 'role:user'])->group(function() {
    Route::get('/dashboard/user', function() {
        return ApiResponse::success(
            ['user' => auth('user')->user()],
            'Dashboard user'
        );
    });

    // User bisa akses: Menu (read-only), Pesanan, Detail Pesanan
    Route::get('/menu', [MenuController::class, 'index']);
    Route::get('/menu/{id}', [MenuController::class, 'show']);

    Route::get('/pesanan', [PesananController::class, 'index']);
    Route::post('/pesanan', [PesananController::class, 'store']);
    Route::get('/pesanan/{id}', [PesananController::class, 'show']);
    Route::put('/pesanan/{id}', [PesananController::class, 'update']);
    Route::delete('/pesanan/{id}', [PesananController::class, 'destroy']);

    Route::get('/detail-pesanan', [DetailPesananController::class, 'index']);
    Route::post('/detail-pesanan', [DetailPesananController::class, 'store']);
    Route::get('/detail-pesanan/{id}', [DetailPesananController::class, 'show']);
    Route::put('/detail-pesanan/{id}', [DetailPesananController::class, 'update']);
    Route::delete('/detail-pesanan/{id}', [DetailPesananController::class, 'destroy']);
});

// -------- ADMIN ROUTES --------
Route::middleware(['auth:sanctum', 'role:admin'])->group(function() {
    Route::get('/dashboard/admin', function() {
        return ApiResponse::success(
            ['admin' => auth('admin')->user()],
            'Dashboard admin'
        );
    });

    // Admin bisa akses: Menu, Pesanan, Detail Pesanan, Stok Menu, Driver
    Route::apiResource('/menu', MenuController::class);

    Route::apiResource('/pesanan', PesananController::class);

    Route::apiResource('/detail-pesanan', DetailPesananController::class);

    Route::apiResource('/stok-menu', StokMenuController::class);

    Route::apiResource('/driver', DriverController::class);
});

// -------- SUPER ADMIN ROUTES --------
Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function() {
    Route::get('/dashboard/superadmin', function() {
        return ApiResponse::success(
            ['super_admin' => auth('superadmin')->user()],
            'Dashboard super admin'
        );
    });

    // Super Admin bisa akses SEMUA resource
    Route::apiResource('/menu', MenuController::class);

    Route::apiResource('/pesanan', PesananController::class);

    Route::apiResource('/detail-pesanan', DetailPesananController::class);

    Route::apiResource('/stok-menu', StokMenuController::class);

    Route::apiResource('/driver', DriverController::class);

    Route::apiResource('/admin', AdminController::class);

    Route::apiResource('/user', UserController::class);

    // Route khusus tambah admin
    Route::post('/superadmin/add-admin', [AuthController::class, 'addAdmin']);
});
