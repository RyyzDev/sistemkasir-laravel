<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/laporan', function(){
    return view('laporan');
});

Route::get('/cashend', function(){
    return view('cashend');
});

Route::get('/login', [loginController::class, 'index'])->name('login');
Route::get('/register', [registerController::class, 'index']);


//method post
Route::post('/register', [registerController::class, 'store']);
Route::post('/suppliers', [SupplierController::class, 'store']);
Route::post('/login', [loginController::class, 'authenticate']);
Route::post('/logout', [loginController::class, 'logout']);

// routes/web.php atau routes/api.php
Route::middleware(['auth'])->group(function () {
    // Product routes
    Route::get('/api/products/search', [ProductController::class, 'search']);
    Route::get('/api/products', [ProductController::class, 'getAll']);
    
    // Transaction routes
    Route::post('/api/transactions', [TransactionController::class, 'store']);
    Route::get('/api/transactions', [TransactionController::class, 'index']);
    Route::get('/api/transactions/{id}', [TransactionController::class, 'show']);
});

