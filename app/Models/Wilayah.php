<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayah';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
        'level',
        'induk',
    ];

    const LEVEL_PROVINSI = 1;
    const LEVEL_KABUPATEN_KOTA = 2;
    const LEVEL_KECAMATAN = 3;
    const LEVEL_KELURAHAN = 4;
}