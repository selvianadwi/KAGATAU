<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataLayanan extends Model
{
    use HasFactory;

    // Pastikan koneksi database-nya benar jika menggunakan multi-db
    protected $connection = 'mysql_layanan'; 
    protected $table = 'data_layanan';

    protected $fillable = [
        'tahanan_id',   // Pastikan ID Tahanan ada di sini
        'penitip_id', 
        'hubungan', 
        'hp_manual', 
        'tanggal_masuk', 
        'tanggal_layanan', 
        'status',
        'screenshot',
        'dokumentasi'
    ];

    /**
     * Relasi ke Keluarga (Penitip) - Database Kagatau
     */
    public function keluarga()
    {
        return $this->belongsTo(Penitip::class, 'penitip_id');
    }

    /**
     * RELASI BARU: Ke Tahanan - Database Sipirman
     */
    public function tahanan()
    {
        // Kita hubungkan ke Model Tahanan menggunakan foreign key 'tahanan_id'
        return $this->belongsTo(Tahanan::class, 'tahanan_id');
    }
}