<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Menggunakan model User tunggal yang kamu miliki

class KemendikdasmenAuthController extends Controller
{
    /**
     * Menampilkan halaman Form Login Admin Kemendikdasmen
     */
    public function showLogin()
    {
        // Jika admin sudah login, langsung lempar ke dashboard saja, tidak usah ke form login lagi
        if (Auth::check() && Auth::user()->role === 'kemendikdasmen') {
            return redirect()->route('kemendikdasmen.dashboard');
        }

        return view('auth.login-admin');
    }

    /**
     * Memproses data dari form login (Autentikasi)
     */
    public function login(Request $request)
    {
        // Validasi input wajib diisi
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba autentikasi menggunakan email dan password
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            
            // PROTEKSI EKSTRA: Cek apakah user yang login benar-benar role kemendikdasmen
            if (Auth::user()->role === 'kemendikdasmen') {
                $request->session()->regenerate();
                
                // Jika benar, arahkan ke dashboard admin pusat
                return redirect()->intended(route('kemendikdasmen.dashboard'));
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

    /**
     * Menampilkan halaman Dashboard Admin Kemendikdasmen beserta data kartu angka & persentase
     */
    public function dashboard()
    {
        // ==========================================
        // 1. STRATEGI DATA SEMI-DINAMIS (TABEL USERS)
        // ==========================================
        
        // Menghitung jumlah siswa SMP & SMK berdasarkan kriteria kolom di tabel users kamu
        // (Silakan sesuaikan value 'siswa'/'siswa_smk' atau 'SMP'/'SMK' dengan isi database asli kamu nanti)
        $statSiswaSmpTerdaftar = User::where('role', 'siswa')->whereNotNull('nisn')->count();
        $statSiswaSmkTerdaftar = User::where('role', 'siswa_smk')->count();
        
        // Menghitung jumlah sekolah unik yang terdeteksi dari isian data siswa
        $statSekolahTerdaftar = User::whereNotNull('asal_sekolah')->distinct('asal_sekolah')->count();

        // FALLBACK BACKUP: Jika database masih kosong/0 (baru di-migrate fresh), 
        // kita isi angka tiruan agar presentasi/demo awal kamu tetap terlihat bagus dan terisi.
        if ($statSiswaSmpTerdaftar === 0) {
            $statSiswaSmpTerdaftar = 128430;
        }
        if ($statSiswaSmkTerdaftar === 0) {
            $statSiswaSmkTerdaftar = 496472;
        }
        if ($statSekolahTerdaftar === 0) {
            $statSekolahTerdaftar = 18420;
        }
        
        // Menghitung persentase pendaftaran SMK berdasarkan target kuota nasional (target 600.000)
        $targetKuotaSmk = 600000;
        $persentaseSmk = round(($statSiswaSmkTerdaftar / $targetKuotaSmk) * 100, 1);

        // ==========================================
        // 2. DATA REGIONAL LEADERBOARD (UNTUK BLADE)
        // ==========================================
        $leaderboardWilayah = [
            ['provinsi' => 'DKI Jakarta', 'sekolah' => '1.240', 'siswa' => '85.420', 'completion' => '96.2%'],
            ['provinsi' => 'Jawa Barat', 'sekolah' => '4.850', 'siswa' => '142.110', 'completion' => '94.8%'],
            ['provinsi' => 'Jawa Timur', 'sekolah' => '3.920', 'siswa' => '118.450', 'completion' => '91.5%'],
            ['provinsi' => 'Sumatera Utara', 'sekolah' => '1.810', 'siswa' => '54.230', 'completion' => '89.1%'],
            ['provinsi' => 'Sulawesi Selatan', 'sekolah' => '980', 'siswa' => '28.640', 'completion' => '87.4%'],
        ];

        // Mengirimkan seluruh variabel pelengkap dengan aman menuju file view dashboard-admin.blade.php
        return view('Kemendikdasmen.dashboard-admin', compact(
            'statSekolahTerdaftar',
            'statSiswaSmpTerdaftar', 
            'statSiswaSmkTerdaftar',
            'persentaseSmk',
            'leaderboardWilayah'
        ));
    }

    /**
     * Fungsi untuk Logout Admin
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Diperbarui agar menggunakan penamaan rute resmi Laravel
        return redirect()->route('kemendikdasmen.login');
    }
}