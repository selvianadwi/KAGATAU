<?php

namespace App\Http\Controllers;

use App\Models\DataLayanan;
use App\Models\Penitip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        $query = DataLayanan::with('keluarga');

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

    public function create()
    {
        $keluargas = Penitip::orderBy('nama', 'asc')->get();
        return view('layanan.create', compact('keluargas'));
    }

    public function store(Request $request)
{
    $request->validate([
        'tanggal_layanan' => 'required|date',
        'penitip_id'      => 'required',
        'hubungan'        => 'nullable', // <--- Ganti jadi nullable biar nggak error kalau kosong
        'hp_manual'       => 'nullable|numeric',
    ]);

    DataLayanan::create([
        'tanggal_layanan' => $request->tanggal_layanan,
        'penitip_id'      => $request->penitip_id,
        'hubungan'        => $request->hubungan, 
        'hp_manual'       => $request->hp_manual,
        'status'          => 'pending',
    ]);

    return redirect()->route('layanan.index')->with('success', 'Data layanan berhasil ditambahkan!');
}

    // --- FUNCTION EDIT YANG TADI HILANG ---
    public function edit($id)
    {
        $layanan = DataLayanan::findOrFail($id);
        $keluargas = Penitip::orderBy('nama', 'asc')->get();
        
        return view('layanan.edit', compact('layanan', 'keluargas'));
    }

   public function update(Request $request, $id)
{
    // 1. Validasi HANYA untuk file foto
    $request->validate([
        'screenshot'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Maksimal 2MB
        'dokumentasi' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Maksimal 2MB
    ]);

    $layanan = DataLayanan::findOrFail($id);
    $data = []; // Buat array kosong untuk menampung path foto baru

    // 2. Proses Upload Screenshot (Bukti WA)
    if ($request->hasFile('screenshot')) {
        // Hapus foto lama dari server jika ada
        if ($layanan->screenshot) {
            Storage::disk('public')->delete($layanan->screenshot);
        }
        // Simpan foto baru ke folder 'public/layanan/screenshot'
        $data['screenshot'] = $request->file('screenshot')->store('layanan/screenshot', 'public');
    }

    // 3. Proses Upload Dokumentasi (Foto Layanan)
    if ($request->hasFile('dokumentasi')) {
        // Hapus foto lama dari server jika ada
        if ($layanan->dokumentasi) {
            Storage::disk('public')->delete($layanan->dokumentasi);
        }
        // Simpan foto baru ke folder 'public/layanan/dokumentasi'
        $data['dokumentasi'] = $request->file('dokumentasi')->store('layanan/dokumentasi', 'public');
    }

    // 4. Update data HANYA jika ada foto baru yang diunggah
    if (!empty($data)) {
        $layanan->update($data);
        return redirect()->route('layanan.index')->with('success', 'Dokumentasi layanan berhasil diperbarui!');
    }

    return redirect()->route('layanan.index')->with('info', 'Tidak ada perubahan data (tidak ada foto yang diunggah).');
}
    public function destroy($id)
    {
        $layanan = DataLayanan::findOrFail($id);
        
        // Hapus file fisik jika ada sebelum hapus data di DB
        if ($layanan->screenshot) Storage::disk('public')->delete($layanan->screenshot);
        if ($layanan->dokumentasi) Storage::disk('public')->delete($layanan->dokumentasi);
        
        $layanan->delete();

        return redirect()->back()->with('success', 'Data layanan berhasil dihapus!');
    }

    public function layani($id)
{
    $layanan = DataLayanan::findOrFail($id);
    
    // Update status menjadi terlayani
    $layanan->update([
        'status' => 'dilayani' // sesuaikan dengan ENUM di database kamu ('pending', 'dilayani')
    ]);

    return redirect()->back()->with('success', 'Status berhasil diperbarui!');
}
    
}