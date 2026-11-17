<?php

namespace App\Console\Commands;

use App\Support\Audit;
use App\Support\DatabaseBackup;
use Database\Seeders\ForecastSampleSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetData extends Command
{
    protected $signature = 'data:reset
        {--forecast-sample : After the reset, fill in the forecasting sample data}
        {--no-backup : Skip the safety backup (not recommended)}
        {--force : Do not ask for confirmation}';

    protected $description = 'Delete ALL data except the users table (and the migrations table), optionally loading the forecasting sample data';

    /** Never emptied: the accounts, and Laravel's own record of which migrations ran. */
    private const KEEP = ['users', 'migrations'];

    public function handle(): int
    {
        if (app()->environment('production') && !$this->option('force')) {
            $this->error('Refusing to run in production without --force.');
            return self::FAILURE;
        }

        $tables = [];
        foreach (DB::select("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'") as $row) {
            $name = current((array) $row);
            if (!in_array($name, self::KEEP, true)) {
                $tables[$name] = DB::table($name)->count();
            }
        }
        ksort($tables);

        $this->line('Database: <info>' . DB::getDatabaseName() . '</info>');
        $this->line('Kept: ' . implode(', ', self::KEEP));
        $this->table(['Table to empty', 'Rows'], array_map(fn ($t, $n) => [$t, $n], array_keys($tables), $tables));

        if (!$this->option('force') && !$this->confirm('This permanently deletes all of the rows above. Continue?', false)) {
            $this->info('Cancelled. Nothing was deleted.');
            return self::SUCCESS;
        }

        if (!$this->option('no-backup')) {
            $backup = DatabaseBackup::create('manual');
            $this->info("Backup saved: storage/app/backups/{$backup['name']} (" . DatabaseBackup::humanSize($backup['size']) . ')');
        }

        Schema::disableForeignKeyConstraints();
        try {
            foreach (array_keys($tables) as $table) {
                DB::table($table)->truncate();
            }
        } finally {
            Schema::enableForeignKeyConstraints();
        }
        $this->info(count($tables) . ' tables emptied. Users were kept.');
        Audit::log('data_reset', 'Emptied ' . count($tables) . ' tables (everything except users and migrations)' . ($this->option('forecast-sample') ? ' and loaded the forecasting sample data' : ''), 'System');

        if ($this->option('forecast-sample')) {
            $this->call('db:seed', ['--class' => ForecastSampleSeeder::class, '--force' => true]);
        }

        return self::SUCCESS;
    }
}
