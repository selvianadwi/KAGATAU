<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BukuTelepon extends Model
{
    public static function getCombinedData($search = null)
    {
        $query = DB::connection('mysql')->table('sipirman.penitip')
            ->leftJoin('kagatau.data_layanan', 'kagatau.data_layanan.tahanan_id', '=', 'sipirman.penitip.id')
            ->select([
                'sipirman.penitip.id',
                'sipirman.penitip.nama as nama_keluarga',
                'sipirman.penitip.nama_wbp as nama_tahanan',
                'sipirman.penitip.hp',
                'kagatau.data_layanan.hp_manual',
                'kagatau.data_layanan.hubungan',
                DB::raw("REPLACE(REPLACE(REPLACE(sipirman.penitip.nama_wbp, '[\"', ''), '\"]', ''), '\"', '') as nama_tahanan"),
                'kagatau.data_layanan.hubungan',
                DB::raw('COALESCE(kagatau.data_layanan.hp_manual, sipirman.penitip.hp) as nomor_hp')
            ]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('sipirman.penitip.nama_wbp', 'like', "%{$search}%")
                    ->orWhere('sipirman.penitip.nama', 'like', "%{$search}%");
            });
        }

        return $query->get();
    }
}
