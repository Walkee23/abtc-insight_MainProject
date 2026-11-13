<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Database backups as plain .sql files in storage/app/backups, written in PHP (no
 * mysqldump needed), plus the auto-backup schedule kept in system_settings.
 */
class DatabaseBackup
{
    private const TZ = 'Asia/Manila';

    public static function directory(): string
    {
        $dir = storage_path('app/backups');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        return $dir;
    }

    // ------------------------------------------------------------------ files

    /** Writes a full dump (structure + data of every table) and returns its details. */
    public static function create(string $type = 'manual'): array
    {
        $name = DB::getDatabaseName() . '_' . now(self::TZ)->format('Ymd_His') . ($type === 'auto' ? '_auto' : '') . '.sql';
        $path = self::directory() . DIRECTORY_SEPARATOR . $name;

        $handle = fopen($path, 'wb');
        if (!$handle) {
            throw new \RuntimeException('Could not write to the backup folder.');
        }

        $pdo = DB::connection()->getPdo();
        $tables = [];
        foreach (DB::select("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'") as $row) {
            $tables[] = current((array) $row);
        }

        $rowCount = 0;
        try {
            fwrite($handle, "-- ABTC-Insight database backup\n-- Database: " . DB::getDatabaseName() . "\n-- Created: " . now(self::TZ)->toDateTimeString() . " (Asia/Manila)\n\n");
            fwrite($handle, "SET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS=0;\n\n");

            foreach ($tables as $table) {
                $create = (array) DB::select('SHOW CREATE TABLE `' . str_replace('`', '``', $table) . '`')[0];
                fwrite($handle, "-- Table: {$table}\nDROP TABLE IF EXISTS `{$table}`;\n" . $create['Create Table'] . ";\n\n");

                $batch = [];
                $columns = null;
                foreach (DB::table($table)->cursor() as $record) {
                    $record = (array) $record;
                    $columns ??= '`' . implode('`, `', array_keys($record)) . '`';
                    $batch[] = '(' . implode(', ', array_map(fn ($v) => self::literal($pdo, $v), $record)) . ')';
                    $rowCount++;

                    if (count($batch) >= 100) {
                        fwrite($handle, "INSERT INTO `{$table}` ({$columns}) VALUES\n" . implode(",\n", $batch) . ";\n");
                        $batch = [];
                    }
                }
                if ($batch) {
                    fwrite($handle, "INSERT INTO `{$table}` ({$columns}) VALUES\n" . implode(",\n", $batch) . ";\n");
                }
                fwrite($handle, "\n");
            }

            fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
        } catch (\Throwable $e) {
            fclose($handle);
            @unlink($path);
            throw $e;
        }
        fclose($handle);

        return ['name' => $name, 'size' => filesize($path), 'tables' => count($tables), 'rows' => $rowCount];
    }

    private static function literal(\PDO $pdo, mixed $value): string
    {
        if ($value === null) {
            return 'NULL';
        }
        if (is_bool($value)) {
            return $value ? '1' : '0';
        }
        if (is_int($value) || is_float($value)) {
            return (string) $value;
        }
        return $pdo->quote((string) $value);
    }

    /** Backups, newest first. */
    public static function list(): array
    {
        $files = glob(self::directory() . DIRECTORY_SEPARATOR . '*.sql') ?: [];
        usort($files, fn ($a, $b) => filemtime($b) <=> filemtime($a));

        return array_map(fn ($file) => [
            'name' => basename($file),
            'size' => filesize($file),
            'modified' => Carbon::createFromTimestamp(filemtime($file), self::TZ),
            'type' => str_ends_with($file, '_auto.sql') ? 'auto' : 'manual',
        ], $files);
    }

    /** Full path for a backup file name, or null if the name is not one of ours. */
    public static function resolve(string $name): ?string
    {
        if (!preg_match('/^[A-Za-z0-9_\-]+\.sql$/', $name)) {
            return null;
        }
        $path = self::directory() . DIRECTORY_SEPARATOR . $name;
        return is_file($path) ? $path : null;
    }

    /** Keeps the newest $keep automatic backups; manual ones are never removed. */
    public static function prune(int $keep): int
    {
        $auto = array_values(array_filter(self::list(), fn ($f) => $f['type'] === 'auto'));
        $removed = 0;
        foreach (array_slice($auto, max(1, $keep)) as $file) {
            if (@unlink(self::directory() . DIRECTORY_SEPARATOR . $file['name'])) {
                $removed++;
            }
        }
        return $removed;
    }

