<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel referensi wilayah administratif Indonesia (provinsi, kabupaten/kota,
     * kecamatan, kelurahan/desa) untuk dropdown domisili berjenjang saat registrasi.
     *
     * Sumber: Kepmendagri No 300.2.2-2430 Tahun 2025 (github.com/cahyadsn/wilayah).
     *
     * Struktur kode mengikuti hierarki resmi Kemendagri, dipisah titik:
     *   - level 1 (provinsi)        contoh: 11
     *   - level 2 (kabupaten/kota)  contoh: 11.01
     *   - level 3 (kecamatan)       contoh: 11.01.01
     *   - level 4 (kelurahan/desa)  contoh: 11.01.01.2001
     *
     * `induk` menyimpan kode level di atasnya supaya query berjenjang
     * (WHERE induk = ?) cukup pakai satu indeks tanpa parsing string kode.
     */
    public function up(): void
    {
        Schema::create('wilayah', function (Blueprint $table) {
            $table->string('kode', 20)->primary();
            $table->string('nama', 100);
            $table->unsignedTinyInteger('level'); // 1=provinsi, 2=kab/kota, 3=kecamatan, 4=kelurahan
            $table->string('induk', 20)->nullable(); // kode level di atasnya, null utk provinsi

            $table->index(['induk', 'level'], 'idx_wilayah_induk_level');
            $table->index('level', 'idx_wilayah_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wilayah');
    }
};