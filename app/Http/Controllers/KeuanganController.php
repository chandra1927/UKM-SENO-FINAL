<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    /**
     * Tampilkan dashboard untuk keuangan
     */
    public function index()
    {
        // Pastikan hanya keuangan yang dapat mengakses
        if (auth()->user()->role === 'keuangan') {
            return view('keuangan.dashboard'); // Tampilkan halaman dashboard keuangan
        }

        // Jika bukan keuangan, redirect ke halaman utama
        return redirect('/')->with('error', 'Unauthorized access');
    }
}
