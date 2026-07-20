<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiasecResult; // Pastikan Model ini ada
use App\Models\SoalRiasec;   // Bank soal dari database
use App\Models\Pengaturan;   // Pengaturan sistem (durasi tes, dll)
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    /**
     * Tampilkan halaman awal form (Panduan/Index)
     */
    public function index()
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Dulu: kalau sudah punya hasil tes, langsung redirect ke dashboard.
        // Sekarang Assessment adalah tab tetap di bottom nav, jadi halaman ini
        // harus tetap bisa dibuka kapan saja — cukup kasih tahu status "sudah tes"
        // ke view supaya tombolnya berubah jadi "Ulangi Tes".
        $sudahTes = RiasecResult::where('user_id', auth()->id())->exists();

        return view('assessment.index', compact('sudahTes'));
    }

    /**
     * Mulai assessment
     */
    public function start(Request $request)
    {
        $request->session()->put('assessment_started', true);
        return redirect()->route('assessment.questions');
    }

    /**
     * Tampilkan pertanyaan assessment.
     * Soal sekarang diambil dari tabel soal_riasecs (status = aktif),
     * bukan lagi array hardcoded di dalam view.
     */
    public function questions()
    {
        if (!session('assessment_started')) {
            return redirect()->route('assessment.index')
                            ->with('error', 'Silakan klik Mulai Tes terlebih dahulu');
        }

        $soalList = SoalRiasec::where('status', 'aktif')
            ->orderBy('urutan')
            ->get();

        // Jaga-jaga kalau admin menonaktifkan/menghapus semua soal
        if ($soalList->isEmpty()) {
            return redirect()->route('assessment.index')
                            ->with('error', 'Soal tes belum tersedia. Hubungi admin.');
        }

        // Durasi tes (menit) diambil dari pengaturan sistem yang bisa diubah admin
        $durasiMenit = (int) Pengaturan::get('durasi_tes_menit', 5);

        return view('assessment.questions-siswa', compact('soalList', 'durasiMenit'));
    }

    /**
     * Proses hasil assessment dan simpan ke database.
     * Skor dihitung berdasarkan aspek tiap soal yang tersimpan di database
     * (bukan lagi kunci jawaban hardcoded berbasis nomor soal).
     */
    public function submit(Request $request)
    {
        // $jawaban berisi daftar ID soal yang dijawab "YA"
        $jawaban = $request->input('jawaban', []);

        $skor = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];

        // Ambil aspek tiap soal yang dijawab YA langsung dari database
        $aspekMap = SoalRiasec::whereIn('id', $jawaban)->pluck('aspek', 'id');

        foreach ($jawaban as $idSoal) {
            $aspek = $aspekMap[$idSoal] ?? null;
            if ($aspek && isset($skor[$aspek])) {
                $skor[$aspek]++;
            }
        }

        // SIMPAN KE DATABASE
        RiasecResult::create([
            'user_id' => Auth::id(),
            'skor_r'  => $skor['R'],
            'skor_i'  => $skor['I'],
            'skor_a'  => $skor['A'],
            'skor_s'  => $skor['S'],
            'skor_e'  => $skor['E'],
            'skor_c'  => $skor['C'],
        ]);

        // Urutkan untuk session result (tampilan)
        arsort($skor);
        $top3 = array_slice($skor, 0, 3, true);

        $request->session()->put('assessment_result', [
            'skor_lengkap' => $skor,
            'top3' => $top3
        ]);

        return redirect()->route('assessment.result')
                         ->with('success', 'Tes selesai! Hasil telah disimpan.');
    }

    public function result()
    {
        if (!session('assessment_result')) {
            return redirect()->route('assessment.index');
        }

        return view('assessment.result', [
            'hasil' => session('assessment_result')
        ]);
    }

    public function reset(Request $request)
    {
        $request->session()->forget(['assessment_started', 'assessment_result']);
        return redirect()->route('assessment.index');
    }
}