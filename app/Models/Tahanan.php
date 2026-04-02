<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tahanan extends Model
{
    protected $table = 'tahanan';
    protected $primaryKey = 'id';
    
    // Matikan timestamps karena tabel bawaan sipirman.sql tidak memilikinya
    public $timestamps = false;

    protected $fillable = ['code_napi', 'nama', 'nama_ayah', 'jenis_kelamin'];
}