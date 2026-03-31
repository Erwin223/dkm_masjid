<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('donasi_masuk', 'satuan')) {
            Schema::table('donasi_masuk', function (Blueprint $table) {
                $table->string('satuan')->nullable()->after('jumlah');
            });
        }

        Schema::table('donasi_keluar', function (Blueprint $table) {
            if (! Schema::hasColumn('donasi_keluar', 'satuan')) {
                $table->string('satuan')->nullable()->after('jumlah');
            }

            if (! Schema::hasColumn('donasi_keluar', 'nominal')) {
                $table->decimal('nominal', 15, 2)->nullable()->after('satuan');
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('donasi_masuk', 'satuan')) {
            Schema::table('donasi_masuk', function (Blueprint $table) {
                $table->dropColumn('satuan');
            });
        }

        Schema::table('donasi_keluar', function (Blueprint $table) {
            if (Schema::hasColumn('donasi_keluar', 'nominal')) {
                $table->dropColumn('nominal');
            }

            if (Schema::hasColumn('donasi_keluar', 'satuan')) {
                $table->dropColumn('satuan');
            }
        });
    }
};
