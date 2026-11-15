<?php

namespace App\Services;

use App\Jobs\SendSmsReminderJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /** Day offsets after Day 0 that get a reminder. D0 is given at the clinic, so it is skipped. */
    public const REMINDER_OFFSETS = ['D3' => 3, 'D7' => 7, 'D28' => 28];

    /**
     * Doses due on $date, worked out from bite_section7_immunization (no dose_schedule needed).
     * Due date = dayN_date if that column is filled, otherwise day0_date + N days.
     * A dose whose dayN_date is already in the past (already given) never matches a future date.
     */
    public function dueDoses($date)
    {
        $date = Carbon::parse($date)->toDateString();
        $all  = collect();

        foreach (self::REMINDER_OFFSETS as $label => $n) {
            // $n comes from the constant above, never from user input
            $rows = DB::table('bite_section7_immunization as i')
                ->join('bite_cases as bc', 'bc.bite_case_id', '=', 'i.bite_case_id')
                ->join('patients as p', 'p.patient_id', '=', 'bc.patient_id')
                ->whereNotNull('i.day0_date')
                ->where('bc.category', '!=', 'I') // Category I needs no vaccine course
                ->whereRaw("COALESCE(i.day{$n}_date, DATE_ADD(i.day0_date, INTERVAL {$n} DAY)) = ?", [$date])
                ->select('bc.bite_case_id', 'bc.patient_id', 'p.patient_name', 'p.contact_num')
                ->get()
                ->map(function ($r) use ($label, $date) {
                    $r->dose_label = $label;
                    $r->sched_date = $date;
                    return $r;
                });

            $all = $all->concat($rows);
        }

        return $all;
    }

    /** Creates a Pending row in `sms` per due dose (skipping duplicates) and dispatches the job. */
    public function queueDueReminders($date): int
    {
        $queued = 0;

        foreach ($this->dueDoses($date) as $d) {
            $exists = DB::table('sms')
                ->where('bite_case_id', $d->bite_case_id)
                ->where('dose_label', $d->dose_label)
                ->where('sms_type', 'Reminder')
                ->whereIn('status', ['Pending', 'Sent'])
                ->exists();

            if ($exists) {
                continue;
            }

            // sched_id links to dose_schedule. Filled when a matching row exists, otherwise left NULL.
            $schedId = DB::table('dose_schedule')
                ->where('bite_case_id', $d->bite_case_id)
                ->where('dose_label', $d->dose_label)
                ->value('sched_id');

            $smsId = DB::table('sms')->insertGetId([
                'patient_id'   => $d->patient_id,
                'bite_case_id' => $d->bite_case_id,
                'sched_id'     => $schedId,
                'dose_label'   => $d->dose_label,
                'contact_num'  => $this->normalizePhone($d->contact_num),
                'sms_type'     => 'Reminder',
                'message'      => $this->buildMessage($d->patient_name, $d->dose_label, $d->sched_date),
                'status'       => 'Pending',
            ]);

            SendSmsReminderJob::dispatch($smsId);
            $queued++;
        }

        return $queued;
    }

    public function buildMessage(string $patientName, string $doseLabel, $schedDate): string
    {
        // patient_name is stored as "Last, First, MI." -> use first name only (less data on a lock screen)
        $parts = array_map('trim', explode(',', $patientName));
        $first = $parts[1] ?? $parts[0];

        $dose = 'Day ' . ltrim($doseLabel, 'D');
        $when = Carbon::parse($schedDate)->isToday() ? 'today' : 'tomorrow';

        return "Hi {$first}, this is a reminder from ABTC Insight: your {$dose} vaccine dose is scheduled {$when}. Please visit the clinic.";
    }

    /** Converts 09XXXXXXXXX / +63 9XXXXXXXXX / 9XXXXXXXXX to 639XXXXXXXXX. Check iProgSMS docs for the format they want. */
    public function normalizePhone(string $phone): string
    {
        $d = preg_replace('/\D+/', '', $phone);

        if (str_starts_with($d, '0'))  return '63' . substr($d, 1);
        if (strlen($d) === 10 && str_starts_with($d, '9')) return '63' . $d;
        return $d;
    }

    /** Sends one SMS. Returns ['ok' => bool, 'body' => string]. */
    public function send(string $phone, string $message): array
    {
        try {
            $response = Http::asForm()->timeout(15)->post(config('services.iprogsms.url'), [
                'api_token'    => config('services.iprogsms.token'),
                'message'      => $message,
                'phone_number' => $phone,
            ]);
        } catch (\Throwable $e) {
            Log::error('SMS exception: ' . $e->getMessage());
            return ['ok' => false, 'body' => $e->getMessage()];
        }

        $ok = $response->successful();
        $ok ? Log::info("SMS sent to {$phone}") : Log::error('SMS failed: ' . $response->body());

        return ['ok' => $ok, 'body' => $response->body()];
    }
}
