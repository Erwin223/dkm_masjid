<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('jadwal_kegiatan', function (Blueprint $table) {
        $table->string('nama_kegiatan')->after('id');
        $table->date('tanggal')->after('nama_kegiatan');
        $table->string('waktu')->nullable()->after('tanggal');
        $table->string('tempat')->nullable()->after('waktu');
        $table->string('penanggung_jawab')->nullable()->after('tempat');
        $table->text('keterangan')->nullable()->after('penanggung_jawab');
    });
}

public function down()
{
    Schema::table('jadwal_kegiatan', function (Blueprint $table) {
        $table->dropColumn([
            'nama_kegiatan',
            'tanggal',
            'waktu',
            'tempat',
            'penanggung_jawab',
            'keterangan'
        ]);
    });
}
};
