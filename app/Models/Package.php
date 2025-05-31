<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
    ];

    /**
     * Relasi ke tabel event.
     * Jika paket berhubungan dengan event, maka bisa dibuat relasi ke Event.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
