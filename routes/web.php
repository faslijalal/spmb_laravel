<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SiswaController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Halaman Utama
Route::get('/', [PageController::class, 'beranda'])->name('beranda');
Route::get('/pengumuman', [PageController::class, 'pengumuman'])->name('pengumuman');

// Login / Registrasi
Route::middleware('guest')->group(function () {
    Route::get('/masuk', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/masuk', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register'])->middleware('throttle:10,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');

    // Arahkan sesuai peran: Admin atau Calon siswa / Orang tua
    Route::get('/dashboard', function () {
        return redirect()->route(Auth::user()->isAdmin() ? 'admin.dashboard' : 'siswa.dashboard');
    })->name('dashboard');

    Route::get('/berkas/{berkas}', [BerkasController::class, 'tampil'])->name('berkas.tampil');

    // Calon siswa / Orang tua
    Route::prefix('siswa')->name('siswa.')->middleware(RoleMiddleware::class . ':siswa')->group(function () {
        Route::get('/', [SiswaController::class, 'dashboard'])->name('dashboard');
        Route::post('/daftar', [SiswaController::class, 'daftar'])->name('daftar');
        Route::get('/formulir', [SiswaController::class, 'formulir'])->name('formulir');
        Route::post('/formulir', [SiswaController::class, 'simpanFormulir'])->name('formulir.simpan');
        Route::get('/berkas', [SiswaController::class, 'berkas'])->name('berkas');
        Route::post('/berkas', [SiswaController::class, 'simpanBerkas'])->name('berkas.simpan');
        Route::post('/berkas/kirim', [SiswaController::class, 'kirimBerkas'])->name('berkas.kirim');
        Route::get('/hasil', [SiswaController::class, 'hasil'])->name('hasil');
    });

    // Admin
    Route::prefix('admin')->name('admin.')->middleware(RoleMiddleware::class . ':admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/pendaftar', [AdminController::class, 'index'])->name('pendaftar.index');
        Route::get('/pendaftar/{pendaftaran}', [AdminController::class, 'show'])->name('pendaftar.show');
        Route::post('/pendaftar/{pendaftaran}/terima', [AdminController::class, 'terima'])->name('pendaftar.terima');
        Route::post('/pendaftar/{pendaftaran}/bermasalah', [AdminController::class, 'bermasalah'])->name('pendaftar.bermasalah');
        Route::post('/pengumuman/toggle', [AdminController::class, 'togglePengumuman'])->name('pengumuman.toggle');
    });
});
