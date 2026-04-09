<?php

namespace App\Http\Controllers;

use App\Models\Tahanan;
use Illuminate\Http\Request;

class TahananController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        // MENGGUNAKAN paginate() BUKAN get()
        // withQueryString() berfungsi agar parameter ?search=... tetap ada di URL saat klik next page
        $tahanans = Tahanan::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('code_napi', 'like', "%{$search}%");
        })
        ->orderBy('id', 'desc') 
        ->paginate(20) // Ini kuncinya agar currentPage() di Blade bisa jalan
        ->withQueryString(); 

        return view('tahanan.index', compact('tahanans'));
    }

    public function create()
    {
        return view('tahanan.create');
    }

public function store(Request $request)
{
    // 1. Generate Kode Unik 8 Digit
    $codeNapi = $this->generateUniqueCode();

    // 2. Validasi (Hapus code_napi dari validasi required karena kita generate sendiri)
    $request->validate([
        'nama'          => 'required|string|max:255',
        'nama_ayah'     => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:Pria,Wanita',
        'tanggal_masuk' => 'required|date',
        'perkara'       => 'nullable|string',
    ]);

    // 3. Simpan
    Tahanan::create([
        'code_napi'     => $codeNapi, // Pakai hasil generate
        'nama'          => strtoupper($request->nama),
        'nama_ayah'     => strtoupper($request->nama_ayah),
        'jenis_kelamin' => $request->jenis_kelamin,
        'tanggal_masuk' => $request->tanggal_masuk,
        'perkara'       => $request->perkara,
    ]);

    if ($request->asal_input === 'halaman_tahanan') {
        return redirect()->route('tahanan.index')->with('success', 'Tahanan berhasil ditambah! Kode: ' . $codeNapi);
    }
    return redirect()->back()->with('success', 'Tahanan berhasil ditambah! Kode: ' . $codeNapi);
}

/**
 * Fungsi Helper Generate Kode 8 Digit Unik
 */
private function generateUniqueCode()
{
    $exists = true;
    $code = '';

    while ($exists) {
        // Generate 8 digit alfanumerik (Huruf Kapital & Angka)
        $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        
        // Cek di DB Sipirman apakah sudah ada
        $exists = Tahanan::where('code_napi', $code)->exists();
    }

    return $code;
}
    public function edit($id)
    {
        $tahanan = Tahanan::findOrFail($id);
        return view('tahanan.edit', compact('tahanan'));
    }

    public function update(Request $request, $id)
    {
        $tahanan = Tahanan::findOrFail($id);

        $request->validate([
            'code_napi'     => 'required|unique:tahanan,code_napi,' . $id,
            'nama'          => 'required|string|max:255',
            'nama_ayah'     => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Pria,Wanita',
            'perkara'       => 'nullable|string',
        ]);

        $tahanan->update([
            'code_napi'     => $request->code_napi,
            'nama'          => strtoupper($request->nama),
            'nama_ayah'     => strtoupper($request->nama_ayah),
            'jenis_kelamin' => $request->jenis_kelamin,
            'perkara'       => $request->perkara,
        ]);

        return redirect()->route('tahanan.index')->with('success', 'Data tahanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $tahanan = Tahanan::findOrFail($id);
        $tahanan->delete();
        return redirect()->route('tahanan.index')->with('success', 'Data tahanan berhasil dihapus!');
    }
}