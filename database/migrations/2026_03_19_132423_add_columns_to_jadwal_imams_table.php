<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
{
    Schema::table('jadwal_imams', function (Blueprint $table) {
        $table->string('nama_imam')->after('id');
        $table->date('tanggal')->after('nama_imam');
        $table->string('waktu_sholat')->after('tanggal');
        $table->text('keterangan')->nullable()->after('waktu_sholat');
    });
}

public function down()
{
    Schema::table('jadwal_imams', function (Blueprint $table) {
        $table->dropColumn([
            'nama_imam',
            'tanggal',
            'waktu_sholat',
            'keterangan'
        ]);
    });
}
};
