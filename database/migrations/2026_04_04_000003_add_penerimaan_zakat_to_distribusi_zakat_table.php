<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('distribusi_zakat', function (Blueprint $table) {
            // Add foreign key to track which penerimaan_zakat this distribusi came from
            if (! Schema::hasColumn('distribusi_zakat', 'penerimaan_zakat_id')) {
                $table->foreignId('penerimaan_zakat_id')
                    ->nullable()
                    ->constrained('penerimaan_zakat')
                    ->cascadeOnUpdate()
                    ->nullOnDelete()
                    ->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('distribusi_zakat', function (Blueprint $table) {
            if (Schema::hasColumn('distribusi_zakat', 'penerimaan_zakat_id')) {
                $table->dropForeign(['penerimaan_zakat_id']);
                $table->dropColumn('penerimaan_zakat_id');
            }
        });
    }
};
