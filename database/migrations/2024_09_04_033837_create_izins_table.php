<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('izins', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Menyimpan nama karyawan
            $table->string('alasan');        // Menyimpan alasan izin (sakit/izin)
            $table->string('gambar')->nullable(); // Menyimpan gambar bukti izin, bisa null jika tidak ada
            $table->text('deskripsi');       // Menyimpan deskripsi izin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izins');
    }
};
