<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('penitips', function (Blueprint $table) {
        $table->id();
        $table->timestamp('deleted_date')->nullable();
        $table->string('resi');
        $table->string('input_by');
        $table->dateTime('tanggal');
        $table->string('nik');
        $table->string('nama_pengirim');
        $table->string('hubungan');
        $table->boolean('keluarga_inti')->default(0);
        $table->string('kode_tahanan');
        $table->string('nama_tahanan');
        $table->text('data_antiseptik')->nullable();
        $table->text('pesan_penitip')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penitips');
    }
};
