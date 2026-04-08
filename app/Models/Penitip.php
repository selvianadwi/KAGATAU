<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penitip extends Model
{
    // SESUAIKAN: Pakai koneksi yang mengarah ke DB kagatau
    protected $connection = 'mysql'; 
    protected $table = 'penitip'; 
    
    protected $primaryKey = 'id';
    
    // Aktifkan true jika tabel penitip punya kolom created_at & updated_at
    public $timestamps = false; 

    protected $fillable = [
        'nama', 
        'nik', 
        'hp', 
        'kode_tahanan', // Ini field lama (opsional tetap ada)
        'nama_wbp',     // Ini field lama (opsional tetap ada)
        'foto', 
        'foto_ktp'
    ];

    /**
     * Relasi ke Tahanan (Sipirman)
     */
    public function tahanan()
    {
        // Relasi ini tetap bisa ada jika ingin akses langsung dari Keluarga ke Tahanan
        return $this->belongsTo(Tahanan::class, 'kode_tahanan', 'code_napi');
    }
}