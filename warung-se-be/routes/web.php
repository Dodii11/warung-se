<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;

// MENU
Route::resource('menu', MenuController::class);

// PESANAN
Route::get('pesanan', [PesananController::class, 'index'])->name('pesanan.index'); // admin
Route::get('pesanan-user', [PesananController::class, 'user'])->name('pesanan.user'); // user
Route::post('pesanan', [PesananController::class, 'store'])->name('pesanan.store');
Route::put('pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
Route::get('pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
