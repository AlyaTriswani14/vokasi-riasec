<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan data domisili siswa (provinsi, kabupaten/kota, kecamatan,
     * kelurahan) supaya rekomendasi "SMK Terdekat" bisa dicocokkan
     * berdasarkan wilayah tempat tinggal siswa, bukan data contoh statis.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('provinsi')->nullable()->after('kelas');
            $table->string('kabupaten_kota')->nullable()->after('provinsi');
            $table->string('kecamatan')->nullable()->after('kabupaten_kota');
            $table->string('kelurahan')->nullable()->after('kecamatan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['provinsi', 'kabupaten_kota', 'kecamatan', 'kelurahan']);
        });
    }
};