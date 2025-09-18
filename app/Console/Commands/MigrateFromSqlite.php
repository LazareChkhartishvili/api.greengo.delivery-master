<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateFromSqlite extends Command
{
    protected $signature = 'migrate:from-sqlite {sqlite_path}';
    protected $description = 'Migrate data from SQLite to current database (PostgreSQL)';

    public function handle()
    {
        $sqlitePath = $this->argument('sqlite_path');
        
        if (!file_exists($sqlitePath)) {
            $this->error("SQLite file not found: {$sqlitePath}");
            return 1;
        }

        // Add SQLite connection temporarily
        config(['database.connections.sqlite_source' => [
            'driver' => 'sqlite',
            'database' => $sqlitePath,
            'prefix' => '',
        ]]);

        $tables = [
            'user_status',
            'user_role', 
            'categorys',
            'cities',
            'companys',
            'product_categorys',
            'products',
            'users'
        ];

        foreach ($tables as $table) {
            $this->info("Migrating table: {$table}");
            
            try {
                // Check if table exists in SQLite
                $sourceExists = DB::connection('sqlite_source')
                    ->select("SELECT name FROM sqlite_master WHERE type='table' AND name='{$table}'");
                
                if (empty($sourceExists)) {
                    $this->warn("Table {$table} not found in SQLite, skipping...");
                    continue;
                }

                // Get data from SQLite
                $data = DB::connection('sqlite_source')->table($table)->get()->toArray();
                
                if (empty($data)) {
                    $this->warn("Table {$table} is empty, skipping...");
                    continue;
                }

                // Convert to array and insert into PostgreSQL
                $insertData = array_map(function($item) {
                    return (array) $item;
                }, $data);

                // Clear existing data in target table
                DB::table($table)->truncate();

                // Insert in batches
                $chunks = array_chunk($insertData, 100);
                foreach ($chunks as $chunk) {
                    DB::table($table)->insert($chunk);
                }

                $this->info("Migrated " . count($data) . " records from {$table}");
                
            } catch (\Exception $e) {
                $this->error("Error migrating {$table}: " . $e->getMessage());
                continue;
            }
        }

        $this->info("Migration completed!");
        return 0;
    }
}
