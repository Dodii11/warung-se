<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;

// MENU
Route::resource('admin/menu', MenuController::class);

// PESANAN
Route::get('admin/pesanan', [PesananController::class, 'index'])->name('pesanan.index'); // admin
Route::get('user/pesanan', [PesananController::class, 'user'])->name('pesanan.user'); // user
Route::post('admin/pesanan', [PesananController::class, 'store'])->name('pesanan.store');
Route::post('/pesanan/update-status/{id}', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
Route::get('admin/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');

Route::get('/auth/google/callback', [SocialiteController::class, 'callback'])
    ->name('google.callback');