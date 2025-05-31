<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financials extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'type',
        'amount',
        'description',
        'date',
    ];

    /**
     * Relasi ke transaksi (optional jika ada).
     */
    public function transactions()
    {
        return $this->belongsTo(Transactions::class);
    }
}
