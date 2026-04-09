<?php

namespace App\Http\Controllers;

use App\Models\DataLayanan; // Model di DB Kagatau
use App\Models\Penitip;     // Model di DB Sipirman (Data Keluarga)
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
    $search = $request->query('search');
    $dari = $request->query('dari');
    $sampai = $request->query('sampai');
    $status = $request->query('status'); // Ambil input status

    $dbSipirman = "sipirman"; 

    $layanans = DataLayanan::with(['tahanan', 'keluarga'])
        ->when($search, function ($query, $search) use ($dbSipirman) {
            return $query->where(function ($q) use ($search, $dbSipirman) {
                $q->whereHas('tahanan', function ($queryT) use ($search, $dbSipirman) {
                    $queryT->from($dbSipirman . '.tahanan')
                           ->where('nama', 'like', "%{$search}%");
                })
                ->orWhereHas('keluarga', function ($queryK) use ($search, $dbSipirman) {
                    $queryK->from($dbSipirman . '.penitip')
                           ->where('nama', 'like', "%{$search}%");
                });
            });
        })
        ->when($dari, function ($query, $dari) {
            return $query->whereDate('tanggal_layanan', '>=', $dari);
        })
        ->when($sampai, function ($query, $sampai) {
            return $query->whereDate('tanggal_layanan', '<=', $sampai);
        })
        // FILTER STATUS
        ->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })
        ->orderBy('id', 'desc')
        ->paginate(20)
        ->withQueryString();

    return view('layanan.index', compact('layanans'));
}
    /**
     * Menampilkan form input layanan baru
     */
    public function create()
    {
        // Ambil data Tahanan dari DB Sipirman
        $tahanans = Tahanan::orderBy('nama', 'asc')->get();
        
        // Ambil data Keluarga dari DB Sipirman
        $keluargas = Penitip::orderBy('nama', 'asc')->get();
        
        return view('layanan.create', compact('tahanans', 'keluargas'));
    }

    /**
     * Menyimpan data layanan ke database
     */
    public function store(Request $request)
{
    $request->validate([
        // Hapus 'mysql.' atau 'sipirman.' cukup nama tabelnya saja karena ini koneksi utama
        'tahanan_id' => 'required|exists:tahanan,id', 
        'penitip_id' => 'required|exists:penitip,id',
        'hubungan'   => 'required',
        'hp_manual'  => 'nullable|numeric',
    ]);

    // Ambil data tahanan
    $tahanan = \App\Models\Tahanan::findOrFail($request->tahanan_id);

    // Simpan ke DB Kagatau (Koneksi: mysql_layanan)
    \App\Models\DataLayanan::create([
        'tahanan_id'      => $request->tahanan_id,
        'penitip_id'      => $request->penitip_id,
        'hubungan'        => $request->hubungan,
        'hp_manual'       => $request->hp_manual,
        'tanggal_masuk'   => $tahanan->tanggal_masuk,
        'status'          => 'pending',
        'tanggal_layanan' => null,
    ]);

    return redirect()->route('layanan.index')->with('success', 'Antrean berhasil didaftarkan!');
}

    /**
     * Menampilkan form edit dokumentasi
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
     * Memproses layanan
     */
    public function layani($id)
    {
        $layanan = DataLayanan::findOrFail($id);
        
        $layanan->update([
            'status'          => 'dilayani',
            'tanggal_layanan' => Carbon::now() 
        ]);

        return redirect()->back()->with('success', 'Status layanan diperbarui menjadi Terlayani!');
    }
    /**
     * Fitur Edit Data Baru (edit2)
     */
    public function edit2($id)
    {
        $layanan = DataLayanan::findOrFail($id);
        
        // Ambil data untuk dropdown relasi
        $tahanans = Tahanan::orderBy('nama', 'asc')->get();
        $keluargas = Penitip::orderBy('nama', 'asc')->get();
        
        return view('layanan.edit2', compact('layanan', 'tahanans', 'keluargas'));
    }

    /**
     * Fungsi Update (Bisa dipakai oleh edit.blade maupun edit2.blade)
     */
    public function update(Request $request, $id)
    {
        $layanan = DataLayanan::findOrFail($id);
        
        // Gabungkan semua input (baik teks maupun file)
        $updateData = $request->all();

        // 1. Logic Sinkron Tanggal Masuk (Jika Tahanan Diganti di edit2)
        if ($request->tahanan_id && $layanan->tahanan_id != $request->tahanan_id) {
            $tahanan = Tahanan::find($request->tahanan_id);
            $updateData['tanggal_masuk'] = $tahanan->tanggal_masuk;
        }

        // 2. Logic Upload Foto (Jika ada file di edit/edit2)
        if ($request->hasFile('screenshot')) {
            if ($layanan->screenshot) Storage::disk('public')->delete($layanan->screenshot);
            $updateData['screenshot'] = $request->file('screenshot')->store('layanan/screenshot', 'public');
        }

        if ($request->hasFile('dokumentasi')) {
            if ($layanan->dokumentasi) Storage::disk('public')->delete($layanan->dokumentasi);
            $updateData['dokumentasi'] = $request->file('dokumentasi')->store('layanan/dokumentasi', 'public');
        }

        $layanan->update($updateData);

        return redirect()->route('layanan.index')->with('success', 'Data antrean berhasil diperbarui!');
    }
}