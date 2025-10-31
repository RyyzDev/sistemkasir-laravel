<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;





Route::get('/login', [loginController::class, 'index'])->name('login')->middleware('guest');
Route::get('/register', [registerController::class, 'index'])->middleware('guest')->name('register');
Route::post('/login', [loginController::class, 'authenticate']);


Route::middleware(['auth'])->group(function () {
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
   	Route::get('/pos', [PosController::class, 'index'])->name('pos');
	Route::get('/sales-report', [SalesController::class, 'getSalesReport'])->name('sales.report');

	Route::post('/register', [registerController::class, 'store']);
	Route::post('/productregister', [ProductController::class, 'store']);
	Route::post('/suppliers', [SupplierController::class, 'store']);
	Route::delete('/destroy/{id}', [SupplierController::class, 'destroy'])->name('products.destroy')->middleware('auth');

	Route::post('/logout', [loginController::class, 'logout']);

	Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');


});

