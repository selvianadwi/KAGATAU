<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuTeleponController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $dbSipirman = "sipirman"; // Sesuaikan dengan nama DB Sipirman Anda

        // 1. Ambil data Tahanan dari DB Sipirman (mysql)
        $tahanans = DB::connection('mysql')
            ->table('tahanan')
            ->when($search, function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('code_napi', 'like', "%{$search}%");
            })
            ->orderBy('nama', 'asc')
            ->paginate(10);

        foreach ($tahanans as $t) {
            // SOURCE A: Dari Layanan KAGATAU (Database: kagatau)
            $dariLayanan = DB::connection('mysql_layanan')
                ->table('data_layanan')
                ->leftJoin($dbSipirman . '.penitip', 'data_layanan.penitip_id', '=', 'penitip.id')
                ->where('data_layanan.tahanan_id', $t->id)
                ->select(
                    'data_layanan.id as id_aksi', // ID untuk delete
                    'penitip.nama as nama_keluarga',
                    DB::raw("COALESCE(data_layanan.hp_manual, penitip.hp) as hp"),
                    'data_layanan.hubungan',
                    DB::raw("'Layanan KAGATAU' as sumber")
                )
                ->get();

            // SOURCE B: Dari Master Penitip Sipirman
            $dariPenitip = DB::connection('mysql')
                ->table('penitip')
                ->where('kode_tahanan', $t->code_napi)
                ->select(
                    DB::raw("NULL as id_aksi"),
                    'nama as nama_keluarga',
                    'hp',
                    DB::raw("'Pendaftar Kunjungan' as hubungan"),
                    DB::raw("'Master Penitip' as sumber")
                )
                ->get();

            // SOURCE C: Dari Data Titipan Barang Sipirman
            $dariTitipan = DB::connection('mysql')
                ->table('data_titipan')
                ->leftJoin('penitip', 'data_titipan.nik', '=', 'penitip.nik')
                ->where('data_titipan.kode_tahanan', $t->code_napi)
                ->select(
                    DB::raw("NULL as id_aksi"),
                    'data_titipan.nama_pengirim as nama_keluarga',
                    'penitip.hp as hp',
                    'data_titipan.hubungan',
                    DB::raw("'Titipan Barang' as sumber")
                )
                ->get();

            // Gabungkan dan Filter Duplikat Nama + HP
            $gabungan = $dariLayanan->concat($dariPenitip)->concat($dariTitipan);
            $t->semua_keluarga = $gabungan->filter(function($item) {
                return !is_null($item->nama_keluarga);
            })->unique(function ($item) {
                return $item->nama_keluarga . $item->hp;
            });
        }

        return view('buku_telepon.index', compact('tahanans'));
    }

    public function destroy($id)
    {
        try {
            DB::connection('mysql_layanan')
                ->table('data_layanan')
                ->where('id', $id)
                ->delete();

            return redirect()->back()->with('success', 'Riwayat kontak berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}