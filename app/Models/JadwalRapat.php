<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalRapat extends Model
{
    protected $fillable = [
        'agenda',
        'tanggal',
        'waktu',
        'tempat',
        'notulen',
    ];

    protected $dates = [
        'tanggal', // Menggunakan tipe date untuk kolom tanggal
    ];
}