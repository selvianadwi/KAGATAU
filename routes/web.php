<?php

use App\Http\Controllers\BukuTeleponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PenitipController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TahananController;
use Illuminate\Support\Facades\Route;

// Hapus .php dan ganti jadi ::class
Route::get('/', [DashboardController::class, 'index']);
// Route::get('/', function () {
//     return view('welcome');
// });



Route::get('/tahanan', [TahananController::class, 'index'])->name('tahanan.index');
Route::get('/tahanan/create', [TahananController::class, 'create'])->name('tahanan.create');
Route::post('/tahanan/store', [TahananController::class, 'store'])->name('tahanan.store');
// Tambahkan parameter {id} untuk menentukan data mana yang dihapus
Route::delete('/tahanan/{id}', [TahananController::class, 'destroy'])->name('tahanan.destroy');
Route::resource('tahanan', TahananController::class);


Route::get('/penitip', [PenitipController::class, 'index'])->name('penitip.index');
Route::get('/penitip/create', [PenitipController::class, 'create'])->name('penitip.create');
Route::post('/penitip', [PenitipController::class, 'store'])->name('penitip.store');
Route::delete('/penitip/{id}', [PenitipController::class, 'destroy'])->name('penitip.destroy');
Route::get('/penitip/{id}/edit', [PenitipController::class, 'edit'])->name('penitip.edit');
Route::put('/penitip/{id}', [PenitipController::class, 'update'])->name('penitip.update');

Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
Route::post('/setting/update', [SettingController::class, 'update'])->name('setting.update');

Route::get('layanan/{id}/layani', [LayananController::class, 'layani'])->name('layanan.layani');
Route::resource('layanan', LayananController::class);
Route::get('layanan/{id}/layani', [App\Http\Controllers\LayananController::class, 'layani'])->name('layanan.layani');
Route::resource('layanan', App\Http\Controllers\LayananController::class);
<<<<<<< HEAD
Route::get('/layanan/{id}/edit-data', [LayananController::class, 'edit2'])->name('layanan.edit2');
=======

Route::get('/buku-telepon', [BukuTeleponController::class, 'index'])->name('bukutelepon.index');
Route::delete('/buku-telepon/{id}', [BukuTeleponController::class, 'destroy'])->name('bukuTelepon.destroy');
>>>>>>> 1a2aba5c0d58244073adf24ad376bb4521abc444
