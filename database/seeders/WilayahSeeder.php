<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    /**
     * Import data wilayah administratif Indonesia (provinsi, kabupaten/kota,
     * kecamatan, kelurahan/desa) dari CSV ke tabel `wilayah`.
     * Sumber: Kepmendagri No 300.2.2-2430 Tahun 2025 (github.com/cahyadsn/wilayah).
     */
    public function run(): void
    {
        $path = database_path('seeders/data/wilayah.csv');

        if (!file_exists($path)) {
            $this->command->error("File data tidak ditemukan: {$path}");
            return;
        }

        $handle = fopen($path, 'r');
        $header = fgetcsv($handle);

        $batch = [];
        $batchSize = 1000;
        $total = 0;

        DB::table('wilayah')->truncate();

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) !== count($header)) {
                continue; // lewati baris rusak/kosong (mis. baris kosong di akhir file)
            }

            $data = array_combine($header, $row);

            $batch[] = [
                'kode' => $data['kode'],
                'nama' => $data['nama'],
                'level' => (int) $data['level'],
                'induk' => $data['induk'] !== '' ? $data['induk'] : null,
            ];

            if (count($batch) >= $batchSize) {
                DB::table('wilayah')->insert($batch);
                $total += count($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            DB::table('wilayah')->insert($batch);
            $total += count($batch);
        }

        fclose($handle);

        $this->command->info("Selesai import {$total} data wilayah.");
    }
}