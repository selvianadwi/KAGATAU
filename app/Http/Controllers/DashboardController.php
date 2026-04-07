<?php

namespace App\Http\Controllers;

use App\Models\DataLayanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung data dari database kagatau
        $totalTahanan  = DataLayanan::count();
        $terlayani     = DataLayanan::where('status', 'dilayani')->count();
        $belumTerlayani = DataLayanan::where('status', 'pending')->count();

        return view('dashboard', compact('totalTahanan', 'terlayani', 'belumTerlayani'));
    }
}