<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Notification;

class PaymentCallbackController extends Controller
{
    public function handleNotification(Request $request)
    {
        try {
            // Inisialisasi notifikasi Midtrans
            $notification = new Notification();

            $orderId = $notification->order_id;
            $statusCode = $notification->status_code;
            $grossAmount = $notification->gross_amount;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;

            // Ambil order berdasarkan midtrans_order_id
            $order = Order::where('midtrans_order_id', $orderId)->first();

            if (!$order) {
                \Log::warning('Order not found for Midtrans notification: ' . $orderId);
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Verifikasi jumlah pembayaran
            if ($grossAmount != $order->total_harga) {
                \Log::warning('Invalid gross amount for order: ' . $orderId);
                return response()->json(['message' => 'Invalid amount'], 400);
            }

            // Perbarui status berdasarkan transaction_status dan fraud_status
            if ($transactionStatus == 'capture' && $fraudStatus == 'accept') {
                $order->update([
                    'status' => 'success',
                    'payment_status' => 'success',
                ]);
            } elseif ($transactionStatus == 'settlement') {
                $order->update([
                    'status' => 'success',
                    'payment_status' => 'success',
                ]);
            } elseif ($transactionStatus == 'pending') {
                $order->update([
                    'status' => 'pending',
                    'payment_status' => 'pending',
                ]);
            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'cancel' || $transactionStatus == 'expire') {
                $order->update([
                    'status' => 'failed',
                    'payment_status' => $transactionStatus == 'expire' ? 'expired' : 'failed',
                ]);
            }

            \Log::info('Midtrans notification processed for order: ' . $orderId . ', status: ' . $transactionStatus);

            return response()->json(['message' => 'Notification processed'], 200);
        } catch (\Exception $e) {
            \Log::error('Midtrans notification error: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing notification'], 500);
        }
    }
}