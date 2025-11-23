<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AuthController;

// USER
Route::get('/login-user', function(){ return view('auth.login_user'); });
Route::post('/login/user', [AuthController::class,'loginUser']);
Route::get('/dashboard/user', function(){ return view('dashboard.user'); })->middleware('role:user');

// ADMIN
Route::get('/login-admin', function(){ return view('auth.login_admin'); });
Route::post('/login/admin', [AuthController::class,'loginAdmin']);
Route::get('/dashboard/admin', function(){ return view('dashboard.admin'); })->middleware('role:admin');

// SUPERADMIN
Route::get('/login-superadmin', function(){ return view('auth.login_superadmin'); });
Route::post('/login/superadmin', [AuthController::class,'loginSuperAdmin']);
Route::get('/dashboard/superadmin', function(){ return view('dashboard.superadmin'); })->middleware('role:superadmin');
