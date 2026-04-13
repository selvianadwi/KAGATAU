<?php

namespace App\Http\Controllers;

use App\Models\DataLayanan;
use App\Models\Tahanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Set Default: 13 April 2026 sampai hari ini
        $tgl_mulai = $request->input('tgl_mulai', '2026-04-13');
        $tgl_selesai = $request->input('tgl_selesai', Carbon::now()->format('Y-m-d'));

        // Format untuk query
        $start = Carbon::parse($tgl_mulai)->startOfDay();
        $end = Carbon::parse($tgl_selesai)->endOfDay();

        // 1. Total Tahanan (Pakai kolom 'tanggal_masuk' sesuai database Sipirman)
        $totalTahanan = Tahanan::whereBetween('tanggal_masuk', [$tgl_mulai, $tgl_selesai])->count();

        // 2. Statistik Layanan (Tetap pakai 'created_at' karena ini tabel Kagatau)
        $terlayani = DataLayanan::whereBetween('created_at', [$start, $end])
                                ->where('status', 'dilayani')
                                ->count();

        $belumTerlayani = DataLayanan::whereBetween('created_at', [$start, $end])
                                     ->where('status', 'pending')
                                     ->count();

        return view('dashboard', compact('totalTahanan', 'terlayani', 'belumTerlayani', 'tgl_mulai', 'tgl_selesai'));
    }
}