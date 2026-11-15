<?php

namespace App\Http\Controllers;

use App\Jobs\SendSmsReminderJob;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItDashboardController extends Controller
{
    public function index(Request $request, SmsService $sms)
    {
        $logs = DB::table('sms as s')
            ->when($request->status, fn ($q, $v) => $q->where('s.status', $v))
            ->when($request->type, fn ($q, $v) => $q->where('s.sms_type', $v))
            ->orderByDesc('s.sms_id')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total'        => DB::table('sms')->count(),
            'sent'         => DB::table('sms')->where('status', 'Sent')->count(),
            'failed'       => DB::table('sms')->where('status', 'Failed')->count(),
            'pending'      => DB::table('sms')->where('status', 'Pending')->count(),
            'pending_jobs' => DB::table('jobs')->count(),
            'failed_jobs'  => DB::table('failed_jobs')->count(),
        ];

        // Preview of what the 08:00 scheduler would pick up for tomorrow
        $upcoming = $sms->dueDoses(today()->addDay());

        $failedJobs = DB::table('failed_jobs')->latest('failed_at')->limit(5)
            ->get(['id', 'queue', 'failed_at', 'exception']);

        return view('it.dashboard', compact('logs', 'stats', 'upcoming', 'failedJobs'));
    }

    /** Sends a real SMS to a number you type (no patient data involved). */
    public function sendTest(Request $request, SmsService $sms)
    {
        $data = $request->validate(['phone' => 'required|string|max:20']);

        $phone   = $sms->normalizePhone($data['phone']);
        $message = 'ABTC Insight test message. Please ignore.';
        $r       = $sms->send($phone, $message);

        DB::table('sms')->insert([
            'patient_id'   => null,
            'bite_case_id' => null,
            'sched_id'     => null,
            'contact_num'  => $phone,
            'sms_type'     => 'Test',
            'message'      => $message,
            'status'       => $r['ok'] ? 'Sent' : 'Failed',
            'error_detail' => $r['ok'] ? null : substr($r['body'], 0, 1000),
        ]);

        return back()->with('status', $r['ok'] ? 'Test SMS sent.' : 'Test SMS failed. See the log below.');
    }

    /** Same as the 08:00 scheduler, but on demand (for testing). */
    public function runNow(SmsService $sms)
    {
        $n = $sms->queueDueReminders(today()->addDay());

        return back()->with('status', "{$n} reminder(s) queued. Make sure `php artisan queue:work` is running.");
    }

    public function retry(int $smsId)
    {
        $row = DB::table('sms')->where('sms_id', $smsId)->where('status', 'Failed')->first();
        abort_unless($row, 404);

        DB::table('sms')->where('sms_id', $smsId)->update(['status' => 'Pending', 'error_detail' => null]);
        SendSmsReminderJob::dispatch($smsId);

        return back()->with('status', "Retry queued for SMS #{$smsId}.");
    }
}
