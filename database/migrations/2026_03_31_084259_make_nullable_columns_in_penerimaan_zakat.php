<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penerimaan_zakat', function (Blueprint $table) {
            $table->string('metode_pembayaran')->nullable()->change();
            $table->decimal('nominal', 15, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::table('penerimaan_zakat')
            ->whereNull('metode_pembayaran')
            ->update(['metode_pembayaran' => 'Tunai']);

        DB::table('penerimaan_zakat')
            ->whereNull('nominal')
            ->update(['nominal' => 0]);

        Schema::table('penerimaan_zakat', function (Blueprint $table) {
            $table->string('metode_pembayaran')->nullable(false)->change();
            $table->decimal('nominal', 15, 2)->nullable(false)->change();
        });
    }
};
