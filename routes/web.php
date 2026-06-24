<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\KemendikdasmenAuthController;
use App\Http\Controllers\Kemendikdasmen\KemendikdasmenManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes - Ekosistem Vokasi RIASEC
|--------------------------------------------------------------------------
*/

// Redirect root ke halaman register
Route::get('/', function () {
    return redirect()->route('register');
});

// ==========================================
// KELOMPOK RUTE SISWA (SMP & SMK)
// ==========================================
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', function () {
    return view('auth.login'); 
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    return "Proses login untuk: " . $request->email . " akan dikerjakan di sini.";
});

// Halaman-Halaman Dashboard & Informasi Siswa
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/jurusan/tkj', function () {
    return view('detail');
})->name('jurusan.tkj');

Route::get('/sekolah/eksplor', function () {
    return view('sekolah.explore');
})->name('sekolah.explore');

Route::get('/profil', function () {
    return view('profil');
})->name('profil');

// Assessment / Kuesioner RIASEC Siswa
Route::prefix('assessment')->name('assessment.')->group(function () {
    Route::get('/', [AssessmentController::class, 'index'])->name('index');
    Route::post('/start', [AssessmentController::class, 'start'])->name('start');
    Route::get('/questions', [AssessmentController::class, 'questions'])->name('questions');
    Route::post('/submit', [AssessmentController::class, 'submit'])->name('submit');
    Route::get('/result', [AssessmentController::class, 'result'])->name('result');
    Route::get('/scoring', [AssessmentController::class, 'scoring'])->name('scoring'); 
    Route::post('/reset', [AssessmentController::class, 'reset'])->name('reset');
});


// ==========================================
// KELOMPOK RUTE ADMIN PUSAT KEMENDIKDASMEN
// ==========================================
Route::prefix('kemendikdasmen')->group(function () {
    
    // Pintu Masuk Otentikasi (Satu Jalur Resmi)
    Route::get('/login', [KemendikdasmenAuthController::class, 'showLogin'])->name('kemendikdasmen.login');
    Route::post('/login', [KemendikdasmenAuthController::class, 'login']);
    Route::post('/logout', [KemendikdasmenAuthController::class, 'logout'])->name('kemendikdasmen.logout');

    // Area Proteksi Dashboard & Manajemen (Wajib Login)
    Route::middleware('auth')->group(function () {
        
        // Halaman Utama Dashboard
        Route::get('/dashboard', [KemendikdasmenAuthController::class, 'dashboard'])->name('kemendikdasmen.dashboard');
        
        // Modul 1: User & Instansi Management
        Route::get('/users', [KemendikdasmenManagementController::class, 'userManagement'])->name('kemendikdasmen.users');
        
        // Modul 2: Bank Soal & Instrumen Kuesioner RIASEC
        Route::get('/questions', [KemendikdasmenManagementController::class, 'questions'])->name('kemendikdasmen.questions');
        
        // Modul 3: Konfigurasi Parameter / Kuota Sistem
        Route::get('/settings', [KemendikdasmenManagementController::class, 'settings'])->name('kemendikdasmen.settings');
        
        // Modul 4: Broadcast Center (Notifikasi Massal)
        Route::get('/broadcast', [KemendikdasmenManagementController::class, 'broadcast'])->name('kemendikdasmen.broadcast');
    });
});