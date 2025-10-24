<?php

namespace App\Http\Controllers;

//use App\Models\Supplier;
use App\Models\Products;
use Illuminate\Http\Request;

class PosController extends Controller
{

public function index()
{
    $products = \App\Models\Products::all(); // ambil semua produk
    return view('pos', compact('products'));
}



}