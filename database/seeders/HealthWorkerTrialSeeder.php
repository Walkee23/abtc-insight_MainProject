<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Trial accounts for Health Workers only (role "Health Worker", the value AuthController
 * redirects to /healthworker/dashboard). For development and demos, not for production.
 *
 * Run:  php artisan db:seed --class=HealthWorkerTrialSeeder
 * Safe to run again: it updates the same usernames instead of adding duplicates.
 */
class HealthWorkerTrialSeeder extends Seeder
{
    /** Shared password for all trial accounts. Change it here and re-run the seeder. */
    private const TRIAL_PASSWORD = 'HwTrial#2026';

    private const ACCOUNTS = [
        ['username' => 'hw_trial1', 'full_name' => 'Dr. Maria Lopez'],
        ['username' => 'hw_trial2', 'full_name' => 'Dr. Jose Ramirez'],
        ['username' => 'hw_trial3', 'full_name' => 'Dr. Ana Cruz'],
    ];

    public function run(): void
    {
        foreach (self::ACCOUNTS as $account) {
            $values = [
                'password_hash' => Hash::make(self::TRIAL_PASSWORD),
                'full_name' => $account['full_name'],
                'role' => 'Health Worker',
                'is_active' => 1,
            ];

            if (DB::table('users')->where('username', $account['username'])->exists()) {
                DB::table('users')->where('username', $account['username'])->update($values);
            } else {
                DB::table('users')->insert($values + ['username' => $account['username'], 'created_at' => now()]);
            }

            $this->command?->info("Trial health worker ready: {$account['username']} ({$account['full_name']})");
        }
    }
}
