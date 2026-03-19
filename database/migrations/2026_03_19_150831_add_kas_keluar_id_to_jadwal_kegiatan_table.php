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
    Schema::table('jadwal_kegiatan', function (Blueprint $table) {
        $table->foreignId('kas_keluar_id')->nullable()->constrained('kas_keluar')->onDelete('set null')->after('keterangan');
    });
}

public function down()
{
    Schema::table('jadwal_kegiatan', function (Blueprint $table) {
        $table->dropForeign(['kas_keluar_id']);
        $table->dropColumn('kas_keluar_id');
    });
}
};
