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
        Schema::table('jadwal_imam', function (Blueprint $table) {
            $table->dropColumn('nama_imam');
            $table->unsignedBigInteger('imam_id')->nullable();
            $table->string('hari')->nullable();
            
            // Assuming data_imam table exists, we can add foreign key
            // $table->foreign('imam_id')->references('id')->on('data_imam')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_imam', function (Blueprint $table) {
            $table->string('nama_imam');
            $table->dropColumn('imam_id');
            $table->dropColumn('hari');
        });
    }
};
