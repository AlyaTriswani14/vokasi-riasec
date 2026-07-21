<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel referensi daftar SMK se-Indonesia, dipakai untuk fitur
     * "SMK Terdekat" pada halaman rekomendasi siswa SMP.
     * Sumber data: Dapodik (diolah dari file daftar_SMK_di_Indonesia.xlsx).
     */
    public function up(): void
    {
        Schema::create('sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('npsn', 20)->unique();
            $table->string('nama_sekolah');
            $table->string('provinsi');
            $table->string('kabupaten_kota');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('alamat')->nullable();
            $table->timestamps();

            // Indeks untuk pencarian bertingkat (kelurahan -> kecamatan -> kab/kota -> provinsi)
            $table->index(['provinsi', 'kabupaten_kota', 'kecamatan', 'kelurahan'], 'idx_sekolah_wilayah');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sekolah');
    }
};