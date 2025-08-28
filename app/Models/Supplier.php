<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_supplier',
        'kode_supplier', 
        'kontak',
        'email',
        'alamat',
        'nama',
        'qty',
        'price',
        'deskripsi',
        'status'
    ];


    protected $casts = [
        'deskripsi' => 'array', // Cast JSON ke array
        'status' => 'boolean'
    ];

        // Tambahkan di model Supplier
public function transactionDetails()
{
    return $this->hasMany(TransactionDetail::class, 'product_id');
}

}