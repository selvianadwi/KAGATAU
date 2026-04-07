<?php

namespace App\Http\Controllers;

use App\Models\Penitip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenitipController extends Controller
{
    public function create()
{
    // Ambil data tahanan untuk pilihan dropdown di form (opsional, jika form butuh list tahanan)
    // $tahanans = \App\Models\Tahanan::all(); 
    
    return view('penitip.create'); // Pastikan file resources/views/penitip/create.blade.php sudah ada
}
    public function index(Request $request)
    {
        $search = $request->query('search');
        $penitips = Penitip::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('nik', 'like', "%{$search}%")
                         ->orWhere('hp', 'like', "%{$search}%"); // Tambah search by HP
        })
        ->latest('id')
        ->paginate(20)
        ->withQueryString();

        return view('penitip.index', compact('penitips'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'nik'      => 'required|numeric|digits:16|unique:penitip,nik',
            'hp'       => 'required|numeric|digits_between:10,15', // Validasi kolom hp
            'nama_wbp' => 'required',
            'foto'     => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $namaFoto = time() . '_' . $request->file('foto')->getClientOriginalName();
        $request->file('foto')->storeAs('foto_diri', $namaFoto, 'public');

        $namaKtp = time() . '_ktp_' . $request->file('foto_ktp')->getClientOriginalName();
        $request->file('foto_ktp')->storeAs('foto_ktp', $namaKtp, 'public');

        Penitip::create([
            'nama'     => $request->nama,
            'nik'      => $request->nik,
            'nama_wbp' => $request->nama_wbp,
            'hp'       => $request->hp, // Simpan ke kolom hp
            'foto'     => $namaFoto,
            'foto_ktp' => $namaKtp,
            'jadwal_kunjungan' => now()->toDateString(),
        ]);

        return redirect()->route('penitip.index')->with('success', 'Data penitip berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $penitip = Penitip::findOrFail($id);
        return view('penitip.edit', compact('penitip'));
    }

    public function update(Request $request, $id)
    {
        $penitip = Penitip::findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:255',
            'nik'      => 'required|numeric|digits:16|unique:penitip,nik,' . $id,
            'hp'       => 'required|numeric|digits_between:10,15',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $penitip->nama = $request->nama;
        $penitip->nik  = $request->nik;
        $penitip->hp   = $request->hp; // Update kolom hp

        if ($request->hasFile('foto')) {
            if ($penitip->foto) Storage::disk('public')->delete('foto_diri/' . $penitip->foto);
            $namaFoto = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->storeAs('foto_diri', $namaFoto, 'public');
            $penitip->foto = $namaFoto;
        }

        if ($request->hasFile('foto_ktp')) {
            if ($penitip->foto_ktp) Storage::disk('public')->delete('foto_ktp/' . $penitip->foto_ktp);
            $namaKtp = time() . '_ktp_' . $request->file('foto_ktp')->getClientOriginalName();
            $request->file('foto_ktp')->storeAs('foto_ktp', $namaKtp, 'public');
            $penitip->foto_ktp = $namaKtp;
        }

        $penitip->save();
        return redirect()->route('penitip.index')->with('success', 'Data penitip berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $penitip = Penitip::findOrFail($id);
        if ($penitip->foto) Storage::disk('public')->delete('foto_diri/' . $penitip->foto);
        if ($penitip->foto_ktp) Storage::disk('public')->delete('foto_ktp/' . $penitip->foto_ktp);
        $penitip->delete();

        return redirect()->route('penitip.index')->with('success', 'Data berhasil dihapus!');
    }
}