<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoalRiasec extends Model
{
    protected $table = 'soal_riasecs';

    protected $fillable = ['pernyataan', 'aspek', 'urutan', 'status'];
}