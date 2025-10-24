<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
         if (!$request->expectsJson()) {
        return response()->json(['error' => 'Request must be JSON'], 400);
    }
        
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'amount_paid' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        
        try {
            $totalAmount = 0;
            $transactionItems = [];

            // Validasi stok dan hitung total
            foreach ($request->items as $item) {
                $product = Products::findOrFail($item['id']);
                
                // Cek stok
                if ($product->qty < $item['quantity']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok {$product->nama} tidak mencukupi"
                    ], 400);
                }

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $transactionItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal
                ];
            }

            // Cek pembayaran
            if ($request->amount_paid < $totalAmount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah pembayaran kurang'
                ], 400);
            }

            // Buat transaction header
            $transaction = Transaction::create([
                'transaction_code' => $this->generateTransactionCode(),
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'amount_paid' => $request->amount_paid,
                'change_amount' => $request->amount_paid - $totalAmount,
                'transaction_date' => now(),
                'status' => 'completed'
            ]);

            // Buat transaction details dan update stok
            foreach ($transactionItems as $item) {
                // Insert detail transaksi
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->nama_produk,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal']
                ]);

                // Update stok produk
                $item['product']->decrement('qty', $item['quantity']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil',
                'data' => [
                    'transaction_id' => $transaction->id,
                    'transaction_code' => $transaction->transaction_code,
                    'total_amount' => $totalAmount,
                    'amount_paid' => $request->amount_paid,
                    'change_amount' => $request->amount_paid - $totalAmount
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generateTransactionCode()
    {
        $date = now()->format('Ymd');
        $lastTransaction = Transaction::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastTransaction ? (int) substr($lastTransaction->transaction_code, -4) + 1 : 1;
        
        return 'TRX' . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function show($id)
    {
        $transaction = Transaction::with('details')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $transaction
        ]);
    }

    public function index(Request $request)
    {
        $transactions = Transaction::with(['user', 'details'])
            ->when($request->date, function($q) use ($request) {
                $q->whereDate('transaction_date', $request->date);
            })
            ->when($request->payment_method, function($q) use ($request) {
                $q->where('payment_method', $request->payment_method);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $transactions
        ]);
    }
}