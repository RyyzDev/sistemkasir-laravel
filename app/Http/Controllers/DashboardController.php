<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Products;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(){
        $products = \App\Models\Products::all(); // ambil semua produk
        $person = \App\Models\User::all();
        return view('dashboard', compact('products', 'person'));
    }
}
