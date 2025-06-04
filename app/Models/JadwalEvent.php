<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalEvent extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'waktu',
        'tempat',
    ];

    protected $dates = [
        'tanggal', // Menggunakan tipe date untuk kolom tanggal
    ];
}