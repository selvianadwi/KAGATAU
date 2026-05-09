<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuTeleponController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $dbSipirman = "sipirman"; 
        $dbLayanan = "kagatau";   

        $tahanans = DB::connection('mysql')
            ->table('tahanan')
            ->select('id', 'nama', 'code_napi', 'nama_ayah', 'jenis_kelamin')
            ->when($search, function ($q) use ($search, $dbLayanan) {
                $q->where(function ($sub) use ($search, $dbLayanan) {
                $sub->where(DB::raw("CONCAT(nama, ' bin ', nama_ayah)"), 'like', "%{$search}%")
                    ->orWhere(DB::raw("CONCAT(nama, ' binti ', nama_ayah)"), 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('code_napi', 'like', "%{$search}%");

                    $sub->orWhereExists(function ($query) use ($search) {
                        $query->select(DB::raw(1))
                            ->from('penitip')
                            ->whereColumn('penitip.kode_tahanan', 'tahanan.code_napi')
                            ->where('penitip.nama', 'like', "%{$search}%");
                    });

                    $sub->orWhereExists(function ($query) use ($search, $dbLayanan) {
                        $query->select(DB::raw(1))
                            ->from($dbLayanan . '.data_layanan')
                            ->join('penitip', $dbLayanan . '.data_layanan.penitip_id', '=', 'penitip.id')
                            ->whereColumn($dbLayanan . '.data_layanan.tahanan_id', 'tahanan.id')
                            ->where('penitip.nama', 'like', "%{$search}%");
                    });

                    $sub->orWhereExists(function ($query) use ($search) {
                        $query->select(DB::raw(1))
                            ->from('data_titipan')
                            ->whereColumn('data_titipan.kode_tahanan', 'tahanan.code_napi')
                            ->where('data_titipan.nama_pengirim', 'like', "%{$search}%");
                    });
                });
            })
            ->orderBy('nama', 'asc')
            ->paginate(10)
            ->withQueryString();

        foreach ($tahanans as $t) {
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