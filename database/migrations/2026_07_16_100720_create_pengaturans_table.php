<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Nilai awal pengaturan sistem
        $defaults = [
            'durasi_tes_menit' => '5',
            'target_kuota_nasional' => '600000',
            'tahun_ajaran' => '2026/2027',
            'status_sistem' => 'Aktif',
        ];

        foreach ($defaults as $key => $value) {
            DB::table('pengaturans')->insert([
                'key' => $key,
                'value' => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};