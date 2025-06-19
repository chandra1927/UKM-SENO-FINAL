<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    protected $fillable = [
        'order_id', 'status', 'midtrans_response',
    ];

    protected $casts = [
        'midtrans_response' => 'array',
    ];
}
