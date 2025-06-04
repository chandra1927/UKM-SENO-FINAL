<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalLatihan extends Model
{
    protected $fillable = [
        'kegiatan',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'tempat',
        'catatan',
    ];

    protected $dates = [
        'tanggal', // Menggunakan tipe date untuk kolom tanggal
    ];
}