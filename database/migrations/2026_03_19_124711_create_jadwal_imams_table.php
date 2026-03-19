<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('jadwal_imam', function (Blueprint $table) {
        $table->id();
        $table->string('nama_imam');
        $table->date('tanggal');
        $table->string('waktu_sholat');
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('jadwal_imam');
}
};
