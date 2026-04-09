<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('muzakki', function (Blueprint $table) {
            if (! Schema::hasColumn('muzakki', 'email')) {
                $table->string('email')->nullable()->unique()->after('no_hp');
            }

            if (! Schema::hasColumn('muzakki', 'status')) {
                $table->enum('status', ['active', 'inactive', 'suspended'])
                    ->default('active')
                    ->after('email');
            }

            if (! Schema::hasColumn('muzakki', 'tahun_daftar')) {
                $table->year('tahun_daftar')
                    ->default(now()->year)
                    ->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('muzakki', function (Blueprint $table) {
            if (Schema::hasColumn('muzakki', 'tahun_daftar')) {
                $table->dropColumn('tahun_daftar');
            }

            if (Schema::hasColumn('muzakki', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('muzakki', 'email')) {
                $table->dropUnique(['email']);
                $table->dropColumn('email');
            }
        });
    }
};
