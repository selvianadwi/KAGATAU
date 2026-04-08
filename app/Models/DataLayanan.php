<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/DataLayanan.php
class DataLayanan extends Model
{
    protected $connection = 'mysql_layanan'; 
    protected $table = 'data_layanan';

    protected $fillable = [
        'tahanan_id', 'penitip_id', 'hubungan', 'hp_manual', 
        'tanggal_masuk', 'tanggal_layanan', 'status', 'screenshot', 'dokumentasi'
    ];

    public function keluarga() {
        return $this->belongsTo(Penitip::class, 'penitip_id');
    }

    public function tahanan() {
        return $this->belongsTo(Tahanan::class, 'tahanan_id');
    }
}