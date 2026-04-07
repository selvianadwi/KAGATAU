<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penitip extends Model
{
    protected $connection = 'mysql'; 
    protected $table = 'penitip'; // Pastikan sesuai nama tabel di DB sipirman (penitip atau penitips)
    protected $primaryKey = 'id';
    public $timestamps = false;

    // WAJIB ADA: Daftarkan kolom sesuai database sipirman
    protected $fillable = [
        'nama', 
        'nik', 
        'hp', 
        'kode_tahanan', 
        'nama_wbp', 
        'foto', 
        'foto_ktp'
    ];
    public function tahanan()
    {
        return $this->belongsTo(Tahanan::class, 'kode_tahanan', 'code_napi');
    }
}