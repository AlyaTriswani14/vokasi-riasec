<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('riasec_results', function (Blueprint $table) {
            $table->integer('skor_s')->nullable();
            $table->integer('skor_e')->nullable();
            $table->integer('skor_c')->nullable();
        });
    }

    public function down()
    {
        Schema::table('riasec_results', function (Blueprint $table) {
            $table->dropColumn(['skor_s', 'skor_e', 'skor_c']);
        });
    }
};
