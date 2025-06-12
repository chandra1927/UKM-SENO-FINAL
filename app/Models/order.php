<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
    // 'user_id',
    // 'bundle_id',
    // 'nama_lengkap',
    // 'no_telepon',
    // 'email',
    // 'alamat',
    // 'tanggal_acara',
    // 'waktu_acara',
    // 'lokasi_acara',
    // 'notes',
    // 'total_harga',
    // 'status',
    // 'midtrans_order_id',
    // 'midtrans_payment_url',


    'user_id',
    'bundle_id',
    'total_harga',
    'status',
    'midtrans_order_id',
    'midtrans_payment_url',
    'nama_lengkap',
    'no_telepon',
    'email',
    'alamat',
    'tanggal_acara',
    'waktu_acara',
    'lokasi_acara',
    'notes',
    'bundle_details',
];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }
}