<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProductController;



Route::get('/', [loginController::class, 'index']);
Route::get('/pos', [PosController::class, 'index'])->name('pos')->middleware('auth');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/cashend', function(){
    return view('cashend');
})->middleware('auth');



Route::get('/login', [loginController::class, 'index'])->name('login')->middleware('guest');
Route::get('/register', [registerController::class, 'index'])->middleware('guest')->name('register');


//method post
Route::post('/register', [registerController::class, 'store']);
Route::post('/productregister', [ProductController::class, 'store']);
Route::post('/suppliers', [SupplierController::class, 'store']);
Route::delete('/destroy/{id}', [SupplierController::class, 'destroy'])->name('products.destroy');
Route::post('/login', [loginController::class, 'authenticate']);
Route::post('/logout', [loginController::class, 'logout']);

Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

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

