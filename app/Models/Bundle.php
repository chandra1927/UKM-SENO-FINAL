<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    protected $fillable = [
        'nama_paket',
        'isi_paket',
        'deskripsi',
        'harga',
        'video_path',
    ];

    protected $casts = [
        'isi_paket' => 'array', // Cast kolom JSON menjadi array
    ];
}