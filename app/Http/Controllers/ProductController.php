<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
      public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|max:255',  
            'kode_produk' => 'required|max:100',
            'price' => 'required',
            'qty' => 'required',
            'description' => 'nullable',
            // 'nama' => 'required|max:100|unique:suppliers',
            // 'qty' => 'required|max:100',
            // 'price' => 'required',
            //'deskripsi' => 'nullable|array',
            'status' => 'boolean'
        ]);

        // // Filter deskripsi yang kosong
        // $deskripsi = array_filter($request->deskripsi ?? [], function($desc) {
        //     return !empty(trim($desc));
        // });

        Products::create([
            'nama_produk' => $request->nama_produk,
            'kode_produk' => $request->kode_produk,
            'price' => $request->price,
            'qty' => $request->qty,
            'deskripsi' => $request->description,
            // 'nama' => $request->nama,
            // 'qty' => $request->qty,
            // 'price'=>$request->price,
            // 'deskripsi' => $deskripsi,
            'status' => $request->status ?? 1
        ]);

        return redirect()->route('dashboard')->with('success', 'Produk berhasil ditambahkan!');
    }



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
        $products = Products::select('id', 'nama_produk', 'kode_produk as kode', 'price', 'qty')
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