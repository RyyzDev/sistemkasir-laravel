<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        $products = Supplier::select('id', 'nama', 'kode_supplier as kode', 'price', 'qty')
            ->where(function($q) use ($query) {
                $q->where('nama', 'like', "%{$query}%")
                  ->orWhere('kode_supplier', 'like', "%{$query}%");
            })
            ->where('status', 1) // Hanya produk aktif
            ->orderBy('nama')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function getAll()
    {
        $products = Supplier::select('id', 'nama', 'kode_supplier as kode', 'price', 'qty')
            ->where('status', 1)
            ->where('qty', '>', 0) // Hanya yang ada stok
            ->orderBy('nama')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }
}