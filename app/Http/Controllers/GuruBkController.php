<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\RiasecResult;

class GuruBkController extends Controller
{
    private function tipeDominan(?RiasecResult $hasil): ?string
    {
        if (!$hasil) {
            return null;
        }
        $skor = [
            'R' => $hasil->skor_r, 'I' => $hasil->skor_i, 'A' => $hasil->skor_a,
            'S' => $hasil->skor_s, 'E' => $hasil->skor_e, 'C' => $hasil->skor_c,
        ];
        arsort($skor);
        return array_key_first($skor);
    }

    private function guardGuruBk()
    {
        if (!Auth::check() || Auth::user()->role !== 'guru_bk') {
            return redirect()->route('guru-bk.login');
        }
        return null;
    }

    public function index(Request $request)
    {
        if ($redirect = $this->guardGuruBk()) {
            return $redirect;
        }

        $guru = Auth::user();

        $allSiswa = User::where('role', 'siswa')
            ->where('asal_sekolah', $guru->nama_sekolah)
            ->get()
            ->map(function ($siswa) {
                $hasil = RiasecResult::where('user_id', $siswa->id)->latest()->first();
                $siswa->hasil_tes = $hasil;
                $siswa->tipe_dominan = $this->tipeDominan($hasil);
                return $siswa;
            });

        $totalSiswa = $allSiswa->count();
        $sudahTes = $allSiswa->filter(fn ($s) => $s->hasil_tes !== null)->count();
        $belumTes = $totalSiswa - $sudahTes;

        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status', '');

        $siswaList = $allSiswa;

        if ($search !== '') {
            $siswaList = $siswaList->filter(
                fn ($s) => str_contains(strtolower($s->name), strtolower($search))
            );
        }

        if ($status === 'sudah') {
            $siswaList = $siswaList->filter(fn ($s) => $s->hasil_tes !== null);
        } elseif ($status === 'belum') {
            $siswaList = $siswaList->filter(fn ($s) => $s->hasil_tes === null);
        }

        return view('guru-bk.panel', compact(
            'guru', 'siswaList', 'totalSiswa', 'sudahTes', 'belumTes', 'search', 'status'
        ));
    }

    public function detail($id)
    {
        if ($redirect = $this->guardGuruBk()) {
            return $redirect;
        }

        $guru = Auth::user();

        // findOrFail dengan filter asal_sekolah sekaligus jadi pengaman:
        // guru BK cuma bisa lihat detail siswa dari sekolahnya sendiri.
        $siswa = User::where('role', 'siswa')
            ->where('asal_sekolah', $guru->nama_sekolah)
            ->findOrFail($id);

        $hasil = RiasecResult::where('user_id', $siswa->id)->latest()->first();

        $persenArr = [];
        if ($hasil) {
            $skorArr = [
                'R' => $hasil->skor_r, 'I' => $hasil->skor_i, 'A' => $hasil->skor_a,
                'S' => $hasil->skor_s, 'E' => $hasil->skor_e, 'C' => $hasil->skor_c,
            ];
            foreach ($skorArr as $kode => $skor) {
                $persenArr[$kode] = round(($skor / 7) * 100);
            }
        }

        return view('guru-bk.siswa-detail', compact('guru', 'siswa', 'hasil', 'persenArr'));
    }

    public function export()
    {
        if ($redirect = $this->guardGuruBk()) {
            return $redirect;
        }

        $guru = Auth::user();
        $siswaList = User::where('role', 'siswa')
            ->where('asal_sekolah', $guru->nama_sekolah)
            ->get();

        $filename = 'siswa-bina-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($siswaList) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama', 'Kelas', 'NISN', 'Email', 'Status Tes', 'Tanggal Tes', 'Tipe Dominan']);

            foreach ($siswaList as $siswa) {
                $hasil = RiasecResult::where('user_id', $siswa->id)->latest()->first();
                $dominan = $this->tipeDominan($hasil) ?? '-';
                fputcsv($file, [
                    $siswa->name,
                    $siswa->kelas ?? '-',
                    $siswa->nisn ?? '-',
                    $siswa->email,
                    $hasil ? 'Selesai' : 'Belum Tes',
                    $hasil ? $hasil->created_at->format('d-m-Y') : '-',
                    $dominan,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}