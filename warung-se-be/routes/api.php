<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::get('admin/menu', [MenuController::class, 'index']);
Route::post('admin/menu', [MenuController::class, 'store']);
Route::put('admin/menu/{id}', [MenuController::class, 'update']);
Route::delete('admin/menu/{id}', [MenuController::class, 'destroy']);

