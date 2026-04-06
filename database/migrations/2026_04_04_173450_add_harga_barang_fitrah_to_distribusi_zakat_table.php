<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('distribusi_zakat', function (Blueprint $table) {
            if (! Schema::hasColumn('distribusi_zakat', 'harga_barang_fitrah')) {
                $table->decimal('harga_barang_fitrah', 15, 2)->nullable()->after('nominal');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distribusi_zakat', function (Blueprint $table) {
            if (Schema::hasColumn('distribusi_zakat', 'harga_barang_fitrah')) {
                $table->dropColumn('harga_barang_fitrah');
            }
        });
    }
};
