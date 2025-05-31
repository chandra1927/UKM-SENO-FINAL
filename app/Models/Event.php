<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'start_date',
        'end_date',
    ];

    // Relasi ke transaksi (jika ada pembayaran terkait event)
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
