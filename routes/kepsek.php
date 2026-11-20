<?php

use App\Http\Controllers\Kepsek\KepsekController;
use Illuminate\Support\Facades\Route;

Route::get('/', [KepsekController::class, 'dashboard'])->name('dashboard');
Route::get('laporan', [KepsekController::class, 'reports'])->name('reports');
Route::get('laporan/cetak', [KepsekController::class, 'printAttendanceReport'])->name('reports.print');
Route::get('persetujuan', [KepsekController::class, 'approvals'])->name('approvals');
Route::patch('persetujuan/{approval}', [KepsekController::class, 'decideApproval'])->name('approvals.decide');
Route::get('pengumuman', [KepsekController::class, 'announcements'])->name('announcements');
Route::post('pengumuman', [KepsekController::class, 'storeAnnouncement'])->name('announcements.store');
