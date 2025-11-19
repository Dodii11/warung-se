<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// USER
Route::post('/register/user',[AuthController::class,'registerUser']);
Route::post('/login/user',[AuthController::class,'loginUser']);
Route::middleware(['role:user'])->group(function(){
    Route::get('/dashboard/user', function(){ return 'Dashboard User'; });
});

// ADMIN
Route::post('/register/admin',[AuthController::class,'registerAdmin']);
Route::post('/login/admin',[AuthController::class,'loginAdmin']);
Route::middleware(['role:admin'])->group(function(){
    Route::get('/dashboard/admin', function(){ return 'Dashboard Admin'; });
    Route::get('/kelola-pesanan', function(){ return 'Admin hanya bisa kelola pesanan'; });
});

// SUPER ADMIN
Route::post('/register/superadmin',[AuthController::class,'registerSuperAdmin']);
Route::post('/login/superadmin',[AuthController::class,'loginSuperAdmin']);
Route::middleware(['role:superadmin'])->group(function(){
    Route::get('/dashboard/superadmin', function(){ return 'Dashboard Super Admin'; });
    Route::get('/kelola-menu', function(){ return 'Super Admin bisa kelola menu'; });
    Route::get('/kelola-driver', function(){ return 'Super Admin bisa kelola driver'; });
    Route::get('/kelola-pelanggan', function(){ return 'Super Admin bisa kelola pelanggan'; });
    Route::get('/kelola-pesanan', function(){ return 'Super Admin bisa kelola pesanan'; });
});

