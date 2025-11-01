<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';


    protected $fillable = [
        'nama',
        'kode_induk_karyawan',
        'jabatan',
        'gaji_pokok',
        'email',
        'no_hp',
        'status_karyawan',
        'tanggal_masuk',
        'tanggal_keluar',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
    ];

    /**
     * Boot method model untuk auto-generate kode_induk_karyawan.
     */
    protected static function boot()
    {
        parent::boot();

       
        static::creating(function ($karyawan) {
            $prefix = 'RYZM'; // Prefix kode karyawan
            $year = date('y'); // Tahun 2 digit saat ini (misal: 25)

            //Ambil nomor urut terakhir
            $lastKaryawan = self::latest('id')->first();
            
            //Tentukan nomor urut berikutnya
            $nextNumber = 1;
            if ($lastKaryawan) {
              
                $nextNumber = $lastKaryawan->id + 1;
            }

            // 3. Format nomor urut menjadi 4 digit (misal: 0001)
            $formattedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            //Gabungkan untuk membuat kode akhir
            $karyawan->kode_induk_karyawan = "{$prefix}-{$year}-{$formattedNumber}";
        });
    }
}