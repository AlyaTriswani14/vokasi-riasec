<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    protected $table = 'broadcasts';

    protected $fillable = ['subjek', 'isi', 'target_penerima', 'target_jenjang'];

    /**
     * Query broadcast yang relevan untuk seorang user (siswa atau guru_bk),
     * dengan mempertimbangkan target penerima dan target jenjang.
     */
    public static function untukUser($user)
    {
        // Guru BK dianggap penerima 'guru_bk', selain itu 'siswa'
        $penerima = ($user->role === 'guru_bk') ? 'guru_bk' : 'siswa';
        $jenjang = $user->jenjang;

        return static::where(function ($q) use ($penerima) {
                $q->where('target_penerima', $penerima)
                  ->orWhere('target_penerima', 'semua');
            })
            ->where(function ($q) use ($jenjang) {
                $q->where('target_jenjang', $jenjang)
                  ->orWhere('target_jenjang', 'semua');
            })
            ->latest();
    }
}