<?php

namespace App\Http\Controllers;

use App\Support\Audit;
use App\Support\BiteCaseImporter;
use App\Support\DatabaseBackup;
use App\Support\XlsxReader;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

/**
 * Admin > User & System Management tools: database backups, the auto-backup schedule,
 * the audit log and the server health check. These expose or change sensitive data
 * (a backup contains every table, password hashes included), so they are Admin-only.
 */
class SystemToolsController extends Controller
{
    private const TZ = 'Asia/Manila';

    private function admin(): void
    {
        abort_unless(Auth::check() && Auth::user()->role === 'Admin', 403, 'Please log in as an Admin to use the system tools.');
    }

    // ---------------------------------------------------------------- backups

    private function backupRows(): array
    {
        return array_map(fn ($f) => [
            'name' => $f['name'],
            'size' => DatabaseBackup::humanSize($f['size']),
            'modified' => $f['modified']->format('M d, Y g:i A'),
            'type' => $f['type'],
            'download' => route('admin.system.backups.download', $f['name']),
        ], DatabaseBackup::list());
    }

    public function backups(): JsonResponse
    {
        $this->admin();
        return response()->json(['backups' => $this->backupRows()]);
    }

    public function createBackup(): JsonResponse
    {
        $this->admin();

        try {
            $result = DatabaseBackup::create('manual');
        } catch (\Throwable $e) {
            Audit::log('backup_failed', 'Manual backup failed: ' . $e->getMessage());
            return response()->json(['message' => 'Backup failed: ' . $e->getMessage()], 500);
        }

        Audit::log('backup_manual', "Manual backup created: {$result['name']} (" . DatabaseBackup::humanSize($result['size']) . ", {$result['tables']} tables, {$result['rows']} rows)");

        return response()->json([
            'message' => 'Backup created (' . DatabaseBackup::humanSize($result['size']) . ', ' . $result['tables'] . ' tables).',
            'download' => route('admin.system.backups.download', $result['name']),
            'backups' => $this->backupRows(),
        ]);
    }

    public function downloadBackup(string $file)
    {
        $this->admin();
        $path = DatabaseBackup::resolve($file);
        abort_unless($path, 404);

        Audit::log('backup_downloaded', "Downloaded backup {$file}");

        return response()->download($path, $file, ['Content-Type' => 'application/sql']);
    }

    public function deleteBackup(string $file): JsonResponse
    {
        $this->admin();
        $path = DatabaseBackup::resolve($file);
        abort_unless($path, 404);

        File::delete($path);
        Audit::log('backup_deleted', "Deleted backup {$file}");

        return response()->json(['message' => 'Backup deleted.', 'backups' => $this->backupRows()]);
    }

    // ------------------------------------------------------------ auto-backup

    private function autoState(): array
    {
        $cfg = DatabaseBackup::config();
        $next = DatabaseBackup::nextRun($cfg);
        $last = $cfg['last_run'] ? Carbon::parse($cfg['last_run'])->setTimezone(self::TZ) : null;

        return [
            'enabled' => $cfg['enabled'],
            'frequency' => $cfg['frequency'],
            'day' => $cfg['day'],
            'time' => $cfg['time'],
            'keep' => $cfg['keep'],
            'last_run' => $last?->format('M d, Y g:i A'),
            'last_status' => $cfg['last_status'],
            'next_run' => $next ? ($next->lte(now(self::TZ)->addMinute()) ? 'Due now' : $next->format('D, M d, Y g:i A')) : null,
        ];
    }

    public function autoBackup(): JsonResponse
    {
        $this->admin();
        return response()->json($this->autoState());
    }

