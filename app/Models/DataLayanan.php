<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataLayanan extends Model
{
    use HasFactory;

    // WAJIB: Beritahu Laravel kalau model ini pakai database 'kagatau'
    protected $connection = 'mysql_layanan';

    protected $table = 'data_layanan';

    protected $fillable = [
        'tanggal_layanan',
        'penitip_id',
        'hp_manual',
        'screenshot',
        'dokumentasi',
        'status'
    ];

    // Relasi ke tabel Penitip (Database Utama)
    public function keluarga()
    {
        // Walaupun beda database, Laravel bisa melakukan JOIN jika dalam 1 server MySQL
        return $this->belongsTo(Penitip::class, 'penitip_id');
    }
}