<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;

#[Fillable(['name', 'username', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Paksa model ini menggunakan koneksi database kagatau
     * Pastikan di config/database.php sudah ada koneksi 'mysql_layanan'
     */
    protected $connection = 'mysql_layanan'; 
    protected $table = 'users';

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}