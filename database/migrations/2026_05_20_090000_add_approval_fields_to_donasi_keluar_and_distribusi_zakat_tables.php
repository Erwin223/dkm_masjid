<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->addApprovalColumns('donasi_keluar');
        $this->addApprovalColumns('distribusi_zakat');

        DB::table('donasi_keluar')->whereNull('status')->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        DB::table('distribusi_zakat')->whereNull('status')->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);
    }

    public function down(): void
    {
        $this->dropApprovalColumns('donasi_keluar');
        $this->dropApprovalColumns('distribusi_zakat');
    }

    private function addApprovalColumns(string $tableName): void
    {
        if (! Schema::hasTable($tableName)) {
            return;
        }

        if (! Schema::hasColumn($tableName, 'status')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->enum('status', ['pending', 'approved', 'rejected'])
                    ->nullable()
                    ->after('keterangan');
            });
        }

        if (! Schema::hasColumn($tableName, 'approved_by')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('approved_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete()
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
    }

    private function dropApprovalColumns(string $tableName): void
    {
        if (! Schema::hasTable($tableName)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            $foreignKey = $tableName . '_approved_by_foreign';
            if ($this->hasForeignKey($tableName, $foreignKey)) {
                $table->dropForeign($foreignKey);
            }
        });

        $columns = array_values(array_filter([
            Schema::hasColumn($tableName, 'status') ? 'status' : null,
            Schema::hasColumn($tableName, 'approved_by') ? 'approved_by' : null,
            Schema::hasColumn($tableName, 'approved_at') ? 'approved_at' : null,
            Schema::hasColumn($tableName, 'rejection_reason') ? 'rejection_reason' : null,
        ]));

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

        $database = $connection->getDatabaseName();
        $result = DB::selectOne(
            'SELECT CONSTRAINT_NAME
             FROM information_schema.TABLE_CONSTRAINTS
             WHERE TABLE_SCHEMA = ?
               AND TABLE_NAME = ?
               AND CONSTRAINT_NAME = ?
               AND CONSTRAINT_TYPE = ?',
            [$database, $tableName, $foreignKey, 'FOREIGN KEY']
        );

        return $result !== null;
    }
};
