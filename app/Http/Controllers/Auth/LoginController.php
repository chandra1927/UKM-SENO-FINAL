<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (in_array($user->role, ['customer', 'anggota'])) {
                return redirect()->intended('/dashboard');
            }

            Auth::logout(); // logout jika role tidak sesuai
        }

        return back()->withErrors(['email' => 'Login gagal. Periksa kembali email dan password.']);
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
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role === 'superuser') {
                return redirect()->intended('/superuser');
            } elseif ($user->role === 'keuangan') {
                return redirect()->intended('/keuangan');
            }

            Auth::logout(); // logout jika role tidak sesuai
        }

        return back()->withErrors(['email' => 'Login gagal. Periksa kembali email dan password.']);
    }

    /**
     * Logout pengguna dan redirect ke halaman login.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'Berhasil logout.');
    }
}
