<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SekolahSeeder extends Seeder
{
    /**
     * Import daftar SMK se-Indonesia dari file CSV (sumber: Dapodik,
     * diolah dari daftar_SMK_di_Indonesia.xlsx) ke tabel `sekolah`.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/sekolah.csv');

        if (!file_exists($path)) {
            $this->command->error("File data tidak ditemukan: {$path}");
            return;
        }

        $handle = fopen($path, 'r');
        $header = fgetcsv($handle); // baris pertama = nama kolom

        $now = Carbon::now();
        $batch = [];
        $batchSize = 500;
        $total = 0;

        DB::table('sekolah')->truncate();

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) !== count($header)) {
                continue; // lewati baris rusak/kosong (mis. baris kosong di akhir file)
            }

            $data = array_combine($header, $row);

            $batch[] = [
                'npsn' => $data['npsn'],
                'nama_sekolah' => $data['nama_sekolah'],
                'provinsi' => $data['provinsi'],
                'kabupaten_kota' => $data['kabupaten_kota'],
                'kecamatan' => $data['kecamatan'],
                'kelurahan' => $data['kelurahan'],
                'alamat' => $data['alamat'] !== '' ? $data['alamat'] : null,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (count($batch) >= $batchSize) {
                DB::table('sekolah')->insert($batch);
                $total += count($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            DB::table('sekolah')->insert($batch);
            $total += count($batch);
        }

        fclose($handle);

        $this->command->info("Selesai import {$total} data sekolah.");
    }
}