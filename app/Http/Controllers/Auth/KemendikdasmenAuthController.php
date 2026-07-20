<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\RiasecResult;

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
        // DATA ASLI DARI DATABASE (bukan data contoh lagi)
        // ==========================================

        $totalSiswaSmp = User::where('role', 'siswa')->where('jenjang', 'smp')->count();
        $totalSiswaSmk = User::where('role', 'siswa')->where('jenjang', 'smk')->count();

        $totalSekolahSmp = User::where('role', 'guru_bk')->where('jenjang', 'smp')->count();
        $totalSekolahSmk = User::where('role', 'guru_bk')->where('jenjang', 'smk')->count();

        $siswaSmpIds = User::where('role', 'siswa')->where('jenjang', 'smp')->pluck('id');
        $siswaSmkIds = User::where('role', 'siswa')->where('jenjang', 'smk')->pluck('id');

        $totalTesSmp = RiasecResult::whereIn('user_id', $siswaSmpIds)->distinct('user_id')->count('user_id');
        $totalTesSmk = RiasecResult::whereIn('user_id', $siswaSmkIds)->distinct('user_id')->count('user_id');

        // Top 5 sekolah berdasarkan jumlah siswa terdaftar (dihitung dari akun Guru BK
        // yang sudah terdaftar via NPSN, dicocokkan ke asal_sekolah siswa)
        $topSekolah = User::where('role', 'guru_bk')->get()->map(function ($guru) {
            $jumlahSiswa = User::where('role', 'siswa')
                ->where('asal_sekolah', $guru->nama_sekolah)
                ->count();

            return [
                'nama' => $guru->nama_sekolah,
                'npsn' => $guru->npsn,
                'jumlah_siswa' => $jumlahSiswa,
            ];
        })->sortByDesc('jumlah_siswa')->take(5)->values();

        // Tren jumlah tes selesai per bulan, dipisah SMP & SMK
        $jenjangMap = User::pluck('jenjang', 'id');
        $hasilAll = RiasecResult::select('user_id', 'created_at')->orderBy('created_at')->get();

        $trendSmp = [];
        $trendSmk = [];
        foreach ($hasilAll as $r) {
            $bulan = $r->created_at->format('Y-m');
            $jenjangSiswa = $jenjangMap[$r->user_id] ?? null;
            if ($jenjangSiswa === 'smp') {
                $trendSmp[$bulan] = ($trendSmp[$bulan] ?? 0) + 1;
            } elseif ($jenjangSiswa === 'smk') {
                $trendSmk[$bulan] = ($trendSmk[$bulan] ?? 0) + 1;
            }
        }

        $allBulan = collect(array_keys($trendSmp))->merge(array_keys($trendSmk))->unique()->sort()->values();

        $trendLabels = $allBulan->map(fn ($b) => \Carbon\Carbon::createFromFormat('Y-m', $b)->translatedFormat('M Y'))->toArray();
        $trendDataSmp = $allBulan->map(fn ($b) => $trendSmp[$b] ?? 0)->toArray();
        $trendDataSmk = $allBulan->map(fn ($b) => $trendSmk[$b] ?? 0)->toArray();

        return view('Kemendikdasmen.dashboard-admin', compact(
            'totalSiswaSmp',
            'totalSiswaSmk',
            'totalSekolahSmp',
            'totalSekolahSmk',
            'totalTesSmp',
            'totalTesSmk',
            'topSekolah',
            'trendLabels',
            'trendDataSmp',
            'trendDataSmk'
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