<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PaymentStatus;
use Illuminate\Support\Facades\Log;
use Midtrans\Transaction;

class MidtransCallbackController extends Controller
{
    public function receive(Request $request)
    {
        $serverKey = config('midtrans.server_key'); // dari config
        $signatureKey = $request->signature_key;

        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;

        $computedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $computedSignature) {
            Log::warning('Invalid Midtrans signature for order ' . $orderId);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status;

        $order = Order::where('midtrans_order_id', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $order->status = 'success';
            } else {
                $order->status = 'failed';
            }
        } elseif ($transactionStatus == 'settlement') {
            $order->status = 'success';
        } elseif ($transactionStatus == 'pending') {
            $order->status = 'pending';
        } else {
            $order->status = 'failed';
        }

        $order->save();

        // Simpan ke table payment_status
        PaymentStatus::create([
            'order_id' => $order->id,
            'status' => $order->status,
            'midtrans_response' => json_encode($request->all())
        ]);

        return response()->json(['message' => 'Notification handled']);
    }
}
