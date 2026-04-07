<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        $path = storage_path('app/wa_settings.json');
        
        // Cek apakah file ada
        if (File::exists($path)) {
            $json = File::get($path);
            $data = json_decode($json, true);
        } else {
            // Default template jika file belum ada
            $data = ['wa_template' => "Halo [nama_keluarga], tahanan [nama_tahanan] sudah di Rutan."];
        }

        $wa_template = $data['wa_template'] ?? '';
        
        return view('setting.index', compact('wa_template'));
    }

    public function update(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'wa_template' => 'required'
        ]);

        $path = storage_path('app/wa_settings.json');
        $data = ['wa_template' => $request->wa_template];

        try {
            // 2. Pastikan folder 'app' di dalam storage ada dan bisa ditulis
            if (!File::isDirectory(storage_path('app'))) {
                File::makeDirectory(storage_path('app'), 0775, true);
            }

            // 3. Simpan file (menggunakan File::put atau file_put_contents)
            // JSON_UNESCAPED_UNICODE agar karakter seperti enter tidak berubah jadi kode aneh
            File::put($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return redirect()->route('setting.index')->with('success', 'Template berhasil disimpan!');
            
        } catch (\Exception $e) {
            // Jika gagal, tampilkan pesan errornya agar kita tahu kenapa
            return redirect()->back()->with('success', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }
}