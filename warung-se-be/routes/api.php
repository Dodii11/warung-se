<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;

// Rute ini otomatis akan memiliki prefix /api
Route::get('/test', function () {
    return response()->json([
        'message' => 'API Warung Ayam Berhasil Terhubung!'
    ]);
});

// Rute ini akan mengambil data user yang sedang login
// (Otomatis dibuat jika Anda juga menjalankan breeze:install api)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return $request->user();});


