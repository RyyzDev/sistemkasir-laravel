<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\registerController;

Route::get('/', function () {
   return view('dashboard');
});

Route::get('/dashboard', function() {
    return view('dashboard');
});

Route::get('/laporan', function(){
    return view('laporan');
});

Route::get('/cashend', function(){
    return view('cashend');
});

Route::get('/login', [loginController::class, 'index']);


Route::get('/register', [registerController::class, 'index']);
Route::post('/register', [registerController::class, 'store']);