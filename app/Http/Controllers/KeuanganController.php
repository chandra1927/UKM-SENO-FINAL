<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialTransaction;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    /**
     * Tampilkan dashboard untuk keuangan
     */
    public function index()
    {
        if (auth()->user()->role !== 'keuangan') {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        $totalPemasukan = FinancialTransaction::where('type', 'pemasukan')->sum('amount');
        $totalPengeluaran = FinancialTransaction::where('type', 'pengeluaran')->sum('amount');
        $saldo = $totalPemasukan - $totalPengeluaran;
        $transactions = FinancialTransaction::orderBy('date', 'desc')->take(10)->get();

        return view('keuangan.dashboard', compact('totalPemasukan', 'totalPengeluaran', 'saldo', 'transactions'));
    }

    /**
     * Tampilkan halaman pemasukan
     */
    public function pemasukan()
    {
        if (auth()->user()->role !== 'keuangan') {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        $transactions = FinancialTransaction::where('type', 'pemasukan')->orderBy('date', 'desc')->get();
        return view('keuangan.pemasukan', compact('transactions'));
    }

    /**
     * Simpan data pemasukan
     */
    public function storePemasukan(Request $request)
    {
        if (auth()->user()->role !== 'keuangan') {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        FinancialTransaction::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'description' => $request->description,
            'type' => 'pemasukan',
            'amount' => $request->amount,
        ]);

        return redirect()->route('keuangan.pemasukan')->with('success', 'Pemasukan berhasil ditambahkan');
    }

    /**
     * Tampilkan halaman pengeluaran
     */
    public function pengeluaran()
    {
        if (auth()->user()->role !== 'keuangan') {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        $transactions = FinancialTransaction::where('type', 'pengeluaran')->orderBy('date', 'desc')->get();
        return view('keuangan.pengeluaran', compact('transactions'));
    }

    /**
     * Simpan data pengeluaran
     */
    public function storePengeluaran(Request $request)
    {
        if (auth()->user()->role !== 'keuangan') {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        FinancialTransaction::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'description' => $request->description,
            'type' => 'pengeluaran',
            'amount' => $request->amount,
        ]);

        return redirect()->route('keuangan.pengeluaran')->with('success', 'Pengeluaran berhasil ditambahkan');
    }

    /**
     * Tampilkan halaman laporan keuangan
     */
    public function laporan()
    {
        if (auth()->user()->role !== 'keuangan') {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        $pemasukan = FinancialTransaction::where('type', 'pemasukan')->sum('amount');
        $pengeluaran = FinancialTransaction::where('type', 'pengeluaran')->sum('amount');
        $saldo = $pemasukan - $pengeluaran;
        $transactions = FinancialTransaction::orderBy('date', 'desc')->get();

        return view('keuangan.laporan', compact('pemasukan', 'pengeluaran', 'saldo', 'transactions'));
    }

    public function handleMidtransNotification(Request $request)
{
    \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
    \Midtrans\Config::$isProduction = config('services.midtrans.is_production');

    try {
        $notif = new \Midtrans\Notification();
        $transaction = $notif->getResponse();

        $transactionId = $transaction->transaction_id;
        $status = $transaction->transaction_status;
        $amount = $transaction->gross_amount;

        $order = Order::where('midtrans_order_id', $transactionId)->first();

        if ($order && $status === 'settlement') {
            $order->update(['status' => 'success']);
            \App\Models\FinancialTransaction::create([
                'user_id' => 1, // Ganti dengan ID pengguna keuangan atau logika lain
                'date' => now()->toDateString(),
                'description' => 'Pembayaran Pesanan #' . $order->id,
                'type' => 'pemasukan',
                'amount' => $amount,
                'midtrans_transaction_id' => $transactionId,
            ]);
        } elseif ($order && in_array($status, ['cancel', 'deny', 'expire'])) {
            $order->update(['status' => 'failed']);
        }

        return response()->json(['status' => 'success'], 200);
    } catch (\Exception $e) {
        \Log::error('Midtrans notification error: ' . $e->getMessage());
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
    }
}
}