<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if ($this->indexExists('urls', 'urls_deletion_key_unique')) {
            Schema::table('urls', function (Blueprint $table) {
                $table->dropUnique('urls_deletion_key_unique');
            });
        }

        if (!$this->indexExists('urls', 'urls_deletion_key_index')) {
            Schema::table('urls', function (Blueprint $table) {
                $table->index('deletion_key');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if ($this->indexExists('urls', 'urls_deletion_key_index')) {
            Schema::table('urls', function (Blueprint $table) {
                $table->dropIndex('urls_deletion_key_index');
            });
        }

        if (!$this->indexExists('urls', 'urls_deletion_key_unique')) {
            Schema::table('urls', function (Blueprint $table) {
                $table->unique('deletion_key');
            });
        }
    }

    private function indexExists(string $table, string $indexName): bool
    {
        $connection = Schema::getConnection();
        $driver = $connection->getDriverName();

        if ($driver === 'mysql') {
            $rows = DB::select("SHOW INDEX FROM `{$table}` WHERE Key_name = ?", [$indexName]);
            return !empty($rows);
        }

        if ($driver === 'sqlite') {
            $rows = DB::select("PRAGMA index_list('{$table}')");
            foreach ($rows as $row) {
                if (($row->name ?? null) === $indexName) {
                    return true;
                }
            }
            return false;
        }

        return false;
    }
};
