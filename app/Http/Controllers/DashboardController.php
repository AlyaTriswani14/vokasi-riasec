<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiasecResult;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $hasilTes = RiasecResult::where('user_id', Auth::id())->latest()->first();

        $top3 = [];
        $dataMinat = [];

        if ($hasilTes) {
            $skor = [
                'R' => $hasilTes->skor_r, 'I' => $hasilTes->skor_i, 
                'A' => $hasilTes->skor_a, 'S' => $hasilTes->skor_s, 
                'E' => $hasilTes->skor_e, 'C' => $hasilTes->skor_c
            ];
            arsort($skor);
            $top3 = array_slice($skor, 0, 3, true);

            $mapping = [
                'R' => ['nama' => 'Realistic (Praktis)', 'desc' => 'Kamu menyukai aktivitas fisik, alat-alat, dan bekerja di luar ruangan.', 'rekomendasi' => 'Teknik Mesin, Otomotif, Teknik Sipil, Pertanian.'],
                'I' => ['nama' => 'Investigative (Pemikir)', 'desc' => 'Kamu gemar mengamati, belajar, dan menganalisis masalah kompleks.', 'rekomendasi' => 'TKJ, Kimia Analisis, Farmasi, Rekayasa Perangkat Lunak.'],
                'A' => ['nama' => 'Artistic (Kreatif)', 'desc' => 'Kamu memiliki jiwa ekspresif, orisinal, dan menyukai kebebasan dalam berkreasi.', 'rekomendasi' => 'DKV, Multimedia, Seni Lukis, Animasi, Tata Busana.'],
                'S' => ['nama' => 'Social (Penolong)', 'desc' => 'Kamu senang membantu, mengajar, dan berinteraksi dengan orang lain.', 'rekomendasi' => 'Pendidikan, Keperawatan, Pekerjaan Sosial, Psikologi.'],
                'E' => ['nama' => 'Enterprising (Pemimpin)', 'desc' => 'Kamu memengaruhi orang lain, berani mengambil keputusan, dan mengejar target.', 'rekomendasi' => 'Bisnis Daring, Manajemen Perkantoran, Usaha Perjalanan Wisata.'],
                'C' => ['nama' => 'Conventional (Teratur)', 'desc' => 'Kamu menyukai data, angka, dan bekerja dengan sistem yang rapi.', 'rekomendasi' => 'Akuntansi, Administrasi Perkantoran, Perbankan.'],
            ];

            foreach ($top3 as $key => $val) {
                if (isset($mapping[$key])) {
                    $dataMinat[$key] = $mapping[$key];
                }
            }
        }

        return view('siswa.dashboard', compact('hasilTes', 'top3', 'dataMinat'));
    }

    public function profil()
    {
        // Mengambil hasil tes terakhir user untuk ditampilkan di halaman profil
        $hasilTes = RiasecResult::where('user_id', Auth::id())->latest()->first();
        
        return view('siswa.profil', compact('hasilTes'));
    }
}