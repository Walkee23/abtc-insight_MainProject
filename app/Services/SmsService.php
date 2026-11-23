<?php

namespace App\Services;

use App\Jobs\SendSmsReminderJob;
use App\Support\PepSchedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /** Gap between queued texts. 20 seconds = 3 texts per minute. Change it here. */
    public const SECONDS_BETWEEN_SMS = 20;

    /**
     * Every day that can get a reminder. D0 is given at the clinic, so it is skipped. Which of these a case really has
     * depends on its schedule (App\Support\PepSchedule::hasDaySql):
     *   Primary IM -> D3, D7, D14   Primary ID (or no route) -> D3, D7, D28   Booster -> D3
     */
    public const REMINDER_OFFSETS = ['D3' => 3, 'D7' => 7, 'D14' => 14, 'D28' => 28];

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
                ->whereRaw(PepSchedule::hasDaySql($n, 'i')) // only a dose that is part of this case's schedule
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

    /**
     * Doses MISSED: due on $dueDate (day0 + N days) and not recorded as given.
     * "Given" = Section VII dayN_date is filled, or dose_schedule has an actual_date for that dose.
     * Skipped: Category I, closed cases, and patients who already had a LATER dose (they are still attending).
     * To change what counts as "given", edit only this method.
     */
    public function missedDoses($dueDate)
    {
        $dueDate = Carbon::parse($dueDate)->toDateString();
        $all = collect();

        foreach (self::REMINDER_OFFSETS as $label => $n) {
            // $n and $m come from the constant above, never from user input
            $q = DB::table('bite_section7_immunization as i')
                ->join('bite_cases as bc', 'bc.bite_case_id', '=', 'i.bite_case_id')
                ->join('patients as p', 'p.patient_id', '=', 'bc.patient_id')
                ->whereNotNull('i.day0_date')
                ->where('bc.category', '!=', 'I')
                ->where(fn ($w) => $w->whereNull('bc.outcome')
                    ->orWhereNotIn('bc.outcome', ['Completed', 'Lost to Follow-up', 'Discharged (Cat. I)']))
                ->whereRaw(PepSchedule::hasDaySql($n, 'i')) // only a dose that is part of this case's schedule
                ->whereRaw("DATE_ADD(i.day0_date, INTERVAL {$n} DAY) = ?", [$dueDate])
                ->whereNull("i.day{$n}_date")
                ->whereNotExists(fn ($x) => $x->select(DB::raw(1))->from('dose_schedule as ds')
                    ->whereColumn('ds.bite_case_id', 'i.bite_case_id')
                    ->where('ds.dose_label', $label)
                    ->whereNotNull('ds.actual_date'));

            // a later dose of THIS case's course already given means the patient is still attending
            foreach (self::REMINDER_OFFSETS as $m) {
                if ($m > $n) $q->whereRaw('(NOT ' . PepSchedule::hasDaySql($m, 'i') . " OR i.day{$m}_date IS NULL)");
            }

            $rows = $q->select('bc.bite_case_id', 'bc.patient_id', 'p.patient_name', 'p.contact_num')->get()
                ->map(function ($r) use ($label, $dueDate) {
                    $r->dose_label = $label;
                    $r->sched_date = $dueDate;   // the date the dose was due
                    return $r;
                });

            $all = $all->concat($rows);
        }

        return $all;
    }

    public function queueDueReminders($date): int
    {
        return $this->queueBatch($this->dueDoses($date), 'Reminder');
    }

    /** Pass the date the dose was due (normally yesterday). */
    public function queueLateFollowUps($dueDate): int
    {
        return $this->queueBatch($this->missedDoses($dueDate), 'Late Follow-up');
    }

    /** Creates a Pending row in `sms` per dose (skipping duplicates) and dispatches the job. */
    private function queueBatch($doses, string $type): int
    {
        $queued = 0;

        foreach ($doses as $d) {
            $exists = DB::table('sms')
                ->where('bite_case_id', $d->bite_case_id)
                ->where('dose_label', $d->dose_label)
                ->where('sms_type', $type)
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
                'sms_type'     => $type,
                'message'      => $type === 'Reminder'
                    ? $this->buildMessage($d->patient_name, $d->dose_label, $d->sched_date)
                    : $this->buildLateMessage($d->patient_name, $d->dose_label, $d->sched_date),
                'status'       => 'Pending',
            ]);

            // Spread the texts out so the gateway isn't hit all at once
            SendSmsReminderJob::dispatch($smsId)
                ->delay(now()->addSeconds($queued * self::SECONDS_BETWEEN_SMS));
            $queued++;
        }

        return $queued;
    }

    public function buildLateMessage(string $patientName, string $doseLabel, $dueDate): string
    {
        $parts = array_map('trim', explode(',', $patientName));
        $first = $parts[1] ?? $parts[0];
        $dose  = 'Day ' . ltrim($doseLabel, 'D');
        $on    = Carbon::parse($dueDate)->format('M j');

        return "Hi {$first}, ABTC Insight noticed you missed your {$dose} vaccine dose on {$on}. Please visit the clinic as soon as possible to continue your treatment.";
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

        $body = $response->body();
        $ok   = $response->successful();

        // Some gateways answer HTTP 200 even when they reject the message,
        // so also treat an error-looking JSON body as a failure.
        $json = $response->json();
        if ($ok && is_array($json)) {
            $status = $json['status'] ?? null;
            if (! empty($json['error']) || ! empty($json['errors'])
                || (is_string($status) && in_array(strtolower($status), ['error', 'failed', 'fail'], true))
                || (is_numeric($status) && (int) $status >= 400)) {
                $ok = false;
            }
        }

        // The full API reply is always written to storage/logs/laravel.log
        $ok ? Log::info("SMS to {$phone} accepted: {$body}") : Log::error("SMS to {$phone} rejected: {$body}");

        return ['ok' => $ok, 'body' => $body];
    }
}