<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_supplier');
            $table->string('kode_supplier');
            $table->string('kontak')->nullable();
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
           // $table->string('nama') ->unique();
           // $table->integer('qty');
           // $table->integer('price');
           // $table->json('deskripsi')->nullable(); // JSON untuk array deskripsi
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
};