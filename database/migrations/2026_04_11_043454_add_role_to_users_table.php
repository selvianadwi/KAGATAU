<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // PAKSA pakai koneksi mysql_layanan (Database Kagatau)
        Schema::connection('mysql_layanan')->table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('username');
        });
    }

    public function down(): void
    {
        Schema::connection('mysql_layanan')->table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};