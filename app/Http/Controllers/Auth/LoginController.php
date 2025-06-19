<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Tampilkan form login untuk anggota/customer.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login untuk anggota/customer.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Log::info('User logged in', ['email' => $user->email, 'role' => $user->role]);

            if ($user->role === 'customer') {
                return redirect()->route('customer.index');
            } elseif ($user->role === 'anggota') {
                return redirect()->route('anggota.dashboard');
            }

            Auth::logout();
            return back()->withErrors(['email' => 'Role tidak diizinkan untuk login di sini.']);
        }

        return back()->withErrors(['email' => 'Email atau kata sandi salah.']);
    }

    /**
     * Tampilkan form login untuk superuser/keuangan.
     */
    public function showOfficeLoginForm()
    {
        return view('auth.office-login');
    }

    /**
     * Proses login untuk superuser/keuangan.
     */
    public function officeLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Log::info('Office user logged in', ['email' => $user->email, 'role' => $user->role]);

            if ($user->role === 'superuser') {
                return redirect()->intended('/superuser');
            } elseif ($user->role === 'keuangan') {
                return redirect()->intended('/keuangan');
            }

            Auth::logout();
            return back()->withErrors(['email' => 'Role tidak diizinkan untuk login di sini.']);
        }

        return back()->withErrors(['email' => 'Email atau kata sandi salah.']);
    }

    /**
     * Logout pengguna dan redirect ke halaman login.
     */
    public function logout(Request $request)
    {
        Log::info('User logged out', ['email' => Auth::user()->email ?? 'unknown']);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'Berhasil logout.');
    }
}