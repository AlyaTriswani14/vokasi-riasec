<?php

namespace App\Http\Controllers\Kemendikdasmen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KemendikdasmenManagementController extends Controller
{
    /**
     * Modul 1: User Management (Daftar Instansi, Sekolah & Guru)
     */
    public function userManagement()
    {
        $instansiList = [
            ['nama' => 'SMKN 1 Balige', 'npsn' => '10203456', 'wilayah' => 'Toba, Sumatera Utara', 'role' => 'Admin SMK', 'guru' => 'Leni Siregar, S.Pd', 'status' => 'Aktif'],
            ['nama' => 'SMP Negeri 1 Laguboti', 'npsn' => '10209876', 'wilayah' => 'Toba, Sumatera Utara', 'role' => 'Guru BK SMP', 'guru' => 'Samuel Sitorus, S.Psi', 'status' => 'Aktif'],
            ['nama' => 'SMKN 2 Medan', 'npsn' => '10201122', 'wilayah' => 'Kota Medan, Sumatera Utara', 'role' => 'Admin SMK', 'guru' => 'Ahmad Hidayat, S.T', 'status' => 'Aktif'],
            ['nama' => 'SMP Kristen Jakarta Pusat', 'npsn' => '20104455', 'wilayah' => 'DKI Jakarta', 'role' => 'Guru BK SMP', 'guru' => 'Diana Putri, M.Pd', 'status' => 'Aktif'],
            ['nama' => 'SMK Bina Dirgantara', 'npsn' => '60702211', 'wilayah' => 'Bandung, Jawa Barat', 'role' => 'Admin SMK', 'guru' => 'Rian Prabowo, S.Kom', 'status' => 'Non-Aktif'],
        ];

        return view('Kemendikdasmen.user-management', compact('instansiList'));
    }

    /**
     * Modul 2: Questions (Bank Soal RIASEC)
     */
    public function questions()
    {
        $soalList = [
            ['id' => 1, 'pernyataan' => 'Saya suka merakit, memperbaiki, atau memodifikasi komponen perangkat keras komputer.', 'aspek' => 'R', 'tipe' => 'Realistic', 'status' => 'Aktif'],
            ['id' => 2, 'pernyataan' => 'Saya senang menganalisis data statistik dan memecahkan teka-teki logika pemrograman.', 'aspek' => 'I', 'tipe' => 'Investigative', 'status' => 'Aktif'],
            ['id' => 3, 'pernyataan' => 'Saya tertarik mendesain antarmuka aplikasi (UI/UX) agar terlihat estetik dan ramah pengguna.', 'aspek' => 'A', 'tipe' => 'Artistic', 'status' => 'Aktif'],
            ['id' => 4, 'pernyataan' => 'Saya merasa puas ketika bisa membimbing orang lain menemukan solusi atas masalah mereka.', 'aspek' => 'S', 'tipe' => 'Social', 'status' => 'Aktif'],
            ['id' => 5, 'pernyataan' => 'Saya suka memimpin tim proyek, melakukan presentasi bisnis, dan meyakinkan investor.', 'aspek' => 'E', 'tipe' => 'Enterprising', 'status' => 'Aktif'],
            ['id' => 6, 'pernyataan' => 'Saya menyukai pekerjaan yang terstruktur, mengelola arsip basis data, dan menyusun laporan keuangan.', 'aspek' => 'C', 'tipe' => 'Conventional', 'status' => 'Aktif'],
        ];

        return view('Kemendikdasmen.questions', compact('soalList'));
    }

    /**
     * Modul 3: System Settings (Pengaturan Kuota Nasional)
     */
    public function settings()
    {
        $settings = [
            'target_kuota_nasional' => 600000,
            'tahun_ajaran' => '2026/2027',
            'status_sistem' => 'Maintenance Mode Off',
            'durasi_tes_menit' => 45,
        ];

        return view('Kemendikdasmen.settings', compact('settings'));
    }

    /**
     * Modul 4: Broadcast Center (Pengumuman Massal)
     */
    public function broadcast()
    {
        $historyBroadcast = [
            ['subjek' => 'Pembukaan Sinkronisasi Sistem Vokasi RIASEC 2026', 'target' => 'Semua Sekolah (SMP & SMK)', 'tanggal' => '20 Juni 2026', 'status' => 'Terkirim'],
            ['subjek' => 'Panduan Pengisian Fasilitas Unggulan bagi Admin SMK', 'target' => 'Khusus Admin SMK', 'tanggal' => '15 Mei 2026', 'status' => 'Terkirim'],
            ['subjek' => 'Pelatihan Evaluasi Minat Bakat Menggunakan RIASEC Apps', 'target' => 'Khusus Guru BK SMP', 'tanggal' => '02 April 2026', 'status' => 'Arsip'],
        ];

        return view('Kemendikdasmen.broadcast', compact('historyBroadcast'));
    }
}