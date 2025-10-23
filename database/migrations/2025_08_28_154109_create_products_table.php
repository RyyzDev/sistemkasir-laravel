<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key auto increment
            $table->string('nama_produk');
            $table->string('kode_produk');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('qty')->default(0);
          //  $table->boolean('is_active')->default(true);
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};