<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiasecResult; // Pastikan Model ini sudah ada
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $hasilTes = \App\Models\RiasecResult::where('user_id', \Illuminate\Support\Facades\Auth::id())->latest()->first();

        return view('siswa.dashboard', compact('hasilTes'));
    }
}