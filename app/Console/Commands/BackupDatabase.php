<?php

namespace App\Console\Commands;

use App\Support\Audit;
use App\Support\DatabaseBackup;
use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database {--auto : Only run when the auto-backup schedule says it is due}';

    protected $description = 'Back up the database to storage/app/backups (manual, or on the auto-backup schedule)';

    public function handle(): int
    {
        if ($this->option('auto')) {
            $result = DatabaseBackup::runIfDue();
            $this->line($result ? "Auto-backup created: {$result['name']}" : 'Auto-backup not due.');
            return self::SUCCESS;
        }

        $result = DatabaseBackup::create('manual');
        Audit::log('backup_manual', "Backup created from the command line: {$result['name']} (" . DatabaseBackup::humanSize($result['size']) . ')', 'System');
        $this->info("Backup created: {$result['name']} ({$result['tables']} tables, {$result['rows']} rows)");

        return self::SUCCESS;
    }
}
