<?php

namespace App\Http\Controllers;

use App\Models\Tahanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TahananController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $tahanans = Tahanan::when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('code_napi', 'like', "%{$search}%")
                    // Pencarian gabungan Nama + Bin + Nama Ayah
                    ->orWhere(DB::raw("CONCAT(nama, ' bin ', nama_ayah)"), 'like', "%{$search}%")
                    // Pencarian gabungan Nama + Binti + Nama Ayah
                    ->orWhere(DB::raw("CONCAT(nama, ' binti ', nama_ayah)"), 'like', "%{$search}%");
            });
        })
            ->orderBy('id', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('tahanan.index', compact('tahanans'));
    }

    public function create()
    {
        return view('tahanan.create');
    }

public function store(Request $request)
{
    $codeNapi = $this->generateUniqueCode();

    $request->validate([
        'nama'          => 'required|string|max:255',
        'nama_ayah'     => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:Pria,Wanita',
        'tanggal_masuk' => 'required|date',
        'perkara'       => 'nullable|string',
    ]);

    Tahanan::create([
        'code_napi'     => $codeNapi,
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

private function generateUniqueCode()
{
    $exists = true;
    $code = '';

    while ($exists) {
        $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        
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