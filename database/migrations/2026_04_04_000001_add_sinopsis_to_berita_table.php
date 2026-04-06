<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            if (!Schema::hasColumn('berita', 'sinopsis')) {
                $table->text('sinopsis')->nullable()->after('judul');
            }
        });
    }

    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            if (Schema::hasColumn('berita', 'sinopsis')) {
                $table->dropColumn('sinopsis');
            }
        });
    }
};