    public function saveAutoBackup(Request $request): JsonResponse
    {
        $this->admin();

        $data = $request->validate([
            'enabled' => 'required|boolean',
            'frequency' => 'required|in:daily,weekly',
            'day' => 'required|integer|between:0,6',
            'time' => ['required', 'regex:/^([01]\d|2[0-3]):[0-5]\d$/'],
            'keep' => 'required|integer|between:1,60',
        ]);

        DatabaseBackup::put('auto_backup.enabled', $data['enabled'] ? '1' : '0');
        DatabaseBackup::put('auto_backup.frequency', $data['frequency']);
        DatabaseBackup::put('auto_backup.day', (string) $data['day']);
        DatabaseBackup::put('auto_backup.time', $data['time']);
        DatabaseBackup::put('auto_backup.keep', (string) $data['keep']);
        // Saving re-arms the schedule: only moments after this point count as due
        DatabaseBackup::put('auto_backup.armed_at', now(self::TZ)->toIso8601String());

        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        Audit::log('backup_settings', $data['enabled']
            ? 'Auto-backup turned on: ' . ($data['frequency'] === 'weekly' ? 'every ' . $days[$data['day']] : 'daily') . " at {$data['time']}, keeping the last {$data['keep']}"
            : 'Auto-backup turned off');

        return response()->json(['message' => $data['enabled'] ? 'Auto-backup schedule saved.' : 'Auto-backup turned off.'] + $this->autoState());
    }

    // ------------------------------------------------------------- audit logs

    private const CATEGORIES = [
        'auth' => ['login', 'login_failed', 'logout'],
        'users' => ['user_created'],
        'backup' => ['backup_manual', 'backup_auto', 'backup_failed', 'backup_deleted', 'backup_downloaded', 'backup_settings'],
        'forecast' => ['forecast_saved'],
    ];

    private function auditQuery(Request $request)
    {
        $query = DB::table('audit_logs')->orderByDesc('id');

        $category = $request->query('category');
        if (isset(self::CATEGORIES[$category])) {
            $query->whereIn('action', self::CATEGORIES[$category]);
        }

        foreach (preg_split('/\s+/', trim((string) $request->query('q', '')), -1, PREG_SPLIT_NO_EMPTY) as $term) {
            $like = '%' . addcslashes($term, '%_\\') . '%';
            $query->where(fn ($q) => $q->where('username', 'like', $like)->orWhere('description', 'like', $like)->orWhere('action', 'like', $like)->orWhere('ip_address', 'like', $like));
        }

        return $query;
    }

    private function auditRow(object $row): array
    {
        return [
            // stored in the app timezone; shown in Asia/Manila
            'time' => Carbon::parse($row->created_at, config('app.timezone'))->setTimezone(self::TZ)->format('M d, Y g:i A'),
            'user' => $row->username ?: 'Unknown',
            'action' => $row->action,
            'description' => $row->description,
            'ip' => $row->ip_address,
        ];
    }

    public function auditLogs(Request $request): JsonResponse
    {
        $this->admin();
        $page = $this->auditQuery($request)->paginate(10)->withQueryString();

        return response()->json([
            'logs' => collect($page->items())->map(fn ($r) => $this->auditRow($r))->all(),
            'page' => $page->currentPage(),
            'last_page' => $page->lastPage(),
            'total' => $page->total(),
        ]);
    }

    public function exportAuditLogs(Request $request)
    {
        $this->admin();
        $rows = $this->auditQuery($request)->limit(5000)->get()->map(fn ($r) => $this->auditRow($r));

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Time (Asia/Manila)', 'User', 'Action', 'Details', 'IP address']);
            foreach ($rows as $r) {
                fputcsv($out, [$r['time'], $r['user'], $r['action'], $r['description'], $r['ip']]);
            }
            fclose($out);
        }, 'audit-logs-' . now(self::TZ)->format('Ymd-His') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    // ------------------------------------------------------ bite case import

    // The file is sent in small pieces (see importChunk) so it never runs into PHP's upload_max_filesize /
    // post_max_size - those limits apply to one request, and every piece is smaller than that.

    private function importDir(): string
    {
        $dir = storage_path('app/imports');
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        return $dir;
    }

    /** Path of a (possibly unfinished) upload; the id is a random 32-character hex string made by the browser. */
    private function importPath(?string $id): ?string
    {
        return is_string($id) && preg_match('/^[a-f0-9]{32}$/', $id) ? $this->importDir() . DIRECTORY_SEPARATOR . $id . '.part' : null;
    }

