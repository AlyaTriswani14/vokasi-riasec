<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GuruBkAuthController extends Controller
{
    public function showRegister()
    {
        return view('guru-bk.daftar');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => 'required|string|max:20|unique:users,npsn',
            'jenjang' => 'required|in:smp,smk',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'npsn.unique' => 'NPSN ini sudah terdaftar. Setiap sekolah hanya bisa memiliki 1 akun Guru BK.',
            'jenjang.required' => 'Jenjang sekolah wajib dipilih.',
            'email.unique' => 'Email ini sudah terdaftar.',
        ]);

        // CATATAN: password TIDAK di-Hash::make() manual di sini,
        // karena User model sudah punya cast 'password' => 'hashed'
        // yang otomatis meng-hash saat disimpan. Kalau di-hash manual
        // juga, passwordnya jadi ke-hash dua kali dan login akan gagal.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'guru_bk',
            'nama_sekolah' => $request->nama_sekolah,
            'npsn' => $request->npsn,
            'jenjang' => $request->jenjang,
        ]);

        Auth::login($user);

        return redirect()->route('guru-bk.panel');
    }

    public function showLogin()
    {
        return view('guru-bk.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'guru_bk',
        ])) {
            $request->session()->regenerate();
            return redirect()->route('guru-bk.panel');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('guru-bk.login');
    }
}