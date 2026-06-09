<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\Auth\RegisterController;
// Nanti uncomment ini kalau kamu sudah buat LoginController
// use App\Http\Controllers\Auth\LoginController;

// Redirect root ke halaman register
Route::get('/', function () {
    return redirect()->route('register');
});

// Authentication Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', function () {
    return view('auth.login'); 
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    return "Proses login untuk: " . $request->email . " akan dikerjakan di sini.";
});

// Halaman Utama Siswa
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Halaman Detail Jurusan
Route::get('/jurusan/tkj', function () {
    return view('detail');
})->name('jurusan.tkj');

// Halaman Eksplor Sekolah
Route::get('/sekolah/eksplor', function () {
    return view('sekolah.explore');
})->name('sekolah.explore');

// Halaman Profil Siswa
Route::get('/profil', function () {
    return view('profil');
})->name('profil');

// Assessment Routes
Route::prefix('assessment')->name('assessment.')->group(function () {
    Route::get('/', [AssessmentController::class, 'index'])->name('index');
    Route::post('/start', [AssessmentController::class, 'start'])->name('start');
    Route::get('/questions', [AssessmentController::class, 'questions'])->name('questions');
    Route::post('/submit', [AssessmentController::class, 'submit'])->name('submit');
    Route::get('/result', [AssessmentController::class, 'result'])->name('result');
    Route::get('/scoring', [AssessmentController::class, 'scoring'])->name('scoring'); 
    Route::post('/reset', [AssessmentController::class, 'reset'])->name('reset');
});