<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donasi_masuk', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('donatur');
            $table->string('jenis_donasi');
            $table->string('kategori_donasi');
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);     
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donasi_masuk');
    }
};
