<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Buat 50 produk random
        Product::factory(50)->create();

        // Buat produk dengan state tertentu
        Product::factory(5)->inactive()->create();
        Product::factory(3)->outOfStock()->create();
        Product::factory(2)->expensive()->create();

        // Buat produk manual
        Product::create([
            'name' => 'iPhone 14',
            'description' => 'Latest iPhone model',
            'price' => 15000000,
            'stock' => 10,
            'category' => 'Electronics',
            'is_active' => true
        ]);
    }
}