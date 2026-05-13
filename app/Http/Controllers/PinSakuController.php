<?php

namespace App\Http\Controllers;

use App\Models\Tahanan;
use Illuminate\Http\Request;

class PinSakuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        
        $tahanans = Tahanan::when($search, function ($query) use ($search) {
            $query->where('nama', 'LIKE', "%$search%")
                  ->orWhere('code_napi', 'LIKE', "%$search%");
        })->paginate(10);

        return view('pin_saku.index', compact('tahanans'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'pin' => 'required|numeric|digits_between:4,6'
    ]);

    $tahanan = Tahanan::findOrFail($id);
    // Enkripsi input PIN ke MD5 sebelum disimpan
    $tahanan->pin = md5($request->pin); 
    $tahanan->save();

    return back()->with('success', 'PIN Saku ' . $tahanan->nama . ' berhasil diperbarui!');
}
}