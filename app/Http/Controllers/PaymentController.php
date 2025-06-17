<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function handleNotification(Request $request)
    {
        try {
            $notification = new Notification();
            
            $transaction_status = $notification->transaction_status;
            $fraud_status = $notification->fraud_status;
            $order_id = $notification->order_id;
            
            // Cari order berdasarkan midtrans_order_id
            $order = Order::where('midtrans_order_id', $order_id)->first();
            
            if (!$order) {
                return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
            }

            // Update status berdasarkan response Midtrans
            if ($transaction_status == 'capture') {
                if ($fraud_status == 'challenge') {
                    $order->status = 'pending';
                } else if ($fraud_status == 'accept') {
                    $order->status = 'success';
                }
            } else if ($transaction_status == 'settlement') {
                $order->status = 'success';
            } else if ($transaction_status == 'pending') {
                $order->status = 'pending';
            } else if ($transaction_status == 'deny') {
                $order->status = 'failed';
            } else if ($transaction_status == 'expire') {
                $order->status = 'failed';
            } else if ($transaction_status == 'cancel') {
                $order->status = 'failed';
            }

            $order->save();
            
            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function callback(Request $request)
    {
        // Callback untuk redirect after payment
        return redirect()->route('customer.order')->with('success', 'Status pembayaran telah diupdate');
    }
}