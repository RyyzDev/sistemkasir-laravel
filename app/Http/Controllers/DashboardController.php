<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Products;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(){
        // ambil semua data
        $products = \App\Models\Products::all(); // ambil semua produk
        $person = \App\Models\User::all();
        $suppliers = \App\Models\Supplier::all();
        $transactions = \App\Models\Transaction::all();

        //

        //total nominal penjualan
        $totalHariIni = Transaction::whereDate('created_at', today())->sum('total_amount');
        $totalBulanIni = Transaction::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total_amount');
        $totalPenjualanKeseluruhan = Transaction::sum('total_amount');

        //total transaksi
        $totalTransaksi = Transaction::count();

        // //best seller
        //  $limit = $request->input('limit', 10);
    
        // // Tentukan periode (opsional)
        // $startDate = $request->input('start_date');
        // $endDate = $request->input('end_date');
        // $bestSellers = TransactionDetail::select(
        //     'product_id',
        //     TransactionDetail::raw('SUM(quantity) as total_sold_qty'), // Menjumlahkan quantity
        //     'product_name' // Nama produk sudah ada di detail transaksi
        // )

        // // Gabungkan ke tabel products untuk data produk lengkap
        // // Karena product_name sudah disimpan di details, kita bisa HANYA mengelompokkan berdasarkan product_name
        // // Jika nama produk bisa berubah, lebih aman join ke tabel products.
        // ->groupBy('product_id', 'product_name') 
        
        // // Filter berdasarkan periode waktu jika ada
        // ->when($startDate, function ($query) use ($startDate, $endDate) {
        //     // Kita perlu join ke tabel transactions untuk memfilter tanggal
        //     $query->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
        //           ->whereBetween('transactions.created_at', [$startDate, $endDate]);
        // });



        return view('dashboard', compact(
            'products', 
            'person', 
            'suppliers', 
            'transactions',
            'totalHariIni',
            'totalBulanIni',
            'totalPenjualanKeseluruhan',
            'totalTransaksi',
           // 'bestSellers'

        ));
    }
}
