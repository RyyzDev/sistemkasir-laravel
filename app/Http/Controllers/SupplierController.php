<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|max:255',
            'kode_supplier' => 'required|unique:suppliers|max:100',
            'kontak' => 'nullable|max:20',
            'email' => 'nullable|email',
            'alamat' => 'nullable',
            'nama' => 'required|max:100|unique:suppliers',
            'qty' => 'required|max:100',
            'price' => 'required',
            'deskripsi' => 'array',
            'status' => 'boolean'
        ]);

        // Filter deskripsi yang kosong
        $deskripsi = array_filter($request->deskripsi ?? [], function($desc) {
            return !empty(trim($desc));
        });

        Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'kode_supplier' => $request->kode_supplier,
            'kontak' => $request->kontak,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'nama' => $request->nama,
            'qty' => $request->qty,
            'price'=>$request->price,
            'deskripsi' => $deskripsi,
            'status' => $request->status ?? 1
        ]);

        return redirect()->route('dashboard')->with('success', 'Supplier berhasil ditambahkan!');
    }

}