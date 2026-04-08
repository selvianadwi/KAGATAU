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
            // NIK jadi nullable, tetap dicek unik kalau diisi
            'nik'      => 'nullable|numeric|digits:16|unique:penitip,nik',
            'hp'       => 'required|numeric|digits_between:10,15',
            // Foto diri & KTP jadi nullable
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle Foto Diri
        $namaFoto = null;
        if ($request->hasFile('foto')) {
            $namaFoto = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->storeAs('foto_diri', $namaFoto, 'public');
        }

        // Handle Foto KTP
        $namaKtp = null;
        if ($request->hasFile('foto_ktp')) {
            $namaKtp = time() . '_ktp_' . $request->file('foto_ktp')->getClientOriginalName();
            $request->file('foto_ktp')->storeAs('foto_ktp', $namaKtp, 'public');
        }

        Penitip::create([
            'nama'             => strtoupper($request->nama),
            'nik'              => $request->nik, // Akan otomatis null jika kosong
            'hp'               => $request->hp,
            'nama_wbp'         => '-',
            'kode_tahanan'     => '-',
            'foto'             => $namaFoto,
            'foto_ktp'         => $namaKtp,
            'jadwal_kunjungan' => now()->toDateString(),
        ]);

        if ($request->header('referer') == route('layanan.create')) {
            return redirect()->back()->with('success', 'Keluarga berhasil ditambahkan!');
        }

        return redirect()->route('penitip.index')->with('success', 'Data keluarga berhasil ditambahkan!');
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
            'nik'      => 'nullable|numeric|digits:16|unique:penitip,nik,' . $id,
            'hp'       => 'required|numeric|digits_between:10,15',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update data teks
        $penitip->nama = strtoupper($request->nama);
        $penitip->nik  = $request->nik;
        $penitip->hp   = $request->hp;

        // Handle Update Foto Diri
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($penitip->foto) {
                Storage::disk('public')->delete('foto_diri/' . $penitip->foto);
            }
            // Simpan foto baru
            $namaFoto = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->storeAs('foto_diri', $namaFoto, 'public');
            $penitip->foto = $namaFoto; // Masukkan ke objek model
        }

        // Handle Update Foto KTP
        if ($request->hasFile('foto_ktp')) {
            // Hapus KTP lama jika ada
            if ($penitip->foto_ktp) {
                Storage::disk('public')->delete('foto_ktp/' . $penitip->foto_ktp);
            }
            // Simpan KTP baru
            $namaKtp = time() . '_ktp_' . $request->file('foto_ktp')->getClientOriginalName();
            $request->file('foto_ktp')->storeAs('foto_ktp', $namaKtp, 'public');
            $penitip->foto_ktp = $namaKtp; // Masukkan ke objek model
        }

        // SIMPAN PERUBAHAN KE DATABASE
        $penitip->save();

        return redirect()->route('penitip.index')->with('success', 'Data keluarga berhasil diperbarui!');
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