    /** Receives one piece of an upload and appends it to the file being assembled. */
    public function importChunk(Request $request): JsonResponse
    {
        $this->admin();

        $path = $this->importPath($request->input('upload_id'));
        $offset = $request->input('offset');
        $piece = $request->file('chunk');
        if (!$path || !ctype_digit((string) $offset)) {
            return response()->json(['message' => 'The upload could not be started. Please try again.'], 422);
        }
        if (!$piece || !$piece->isValid()) {
            return response()->json(['message' => 'A piece of the file did not arrive. Please try again.'], 422);
        }
        $offset = (int) $offset;

        if ($offset === 0) {
            // a fresh upload: also sweep up abandoned ones (older than a day)
            foreach (glob($this->importDir() . DIRECTORY_SEPARATOR . '*.part') ?: [] as $old) {
                if (filemtime($old) < time() - 86400) {
                    @unlink($old);
                }
            }
            @unlink($path);
        } elseif (!is_file($path) || filesize($path) !== $offset) {
            return response()->json(['message' => 'The upload pieces arrived out of order. Please try again.'], 409);
        }

        if ($offset + $piece->getSize() > BiteCaseImporter::MAX_FILE_BYTES) {
            @unlink($path);
            return response()->json(['message' => 'The file is larger than ' . round(BiteCaseImporter::MAX_FILE_BYTES / 1048576) . ' MB. Split it into smaller sheets.'], 422);
        }

        $in = fopen($piece->getRealPath(), 'rb');
        $out = fopen($path, 'ab');
        stream_copy_to_stream($in, $out);
        fclose($in);
        fclose($out);

        return response()->json(['received' => filesize($path)]);
    }

    /**
     * Imports a sheet that was uploaded with importChunk(). With check_only=1 nothing is saved (everything is rolled
     * back) and the uploaded file is kept, so the real import that follows does not need to upload it again.
     */
    public function importCases(Request $request): JsonResponse
    {
        $this->admin();

        // answered by hand: this app only renders JSON errors for api/* routes, so validate() would redirect
        $path = $this->importPath($request->input('upload_id'));
        $name = trim((string) $request->input('filename'));
        if (!$path || !is_file($path)) {
            return response()->json(['message' => 'The uploaded file was not found on the server. Please choose it again.'], 422);
        }
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (!in_array($ext, ['xlsx', 'csv'], true)) {
            @unlink($path);
            return response()->json(['message' => 'Only Excel (.xlsx) or .csv files can be imported. Older .xls files must be saved as .xlsx first.'], 422);
        }
        $name = mb_substr(basename(str_replace('\\', '/', $name)), 0, 120);

        $checkOnly = $request->boolean('check_only');

        try {
            $result = (new BiteCaseImporter($checkOnly))->import(new XlsxReader($path, $ext));
        } catch (\InvalidArgumentException|\RuntimeException $e) {
            @unlink($path);
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['message' => 'The import stopped because of an unexpected error. Nothing was saved.'], 500);
        }

        if (!$checkOnly) {
            @unlink($path);
        }

        $result['error_count'] = count($result['errors']);
        $result['errors'] = array_slice($result['errors'], 0, 100);
        $result['file'] = $name;

        if ($checkOnly) {
            Audit::log('import_check', "Checked bite case file \"{$name}\": {$result['imported']} rows ready, {$result['duplicates']} already in the system, {$result['failed']} with problems (nothing saved)");
        } else {
            Audit::log('import_cases', "Imported bite cases from \"{$name}\": {$result['imported']} saved, {$result['duplicates']} already in the system, {$result['failed']} skipped");
        }

