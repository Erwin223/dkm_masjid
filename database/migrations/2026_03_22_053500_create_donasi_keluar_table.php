<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donasi_keluar', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('jenis_donasi');                     // Uang / Barang dll
            $table->string('tujuan');                           // Untuk apa / kepada siapa
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donasi_keluar');
    }
};
