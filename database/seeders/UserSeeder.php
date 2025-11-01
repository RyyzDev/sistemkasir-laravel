<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class UserSeeder extends Seeder{

	 public function run(): void{
	 	DB::table('users')->truncate();


	 	$user = [
            [
                'name' => 'Admin Ryouta',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin1234'),
                'role' => "CEO/Founder", // Gunakan format desimal yang benar
            ],
        ];

        // Masukkan data ke database
        DB::table('users')->insert($user);






	 }


	


}