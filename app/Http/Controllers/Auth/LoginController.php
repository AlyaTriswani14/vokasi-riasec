<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Memproses percobaan login dari form
     */
    public function login(Request $request)
    {
        // 1. Validasi Input (Pastikan form tidak kosong)
        $request->validate([
            'identifier' => 'required',
            'password' => 'required'
        ], [
            'identifier.required' => 'Email/NISN/NIP wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.'
        ]);

        $identifier = $request->identifier;
        $password = $request->password;

        // 2. Coba Autentikasi (Sistem akan mengecek ke Database)
        
        // Skenario A: Coba cocokkan sebagai Email
        if (Auth::attempt(['email' => $identifier, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // Skenario B: Coba cocokkan sebagai NISN (Jika dia Siswa)
        if (Auth::attempt(['nisn' => $identifier, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // Skenario C: Coba cocokkan sebagai NIP (Jika dia Guru)
        if (Auth::attempt(['nip' => $identifier, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // 3. Jika ketiga skenario di atas gagal (Data tidak ditemukan atau password salah)
        return back()->withErrors([
            'identifier' => 'Identitas atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('identifier'); // Kembalikan ke form beserta input sebelumnya
    }

    /**
     * Memproses proses keluar (Logout)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Hapus sesi keamanan untuk mencegah pembajakan akun
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}