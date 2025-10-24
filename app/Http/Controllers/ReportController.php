<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionDetail;

class ReportController extends Controller
{
    public function getBestSellingProducts(Request $request)
{
    

    $bestSellers = TransactionDetail::select(
            'product_id',
            DB::raw('SUM(quantity) as total_sold_qty'), // Menjumlahkan quantity
            'product_name' // Nama produk sudah ada di detail transaksi
        )

        // Gabungkan ke tabel products untuk data produk lengkap
        // Karena product_name sudah disimpan di details, kita bisa HANYA mengelompokkan berdasarkan product_name
        // Jika nama produk bisa berubah, lebih aman join ke tabel products.
        ->groupBy('product_id', 'product_name') 
        
        // Filter berdasarkan periode waktu jika ada
        ->when($startDate, function ($query) use ($startDate, $endDate) {
            // Kita perlu join ke tabel transactions untuk memfilter tanggal
            $query->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
                  ->whereBetween('transactions.created_at', [$startDate, $endDate]);
        })

        ->orderByDesc('total_sold_qty') // Urutkan dari kuantitas terjual tertinggi
        ->limit($limit)
        ->get();

    return response()->json([
        'success' => true,
        'data' => $bestSellers
    ]);
}
}
