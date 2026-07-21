<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('assessment.index');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|size:10|unique:users,nisn',
            'asal_sekolah' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'jenjang' => 'nullable|in:smp,smk',
            'provinsi' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.size' => 'NISN harus berisi tepat 10 digit nomor.',
            'nisn.unique' => 'NISN sudah terdaftar.',
            'asal_sekolah.required' => 'Asal sekolah wajib diisi.',
            'asal_sekolah.max' => 'Asal sekolah maksimal 255 karakter.',
            'email.required' => 'Email aktif wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal berisi 8 karakter.',
            'password.confirmed' => 'Ulangi kata sandi tidak cocok.',
            'provinsi.required' => 'Provinsi domisili wajib dipilih.',
            'kabupaten_kota.required' => 'Kabupaten/kota domisili wajib dipilih.',
            'kecamatan.required' => 'Kecamatan domisili wajib dipilih.',
            'kelurahan.required' => 'Kelurahan/desa domisili wajib dipilih.',
        ]);

        $jenjang = $validated['jenjang'] ?? session('jenjang', 'smp');

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'nisn' => $validated['nisn'],
            'asal_sekolah' => $validated['asal_sekolah'],
            'jenjang' => $jenjang,
            'provinsi' => $validated['provinsi'],
            'kabupaten_kota' => $validated['kabupaten_kota'],
            'kecamatan' => $validated['kecamatan'],
            'kelurahan' => $validated['kelurahan'],
        ]);

        Auth::login($user);
        $request->session()->put('assessment', [
            'nama' => $user->name,
            'sekolah' => $user->asal_sekolah,
            'kelas' => '10'
        ]);
        return redirect()->route('assessment.questions')
            ->with('success', 'Akun berhasil dibuat! Silakan mulai petualanganmu.');
    }
}