<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama sesuai role user.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'anggota' || $user->role === 'customer') {
            return view('anggota.dashboard  ', compact('user'));
        }

        // Jika bukan role yang diizinkan
        return redirect('/')->with('error', 'Akses tidak diizinkan.');
    }

    /**
     * Menampilkan form edit profil untuk customer.
     */
    public function editCustomer()
    {
        $user = Auth::user();

        if ($user->role !== 'customer') {
            return redirect()->route('dashboard')->with('error', 'Hanya customer yang bisa mengedit profil ini.');
        }

        return view('customer.edit', compact('user'));
    }

    /**
     * Proses update profil customer.
     */
    public function updateCustomer(Request $request)
    {
        // $user = Auth::user();

        // if ($user->role !== 'customer') {
        //     return redirect()->route('dashboard')->with('error', 'Hanya customer yang bisa memperbarui profil.');
        // }

        // $validated = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        // ]);

        // $user->update($validated);

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Menampilkan halaman jadwal event untuk anggota.
     */
    public function jadwalEvent()
    {
        return view('anggota.jadwal.event');
    }

    /**
     * Menampilkan halaman jadwal latihan untuk anggota.
     */
    public function jadwalLatihan()
    {
        return view('anggota.jadwal.latihan');
    }

    /**
     * Menampilkan halaman jadwal rapat untuk anggota.
     */
    public function jadwalRapat()
    {
        return view('anggota.jadwal.rapat');
    }
}
