<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donasi_masuk', function (Blueprint $table) {
            // donatur_id nullable — null berarti "Hamba Allah"
            $table->foreignId('donatur_id')
                  ->nullable()
                  ->constrained('donatur')
                  ->onDelete('set null')
                  ->after('id');
            // donatur_nama sebagai fallback / override
            $table->string('donatur_nama')->default('Hamba Allah')->after('donatur_id');
        });
    }

    public function down(): void
    {
        Schema::table('donasi_masuk', function (Blueprint $table) {
            $table->dropForeign(['donatur_id']);
            $table->dropColumn(['donatur_id', 'donatur_nama']);
        });
    }
};
