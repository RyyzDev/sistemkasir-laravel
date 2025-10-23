<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class PosController extends Controller
{

public function index()
{
    $products = \App\Models\Supplier::all(); // ambil semua produk
    return view('pos', compact('products'));
}



}