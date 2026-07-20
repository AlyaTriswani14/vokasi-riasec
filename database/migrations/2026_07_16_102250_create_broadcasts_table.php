<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('broadcasts', function (Blueprint $table) {
            $table->id();
            $table->string('subjek');
            $table->text('isi');
            $table->string('target_penerima'); // siswa | guru_bk | semua
            $table->string('target_jenjang');  // smp | smk | semua
            $table->timestamps();
        });

        // Pivot untuk menandai broadcast mana yang sudah dibaca tiap user
        Schema::create('broadcast_reads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('broadcast_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->unique(['broadcast_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('broadcast_reads');
        Schema::dropIfExists('broadcasts');
    }
};