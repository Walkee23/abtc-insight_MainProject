<?php

namespace App\Jobs;

use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SendSmsReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = 300; // seconds between retries

    public function __construct(public int $smsId) {}

    public function handle(SmsService $sms): void
    {
        $row = DB::table('sms')->where('sms_id', $this->smsId)->first();

        if (! $row || $row->status === 'Sent') {
            return;
        }

        $r = $sms->send($row->contact_num, $row->message);

        DB::table('sms')->where('sms_id', $this->smsId)->update([
            'status'       => $r['ok'] ? 'Sent' : 'Failed',
            'error_detail' => $r['ok'] ? null : substr($r['body'], 0, 1000),
            'send_date'    => now(),
        ]);

        if (! $r['ok']) {
            throw new \RuntimeException('SMS failed: ' . $r['body']); // lets the queue retry
        }
    }
}
