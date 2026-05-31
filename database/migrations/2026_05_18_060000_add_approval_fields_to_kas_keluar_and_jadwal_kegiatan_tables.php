<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $this->addApprovalColumns('kas_keluar', 'keterangan');
        $this->addApprovalColumns('jadwal_kegiatan', 'kas_keluar_id');
    }

    public function down(): void
    {
        $this->dropApprovalColumns('jadwal_kegiatan');
        $this->dropApprovalColumns('kas_keluar');
    }

    private function addApprovalColumns(string $tableName, string $afterColumn): void
    {
        if (! Schema::hasColumn($tableName, 'status')) {
            Schema::table($tableName, function (Blueprint $table) use ($afterColumn) {
                $table->enum('status', ['pending', 'approved', 'rejected'])
                    ->default('pending')
                    ->after($afterColumn);
            });
        }

        if (! Schema::hasColumn($tableName, 'approved_by')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('approved_by')
                    ->nullable()
                    ->after('status');
            });
        }

        if (! Schema::hasColumn($tableName, 'approved_at')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->timestamp('approved_at')
                    ->nullable()
                    ->after('approved_by');
            });
        }

        if (! Schema::hasColumn($tableName, 'rejection_reason')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->text('rejection_reason')
                    ->nullable()
                    ->after('approved_at');
            });
        }

        $foreignKeyName = $tableName.'_approved_by_foreign';

        if (!$this->hasForeignKey($tableName, $foreignKeyName)) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreign('approved_by')
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            });
        }
    }

    private function dropApprovalColumns(string $tableName): void
    {
        $foreignKeyName = $tableName.'_approved_by_foreign';

        if ($this->hasForeignKey($tableName, $foreignKeyName)) {
            Schema::table($tableName, function (Blueprint $table) use ($foreignKeyName) {
                $table->dropForeign($foreignKeyName);
            });
        }

        $columns = array_filter([
            Schema::hasColumn($tableName, 'status') ? 'status' : null,
            Schema::hasColumn($tableName, 'approved_by') ? 'approved_by' : null,
            Schema::hasColumn($tableName, 'approved_at') ? 'approved_at' : null,
            Schema::hasColumn($tableName, 'rejection_reason') ? 'rejection_reason' : null,
        ]);

        if ($columns !== []) {
            Schema::table($tableName, function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }

    private function hasForeignKey(string $tableName, string $foreignKey): bool
    {
        $connection = Schema::getConnection();
        $driver = $connection->getDriverName();

        if ($driver === 'sqlite') {
            return false;
        }

        $result = DB::selectOne(
            'SELECT CONSTRAINT_NAME
             FROM information_schema.TABLE_CONSTRAINTS
             WHERE TABLE_NAME = ?
               AND CONSTRAINT_NAME = ?
               AND CONSTRAINT_TYPE = ?',
            [$tableName, $foreignKey, 'FOREIGN KEY']
        );

        return $result !== null;
    }
};
