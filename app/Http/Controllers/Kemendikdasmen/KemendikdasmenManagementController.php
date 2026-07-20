<?php

namespace App\Http\Controllers\Kemendikdasmen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SoalRiasec;
use App\Models\Pengaturan;
use App\Models\Broadcast;

class KemendikdasmenManagementController extends Controller
{
    /**
     * Modul 1: User Management (Daftar Sekolah & Guru BK terdaftar)
     * Sekarang diambil dari data akun Guru BK asli, dengan search, filter jenjang,
     * dan pagination (25/50/100 per halaman).
     */
    public function userManagement(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $jenjang = $request->query('jenjang', '');
        $perPage = (int) $request->query('per_page', 25);
        if (!in_array($perPage, [25, 50, 100])) {
            $perPage = 25;
        }

        $query = User::where('role', 'guru_bk');

        if ($jenjang === 'smp' || $jenjang === 'smk') {
            $query->where('jenjang', $jenjang);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                  ->orWhere('npsn', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $instansiPaginated = $query->orderBy('nama_sekolah')->paginate($perPage)->withQueryString();

        $instansiPaginated->getCollection()->transform(function ($guru) {
            $guru->jumlah_siswa = User::where('role', 'siswa')
                ->where('asal_sekolah', $guru->nama_sekolah)
                ->count();
            return $guru;
        });

        return view('Kemendikdasmen.user-management', compact('instansiPaginated', 'search', 'jenjang', 'perPage'));
    }

    /**
     * Tambah sekolah (akun Guru BK) baru secara manual oleh Admin Direktorat SMK.
     */
    public function storeSekolah(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => 'required|string|max:20|unique:users,npsn',
            'jenjang' => 'required|in:smp,smk',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ], [
            'npsn.unique' => 'NPSN ini sudah terdaftar.',
            'email.unique' => 'Email ini sudah terdaftar.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'guru_bk',
            'nama_sekolah' => $request->nama_sekolah,
            'npsn' => $request->npsn,
            'jenjang' => $request->jenjang,
        ]);

        return redirect()->route('kemendikdasmen.users')->with('success', 'Sekolah berhasil ditambahkan.');
    }

    /**
     * Hapus akun sekolah (Guru BK). Data siswa yang sudah terdaftar di sekolah
     * tersebut TIDAK ikut terhapus, hanya akun Guru BK-nya saja.
     */
    public function destroySekolah($id)
    {
        $guru = User::where('role', 'guru_bk')->findOrFail($id);
        $guru->delete();

        return redirect()->route('kemendikdasmen.users')->with('success', 'Akun sekolah berhasil dihapus.');
    }

    /**
     * Modul 2: Questions (Bank Soal RIASEC)
     * Sekarang diambil dari tabel soal_riasecs (bukan array contoh lagi),
     * dengan search, filter aspek, dan pagination (25/50/100 per halaman).
     */
    public function questions(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $aspek = $request->query('aspek', '');
        $perPage = (int) $request->query('per_page', 25);
        if (!in_array($perPage, [25, 50, 100])) {
            $perPage = 25;
        }

        $query = SoalRiasec::query();

        if (in_array($aspek, ['R', 'I', 'A', 'S', 'E', 'C'])) {
            $query->where('aspek', $aspek);
        }

        if ($search !== '') {
            $query->where('pernyataan', 'like', "%{$search}%");
        }

        $soalPaginated = $query->orderBy('urutan')->paginate($perPage)->withQueryString();

        return view('Kemendikdasmen.questions', compact('soalPaginated', 'search', 'aspek', 'perPage'));
    }

    /**
     * Tambah soal baru secara manual.
     */
    public function storeSoal(Request $request)
    {
        $request->validate([
            'pernyataan' => 'required|string|max:1000',
            'aspek' => 'required|in:R,I,A,S,E,C',
        ]);

        $urutanMax = SoalRiasec::max('urutan') ?? 0;

        SoalRiasec::create([
            'pernyataan' => $request->pernyataan,
            'aspek' => $request->aspek,
            'urutan' => $urutanMax + 1,
            'status' => 'aktif',
        ]);

        return redirect()->route('kemendikdasmen.questions')->with('success', 'Soal berhasil ditambahkan.');
    }

    /**
     * Halaman edit satu soal.
     */
    public function editSoal($id)
    {
        $soal = SoalRiasec::findOrFail($id);
        return view('Kemendikdasmen.questions-edit', compact('soal'));
    }

