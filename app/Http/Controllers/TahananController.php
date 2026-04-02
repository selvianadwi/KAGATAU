<?php

namespace App\Http\Controllers;

use App\Models\Tahanan;
use Illuminate\Http\Request;

class TahananController extends Controller
{
    /**
     * Menampilkan daftar tahanan dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Mengambil data tahanan, jika ada parameter 'search', maka difilter
        $tahanans = Tahanan::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('code_napi', 'like', "%{$search}%");
        })->get();

        return view('tahanan.index', compact('tahanans'));
    }

    /**
     * Menampilkan form tambah tahanan.
     */
    public function create()
    {
        return view('tahanan.create');
    }

    /**
     * Menyimpan data tahanan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        // 'in:Pria,Wanita' memastikan data sesuai dengan ENUM di database
        $request->validate([
            'code_napi'     => 'required|unique:tahanan,code_napi',
            'nama'          => 'required',
            'nama_ayah'     => 'required',
            'jenis_kelamin' => 'required|in:Pria,Wanita',
        ], [
            // Custom pesan error (opsional)
            'code_napi.unique' => 'Code NAPI sudah terdaftar di sistem.',
            'jenis_kelamin.in' => 'Pilih jenis kelamin yang tersedia.',
        ]);

        // Simpan ke database menggunakan Model Tahanan
        Tahanan::create([
            'code_napi'     => $request->code_napi,
            'nama'          => $request->nama,
            'nama_ayah'     => $request->nama_ayah,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('tahanan.index')->with('success', 'Data tahanan berhasil ditambahkan!');
    }

    /**
     * (Opsional) Fitur Hapus Data
     */
public function destroy($id)
{
    $tahanan = \App\Models\Tahanan::findOrFail($id);
    $tahanan->delete();

    return redirect()->route('tahanan.index')->with('success', 'Data tahanan berhasil dihapus!');
}
}