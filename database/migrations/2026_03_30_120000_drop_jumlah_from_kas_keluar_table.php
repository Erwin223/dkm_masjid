<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('kas_keluar', 'jumlah')) {
            Schema::table('kas_keluar', function (Blueprint $table) {
                $table->dropColumn('jumlah');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('kas_keluar', 'jumlah')) {
            Schema::table('kas_keluar', function (Blueprint $table) {
                $table->unsignedInteger('jumlah')->nullable()->after('jenis_pengeluaran');
            });
        }
    }
};
