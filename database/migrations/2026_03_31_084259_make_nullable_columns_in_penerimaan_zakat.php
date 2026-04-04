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
            if (Schema::hasColumn('penerimaan_zakat', 'metode_pembayaran')) {
                $table->string('metode_pembayaran')->nullable()->change();
            }

            if (Schema::hasColumn('penerimaan_zakat', 'nominal')) {
                $table->decimal('nominal', 15, 2)->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('penerimaan_zakat', 'metode_pembayaran')) {
            DB::table('penerimaan_zakat')
                ->whereNull('metode_pembayaran')
                ->update(['metode_pembayaran' => 'Tunai']);
        }

        if (Schema::hasColumn('penerimaan_zakat', 'nominal')) {
            DB::table('penerimaan_zakat')
                ->whereNull('nominal')
                ->update(['nominal' => 0]);
        }

        Schema::table('penerimaan_zakat', function (Blueprint $table) {
            if (Schema::hasColumn('penerimaan_zakat', 'metode_pembayaran')) {
                $table->string('metode_pembayaran')->nullable(false)->change();
            }

            if (Schema::hasColumn('penerimaan_zakat', 'nominal')) {
                $table->decimal('nominal', 15, 2)->nullable(false)->change();
            }
        });
    }
};
