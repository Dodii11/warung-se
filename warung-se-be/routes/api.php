<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\PesananController;
use App\Http\Controllers\API\DetailPesananController;
use App\Http\Controllers\API\DriverController;
use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\AlamatController;
use App\Http\Controllers\API\StatistikController;

/*
    |--------------------------------------------------------------------------
    | PUBLIC ROUTES (Tanpa Authentication)
    |--------------------------------------------------------------------------
    */

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
    |--------------------------------------------------------------------------
    | PROTECTED ROUTES (Harus Login - cek token Sanctum)
    |--------------------------------------------------------------------------
    */
Route::middleware(['auth:sanctum'])->group(function () {

    // Logout (semua role)
    Route::post('/logout', [AuthController::class, 'logout']);

    // Routes yang diizinkan semua role *yang sudah login*
    Route::get('/menu', [MenuController::class, 'index']);
    Route::get('/menu/{id}', [MenuController::class, 'show']);
    Route::get('/menu/{id}/gambar', action: [MenuController::class, 'gambar']);

    // ✅ PINDAHKAN /account/me KE SINI, TANPA middleware role:user
    Route::get('/account/me', [AccountController::class, 'me']);

    Route::get('/pesanan/{id}/detail', [DetailPesananController::class, 'index']);
    Route::get('/detail-pesanan/{id}', [DetailPesananController::class, 'show']);

    Route::get('/alamat', [AlamatController::class, 'index']);
    Route::get('/alamat/{id}', [AlamatController::class, 'show']);
    Route::post('/alamat', [AlamatController::class, 'store']);
    Route::put('/alamat/{id}', [AlamatController::class, 'update']);
    Route::delete('/alamat/{id}', [AlamatController::class, 'destroy']);

    /*
        |--------------------------------------------------------------------------
        | ROLE: USER
        |--------------------------------------------------------------------------
        */
    Route::middleware(['role:user'])->group(function () {
        // Cart
        Route::get('/cart', [CartController::class, 'index']);
        Route::post('/cart', [CartController::class, 'store']);
        Route::delete('/cart/{id_menu}', [CartController::class, 'destroy']);
        Route::delete('/cart', [CartController::class, 'clear']);

        // Pesanan sendiri
        Route::get('/pesanan', [PesananController::class, 'index']);
        Route::get('/pesanan/{id}', [PesananController::class, 'show']);
        Route::post('/pesanan', [PesananController::class, 'checkout']);

        // Account sendiri - UPDATE & DELETE tetap untuk user biasa
        // ❌ HAPUS: Route::get('/account/me', [AccountController::class, 'me']);
        Route::put('/account/me', [AccountController::class, 'update']);
        Route::delete('/account/me', [AccountController::class, 'destroy']);
    });

    /*
        |--------------------------------------------------------------------------
        | ROLE: ADMIN
        |--------------------------------------------------------------------------
        */
    Route::middleware(['role:admin'])->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            return response()->json(['message' => 'Admin Dashboard Accessed']);
        });

        // CRUD Driver
        Route::get('/driver', [DriverController::class, 'index']);
        Route::get('/driver/{id}', [DriverController::class, 'show']);
        Route::post('/driver', [DriverController::class, 'store']);
        Route::put('/driver/{id}', [DriverController::class, 'update']);
        Route::delete('/driver/{id}', [DriverController::class, 'destroy']);

        // Pesanan semua user
        Route::get('/pesanan', [PesananController::class, 'index']);
        Route::put('/pesanan/{id}', [PesananController::class, 'updateStatus']);
        Route::put('/detail-pesanan/{id}', [DetailPesananController::class, 'update']);
        Route::delete('/detail-pesanan/{id}', [DetailPesananController::class, 'destroy']);

        // CRUD User
        Route::get('/users/customer', [AccountController::class, 'indexUser']);

        Route::get('/statistik', [StatistikController::class, 'index']);
    });

    /*
        |--------------------------------------------------------------------------
        | ROLE: SUPER ADMIN
        |--------------------------------------------------------------------------
        */
    Route::middleware(['role:super admin'])->group(function () {

        // CRUD Menu
        Route::post('/menu', [MenuController::class, 'store']);
        Route::put('/menu/{id}', [MenuController::class, 'update']);
        Route::delete('/menu/{id}', [MenuController::class, 'destroy']);

        // CRUD Driver
        Route::get('/driver', [DriverController::class, 'index']);
        Route::get('/driver/{id}', [DriverController::class, 'show']);
        Route::post('/driver', [DriverController::class, 'store']);
        Route::put('/driver/{id}', [DriverController::class, 'update']);
        Route::delete('/driver/{id}', [DriverController::class, 'destroy']);

        // CRUD Account / user
        Route::get('/user', [AccountController::class, 'index']);
        Route::get('/user/{id}', [AccountController::class, 'show']);
        Route::post('/user', [AccountController::class, 'store']);
        Route::put('/user/{id}', [AccountController::class, 'update']);
        Route::delete('/user/{id}', [AccountController::class, 'destroy']);
        Route::get('/users/customer', [AccountController::class, 'indexUser']);

        // Assign Driver ke pesanan
        Route::put('/pesanan/{id}/assign-driver', [PesananController::class, 'assignDriver']);

        // Pesanan semua user
        Route::get('/pesanan', [PesananController::class, 'index']);
        Route::put('/pesanan/{id}', [PesananController::class, 'updateStatus']);
        Route::put('/detail-pesanan/{id}', [DetailPesananController::class, 'update']);
        Route::delete('/detail-pesanan/{id}', [DetailPesananController::class, 'destroy']);

        // CRUD Admin
        Route::get('/admins', [AccountController::class, 'indexAdmin']);
        Route::post('/admins', [AccountController::class, 'storeAdmin']);
        Route::post('/admins/{id}', [AccountController::class, 'updateByAdmin']);
        Route::delete('/admins/{id}', [AccountController::class, 'destroy']);

        Route::get('/statistik', [StatistikController::class, 'index']);
    });
});
