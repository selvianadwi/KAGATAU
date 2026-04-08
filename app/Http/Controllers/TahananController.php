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
        ->paginate(10) // Ini kuncinya agar currentPage() di Blade bisa jalan
        ->withQueryString(); 

        return view('tahanan.index', compact('tahanans'));
    }

    public function create()
    {
        return view('tahanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code_napi'     => 'required|unique:tahanan,code_napi',
            'nama'          => 'required|string|max:255',
            'nama_ayah'     => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Pria,Wanita',
            'perkara'       => 'nullable|string',
        ]);

        Tahanan::create([
        'code_napi'     => $request->code_napi,
        'nama'          => strtoupper($request->nama),
        'nama_ayah'     => strtoupper($request->nama_ayah),
        'jenis_kelamin' => $request->jenis_kelamin,
        'tanggal_masuk' => $request->tanggal_masuk, // Pastikan ini ada
    ]);

    // Kembalikan ke halaman sebelumnya (create layanan)
    return redirect()->back()->with('success', 'Data Tahanan Berhasil Ditambahkan!');
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