        return response()->json($result);
    }

    /** CSV with the expected columns and one fictional example row (opens in Excel). */
    public function importTemplate()
    {
        $this->admin();

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");   // BOM so Excel reads the file as UTF-8
            fputcsv($out, BiteCaseImporter::templateHeaders());
            fputcsv($out, BiteCaseImporter::templateExample());
            fclose($out);
        }, 'animal-bite-cases-template.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    // ----------------------------------------------------------- health check

    public function health(): JsonResponse
    {
        $this->admin();
        $checks = [];
        $add = function (string $name, string $status, string $detail) use (&$checks) {
            $checks[] = ['name' => $name, 'status' => $status, 'detail' => $detail];
        };

        // Database
        try {
            $started = microtime(true);
            DB::select('SELECT 1');
            $ms = round((microtime(true) - $started) * 1000, 1);
            $version = DB::selectOne('SELECT VERSION() AS v')->v ?? '';
            $add('Database connection', $ms > 500 ? 'warn' : 'ok', DB::getDatabaseName() . " · MySQL {$version} · {$ms} ms");
            $tables = count(DB::select("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'"));
            $add('Database tables', $tables > 0 ? 'ok' : 'fail', "{$tables} tables");
        } catch (\Throwable $e) {
            $add('Database connection', 'fail', $e->getMessage());
        }

        // Pending migrations
        try {
            $ran = Schema::hasTable('migrations') ? DB::table('migrations')->pluck('migration')->all() : [];
            $files = array_map(fn ($f) => pathinfo($f, PATHINFO_FILENAME), glob(database_path('migrations/*.php')) ?: []);
            $pending = count(array_diff($files, $ran));
            $add('Migrations', $pending ? 'warn' : 'ok', $pending ? "{$pending} pending, run php artisan migrate" : 'Up to date');
        } catch (\Throwable $e) {
            $add('Migrations', 'warn', 'Could not check: ' . $e->getMessage());
        }

        // Disk space
        $free = @disk_free_space(storage_path());
        $total = @disk_total_space(storage_path());
        if ($free !== false && $total) {
            $pct = $free / $total * 100;
            $gb = $free / 1024 ** 3;
            $add('Disk space', $gb < 1 ? 'fail' : ($gb < 10 || $pct < 10 ? 'warn' : 'ok'), DatabaseBackup::humanSize((int) $free) . ' free of ' . DatabaseBackup::humanSize((int) $total) . ' (' . round($pct) . '%)');
        }

        // Writable folders
        $notWritable = array_filter(['storage/app' => storage_path('app'), 'storage/logs' => storage_path('logs'), 'storage/framework' => storage_path('framework'), 'bootstrap/cache' => base_path('bootstrap/cache')], fn ($p) => !is_writable($p));
        $add('Writable folders', $notWritable ? 'fail' : 'ok', $notWritable ? 'Not writable: ' . implode(', ', array_keys($notWritable)) : 'storage and bootstrap/cache are writable');

        // PHP
        $missing = array_filter(['pdo_mysql', 'mbstring', 'openssl', 'json', 'ctype', 'tokenizer'], fn ($e) => !extension_loaded($e));
        $add('PHP', $missing ? 'fail' : 'ok', 'PHP ' . PHP_VERSION . ' · Laravel ' . app()->version() . ($missing ? ' · missing extensions: ' . implode(', ', $missing) : ''));

        // Environment
        $add('Environment', config('app.debug') && app()->environment('production') ? 'warn' : 'ok',
            app()->environment() . (config('app.debug') ? ', debug mode on' : ', debug mode off'));

        // Backups
        $backups = DatabaseBackup::list();
        if (!$backups) {
            $add('Latest backup', 'warn', 'No backup yet. Use Manual Database Backup.');
        } else {
            $age = $backups[0]['modified']->diffInDays(now(self::TZ));
            $add('Latest backup', $age > 7 ? 'warn' : 'ok', $backups[0]['name'] . ' · ' . $backups[0]['modified']->diffForHumans());
        }

        $cfg = DatabaseBackup::config();
        if ($cfg['enabled']) {
            $overdue = DatabaseBackup::isDue($cfg);
            $add('Auto-backup', $overdue ? 'warn' : 'ok', $overdue ? 'Scheduled but not run yet (the scheduler may not be running)' : 'On, next run ' . optional(DatabaseBackup::nextRun($cfg))->format('M d, g:i A'));
        } else {
            $add('Auto-backup', 'warn', 'Turned off');
        }

        $worst = in_array('fail', array_column($checks, 'status'), true) ? 'fail' : (in_array('warn', array_column($checks, 'status'), true) ? 'warn' : 'ok');

        return response()->json([
            'overall' => $worst,
            'summary' => ['ok' => 'All systems healthy', 'warn' => 'Working, with items to look at', 'fail' => 'Problems found'][$worst],
            'checked_at' => now(self::TZ)->format('M d, Y g:i:s A'),
            'checks' => $checks,
        ]);
    }
}
