<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penerimaan_zakat', function (Blueprint $table) {
            // Add status field
            if (! Schema::hasColumn('penerimaan_zakat', 'status')) {
                $table->enum('status', ['pending', 'verified', 'distributed', 'cancelled'])
                    ->default('pending')
                    ->after('metode_pembayaran');
            }

            // Add created_by field
            if (! Schema::hasColumn('penerimaan_zakat', 'created_by')) {
                $table->foreignId('created_by')
                    ->nullable()
                    ->constrained('users')
                    ->cascadeOnUpdate()
                    ->nullOnDelete()
                    ->after('status');
            }

            // Add updated_by field
            if (! Schema::hasColumn('penerimaan_zakat', 'updated_by')) {
                $table->foreignId('updated_by')
                    ->nullable()
                    ->constrained('users')
                    ->cascadeOnUpdate()
                    ->nullOnDelete()
                    ->after('created_by');
            }

            // Add verified_date field
            if (! Schema::hasColumn('penerimaan_zakat', 'verified_date')) {
                $table->dateTime('verified_date')
                    ->nullable()
                    ->after('updated_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penerimaan_zakat', function (Blueprint $table) {
            if (Schema::hasColumn('penerimaan_zakat', 'verified_date')) {
                $table->dropColumn('verified_date');
            }

            if (Schema::hasColumn('penerimaan_zakat', 'updated_by')) {
                $table->dropForeign(['updated_by']);
                $table->dropColumn('updated_by');
            }

            if (Schema::hasColumn('penerimaan_zakat', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }

            if (Schema::hasColumn('penerimaan_zakat', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
