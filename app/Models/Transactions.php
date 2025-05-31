<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'amount',
        'status',
        'payment_proof',
        'approved_by',
    ];

    // Relasi ke user yang melakukan transaksi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke event (jika ada)
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relasi ke user yang menyetujui (admin/keuangan)
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Relasi ke financial (jika ada)
    public function financial()
    {
        return $this->hasOne(Financial::class);
    }
}
