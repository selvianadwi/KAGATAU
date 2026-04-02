<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TahananController;

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