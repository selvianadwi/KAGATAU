<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tahanan extends Model
{
    // WAJIB: Kunci koneksi ke database utama (sipirman)
    // mysql adalah nama koneksi default di config/database.php
    protected $connection = 'mysql'; 

    protected $table = 'tahanan';
    protected $primaryKey = 'id';
    
    public $timestamps = false;

    protected $fillable = ['code_napi', 'nama', 'nama_ayah', 'jenis_kelamin'];
}