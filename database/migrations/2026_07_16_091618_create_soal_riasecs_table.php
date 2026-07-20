<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soal_riasecs', function (Blueprint $table) {
            $table->id();
            $table->text('pernyataan');
            $table->string('aspek', 1); // R, I, A, S, E, C
            $table->unsignedInteger('urutan')->default(0);
            $table->string('status')->default('aktif'); // aktif / nonaktif
            $table->timestamps();
        });

        // Migrasi 42 soal yang sebelumnya hardcoded di questions-siswa.blade.php
        // + AssessmentController, dipindahkan persis tanpa perubahan teks/urutan.
        $soal = [
            ['pernyataan' => 'Saya suka mengulik peralatan', 'aspek' => 'R'],
            ['pernyataan' => 'Saya suka mengerjakan puzzle', 'aspek' => 'I'],
            ['pernyataan' => 'Saya suka bekerja mandiri', 'aspek' => 'A'],
            ['pernyataan' => 'Saya suka bekerja dalam kelompok', 'aspek' => 'S'],
            ['pernyataan' => 'Saya suka membuat target untuk diri saya sendiri', 'aspek' => 'E'],
            ['pernyataan' => 'Saya suka merapikan barang-barang (buku, alat tulis, kamar)', 'aspek' => 'C'],
            ['pernyataan' => 'Saya suka menyusun balok/LEGO', 'aspek' => 'R'],
            ['pernyataan' => 'Saya suka membaca buku tentang seni dan musik', 'aspek' => 'A'],
            ['pernyataan' => 'Saya suka mengerjakan hal-hal dengan instruksi yang jelas', 'aspek' => 'C'],
            ['pernyataan' => 'Saya suka meyakinkan teman untuk mengikuti cara saya', 'aspek' => 'E'],
            ['pernyataan' => 'Saya suka melakukan percobaan/eksperimen', 'aspek' => 'I'],
            ['pernyataan' => 'Saya suka menjelaskan sesuatu kepada teman', 'aspek' => 'S'],
            ['pernyataan' => 'Saya suka membantu orang lain memecahkan persoalan', 'aspek' => 'S'],
            ['pernyataan' => 'Saya suka memperbaiki alat-alat mekanik (sepeda, dll.)', 'aspek' => 'R'],
            ['pernyataan' => 'Saya tidak keberatan kalau bekerja melebihi waktu yang ditentukan', 'aspek' => 'C'],
            ['pernyataan' => 'Saya suka menjual sesuatu', 'aspek' => 'E'],
            ['pernyataan' => 'Saya suka membuat karya berbentuk tulisan', 'aspek' => 'A'],
            ['pernyataan' => 'Saya suka sains', 'aspek' => 'I'],
            ['pernyataan' => 'Saya suka mendapatkan tantangan baru', 'aspek' => 'E'],
            ['pernyataan' => 'Saya suka menghibur teman', 'aspek' => 'S'],
            ['pernyataan' => 'Saya suka mencari tahu cara kerja sebuah alat', 'aspek' => 'I'],
            ['pernyataan' => 'Saya suka merangkai atau merakit benda', 'aspek' => 'R'],
            ['pernyataan' => 'Saya adalah orang yang kreatif', 'aspek' => 'A'],
            ['pernyataan' => 'Saya suka memperhatikan detail', 'aspek' => 'C'],
            ['pernyataan' => 'Saya suka merapikan catatan atau LKS', 'aspek' => 'C'],
            ['pernyataan' => 'Saya suka mencari tahu penyebab suatu kejadian', 'aspek' => 'I'],
            ['pernyataan' => 'Saya suka memainkan alat musik atau bernyanyi', 'aspek' => 'A'],
            ['pernyataan' => 'Saya suka mempelajari budaya berbagai daerah', 'aspek' => 'S'],
            ['pernyataan' => 'Saya ingin membuka usaha sendiri suatu saat nanti', 'aspek' => 'E'],
            ['pernyataan' => 'Saya suka memasak', 'aspek' => 'R'],
            ['pernyataan' => 'Saya suka bermain peran atau drama', 'aspek' => 'A'],
            ['pernyataan' => 'Saya suka mempraktikkan hal-hal yang sudah dipelajari', 'aspek' => 'R'],
            ['pernyataan' => 'Saya suka mengerjakan soal matematika atau grafik', 'aspek' => 'I'],
            ['pernyataan' => 'Saya suka mendiskusikan hal-hal yang terjadi di sekitar saya', 'aspek' => 'S'],
            ['pernyataan' => 'Saya suka merapikan kamar saya', 'aspek' => 'C'],
            ['pernyataan' => 'Saya suka memimpin kelompok atau kelas', 'aspek' => 'E'],
            ['pernyataan' => 'Saya suka berkegiatan di luar ruangan', 'aspek' => 'R'],
            ['pernyataan' => 'Saya suka berkegiatan di dalam ruangan dengan meja-kursi', 'aspek' => 'C'],
            ['pernyataan' => 'Saya suka menghitung', 'aspek' => 'I'],
            ['pernyataan' => 'Saya suka menolong orang', 'aspek' => 'S'],
            ['pernyataan' => 'Saya suka menggambar', 'aspek' => 'A'],
            ['pernyataan' => 'Saya suka berbicara di depan umum', 'aspek' => 'E'],
        ];

        foreach ($soal as $i => $item) {
            DB::table('soal_riasecs')->insert([
                'pernyataan' => $item['pernyataan'],
                'aspek' => $item['aspek'],
                'urutan' => $i + 1,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('soal_riasecs');
    }
};