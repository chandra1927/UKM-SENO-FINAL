<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    }

 public function checkPaymentStatus($id)
{
    $order = Order::findOrFail($id);
    
    // Pastikan user hanya bisa check order miliknya sendiri
    if ($order->user_id !== auth()->id()) {
        return back()->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengecek pesanan ini.');
    }
    
    if (!$order->midtrans_order_id) {
        return back()->with('error', 'Order ID Midtrans tidak ditemukan.');
    }
    
    try {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
        
        // Check status ke Midtrans API
        $status = \Midtrans\Transaction::status($order->midtrans_order_id);
        
        $old_status = $order->status;
        
        Log::info('Manual payment status check', [
            'order_id' => $order->id,
            'midtrans_order_id' => $order->midtrans_order_id,
            'midtrans_status' => $status->transaction_status,
            'old_status' => $old_status
        ]);
        
        // Update status berdasarkan response
        if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
            $order->status = 'success';
            $order->save();
            return back()->with('success', 'Status pembayaran berhasil diupdate menjadi "Pembayaran Berhasil"!');
        } else if ($status->transaction_status == 'pending') {
            $order->status = 'pending';
            if ($old_status !== $order->status) {
                $order->save();
            }
            return back()->with('warning', 'Pembayaran masih dalam proses. Silakan tunggu beberapa saat lagi.');
        } else if (in_array($status->transaction_status, ['deny', 'expire', 'cancel'])) {
            $order->status = 'failed';
            $order->save();
            return back()->with('error', 'Status pembayaran: ' . ucfirst($status->transaction_status) . '. Silakan lakukan pembayaran ulang.');
        }
        
        return back()->with('info', 'Status pembayaran saat ini: ' . ucfirst($status->transaction_status));
        
    } catch (\Exception $e) {
        Log::error('Check payment status error', [
            'order_id' => $id,
            'midtrans_order_id' => $order->midtrans_order_id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return back()->with('error', 'Gagal mengecek status pembayaran. Silakan coba lagi nanti.');
    }
    
}
public function handleCallback(Request $request)
{
    $notification = new Notification();

    $transaction = $notification->transaction_status;
    $type = $notification->payment_type;
    $orderId = $notification->order_id;
    $fraud = $notification->fraud_status;

    // Cari pesanan berdasarkan order_id dari midtrans
    $order = Order::where('midtrans_order_id', $orderId)->first();

    if (!$order) {
        Log::error("Order not found: " . $orderId);
        return response()->json(['message' => 'Order not found'], 404);
    }

    // Ubah status di database
    if ($transaction == 'capture') {
        if ($type == 'credit_card') {
            if ($fraud == 'challenge') {
                $order->status = 'pending';
            } else {
                $order->status = 'success';
            }
        }
    } else if ($transaction == 'settlement') {
        $order->status = 'success';
    } else if ($transaction == 'pending') {
        $order->status = 'pending';
    } else if ($transaction == 'deny' || $transaction == 'cancel' || $transaction == 'expire') {
        $order->status = 'failed';
    }

    $order->save();
    return response()->json(['message' => 'Callback handled'], 200);
}
}
