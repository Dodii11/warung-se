<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
});

// -------- ADMIN ROUTES --------
Route::middleware(['auth:sanctum', 'role:admin'])->group(function() {
    Route::get('/dashboard/admin', function() {
        return ApiResponse::success(
            ['admin' => auth('admin')->user()],
            'Dashboard admin'
        );
    });

    Route::get('/kelola-pesanan', function() {
        return ApiResponse::success(null, 'Admin bisa kelola pesanan');
    });
});

// -------- SUPER ADMIN ROUTES --------
Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function() {
    Route::get('/dashboard/superadmin', function() {
        return ApiResponse::success(
            ['super_admin' => auth('superadmin')->user()],
            'Dashboard super admin'
        );
    });

    Route::get('/kelola-menu', function() {
        return ApiResponse::success(null, 'Super Admin bisa kelola menu');
    });

    Route::get('/kelola-driver', function() {
        return ApiResponse::success(null, 'Super Admin bisa kelola driver');
    });

    Route::get('/kelola-pelanggan', function() {
        return ApiResponse::success(null, 'Super Admin bisa kelola pelanggan');
    });

    Route::get('/kelola-pesanan', function() {
        return ApiResponse::success(null, 'Super Admin bisa kelola pesanan');
    });

    Route::get('/kelola-admin', function() {
        return ApiResponse::success(null, 'Super Admin bisa kelola admin');
    });

    Route::post('/superadmin/add-admin', [AuthController::class, 'addAdmin']);
});
