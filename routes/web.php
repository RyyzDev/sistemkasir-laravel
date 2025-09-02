<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;


Route::get('/', [loginController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/laporan', function(){
    return view('laporan');
})->middleware('auth');

Route::get('/cashend', function(){
    return view('cashend');
})->middleware('auth');



Route::get('/login', [loginController::class, 'index'])->name('login')->middleware('guest');
Route::get('/register', [registerController::class, 'index'])->middleware('guest')->name('register');


//method post
Route::post('/register', [registerController::class, 'store']);
Route::post('/suppliers', [SupplierController::class, 'store']);
Route::delete('/destroy/{id}', [SupplierController::class, 'destroy'])->name('products.destroy');
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


    //protected

});