    public static function humanSize(int $bytes): string
    {
        foreach (['B', 'KB', 'MB', 'GB'] as $i => $unit) {
            if ($bytes < 1024 || $unit === 'GB') {
                return ($i === 0 ? $bytes : number_format($bytes, 1)) . ' ' . $unit;
            }
            $bytes /= 1024;
        }
    }

    // --------------------------------------------------------------- settings

    public static function setting(string $key, ?string $default = null): ?string
    {
        $value = DB::table('system_settings')->where('setting_key', $key)->value('setting_value');
        return $value ?? $default;
    }

    public static function put(string $key, ?string $value): void
    {
        DB::table('system_settings')->updateOrInsert(['setting_key' => $key], ['setting_value' => $value]);
    }

    /** The auto-backup configuration with defaults filled in. */
    public static function config(): array
    {
        return [
            'enabled' => self::setting('auto_backup.enabled', '0') === '1',
            'frequency' => self::setting('auto_backup.frequency', 'daily'),
            'day' => (int) self::setting('auto_backup.day', '0'),   // 0 = Sunday ... 6 = Saturday
            'time' => self::setting('auto_backup.time', '02:00'),
            'keep' => (int) self::setting('auto_backup.keep', '7'),
            'armed_at' => self::setting('auto_backup.armed_at'),
            'last_run' => self::setting('auto_backup.last_run'),
            'last_status' => self::setting('auto_backup.last_status'),
        ];
    }

    private static function parse(?string $value): ?Carbon
    {
        return $value ? Carbon::parse($value)->setTimezone(self::TZ) : null;
    }

    /** The most recent scheduled moment that is not in the future. */
    private static function latestSlot(array $cfg, Carbon $now): Carbon
    {
        [$h, $m] = array_map('intval', explode(':', $cfg['time']));
        $slot = $now->copy()->setTime($h, $m, 0);

        if ($cfg['frequency'] === 'weekly') {
            $slot->subDays(($now->dayOfWeek - $cfg['day'] + 7) % 7);
            if ($slot->gt($now)) {
                $slot->subDays(7);
            }
        } elseif ($slot->gt($now)) {
            $slot->subDay();
        }

        return $slot;
    }

    /** Due when a scheduled moment has passed since the schedule was saved and since the last run. */
    public static function isDue(?array $cfg = null): bool
    {
        $cfg ??= self::config();
        if (!$cfg['enabled']) {
            return false;
        }

        $slot = self::latestSlot($cfg, now(self::TZ));
        $armed = self::parse($cfg['armed_at']);
        $last = self::parse($cfg['last_run']);

        return (!$armed || $slot->gt($armed)) && (!$last || $slot->gt($last));
    }

    public static function nextRun(?array $cfg = null): ?Carbon
    {
        $cfg ??= self::config();
        if (!$cfg['enabled']) {
            return null;
        }

        $slot = self::latestSlot($cfg, now(self::TZ));
        return self::isDue($cfg) ? now(self::TZ) : $slot->copy()->addDays($cfg['frequency'] === 'weekly' ? 7 : 1);
    }

    /** Runs the automatic backup if it is due. Used by the scheduler and the Admin page. */
    public static function runIfDue(): ?array
    {
        if (!self::isDue()) {
            return null;
        }

        $keep = self::config()['keep'];
        // Mark the run first so a failing backup is not retried on every request
        self::put('auto_backup.last_run', now(self::TZ)->toIso8601String());

        try {
            $result = self::create('auto');
            $removed = self::prune($keep);
            self::put('auto_backup.last_status', 'ok');
            Audit::log('backup_auto', "Automatic backup created: {$result['name']} (" . self::humanSize($result['size']) . ', ' . $result['tables'] . ' tables)' . ($removed ? "; removed {$removed} old backup(s)" : ''), 'System');
            return $result;
        } catch (\Throwable $e) {
            self::put('auto_backup.last_status', 'failed: ' . $e->getMessage());
            Audit::log('backup_failed', 'Automatic backup failed: ' . $e->getMessage(), 'System');
            return null;
        }
    }
}
