<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>ABTC-Insight | IT SMS Monitor</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = { theme: { extend: { colors: { primary: '#004a93', surface: '#f7f9fb', error: '#ba1a1a' } } } }
    </script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
    <script src="{{ asset('js/custom-select.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    <script src="{{ asset('js/mobile-nav.js') }}" defer></script>
</head>
<body class="bg-surface text-slate-800 min-h-screen">

<header class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between">
    <div>
        <h1 class="font-black uppercase text-primary text-sm tracking-wider">ABTC-Insight</h1>
        <p class="text-xs text-slate-500">IT &middot; SMS Reminder Monitor</p>
    </div>
    <div class="flex items-center gap-4 text-sm">
        <span class="text-slate-600">{{ auth()->user()?->full_name ?? 'IT' }}</span>
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button class="px-3 py-1.5 rounded bg-slate-100 hover:bg-slate-200 font-semibold">Logout</button>
        </form>
    </div>
</header>

<main class="p-8 max-w-7xl mx-auto space-y-8">

    @if(session('status'))
        <div class="rounded-lg bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 text-sm">{{ session('status') }}</div>
    @endif
    @if($errors->any())
        <div class="rounded-lg bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">{{ $errors->first() }}</div>
    @endif

    {{-- Stats --}}
    <section class="grid grid-cols-2 md:grid-cols-6 gap-4">
        @foreach([
            ['Total SMS', $stats['total'], 'text-slate-800'],
            ['Sent', $stats['sent'], 'text-green-700'],
            ['Failed', $stats['failed'], 'text-error'],
            ['Pending', $stats['pending'], 'text-amber-600'],
            ['Jobs in queue', $stats['pending_jobs'], 'text-primary'],
            ['Failed jobs', $stats['failed_jobs'], 'text-error'],
        ] as [$label, $value, $color])
            <div class="bg-white rounded-xl border border-slate-200 p-4">
                <p class="text-xs uppercase tracking-wide text-slate-500">{{ $label }}</p>
                <p class="text-2xl font-extrabold {{ $color }}">{{ $value }}</p>
            </div>
        @endforeach
    </section>

    {{-- Test tools --}}
    <section class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <h2 class="font-bold mb-1">Send test SMS</h2>
            <p class="text-xs text-slate-500 mb-3">Checks your iProgSMS URL and token without touching patient data.</p>
            <form method="POST" action="{{ route('it.sms.test') }}" class="flex gap-2">
                @csrf
                <input name="phone" placeholder="09XXXXXXXXX" required class="flex-1 rounded border-slate-300 text-sm">
                <button class="px-4 py-2 rounded bg-primary text-white text-sm font-semibold">Send</button>
            </form>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <h2 class="font-bold mb-1">Run reminder check now</h2>
            <p class="text-xs text-slate-500 mb-3">Does what the 08:00 scheduler does: queues reminders for doses due tomorrow.</p>
            <form method="POST" action="{{ route('it.sms.run') }}">
                @csrf
                <button class="px-4 py-2 rounded bg-primary text-white text-sm font-semibold">Queue reminders</button>
            </form>
        </div>
    </section>

    {{-- Upcoming preview --}}
    <section class="bg-white rounded-xl border border-slate-200 p-5">
        <h2 class="font-bold mb-1">Due tomorrow ({{ today()->addDay()->format('M d, Y') }})</h2>
        <p class="text-xs text-slate-500 mb-3">D3 / D7 / D28 doses the scheduler will pick up, worked out from each case's Day 0 date in Section VII.</p>
        @if($upcoming->isEmpty())
            <p class="text-sm text-slate-500">Nothing due.</p>
        @else
            <table class="w-full text-sm">
                <tr class="text-left text-xs uppercase text-slate-500"><th class="py-1">Patient ID</th><th>Dose</th><th>Phone</th></tr>
                @foreach($upcoming as $u)
                    <tr class="border-t"><td class="py-1.5">{{ $u->patient_id }}</td><td>{{ $u->dose_label }}</td>
                        <td>{{ substr($u->contact_num, 0, 4) }}*****{{ substr($u->contact_num, -2) }}</td></tr>
                @endforeach
            </table>
        @endif
    </section>

    {{-- SMS log --}}
    <section class="bg-white rounded-xl border border-slate-200 p-5">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-bold">SMS log</h2>
            <form method="GET" class="flex gap-2 text-sm">
                <select name="status" class="rounded border-slate-300 text-sm">
                    <option value="">All status</option>
                    @foreach(['Pending','Sent','Failed'] as $s)
                        <option @selected(request('status') === $s)>{{ $s }}</option>
                    @endforeach
                </select>
                <select name="type" class="rounded border-slate-300 text-sm">
                    <option value="">All types</option>
                    @foreach(['Reminder','Late Follow-up','Test'] as $t)
                        <option @selected(request('type') === $t)>{{ $t }}</option>
                    @endforeach
                </select>
                <button class="px-3 py-1.5 rounded bg-slate-100 font-semibold">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <tr class="text-left text-xs uppercase text-slate-500">
                <th class="py-1">#</th><th>Sent at</th><th>Type</th><th>Dose</th><th>Case</th><th>Sched</th><th>Patient ID</th><th>Phone</th><th>Status</th><th>Error</th><th></th>
            </tr>
            @forelse($logs as $l)
                <tr class="border-t align-top">
                    <td class="py-1.5">{{ $l->sms_id }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($l->send_date)->format('M d H:i') }}</td>
                    <td>{{ $l->sms_type }}</td>
                    <td>{{ $l->dose_label ?? '-' }}</td>
                    <td>{{ $l->bite_case_id ?? '-' }}</td>
                    <td>{{ $l->sched_id ?? '-' }}</td>
                    <td class="text-xs">{{ $l->patient_id ?? '-' }}</td>
                    <td>{{ substr($l->contact_num, 0, 4) }}*****{{ substr($l->contact_num, -2) }}</td>
                    <td>
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold
                            {{ $l->status === 'Sent' ? 'bg-green-100 text-green-800' : ($l->status === 'Failed' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                            {{ $l->status }}
                        </span>
                    </td>
                    <td class="max-w-xs text-xs text-slate-500">
                        @if($l->error_detail)
                            <details>
                                <summary class="cursor-pointer">{{ \Illuminate\Support\Str::limit($l->error_detail, 40) }}</summary>
                                <p class="mt-1 break-words text-slate-700">{{ $l->error_detail }}</p>
                            </details>
                        @endif
                    </td>
                    <td>
                        @if($l->status === 'Failed' && $l->sms_type !== 'Test')
                            <form method="POST" action="{{ route('it.sms.retry', $l->sms_id) }}">@csrf
                                <button class="text-primary font-semibold text-xs hover:underline">Retry</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="11" class="py-4 text-center text-slate-500">No SMS records yet.</td></tr>
            @endforelse
        </table>
        </div>
        <div class="mt-4">{{ $logs->links() }}</div>
    </section>

    {{-- Failed jobs --}}
    @if($failedJobs->isNotEmpty())
    <section class="bg-white rounded-xl border border-slate-200 p-5">
        <h2 class="font-bold mb-3">Latest failed queue jobs</h2>
        @foreach($failedJobs as $j)
            <div class="border-t py-2 text-xs">
                <span class="font-semibold">#{{ $j->id }}</span> &middot; {{ $j->failed_at }}
                <p class="text-slate-500 mt-1">{{ \Illuminate\Support\Str::limit($j->exception, 200) }}</p>
            </div>
        @endforeach
        <p class="text-xs text-slate-500 mt-3">Retry all from the terminal: <code>php artisan queue:retry all</code></p>
    </section>
    @endif
</main>
@include('partials.idle-timeout')
</body>
</html>