<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penerimaan_zakat', function (Blueprint $table) {
            if (! Schema::hasColumn('penerimaan_zakat', 'bentuk_zakat')) {
                $table->string('bentuk_zakat')->default('Uang')->after('jenis_zakat');
            }
            if (! Schema::hasColumn('penerimaan_zakat', 'satuan')) {
                $table->string('satuan')->nullable()->after('jumlah_zakat');
            }
            if (! Schema::hasColumn('penerimaan_zakat', 'nominal')) {
                $table->decimal('nominal', 15, 2)->nullable()->after('satuan');
            }
            if (! Schema::hasColumn('penerimaan_zakat', 'standar_per_jiwa')) {
                $table->decimal('standar_per_jiwa', 8, 2)->nullable()->after('jumlah_tanggungan');
            }
        });

        Schema::table('distribusi_zakat', function (Blueprint $table) {
            if (! Schema::hasColumn('distribusi_zakat', 'bentuk_zakat')) {
                $table->string('bentuk_zakat')->default('Uang')->after('jenis_zakat');
            }
            if (! Schema::hasColumn('distribusi_zakat', 'satuan')) {
                $table->string('satuan')->nullable()->after('jumlah_zakat');
            }
            if (! Schema::hasColumn('distribusi_zakat', 'nominal')) {
                $table->decimal('nominal', 15, 2)->nullable()->after('satuan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penerimaan_zakat', function (Blueprint $table) {
            foreach (['bentuk_zakat', 'satuan', 'nominal', 'standar_per_jiwa'] as $column) {
                if (Schema::hasColumn('penerimaan_zakat', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('distribusi_zakat', function (Blueprint $table) {
            foreach (['bentuk_zakat', 'satuan', 'nominal'] as $column) {
                if (Schema::hasColumn('distribusi_zakat', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
