<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Sample data for the Admin forecasting and outbreak pages: walk-in registrations built from
 * database/data/animal_bite_2025_aggregate.csv (date, barangay, number of cases).
 *
 * The CSV is an anonymous aggregate of the 2025 animal bite cases spreadsheet. It holds no
 * names, birthdates or any other personal data, so every generated row is a labelled
 * placeholder ("SAMPLE-2025-000123"), kept at status 'Encoded' so it never shows up in the
 * Staff verification or Case Encoding lists.
 *
 * Run:  php artisan db:seed --class=ForecastSampleSeeder
 * Safe to run again: it replaces the previous sample rows. Normally used through
 *       php artisan data:reset --forecast-sample
 */
class ForecastSampleSeeder extends Seeder
{
    private const FILE = 'database/data/animal_bite_2025_aggregate.csv';
    private const PREFIX = 'SAMPLE-2025-';

    public function run(): void
    {
        $path = base_path(self::FILE);
        if (!is_file($path)) {
            $this->command?->error('Missing ' . self::FILE);
            return;
        }

        DB::table('inflow_general_particulars')->where('patient_name', 'like', self::PREFIX . '%')->delete();

        $handle = fopen($path, 'rb');
        fgetcsv($handle); // header

        $queueNo = [];   // per date: running queue number (the queue resets daily)
        $batch = [];
        $inserted = 0;
        $serial = 0;

        while (($line = fgetcsv($handle)) !== false) {
            [$date, $barangay, $count] = [$line[0], $line[1], (int) $line[2]];

            for ($i = 0; $i < $count; $i++) {
                $queueNo[$date] = ($queueNo[$date] ?? 0) + 1;
                $serial++;

                $batch[] = [
                    'queue_id' => 'N' . $queueNo[$date],
                    'queue_date' => $date,
                    'patient_name' => self::PREFIX . str_pad((string) $serial, 6, '0', STR_PAD_LEFT),
                    'age' => 0,
                    'sex' => 'Unknown',
                    'date_of_birth' => '2000-01-01',
                    'civil_status' => 'Single',
                    'contact_num' => '0000000000',
                    'barangay' => $barangay,
                    'philhealth_member' => 0,
                    'reg_date' => $date . ' 08:00:00',
                    'status' => 'Encoded',
                ];

                if (count($batch) >= 1000) {
                    DB::table('inflow_general_particulars')->insert($batch);
                    $inserted += count($batch);
                    $batch = [];
                }
            }
        }
        fclose($handle);

        if ($batch) {
            DB::table('inflow_general_particulars')->insert($batch);
            $inserted += count($batch);
        }

        $this->command?->info("Forecast sample data ready: {$inserted} registrations over " . count($queueNo) . ' days.');
    }
}
