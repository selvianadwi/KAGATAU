<?php

namespace App\Http\Controllers;

use App\Models\DataLayanan; // Model di DB Kagatau
use App\Models\Penitip;     // Model di DB Kagatau (Data Keluarga)
use App\Models\Tahanan;     // Model di DB Sipirman (Data Tahanan)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LayananController extends Controller
{
    /**
     * Menampilkan daftar antrean layanan
     */
    public function index(Request $request)
    {
        // Load relasi 'keluarga' (Penitip) dan 'tahanan'
        $query = DataLayanan::with(['keluarga', 'tahanan']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('keluarga', function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%");
            })->orWhereHas('tahanan', function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('code_napi', 'LIKE', "%{$search}%");
            });
        }

        $layanans = $query->latest()->paginate(10);
        return view('layanan.index', compact('layanans'));
    }

    /**
     * Menampilkan form input layanan baru
     */
    public function create()
    {
        // Ambil data Tahanan dari DB Sipirman
        $tahanans = Tahanan::orderBy('nama', 'asc')->get();
        
        // Ambil data Keluarga dari DB Kagatau
        $keluargas = Penitip::orderBy('nama', 'asc')->get();
        
        return view('layanan.create', compact('tahanans', 'keluargas'));
    }

    /**
     * Menyimpan data layanan ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahanan_id' => 'required',
            'penitip_id' => 'required',
            'hubungan'   => 'required',
            'hp_manual'  => 'nullable|numeric',
        ]);

        // Cari data Tahanan di DB Sipirman untuk mengambil tanggal_masuk
        $tahanan = Tahanan::findOrFail($request->tahanan_id);

        DataLayanan::create([
            'tahanan_id'      => $request->tahanan_id,
            'penitip_id'      => $request->penitip_id,
            'hubungan'        => $request->hubungan,
            'hp_manual'       => $request->hp_manual,
            'tanggal_masuk'   => $tahanan->tanggal_masuk, // Otomatis ambil dari kolom baru di tabel tahanan
            'tanggal_layanan' => null,                   // NULL sampai tombol 'Layani' dipencet
            'status'          => 'pending',
        ]);

        return redirect()->route('layanan.index')->with('success', 'Antrean layanan berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit (biasanya untuk update foto dokumentasi)
     */
    public function edit($id)
    {
        $layanan = DataLayanan::findOrFail($id);
        $tahanans = Tahanan::orderBy('nama', 'asc')->get();
        $keluargas = Penitip::orderBy('nama', 'asc')->get();
        
        return view('layanan.edit', compact('layanan', 'tahanans', 'keluargas'));
    }

    /**
     * Memperbarui dokumentasi layanan (Screenshot & Foto)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'screenshot'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'dokumentasi' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $layanan = DataLayanan::findOrFail($id);
        $updateData = [];

        if ($request->hasFile('screenshot')) {
            if ($layanan->screenshot) Storage::disk('public')->delete($layanan->screenshot);
            $updateData['screenshot'] = $request->file('screenshot')->store('layanan/screenshot', 'public');
        }

        if ($request->hasFile('dokumentasi')) {
            if ($layanan->dokumentasi) Storage::disk('public')->delete($layanan->dokumentasi);
            $updateData['dokumentasi'] = $request->file('dokumentasi')->store('layanan/dokumentasi', 'public');
        }

        if (!empty($updateData)) {
            $layanan->update($updateData);
            return redirect()->route('layanan.index')->with('success', 'Dokumentasi berhasil diperbarui!');
        }

        return redirect()->route('layanan.index')->with('info', 'Tidak ada file yang diunggah.');
    }

    /**
     * Menghapus data layanan
     */
    public function destroy($id)
    {
        $layanan = DataLayanan::findOrFail($id);
        
        if ($layanan->screenshot) Storage::disk('public')->delete($layanan->screenshot);
        if ($layanan->dokumentasi) Storage::disk('public')->delete($layanan->dokumentasi);
        
        $layanan->delete();

        return redirect()->back()->with('success', 'Data layanan berhasil dihapus!');
    }

    /**
     * Fungsi utama untuk memproses layanan (Tombol WA)
     */
    public function layani($id)
    {
        $layanan = DataLayanan::findOrFail($id);
        
        // Update status menjadi dilayani dan isi tanggal layanan otomatis jam sekarang
        $layanan->update([
            'status'          => 'dilayani',
            'tanggal_layanan' => Carbon::now() // Mengisi waktu presisi saat dilayani
        ]);

        return redirect()->back()->with('success', 'Status layanan diperbarui menjadi Terlayani!');
    }
}