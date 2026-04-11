<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuTeleponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PenitipController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TahananController;
use App\Http\Controllers\UserController; // Pastikan ini sudah di-import
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Bisa diakses siapa saja tanpa login)
|--------------------------------------------------------------------------
*/

// 1. Halaman Pintu Masuk (Landing Page Utama)
Route::get('/', function () {
    return view('welcome_kagatau');
})->name('landing');

// 2. Fitur Login & Logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (WAJIB LOGIN untuk bisa masuk)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // 1. Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Manajemen Tahanan (Sipirman)
    Route::get('/tahanan', [TahananController::class, 'index'])->name('tahanan.index');
    Route::get('/tahanan/create', [TahananController::class, 'create'])->name('tahanan.create');
    Route::post('/tahanan/store', [TahananController::class, 'store'])->name('tahanan.store');
    Route::delete('/tahanan/{id}', [TahananController::class, 'destroy'])->name('tahanan.destroy');
    Route::resource('tahanan', TahananController::class)->except(['index', 'create', 'store', 'destroy']);

    // 3. Manajemen Keluarga / Penitip (Sipirman)
    Route::get('/penitip', [PenitipController::class, 'index'])->name('penitip.index');
    Route::get('/penitip/create', [PenitipController::class, 'create'])->name('penitip.create');
    Route::post('/penitip', [PenitipController::class, 'store'])->name('penitip.store');
    Route::delete('/penitip/{id}', [PenitipController::class, 'destroy'])->name('penitip.destroy');
    Route::get('/penitip/{id}/edit', [PenitipController::class, 'edit'])->name('penitip.edit');
    Route::put('/penitip/{id}', [PenitipController::class, 'update'])->name('penitip.update');

    // 4. Manajemen Layanan KAGATAU
    Route::get('layanan/{id}/layani', [LayananController::class, 'layani'])->name('layanan.layani');
    Route::get('/layanan/{id}/edit-data', [LayananController::class, 'edit2'])->name('layanan.edit2');
    Route::resource('layanan', LayananController::class);

    // 5. Setting WA & Manajemen User Baru
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting/update', [SettingController::class, 'update'])->name('setting.update');
    
    // Fitur Baru: Manajemen Petugas & Profil (Admin & User)
    Route::resource('users', UserController::class);

    // 6. Buku Telepon (Tracing Database)
    Route::get('/buku-telepon', [BukuTeleponController::class, 'index'])->name('buku-telepon.index');
    Route::delete('/buku-telepon/{id}', [BukuTeleponController::class, 'destroy'])->name('buku-telepon.destroy');

});