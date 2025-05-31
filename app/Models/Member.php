<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'nim',
        'prodi',
        'angkatan',
        'email',
        'no_hp',
        'alamat',
        'jenis_kelamin',
        'foto',
        'divisi',
        'status',
        'tanggal_gabung',
        'user_id',
        'role_di_ukm',
    ];

    /**
     * Relasi ke User (optional kalau ada user login)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
