<?php

use App\Http\Controllers\Guru\GuruController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GuruController::class, 'dashboard'])->name('dashboard');

Route::get('absensi', [GuruController::class, 'attendancesIndex'])->name('attendances.index');
Route::get('nilai', [GuruController::class, 'gradesIndex'])->name('grades.index');
Route::get('materi', [GuruController::class, 'materialsIndex'])->name('materials.index');
Route::get('siswa', [GuruController::class, 'studentsIndex'])->name('students.index');
Route::get('pengajuan-dokumen', [GuruController::class, 'approvalsIndex'])->name('approvals.index');
Route::post('pengajuan-dokumen', [GuruController::class, 'storeApproval'])->name('approvals.store');

Route::get('kelas/{assignment}/absensi', [GuruController::class, 'attendances'])->name('attendances');
Route::post('kelas/{assignment}/absensi', [GuruController::class, 'storeAttendances'])->name('attendances.store');
Route::get('kelas/{assignment}/absensi/cetak-harian', [GuruController::class, 'printDailyAttendance'])->name('attendances.print-daily');
Route::get('kelas/{assignment}/absensi/cetak-bulanan', [GuruController::class, 'printMonthlyAttendance'])->name('attendances.print-monthly');
Route::get('kelas/{assignment}/nilai', [GuruController::class, 'grades'])->name('grades');
Route::post('kelas/{assignment}/nilai', [GuruController::class, 'storeGrades'])->name('grades.store');
Route::get('kelas/{assignment}/materi', [GuruController::class, 'materials'])->name('materials');
Route::post('kelas/{assignment}/materi', [GuruController::class, 'storeMaterial'])->name('materials.store');
Route::post('kelas/{assignment}/tugas', [GuruController::class, 'storeTask'])->name('tasks.store');
Route::get('kelas/{assignment}/siswa', [GuruController::class, 'students'])->name('students');
