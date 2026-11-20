<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\LandingController;
use App\Http\Controllers\Public\PpdbController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/berita', [LandingController::class, 'newsIndex'])->name('news.index');
Route::get('/berita/{slug}', [LandingController::class, 'newsShow'])->name('news.show');

Route::get('/ppdb/daftar', [PpdbController::class, 'create'])->name('ppdb.create');
Route::post('/ppdb/daftar', [PpdbController::class, 'store'])->name('ppdb.store');
Route::get('/ppdb/cek', [PpdbController::class, 'check'])->name('ppdb.check');
Route::get('/ppdb/bukti/{number}', [PpdbController::class, 'show'])->name('ppdb.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:10,1');
});

Route::middleware(['auth', 'active'])->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::prefix('superuser')->name('superuser.')->middleware('role:super_user')->group(base_path('routes/superuser.php'));
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(base_path('routes/admin.php'));
    Route::prefix('kepsek')->name('kepsek.')->middleware('role:kepala_sekolah')->group(base_path('routes/kepsek.php'));
    Route::prefix('guru')->name('guru.')->middleware('role:guru')->group(base_path('routes/guru.php'));
});
