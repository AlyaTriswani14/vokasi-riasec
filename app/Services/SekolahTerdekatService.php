<?php

namespace App\Services;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Support\Collection;

class SekolahTerdekatService
{
    /**
     * Jumlah minimum hasil yang diinginkan sebelum melebarkan pencarian
     * ke tingkat wilayah yang lebih luas.
     */
    private const MIN_HASIL = 3;

    /**
     * Jumlah maksimum SMK yang ditampilkan ke siswa.
     */
    private const MAX_HASIL = 5;

    /**
     * Cari SMK terdekat dari domisili siswa dengan fallback bertingkat:
     * kelurahan -> kecamatan -> kabupaten/kota -> provinsi.
     *
     * Setiap SMK yang dikembalikan menyertakan info 'tingkat_kecocokan'
     * supaya tampilan bisa menjelaskan seberapa dekat kecocokannya
     * (mis. "Sekelurahan", "Sekecamatan", "Sekabupaten/kota", "Seprovinsi").
     *
     * @return Collection<int, array{sekolah: Sekolah, tingkat_kecocokan: string}>
     */
    public function untukSiswa(User $siswa): Collection
    {
        if (empty($siswa->provinsi)) {
            return collect();
        }

        $hasil = collect();
        $npsnTerpakai = [];

        $tahapan = [
            [
                'syarat' => !empty($siswa->kelurahan) && !empty($siswa->kecamatan) && !empty($siswa->kabupaten_kota),
                'label' => 'Sekelurahan',
                'query' => fn ($q) => $q
                    ->where('kelurahan', $siswa->kelurahan)
                    ->where('kecamatan', $siswa->kecamatan)
                    ->where('kabupaten_kota', $siswa->kabupaten_kota)
                    ->where('provinsi', $siswa->provinsi),
            ],
            [
                'syarat' => !empty($siswa->kecamatan) && !empty($siswa->kabupaten_kota),
                'label' => 'Sekecamatan',
                'query' => fn ($q) => $q
                    ->where('kecamatan', $siswa->kecamatan)
                    ->where('kabupaten_kota', $siswa->kabupaten_kota)
                    ->where('provinsi', $siswa->provinsi),
            ],
            [
                'syarat' => !empty($siswa->kabupaten_kota),
                'label' => 'Sekabupaten/Kota',
                'query' => fn ($q) => $q
                    ->where('kabupaten_kota', $siswa->kabupaten_kota)
                    ->where('provinsi', $siswa->provinsi),
            ],
            [
                'syarat' => true,
                'label' => 'Seprovinsi',
                'query' => fn ($q) => $q->where('provinsi', $siswa->provinsi),
            ],
        ];

        foreach ($tahapan as $tahap) {
            if ($hasil->count() >= self::MAX_HASIL) {
                break;
            }
            if (!$tahap['syarat']) {
                continue;
            }

            $sisaKuota = self::MAX_HASIL - $hasil->count();

            $query = Sekolah::query();
            ($tahap['query'])($query);

            if (!empty($npsnTerpakai)) {
                $query->whereNotIn('npsn', $npsnTerpakai);
            }

            $sekolahDitemukan = $query->orderBy('nama_sekolah')->limit($sisaKuota)->get();

            foreach ($sekolahDitemukan as $sekolah) {
                $hasil->push([
                    'sekolah' => $sekolah,
                    'tingkat_kecocokan' => $tahap['label'],
                ]);
                $npsnTerpakai[] = $sekolah->npsn;
            }

            // Kalau tahap ini sudah mencukupi jumlah minimum, tidak perlu melebar lagi.
            if ($hasil->count() >= self::MIN_HASIL) {
                break;
            }
        }

        return $hasil;
    }
}