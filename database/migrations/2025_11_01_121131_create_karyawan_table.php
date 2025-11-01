<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            // Data Identitas
            $table->id(); // id (Primary Key, Auto-Increment)
            $table->string('nama', 100);
            $table->string('kode_induk_karyawan', 50)->unique();

            // Data Pekerjaan
            $table->string('jabatan', 50); // jabatan
            $table->integer('gaji_pokok'); // gaji pokok (gunakan integer untuk menyimpan nilai tanpa titik/koma)

            // Data Kontak
            $table->string('email', 100)->unique()->nullable(); // email (Bisa dikosongkan)
            $table->string('no_hp', 20)->nullable(); // no hp (Bisa dikosongkan)

            // Data Status
            $table->enum('status_karyawan', ['Aktif', 'Cuti', 'Nonaktif']); // status karyawan
            $table->date('tanggal_masuk'); // tanggal masuk
            $table->date('tanggal_keluar')->nullable(); // tanggal keluar (Bisa dikosongkan jika masih bekerja)
            
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};