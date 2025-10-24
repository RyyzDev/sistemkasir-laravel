<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Panggil seeder produk di sini
            ProductSeeder::class, 
            // Jika ada UserSeeder, panggil di sini juga
            // UserSeeder::class, 
        ]);
    }
}