<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');

Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class)->except('show');
Route::resource('suppliers', SupplierController::class)->except('show');
