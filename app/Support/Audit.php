<?php

namespace App\Support;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Writes a row to audit_logs. Logging must never break the action being logged,
 * so any failure (for example the table not being migrated yet) is swallowed.
 */
class Audit
{
    public static function log(string $action, string $description, ?string $username = null): void
    {
        try {
            $user = Auth::user();

            DB::table('audit_logs')->insert([
                'user_id' => $user->user_id ?? null,
                'username' => $user->username ?? $username,
                'action' => $action,
                'description' => $description,
                'ip_address' => request()->ip(),
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // intentionally ignored
        }
    }
}
