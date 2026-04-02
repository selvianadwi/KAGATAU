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
    Schema::create('tahanans', function (Blueprint $table) {
        $table->id();
        $table->string('code_napi')->unique();
        $table->string('nama');
        $table->string('nama_ayah');
        $table->string('jenis_kelamin');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahanans');
    }
};
