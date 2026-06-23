<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KemendikdasmenAuthController extends Controller
{
    // 1. Fungsi untuk memproses data dari form login
    public function login(Request $request)
    {
        // Validasi input wajib diisi
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba autentikasi menggunakan email dan password
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            
            // 3. PROTEKSI EKSTRA: Cek apakah user yang login benar-benar role kemendikdasmen
            if (Auth::user()->role === 'kemendikdasmen') {
                $request->session()->regenerate();
                
                // Jika benar, arahkan ke dashboard admin pusat
                return redirect()->intended('/kemendikdasmen/dashboard');
            }

            // Jika role salah (misal akun siswa iseng), paksa logout seketika
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akses ditolak. Halaman ini hanya untuk Otoritas Pusat Kemendikdasmen.',
            ])->onlyInput('email');
        }

        // Jika email atau password salah
        return back()->withErrors([
            'email' => 'NIP/Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // 4. Fungsi untuk Logout Admin
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/kemendikdasmen/login');
    }
}