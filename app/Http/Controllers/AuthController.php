<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan form login untuk customer/anggota
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menangani login untuk customer/anggota
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            // Login untuk customer/anggota
            Auth::login($user);

            // Redirect berdasarkan role
            if ($user->role === 'customer') {
                return redirect()->intended(route('customer.profile')); // Arahkan ke halaman profil customer
            } elseif ($user->role === 'anggota') {
                return redirect()->intended(route('anggota.dashboard')); // Arahkan ke dashboard anggota
            }

            return redirect()->intended('/'); // Default redirect
        } else {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }
    }

    // Menampilkan form login untuk superuser/keuangan
    public function showLoginFormOffice()
    {
        return view('auth.login-office');
    }

    // Menangani login untuk superuser/keuangan
    public function loginOffice(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Validasi untuk superuser dan keuangan
        $user = User::where('email', $request->email)
                    ->whereIn('role', ['superuser', 'keuangan'])
                    ->first();
        if ($user && Hash::check($request->password, $user->password)) {
            // Login untuk superuser/keuangan
            Auth::login($user);

            // Redirect berdasarkan role
            if ($user->role === 'superuser') {
                return redirect()->intended(route('superuser.dashboard'));
            } elseif ($user->role === 'keuangan') {
                return redirect()->intended(route('keuangan.dashboard'));
            }

            return redirect()->intended('/');
        } else {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }
    }

    // Menangani logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('customer.landing');
    }
}