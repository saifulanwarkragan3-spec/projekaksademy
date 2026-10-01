<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StockMovementController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('categories', CategoryController::class)->except('show');
Route::resource('items', ItemController::class)->except('show');
Route::get('/stock-movements', [StockMovementController::class, 'index'])->name('stock-movements.index');
Route::get('/stock-movements/create', [StockMovementController::class, 'create'])->name('stock-movements.create');
Route::post('/stock-movements', [StockMovementController::class, 'store'])->name('stock-movements.store');
