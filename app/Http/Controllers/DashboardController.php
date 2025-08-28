<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{


    public function index(){
        $produk = Supplier::all();
        return view('dashboard', compact('produk'));
    }

        
}