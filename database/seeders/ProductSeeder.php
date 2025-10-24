<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Products; // Pastikan menggunakan Model Products Anda
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Opsional: Hapus data lama agar saat di-seed ulang, datanya bersih
        DB::table('products')->truncate(); 

        $products = [
            [
                'nama_produk' => 'Es Krim Walls Vanilla',
                'kode_produk' => 'WLS-VN01',
                'description' => 'Es krim rasa vanilla 1 liter',
                'price' => 3000.00, // Gunakan format desimal yang benar
                'qty' => 50,
               // 'category' => 'Food & Beverage', // Sesuaikan dengan kolom 'category' Anda
                //'status' => 1, // Aktif
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_produk' => 'Kerupuk Udang ABC',
                'kode_produk' => 'KPK-UD02',
                'description' => 'Kerupuk mentah siap goreng',
                'price' => 15000.00,
                'qty' => 120,
               // 'category' => 'Grocery',
               // 'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_produk' => 'Sabun Mandi Cair Lux',
                'kode_produk' => 'SBN-LX03',
                'description' => 'Sabun mandi cair 450ml',
                'price' => 22500.00,
                'qty' => 85,
              //  'category' => 'Personal Care',
               // 'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Masukkan data ke database
        DB::table('products')->insert($products);

        // Jika Anda menggunakan Factory untuk data yang lebih banyak:
        // Products::factory()->count(50)->create(); 
    }
}