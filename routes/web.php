<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\Auth\KemendikdasmenAuthController;
use App\Http\Controllers\Kemendikdasmen\KemendikdasmenManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruBkAuthController;
use App\Http\Controllers\GuruBkController;
use App\Http\Controllers\WilayahController;

/*
|--------------------------------------------------------------------------
| Web Routes - Ekosistem Vokasi RIASEC
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing');
});

Route::get('/pilih-admin', function () {
    return view('pilih-admin');
})->name('pilih.admin');

Route::get('/mulai', function () {
    return view('welcome-jenjang');
})->name('mulai');

Route::get('/pilih-jenjang/{jenjang}', function (string $jenjang) {
    abort_unless(in_array($jenjang, ['smp', 'smk']), 404);
    session(['jenjang' => $jenjang]);
    return redirect()->route('login')->withCookie(cookie('jenjang', $jenjang, 30));
})->name('jenjang.pilih');

// ==========================================
// KELOMPOK RUTE SISWA (SMP & SMK) & GURU
// ==========================================

Route::prefix('api/wilayah')->name('wilayah.')->group(function () {
    Route::get('/provinsi', [WilayahController::class, 'provinsi'])->name('provinsi');
    Route::get('/kabupaten-kota/{kodeProvinsi}', [WilayahController::class, 'kabupatenKota'])->name('kabupaten-kota');
    Route::get('/kecamatan/{kodeKabupatenKota}', [WilayahController::class, 'kecamatan'])->name('kecamatan');
    Route::get('/kelurahan/{kodeKecamatan}', [WilayahController::class, 'kelurahan'])->name('kelurahan');
});

Route::get('/register', function () {
    return view('auth.login');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register-guru', function () {
    return view('auth.register-guru');
})->name('register.guru');

Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('google.redirect');

Route::get('/auth/google/callback', function (\Illuminate\Http\Request $request) {
    $googleUser = Socialite::driver('google')->stateless()->user();

    \Illuminate\Support\Facades\Log::info('DEBUG jenjang callback', [
        'session_jenjang' => session('jenjang'),
        'cookie_jenjang' => $request->cookie('jenjang'),
        'all_cookies' => $request->cookies->all(),
    ]);

    $jenjang = session('jenjang', $request->cookie('jenjang', 'smp'));
    abort_unless(in_array($jenjang, ['smp', 'smk']), 404);

    $user = User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        $user = User::create([
            'name' => $googleUser->getName() ?: ($googleUser->getNickname() ?: 'Siswa'),
            'email' => $googleUser->getEmail(),
            'password' => Hash::make(Str::random(32)),
            'jenjang' => $jenjang,
            'role' => 'siswa',
        ]);
    } elseif (empty($user->jenjang)) {
        // Jaga-jaga untuk akun lama yang belum pernah punya jenjang tersimpan.
        $user->update(['jenjang' => $jenjang]);
    }

    Auth::login($user);
    $request->session()->regenerate();

    if (empty($user->nisn) || empty($user->asal_sekolah)) {
        return redirect()->route('lengkapi-profil');
    }

    return redirect()->route('dashboard');
})->name('google.callback');

Route::get('/lengkapi-profil', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return view('auth.lengkapi-profil');
})->name('lengkapi-profil');

Route::post('/lengkapi-profil', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'nisn' => 'required|string|size:10|unique:users,nisn,' . Auth::id(),
        'asal_sekolah' => 'required|string|max:255',
        'kelas' => 'required|string',
        'provinsi' => 'required|string|max:255',
        'kabupaten_kota' => 'required|string|max:255',
        'kecamatan' => 'required|string|max:255',
        'kelurahan' => 'required|string|max:255',
    ], [
        'name.required' => 'Nama lengkap wajib diisi.',
        'nisn.required' => 'NISN wajib diisi.',
        'nisn.size' => 'NISN harus berisi tepat 10 digit nomor.',
        'nisn.unique' => 'NISN sudah terdaftar oleh akun lain.',
        'asal_sekolah.required' => 'Asal sekolah wajib diisi.',
        'kelas.required' => 'Kelas wajib dipilih.',
        'provinsi.required' => 'Provinsi domisili wajib dipilih.',
        'kabupaten_kota.required' => 'Kabupaten/kota domisili wajib dipilih.',
        'kecamatan.required' => 'Kecamatan domisili wajib dipilih.',
        'kelurahan.required' => 'Kelurahan/desa domisili wajib dipilih.',
    ]);

    Auth::user()->update($validated);

    return redirect()->route('dashboard')->with('success', 'Profil lengkap! Yuk mulai eksplorasi minatmu.');
})->name('lengkapi-profil.submit');

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// CATATAN: Middleware ['auth'] dimatikan SEMENTARA. Menggunakan array kosong [] agar tidak error.
Route::group([], function () {

    Route::get('/eksplorasi', function () {
        $user = \Illuminate\Support\Facades\Auth::user();
        $hasilTes = \App\Models\RiasecResult::where('user_id', $user->id)->latest()->first();
        return view('siswa.eksplorasi', compact('hasilTes'));
    })->name('eksplorasi.index');

    Route::get('/rekomendasi', function () {
        $user = \Illuminate\Support\Facades\Auth::user();
        $hasilTes = \App\Models\RiasecResult::where('user_id', $user->id)->latest()->first();
        $sekolahTerdekat = (new \App\Services\SekolahTerdekatService())->untukSiswa($user);
        return view('siswa.rekomendasi', compact('hasilTes', 'user', 'sekolahTerdekat'));
    })->name('rekomendasi.index');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/jurusan/{slug}', function (string $slug) {
        return view('siswa.jurusan-detail', ['slug' => $slug]);
    })->name('jurusan.detail');

    Route::get('/profil', [DashboardController::class, 'profil'])->name('profil');

    Route::post('/profil/update', function (\Illuminate\Http\Request $request) {
        $user = \Illuminate\Support\Facades\Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|size:10|unique:users,nisn,' . $user->id,
            'asal_sekolah' => 'required|string|max:255',
            'kelas' => 'required|string',
            'provinsi' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'nisn' => $request->nisn,
            'asal_sekolah' => $request->asal_sekolah,
            'kelas' => $request->kelas,
            'provinsi' => $request->provinsi,
            'kabupaten_kota' => $request->kabupaten_kota,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
        ]);

        return redirect()->route('profil')->with('success', 'Data diri berhasil diperbarui.');
    })->name('profil.update');

    Route::prefix('assessment')->name('assessment.')->group(function () {
        Route::get('/', [AssessmentController::class, 'index'])->name('index');
        Route::post('/start', [AssessmentController::class, 'start'])->name('start');
        Route::get('/questions', [AssessmentController::class, 'questions'])->name('questions');
        Route::post('/submit', [AssessmentController::class, 'submit'])->name('submit');
        Route::get('/result', [AssessmentController::class, 'result'])->name('result');
        Route::post('/reset', [AssessmentController::class, 'reset'])->name('reset');
    });
});

Route::prefix('guru-bk')->name('guru-bk.')->group(function () {
    Route::get('/daftar', [GuruBkAuthController::class, 'showRegister'])->name('daftar');
    Route::post('/daftar', [GuruBkAuthController::class, 'register'])->name('daftar.submit');
    Route::get('/login', [GuruBkAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [GuruBkAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [GuruBkAuthController::class, 'logout'])->name('logout');
    Route::get('/panel', [GuruBkController::class, 'index'])->name('panel');
    Route::get('/siswa/{id}', [GuruBkController::class, 'detail'])->name('siswa.detail');
    Route::get('/export', [GuruBkController::class, 'export'])->name('export');
});

// ==========================================
// KELOMPOK RUTE ADMIN PUSAT KEMENDIKDASMEN
// ==========================================
Route::prefix('kemendikdasmen')->group(function () {

    Route::get('/login', [KemendikdasmenAuthController::class, 'showLogin'])->name('kemendikdasmen.login');
    Route::post('/login', [KemendikdasmenAuthController::class, 'login']);
    Route::post('/logout', [KemendikdasmenAuthController::class, 'logout'])->name('kemendikdasmen.logout');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [KemendikdasmenAuthController::class, 'dashboard'])->name('kemendikdasmen.dashboard');
        Route::get('/users', [KemendikdasmenManagementController::class, 'userManagement'])->name('kemendikdasmen.users');
        Route::post('/users', [KemendikdasmenManagementController::class, 'storeSekolah'])->name('kemendikdasmen.users.store');
        Route::delete('/users/{id}', [KemendikdasmenManagementController::class, 'destroySekolah'])->name('kemendikdasmen.users.destroy');
        Route::get('/questions', [KemendikdasmenManagementController::class, 'questions'])->name('kemendikdasmen.questions');
        Route::post('/questions', [KemendikdasmenManagementController::class, 'storeSoal'])->name('kemendikdasmen.questions.store');
        Route::get('/questions/{id}/edit', [KemendikdasmenManagementController::class, 'editSoal'])->name('kemendikdasmen.questions.edit');
        Route::put('/questions/{id}', [KemendikdasmenManagementController::class, 'updateSoal'])->name('kemendikdasmen.questions.update');
        Route::delete('/questions/{id}', [KemendikdasmenManagementController::class, 'destroySoal'])->name('kemendikdasmen.questions.destroy');
        Route::post('/questions/import', [KemendikdasmenManagementController::class, 'importCsv'])->name('kemendikdasmen.questions.import');
        Route::get('/settings', [KemendikdasmenManagementController::class, 'settings'])->name('kemendikdasmen.settings');
        Route::post('/settings', [KemendikdasmenManagementController::class, 'updateSettings'])->name('kemendikdasmen.settings.update');
        Route::get('/broadcast', [KemendikdasmenManagementController::class, 'broadcast'])->name('kemendikdasmen.broadcast');
        Route::post('/broadcast', [KemendikdasmenManagementController::class, 'storeBroadcast'])->name('kemendikdasmen.broadcast.store');
        Route::delete('/broadcast/{id}', [KemendikdasmenManagementController::class, 'destroyBroadcast'])->name('kemendikdasmen.broadcast.destroy');
    });
});