    /**
     * Simpan perubahan edit soal.
     */
    public function updateSoal(Request $request, $id)
    {
        $soal = SoalRiasec::findOrFail($id);

        $request->validate([
            'pernyataan' => 'required|string|max:1000',
            'aspek' => 'required|in:R,I,A,S,E,C',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $soal->update([
            'pernyataan' => $request->pernyataan,
            'aspek' => $request->aspek,
            'status' => $request->status,
        ]);

        return redirect()->route('kemendikdasmen.questions')->with('success', 'Soal berhasil diperbarui.');
    }

    /**
     * Hapus soal.
     */
    public function destroySoal($id)
    {
        $soal = SoalRiasec::findOrFail($id);
        $soal->delete();

        return redirect()->route('kemendikdasmen.questions')->with('success', 'Soal berhasil dihapus.');
    }

    /**
     * Import soal dari file CSV. Format: baris pertama header (diabaikan),
     * lalu tiap baris: pernyataan,aspek (aspek harus R/I/A/S/E/C).
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'file_csv' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $path = $request->file('file_csv')->getRealPath();
        $handle = fopen($path, 'r');

        // Lewati baris header
        fgetcsv($handle);

        $urutanMax = SoalRiasec::max('urutan') ?? 0;
        $jumlahImport = 0;
        $jumlahGagal = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 2) {
                $jumlahGagal++;
                continue;
            }

            $pernyataan = trim($row[0]);
            $aspek = strtoupper(trim($row[1]));

            if ($pernyataan === '' || !in_array($aspek, ['R', 'I', 'A', 'S', 'E', 'C'])) {
                $jumlahGagal++;
                continue;
            }

            $urutanMax++;
            SoalRiasec::create([
                'pernyataan' => $pernyataan,
                'aspek' => $aspek,
                'urutan' => $urutanMax,
                'status' => 'aktif',
            ]);
            $jumlahImport++;
        }

        fclose($handle);

        $pesan = "{$jumlahImport} soal berhasil diimpor.";
        if ($jumlahGagal > 0) {
            $pesan .= " {$jumlahGagal} baris dilewati karena format tidak valid.";
        }

        return redirect()->route('kemendikdasmen.questions')->with('success', $pesan);
    }

    /**
     * Modul 3: System Settings (Pengaturan Sistem)
     * Sekarang dibaca dari tabel pengaturans (bukan array contoh lagi),
     * dan bisa diedit lewat form.
     */
    public function settings()
    {
        $settings = [
            'durasi_tes_menit' => (int) Pengaturan::get('durasi_tes_menit', 5),
            'target_kuota_nasional' => (int) Pengaturan::get('target_kuota_nasional', 600000),
            'tahun_ajaran' => Pengaturan::get('tahun_ajaran', '2026/2027'),
            'status_sistem' => Pengaturan::get('status_sistem', 'Aktif'),
        ];

        return view('Kemendikdasmen.settings', compact('settings'));
    }

    /**
     * Simpan perubahan pengaturan sistem.
     * Perubahan durasi tes langsung berlaku ke timer siswa
     * (halaman tes membaca nilai ini setiap kali dibuka).
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'durasi_tes_menit' => 'required|integer|min:1|max:180',
            'target_kuota_nasional' => 'required|integer|min:0',
            'tahun_ajaran' => 'required|string|max:20',
            'status_sistem' => 'required|string|max:50',
        ], [
            'durasi_tes_menit.min' => 'Durasi tes minimal 1 menit.',
            'durasi_tes_menit.max' => 'Durasi tes maksimal 180 menit.',
        ]);

        Pengaturan::set('durasi_tes_menit', $request->durasi_tes_menit);
        Pengaturan::set('target_kuota_nasional', $request->target_kuota_nasional);
        Pengaturan::set('tahun_ajaran', $request->tahun_ajaran);
        Pengaturan::set('status_sistem', $request->status_sistem);

        return redirect()->route('kemendikdasmen.settings')->with('success', 'Pengaturan berhasil disimpan. Durasi tes baru langsung berlaku untuk tes berikutnya.');
    }

    /**
     * Modul 4: Broadcast Center (Pengumuman Massal)
     * Sekarang tersimpan asli di database dan benar-benar tampil ke penerima
     * (siswa & Guru BK) sesuai target penerima + target jenjang.
     */
    public function broadcast()
    {
        $historyBroadcast = Broadcast::latest()->get();

        return view('Kemendikdasmen.broadcast', compact('historyBroadcast'));
    }

    /**
     * Kirim broadcast baru.
     */
    public function storeBroadcast(Request $request)
    {
        $request->validate([
            'subjek' => 'required|string|max:255',
            'isi' => 'required|string|max:2000',
            'target_penerima' => 'required|in:siswa,guru_bk,semua',
            'target_jenjang' => 'required|in:smp,smk,semua',
        ]);

        Broadcast::create($request->only('subjek', 'isi', 'target_penerima', 'target_jenjang'));

        return redirect()->route('kemendikdasmen.broadcast')->with('success', 'Broadcast berhasil dikirim ke penerima yang dituju.');
    }

    /**
     * Hapus broadcast.
     */
    public function destroyBroadcast($id)
    {
        Broadcast::findOrFail($id)->delete();

        return redirect()->route('kemendikdasmen.broadcast')->with('success', 'Broadcast berhasil dihapus.');
    }
}