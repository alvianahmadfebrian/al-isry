<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PpdbManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

Route::get('master', [AdminController::class, 'master'])->name('master');
Route::post('master/tahun-ajaran', [AdminController::class, 'storeAcademicYear'])->name('academic-years.store');
Route::post('master/kelas', [AdminController::class, 'storeClass'])->name('classes.store');
Route::post('master/mapel', [AdminController::class, 'storeSubject'])->name('subjects.store');

Route::get('siswa', [AdminController::class, 'students'])->name('students.index');
Route::post('siswa', [AdminController::class, 'storeStudent'])->name('students.store');
Route::post('siswa/import-csv', [AdminController::class, 'importStudentsCsv'])->name('students.import');
Route::get('siswa/{student}/kartu', [AdminController::class, 'studentCard'])->name('students.card');
Route::delete('siswa/{student}', [AdminController::class, 'destroyStudent'])->name('students.destroy');

Route::get('guru', [AdminController::class, 'teachers'])->name('teachers.index');
Route::post('guru', [AdminController::class, 'storeTeacher'])->name('teachers.store');
Route::patch('guru/{teacher}/landing', [AdminController::class, 'toggleTeacherLanding'])->name('teachers.landing');
Route::patch('guru/{teacher}/aktif', [AdminController::class, 'toggleTeacherActive'])->name('teachers.active');

Route::get('jadwal', [AdminController::class, 'schedules'])->name('schedules.index');
Route::post('jadwal', [AdminController::class, 'storeAssignment'])->name('schedules.store');

Route::get('konten-landing', [AdminController::class, 'cms'])->name('cms.index');
Route::put('konten-landing/profil', [AdminController::class, 'updateProfileCms'])->name('cms.profile');
Route::post('konten-landing/berita', [AdminController::class, 'storeNews'])->name('cms.news.store');
Route::delete('konten-landing/berita/{news}', [AdminController::class, 'destroyNews'])->name('cms.news.destroy');
Route::post('konten-landing/galeri', [AdminController::class, 'storeGallery'])->name('cms.gallery.store');

Route::get('ppdb', [PpdbManagementController::class, 'index'])->name('ppdb.index');
Route::get('ppdb/{ppdb}', [PpdbManagementController::class, 'show'])->name('ppdb.show');
Route::patch('ppdb/{ppdb}/status', [PpdbManagementController::class, 'updateStatus'])->name('ppdb.status');
Route::delete('ppdb/{ppdb}', [PpdbManagementController::class, 'destroy'])->name('ppdb.destroy');
