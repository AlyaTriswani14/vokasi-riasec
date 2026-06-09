<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    /**
     * Tampilkan halaman awal form (Panduan/Index)
     */
    public function index()
    {
        return view('assessment.index');
    }

    /**
     * Mulai assessment (Tanpa validasi nama/kelas karena pakai tombol langsung)
     */
    public function start(Request $request)
    {
        // Karena data diri (nama, dll) didapat dari proses Login/Register sebelumnya,
        // di sini kita cukup memberikan tanda (session) bahwa user sudah memulai tes.
        $request->session()->put('assessment_started', true);

        // Langsung arahkan ke halaman pertanyaan
        return redirect()->route('assessment.questions');
    }

    /**
     * Tampilkan pertanyaan assessment
     */
    public function questions()
    {
        // Pastikan user masuk dari tombol "Mulai Tes", bukan langsung mengetik URL
        if (!session('assessment_started')) {
            return redirect()->route('assessment.index')
                             ->with('error', 'Silakan klik Mulai Tes terlebih dahulu');
        }

        return view('assessment.questions');
    }

    /**
     * Proses hasil assessment (Menghitung Skor RIASEC)
     */
    public function submit(Request $request)
    {
        // Ambil data jawaban (berupa array berisi nomor soal yang dicentang)
        // Jika tidak ada yang dicentang sama sekali, defaultnya adalah array kosong []
        $jawaban = $request->input('jawaban', []); 

        // 1. Kunci Jawaban RIASEC berdasarkan dokumen PDF 
        $kunci = [
            'R' => [1, 7, 14, 22, 30, 32, 37], // R - Realistic 
            'I' => [2, 11, 18, 21, 26, 33, 39], // I - Investigative 
            'A' => [3, 8, 17, 23, 27, 31, 41], // A - Artistic 
            'S' => [4, 12, 13, 20, 28, 34, 40], // S - Social 
            'E' => [5, 10, 16, 19, 29, 36, 42], // E - Enterprising 
            'C' => [6, 9, 15, 24, 25, 35, 38], // C - Conventional 
        ];

        // Siapkan wadah skor awal (0 semua)
        $skor = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];

        // 2. Hitung jumlah skor berdasarkan jawaban "Ya" (yang dicentang)
        foreach ($jawaban as $nomor_soal) {
            foreach ($kunci as $tipe => $daftar_nomor) {
                if (in_array($nomor_soal, $daftar_nomor)) {
                    $skor[$tipe]++;
                    break; // Lanjut ke nomor soal berikutnya
                }
            }
        }

        // 3. Urutkan skor dari yang paling tinggi ke paling rendah
        arsort($skor);

        // 4. Ambil 3 Minat Tertinggi (Top 3)
        $top3 = array_slice($skor, 0, 3, true);

        // Simpan hasil skor ini ke dalam session agar bisa ditampilkan di halaman Result dan Scoring
        $request->session()->put('assessment_result', [
            'skor_lengkap' => $skor,
            'top3' => $top3
        ]);

        // Arahkan ke halaman hasil utama
        return redirect()->route('assessment.result')
                         ->with('success', 'Tes selesai! Ini adalah hasilnya.');
    }

    /**
     * Tampilkan hasil assessment utama
     */
    public function result()
    {
        // Jika belum ada hasil, kembalikan ke halaman index
        if (!session('assessment_result')) {
            return redirect()->route('assessment.index');
        }

        // Tampilkan halaman view result dengan membawa data hasil
        return view('assessment.result', [
            'hasil' => session('assessment_result')
        ]);
    }

    /**
     * Tampilkan detail skoring assessment
     */
    public function scoring()
    {
        // Jika belum ada hasil, kembalikan ke halaman index
        if (!session('assessment_result')) {
            return redirect()->route('assessment.index');
        }

        // Tampilkan halaman view scoring dengan membawa data hasil yang sama
        return view('assessment.scoring', [
            'hasil' => session('assessment_result')
        ]);
    }

    /**
     * Reset assessment
     */
    public function reset(Request $request)
    {
        // Hapus semua data tes dari memori session
        $request->session()->forget(['assessment_started', 'assessment_result']);
        
        return redirect()->route('assessment.index');
    }
}