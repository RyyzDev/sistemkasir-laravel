<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi mass assignment
    protected $fillable = [
        'nama_produk',
        'kode_produk',
        'description', 
        'price',
        'qty',
        'category',
      //  'status'
    ];

    // Cast tipe data
    protected $casts = [
        'price' => 'decimal:2',
     //   'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price');
    }

    // Scopes
    public function scopeActive($query){ return $query->where
    ('is_active', true); }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    // Accessors & Mutators
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(strtolower($value));
    }
}