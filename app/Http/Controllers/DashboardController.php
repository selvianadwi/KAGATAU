<?php

namespace App\Http\Controllers;

use App\Models\DataLayanan;
use App\Models\Tahanan; // WAJIB PANGGIL MODEL TAHANAN
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Total Tahanan dari database Sipirman (Tabel tahanan)
        $totalTahanan = Tahanan::count();

        // 2. Hitung statistik layanan dari database Kagatau (Tabel data_layanan)
        // Pastikan 'status' sesuai dengan isi di database (misal: 'dilayani' atau 'terlayani')
        $terlayani = DataLayanan::where('status', 'dilayani')->count();
        $belumTerlayani = DataLayanan::where('status', 'pending')->count();

        return view('dashboard', compact('totalTahanan', 'terlayani', 'belumTerlayani'));
    }
}