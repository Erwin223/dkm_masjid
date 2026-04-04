<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penerimaan_zakat', function (Blueprint $table) {
            if (! Schema::hasColumn('penerimaan_zakat', 'nominal_pembagian')) {
                $table->decimal('nominal_pembagian', 15, 2)->nullable()->after('nominal');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penerimaan_zakat', function (Blueprint $table) {
            if (Schema::hasColumn('penerimaan_zakat', 'nominal_pembagian')) {
                $table->dropColumn('nominal_pembagian');
            }
        });
    }
};
