<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('jadwal_imams', function (Blueprint $table) {
        $table->foreignId('imam_id')->nullable()->constrained('data_imam')->onDelete('cascade')->after('id');
        $table->string('hari')->nullable()->after('tanggal');
        // tanggal, waktu_sholat, keterangan sudah ada — skip
    });
}

public function down()
{
    Schema::table('jadwal_imams', function (Blueprint $table) {
        $table->dropForeign(['imam_id']);
        $table->dropColumn(['imam_id', 'hari']);
    });
}
};
