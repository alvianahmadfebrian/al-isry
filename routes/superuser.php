<?php

use App\Http\Controllers\SuperUser\SystemController;
use App\Http\Controllers\SuperUser\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SystemController::class, 'dashboard'])->name('dashboard');

Route::resource('akun', UserController::class)
    ->parameters(['akun' => 'user'])
    ->names('users')
    ->except('show');
Route::patch('akun/{user}/status', [UserController::class, 'toggleActive'])->name('users.toggle');

Route::get('pengaturan', [SystemController::class, 'settings'])->name('settings');
Route::put('pengaturan', [SystemController::class, 'updateSettings'])->name('settings.update');

Route::get('log-aktivitas', [SystemController::class, 'logs'])->name('logs');
Route::get('backup', [SystemController::class, 'backup'])->name('backup');
Route::get('backup/unduh', [SystemController::class, 'downloadBackup'])->name('backup.download');
