<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_kegiatan', function (Blueprint $table) {
            $table->decimal('estimasi_anggaran', 15, 2)->nullable()->after('penanggung_jawab');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_kegiatan', function (Blueprint $table) {
            $table->dropColumn('estimasi_anggaran');
        });
    }
};
