<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalLatihan extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari nama model
    protected $table = 'jadwal_latihans'; // Pastikan ini sesuai dengan nama tabel Anda

    // Tentukan kolom yang dapat diisi (fillable)
    protected $fillable = [
        'kegiatan',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'tempat',
        'catatan',
    ];

    // Definisikan relasi jika diperlukan, contoh:
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
