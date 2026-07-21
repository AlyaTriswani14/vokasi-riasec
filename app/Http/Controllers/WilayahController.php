<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\JsonResponse;

class WilayahController extends Controller
{
    /**
     * Daftar provinsi (level 1). Dipakai untuk mengisi dropdown pertama.
     */
    public function provinsi(): JsonResponse
    {
        $data = Wilayah::where('level', Wilayah::LEVEL_PROVINSI)
            ->orderBy('nama')
            ->get(['kode', 'nama']);

        return response()->json($data);
    }

    /**
     * Daftar kabupaten/kota (level 2) di bawah provinsi tertentu.
     */
    public function kabupatenKota(string $kodeProvinsi): JsonResponse
    {
        $data = Wilayah::where('level', Wilayah::LEVEL_KABUPATEN_KOTA)
            ->where('induk', $kodeProvinsi)
            ->orderBy('nama')
            ->get(['kode', 'nama']);

        return response()->json($data);
    }

    /**
     * Daftar kecamatan (level 3) di bawah kabupaten/kota tertentu.
     */
    public function kecamatan(string $kodeKabupatenKota): JsonResponse
    {
        $data = Wilayah::where('level', Wilayah::LEVEL_KECAMATAN)
            ->where('induk', $kodeKabupatenKota)
            ->orderBy('nama')
            ->get(['kode', 'nama']);

        return response()->json($data);
    }

    /**
     * Daftar kelurahan/desa (level 4) di bawah kecamatan tertentu.
     */
    public function kelurahan(string $kodeKecamatan): JsonResponse
    {
        $data = Wilayah::where('level', Wilayah::LEVEL_KELURAHAN)
            ->where('induk', $kodeKecamatan)
            ->orderBy('nama')
            ->get(['kode', 'nama']);

        return response()->json($data);
    }
}