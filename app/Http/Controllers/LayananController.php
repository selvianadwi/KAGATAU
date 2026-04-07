<?php

namespace App\Http\Controllers;

use App\Models\DataLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data layanan beserta data keluarga dari DB sebelah
        $query = DataLayanan::with('keluarga');

        // Fitur Pencarian (Opsional, berdasarkan nama keluarga di DB sebelah)
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('keluarga', function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nama_wbp', 'LIKE', "%{$search}%");
            });
        }

        $layanans = $query->latest()->paginate(10);

        return view('layanan.index', compact('layanans'));
    }

    public function destroy($id)
    {
        $layanan = DataLayanan::findOrFail($id);
        $layanan->delete();

        return redirect()->back()->with('success', 'Data layanan berhasil dihapus!');
    }
}