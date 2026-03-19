<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('jadwal_kegiatan', function (Blueprint $table) {
        $table->id();
        $table->string('nama_kegiatan');
        $table->date('tanggal');
        $table->string('waktu')->nullable();
        $table->string('tempat')->nullable();
        $table->string('penanggung_jawab')->nullable();
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('jadwal_kegiatan');
}
};
