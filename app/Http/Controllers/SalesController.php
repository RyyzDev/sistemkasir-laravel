<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionDetail; 
use App\Models\Transaction;
use Carbon\Carbon;

//file krusial hati hati!

class SalesController extends Controller
{
    public function getSalesReport(Request $request)
    {
        $period = $request->get('period', 'bulan');
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $query = TransactionDetail::query()->with('transaction');//relasi ke model trans..

        switch ($period) {
            case 'hari':
                $query->whereHas('transaction', function ($q) {
                    $q->whereDate('transaction_date', today());
                });
                break;
            case 'minggu':
                $query->whereHas('transaction', function ($q) {
                    $q->whereBetween('transaction_date', [
                        Carbon::now()->subDays(6)->startOfDay(),
                        Carbon::now()->endOfDay()
                    ]);
                });
                break;
            case 'bulan':
                $query->whereHas('transaction', function ($q) use ($month, $year) {
                    $q->whereMonth('transaction_date', $month)
                      ->whereYear('transaction_date', $year);
                });
                break;
            case 'tahun':
                $query->whereHas('transaction', function ($q) use ($year) {
                    $q->whereYear('transaction_date', $year);
                });
                break;
        }

        // Ambil semua detail transaksi
        $details = $query->get();
        
        // Transform data untuk frontend
        $sales = $details->map(function ($detail) {
            $transaction = $detail->transaction;

            // Jika relasi tidak ada (data tidak konsisten), lewati atau berikan nilai default
            if (!$transaction) {
                return null;
            }

            return [
                // Mengambil data dari Transaction (Induk)
                'date' => $transaction->transaction_date->format('Y-m-d'), 
                'transaction_code' => $transaction->transaction_code,
                'method' => $transaction->payment_method,

                // Mengambil data dari TransactionDetail (Detail Item)
                'product' => $detail->product_name, 
                'quantity' => $detail->quantity,
                'price' => $detail->price,
                'total' => $detail->subtotal,
            ];
        })->filter()->values(); // Hapus item null jika ada dan reset index array

        // Hitung total ringkasan
        $transactionsForSummary = $details->map(fn($d) => $d->transaction)->filter()->unique('id');

        return response()->json([
            'success' => true,
            'sales' => $sales,
            'summary' => [
                'total_sales' => $sales->sum('total'),
                'total_transactions' => $transactionsForSummary->count(),
                'total_items' => $sales->sum('quantity'),
                'average_transaction' => $transactionsForSummary->count() > 0 
                    ? $transactionsForSummary->sum('total_amount') / $transactionsForSummary->count() 
                    : 0
            ]
        ]);
    }
}