<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AuthController;

// MENU
Route::resource('admin/menu', MenuController::class);

// PESANAN
Route::get('admin/pesanan', [PesananController::class, 'index'])->name('pesanan.index'); // admin
Route::get('user/pesanan', [PesananController::class, 'user'])->name('pesanan.user'); // user
Route::post('admin/pesanan', [PesananController::class, 'store'])->name('pesanan.store');
Route::post('/pesanan/update-status/{id}', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
Route::get('admin/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');

// Menampilkan form login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Proses login (POST)
Route::post('/login', [AuthController::class, 'login']);

// Proses logout (bisa GET atau POST, POST lebih disarankan)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 1. Akses untuk SEMUA User (termasuk tamu)
Route::get('/', function () { return view('welcome'); });

// 2. Akses Hanya untuk User Biasa (Role: user)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/profile', function () { return view('user.profile'); })->name('user.profile');
});

// 3. Akses Hanya untuk Admin & Super Admin (Role: admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
});

// 4. Akses Hanya untuk Super Admin (Role: super_admin)
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/superadmin/settings', function () { return view('superadmin.settings'); })->name('superadmin.settings');
});