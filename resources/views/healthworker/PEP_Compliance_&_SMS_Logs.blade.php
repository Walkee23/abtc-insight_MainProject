<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>PEP Compliance Dashboard - Cebu City Health Center</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-low": "#f2f4f6",
                        "tertiary": "#7a3800",
                        "surface-variant": "#e0e3e5",
                        "primary-container": "#0b61bb",
                        "on-secondary-container": "#485f7e",
                        "error": "#ba1a1a",
                        "primary-fixed": "#d6e3ff",
                        "tertiary-fixed": "#ffdbc8",
                        "surface": "#f7f9fb",
                        "on-surface-variant": "#414751",
                        "surface-container-highest": "#e0e3e5",
                        "secondary-fixed": "#d3e4ff",
                        "primary-fixed-dim": "#a9c7ff",
                        "inverse-primary": "#a9c7ff",
                        "on-tertiary": "#ffffff",
                        "on-tertiary-container": "#ffd7c0",
                        "on-error-container": "#93000a",
                        "on-tertiary-fixed": "#311300",
                        "on-secondary-fixed-variant": "#314866",
                        "tertiary-fixed-dim": "#ffb689",
                        "secondary-fixed-dim": "#b1c8ec",
                        "secondary": "#49607f",
                        "error-container": "#ffdad6",
                        "on-primary-fixed-variant": "#00468c",
                        "on-primary-fixed": "#001b3d",
                        "tertiary-container": "#9e4b00",
                        "on-surface": "#191c1e",
                        "on-secondary-fixed": "#011c38",
                        "surface-tint": "#005db6",
                        "secondary-container": "#c1d9fd",
                        "on-background": "#191c1e",
                        "inverse-on-surface": "#eff1f3",
                        "primary": "#004a93",
                        "surface-container": "#eceef0",
                        "on-tertiary-fixed-variant": "#743500",
                        "on-primary": "#ffffff",
                        "surface-bright": "#f7f9fb",
                        "on-secondary": "#ffffff",
                        "on-error": "#ffffff",
                        "outline-variant": "#c1c7d3",
                        "outline": "#717782",
                        "on-primary-container": "#d0dfff",
                        "surface-dim": "#d8dadc",
                        "inverse-surface": "#2d3133",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-high": "#e6e8ea",
                        "background": "#f7f9fb"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "1rem",
                        "xl": "1.25rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Inter"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    }
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .ghost-border {
            border: 1px solid rgba(193, 199, 211, 0.15);
        }
    </style>
</head>

<body class="bg-surface text-on-surface">

<aside class="h-screen w-64 fixed left-0 top-0 bg-slate-100 dark:bg-slate-900 flex flex-col pt-6 pb-4 gap-2 z-50">
    <!-- Brand / Header Section -->
    <div class="px-6 mb-8">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white shadow-lg">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
            </div>
            <div>
                <h1 class="text-blue-900 dark:text-blue-50 font-bold text-sm tracking-tight leading-none">ABTC-Insight</h1>
            </div>
        </div>
    </div>

    <!-- Navigation sits right beneath it -->
    <nav class="space-y-1 px-4 dark:bg-slate-900">
        <!-- Dashboard (Inactive) -->
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
           href="{{ route('healthworker.dashboard') }}">
            <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
            <span class="font-['Inter'] text-sm tracking-wide">Dashboard</span>
        </a>

        <!-- Clinical Encoding (Inactive) -->
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
           href="{{ route('healthworker.clinical-encoding') }}">
            <span class="material-symbols-outlined" data-icon="medical_services">medical_services</span>
            <span class="font-['Inter'] text-sm tracking-wide">Clinical Encoding</span>
        </a>

        <!-- Treatment Tracker (Inactive) -->
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
           href="{{ route('healthworker.treatment-tracker') }}">
            <span class="material-symbols-outlined" data-icon="monitor_heart">monitor_heart</span>
            <span class="font-['Inter'] text-sm tracking-wide">Treatment Tracker</span>
        </a>

        <!-- Patient Database (Inactive) -->
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
           href="{{ route('healthworker.patient-database') }}">
            <span class="material-symbols-outlined" data-icon="database">database</span>
            <span class="font-['Inter'] text-sm tracking-wide">Patient Database</span>
        </a>

        <!-- Compliance / PEP Compliance (Active - Admin Style) -->
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-700 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600 translate-x-1 duration-150" 
           href="{{ route('healthworker.compliance') }}">
            <span class="material-symbols-outlined" data-icon="verified_user">verified_user</span>
            <span class="font-['Inter'] text-sm tracking-wide">PEP Compliance</span>
        </a>
    </nav>
</aside>
    <header
        class="fixed top-0 w-full h-16 bg-slate-50/85 dark:bg-slate-900/85 backdrop-blur-md shadow-sm shadow-blue-900/5 z-40">
        <div class="flex justify-between items-center px-8 h-16 w-full">
            <!-- Logo on the far left -->
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white shadow-md">
                    <span class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                </div>
                <h1 class="text-blue-900 dark:text-blue-50 font-bold text-sm tracking-tight leading-none">ABTC-Insight
                </h1>
            </div>
            <!-- Search Bar -->
            <div class="flex items-center flex-1 max-w-md ml-12">
                <div class="relative w-full group">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm group-focus-within:text-blue-700 transition-colors">search</span>
                    <input
                        class="w-full bg-slate-100 dark:bg-slate-800/50 border-none rounded-full py-2 pl-9 pr-4 text-xs focus:ring-2 focus:ring-blue-700/20 placeholder:text-slate-400 font-['Inter']"
                        placeholder="Search records..." type="text" />
                </div>
            </div>
            <!-- Right Side Actions (Notifications, Help, Vertical Divider, Profile) -->
            <div class="flex items-center gap-4">
                <button
                    class="relative w-9 h-9 flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all rounded-full">
                    <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-slate-50"></span>
                </button>
                <button
                    class="w-9 h-9 flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all rounded-full">
                    <span class="material-symbols-outlined" data-icon="help">help</span>
                </button>
                <div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-800 mx-2"></div>
                <div class="flex items-center gap-3 cursor-pointer group relative">
                    <div class="text-right hidden lg:block">
                        <p class="text-xs font-bold text-on-surface leading-tight font-['Inter']">{{ Auth::user()->full_name ?? 'Dr. Elena Santos' }}</p>
                        <p class="text-[10px] text-on-surface-variant font-['Inter']">{{ Auth::user()->role ?? 'Senior Health Worker' }}</p>
                    </div>
                    <img alt="Health Worker Profile"
                        class="w-9 h-9 rounded-full object-cover ring-2 ring-primary/10 group-hover:ring-primary/30 transition-all"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuAzuEzGuKhuDJKI44bu6U1YzFdI7z5disX1FjUVLwgq07xpkF1vi2q1RQg1lWnbbzx-97qaEaUE0wHwrsBEDnQdIf8whoLOPKyx4AYqvvB-lfqq-SS3OBugICvjWAE_JcAHe0Vi0CwgldGbMzdKqqq-JDxrvKkK7FcZlxsnNKgOhrLZQUJ0ev2rjCkC13g53yP7Tgqv7JJmgsQFbx1nOvxapzia3kkgWKs_FBVNJ7u5msUyUkju3OqnpM2i3ofnQDyojEEc-LEA3xlD" />
                    <div
                        class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="p-2">
                            <a href="#"
                                class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-[18px]">person</span>
                                My Profile
                            </a>
                            <div class="h-px bg-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors text-left">
                                    <span class="material-symbols-outlined text-[18px]">logout</span>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content Area -->
    <main class="ml-64 pt-24 min-h-screen bg-surface">
        <div class="p-8">
            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- PEP Completion -->
                <div
                    class="bg-surface-container-lowest p-5 rounded-lg ghost-border hover:shadow-md transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-primary/10 rounded-lg">
                            <span class="material-symbols-outlined text-primary" data-icon="task_alt">task_alt</span>
                        </div>
                        @if($stats['on_time_pct'] !== null)
                        <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full whitespace-nowrap">{{ $stats['on_time_pct'] }}% on time</span>
                        @else
                        <span class="text-xs font-medium text-on-surface-variant bg-surface-container-high px-2 py-1 rounded-full whitespace-nowrap">No doses yet</span>
                        @endif
                    </div>
                    <p class="text-display-md text-3xl font-black text-on-surface tracking-tight">{{ $stats['completion'] !== null ? rtrim(rtrim(number_format($stats['completion'], 1), '0'), '.') . '%' : '—' }}</p>
                    <p
                        class="text-label-sm text-[10px] font-bold uppercase text-on-surface-variant tracking-widest mt-1">
                        PEP Completion Rate</p>
                </div>
                <!-- SMS Success -->
                <div
                    class="bg-surface-container-lowest p-5 rounded-lg ghost-border hover:shadow-md transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-secondary/10 rounded-lg">
                            <span class="material-symbols-outlined text-secondary" data-icon="sms">sms</span>
                        </div>
                        <span
                            class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded-full italic whitespace-nowrap">{{ $stats['sms_total'] }} {{ \Illuminate\Support\Str::plural('message', $stats['sms_total']) }}</span>
                    </div>
                    <p class="text-display-md text-3xl font-black text-on-surface tracking-tight">{{ $stats['sms_rate'] !== null ? rtrim(rtrim(number_format($stats['sms_rate'], 1), '0'), '.') . '%' : '—' }}</p>
                    <p
                        class="text-label-sm text-[10px] font-bold uppercase text-on-surface-variant tracking-widest mt-1">
                        SMS Success Rate</p>
                </div>
                <!-- Pending Reminders -->
                <div
                    class="bg-surface-container-lowest p-5 rounded-lg ghost-border hover:shadow-md transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-tertiary-fixed/30 rounded-lg">
                            <span class="material-symbols-outlined text-tertiary"
                                data-icon="notification_important">notification_important</span>
                        </div>
                        <span
                            class="text-xs font-bold text-on-tertiary-fixed-variant bg-tertiary-fixed px-2 py-1 rounded-full whitespace-nowrap">Due within 24h</span>
                    </div>
                    <p class="text-display-md text-3xl font-black text-on-surface tracking-tight">{{ $stats['pending_reminders'] }}</p>
                    <p
                        class="text-label-sm text-[10px] font-bold uppercase text-on-surface-variant tracking-widest mt-1">
                        Pending Reminders</p>
                </div>
                <!-- Late Follow-ups -->
                <div
                    class="bg-surface-container-lowest p-5 rounded-lg ghost-border hover:shadow-md transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-error-container rounded-lg">
                            <span class="material-symbols-outlined text-error"
                                data-icon="priority_high">priority_high</span>
                        </div>
                        <span
                            class="text-xs font-bold text-on-error-container bg-error-container px-2 py-1 rounded-full whitespace-nowrap">{{ $stats['missed'] > 0 ? 'Needs follow-up' : 'All on track' }}</span>
                    </div>
                    <p class="text-display-md text-3xl font-black text-on-surface tracking-tight">{{ $stats['missed'] }}</p>
                    <p
                        class="text-label-sm text-[10px] font-bold uppercase text-on-surface-variant tracking-widest mt-1">
                        Missed Doses</p>
                </div>
            </div>
            <!-- Main Content: Tracking & Logs -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Left Column: PEP Compliance Tracking Table -->
                <div class="lg:col-span-2 bg-surface-container-lowest rounded-lg ghost-border p-6">
                    <div class="flex flex-wrap justify-between items-center gap-3 mb-6">
                        <h2 class="text-lg font-extrabold tracking-tight text-on-surface">PEP Compliance Tracking</h2>
                        <div class="flex gap-2">
                            @foreach(['all' => 'All', 'pending' => 'Pending', 'missed' => 'Missed', 'completed' => 'Completed'] as $key => $label)
                            <a href="{{ route('healthworker.compliance', array_filter(['q' => $search, 'status' => $key === 'all' ? null : $key])) }}"
                                class="px-3 py-1.5 text-xs font-semibold rounded-full transition-colors {{ $status === $key ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-high text-on-surface-variant hover:bg-surface-variant' }}">{{ $label }}</a>
                            @endforeach
                        </div>
                    </div>
                    <form method="GET" action="{{ route('healthworker.compliance') }}" class="mb-5">
                        @if($status !== 'all')
                        <input type="hidden" name="status" value="{{ $status }}" />
                        @endif
                        <div
                            class="flex items-center bg-surface-container-low rounded-lg px-3 py-2 border border-outline-variant/20 focus-within:border-primary/40 transition-all">
                            <span class="material-symbols-outlined text-outline text-[18px]">search</span>
                            <input id="complianceSearchInput" name="q" type="text" value="{{ $search }}"
                                class="bg-transparent border-none focus:ring-0 text-sm w-full py-0"
                                placeholder="Search by patient, ID, dose, label or barangay..." />
                            @if($search !== '')
                            <a href="{{ route('healthworker.compliance', $status !== 'all' ? ['status' => $status] : []) }}"
                                class="material-symbols-outlined text-outline text-[18px] hover:text-on-surface" title="Clear search">close</a>
                            @endif
                        </div>
                    </form>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left">
                                    <th
                                        class="pb-4 text-[11px] font-black uppercase text-on-surface-variant tracking-widest px-2 whitespace-nowrap">
                                        Patient Name</th>
                                    <th
                                        class="pb-4 text-[11px] font-black uppercase text-on-surface-variant tracking-widest px-2 whitespace-nowrap">
                                        Scheduled Dose</th>
                                    <th
                                        class="pb-4 text-[11px] font-black uppercase text-on-surface-variant tracking-widest px-2 whitespace-nowrap">
                                        Label</th>
                                    <th
                                        class="pb-4 text-[11px] font-black uppercase text-on-surface-variant tracking-widest px-2 whitespace-nowrap">
                                        Status</th>
                                    <th class="pb-4 px-2"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                @forelse($tracking as $dose)
                                @php
                                    $labelStyle = [
                                        'Standard' => 'bg-secondary-container text-on-secondary-container',
                                        'High Risk' => 'bg-blue-100 text-blue-700',
                                        'Booster' => 'bg-slate-100 text-slate-600',
                                    ][$dose->label];
                                    $statusStyle = [
                                        'Pending' => ['text-on-tertiary-fixed-variant bg-tertiary-fixed', 'bg-tertiary'],
                                        'Missed' => ['text-on-error-container bg-error-container', 'bg-error'],
                                        'Completed On Time' => ['text-green-700 bg-green-100', 'bg-green-700'],
                                        'Completed Late' => ['text-amber-800 bg-amber-100', 'bg-amber-600'],
                                    ][$dose->status];
                                @endphp
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="py-4 px-2">
                                        <p class="font-bold text-on-surface text-sm whitespace-nowrap">{{ $dose->patient_name }}</p>
                                        <p class="text-xs text-on-surface-variant whitespace-nowrap">ID: {{ $dose->patient_id }}</p>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span class="text-sm font-medium text-on-surface whitespace-nowrap">{{ $dose->dose_label }}</span>
                                        <p class="text-[11px] text-on-surface-variant whitespace-nowrap">{{ $dose->scheduled->format('M d, Y') }}@if($dose->actual && !$dose->actual->eq($dose->scheduled)) · given {{ $dose->actual->format('M d') }}@endif</p>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span
                                            class="text-xs {{ $labelStyle }} px-2 py-0.5 rounded font-semibold italic whitespace-nowrap">{{ $dose->label }}</span>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span
                                            class="flex items-center gap-1.5 text-xs font-bold {{ $statusStyle[0] }} px-3 py-1 rounded-full w-max whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $statusStyle[1] }}"></span>
                                            {{ $dose->status }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 text-right">
                                        <a href="{{ route('healthworker.ce-vii', ['bite_case_id' => $dose->bite_case_id]) }}"
                                            title="Open case" class="inline-flex p-1 hover:bg-surface-container-high rounded-full"><span
                                                class="material-symbols-outlined text-sm">open_in_new</span></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-sm text-on-surface-variant">
                                        @if($search !== '' || $status !== 'all')
                                        No doses match your search or filter.
                                        @else
                                        No scheduled doses yet. Doses appear here once a case has a Day 0 date in Section VII.
                                        @endif
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($tracking->total() > 0)
                    <div class="flex flex-wrap items-center justify-between gap-3 mt-5 pt-4 border-t border-outline-variant/10">
                        <p class="text-xs text-on-surface-variant">Showing <span class="font-bold text-on-surface">{{ $tracking->firstItem() }}</span>
                            to <span class="font-bold text-on-surface">{{ $tracking->lastItem() }}</span> of <span
                                class="font-bold text-on-surface">{{ $tracking->total() }}</span> doses</p>
                        @if($tracking->hasPages())
                        <div class="flex gap-2">
                            @if($tracking->onFirstPage())
                            <span class="p-1.5 rounded-lg bg-surface-container-low text-outline-variant cursor-not-allowed"><span class="material-symbols-outlined text-sm">chevron_left</span></span>
                            @else
                            <a href="{{ $tracking->previousPageUrl() }}" class="p-1.5 rounded-lg bg-surface-container-low text-outline hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined text-sm">chevron_left</span></a>
                            @endif
                            <span class="px-3 py-1.5 text-xs font-bold text-on-surface">{{ $tracking->currentPage() }} / {{ $tracking->lastPage() }}</span>
                            @if($tracking->hasMorePages())
                            <a href="{{ $tracking->nextPageUrl() }}" class="p-1.5 rounded-lg bg-surface-container-low text-outline hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined text-sm">chevron_right</span></a>
                            @else
                            <span class="p-1.5 rounded-lg bg-surface-container-low text-outline-variant cursor-not-allowed"><span class="material-symbols-outlined text-sm">chevron_right</span></span>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
                <!-- Right Column: SMS Outreach Logs -->
                <div class="bg-surface-container-lowest rounded-lg ghost-border p-6 flex flex-col">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-extrabold tracking-tight text-on-surface">SMS Outreach Logs</h2>
                        <span
                            class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full uppercase tracking-tighter">Live</span>
                    </div>
                    <div class="space-y-4 flex-1" id="smsList">
                        @forelse($smsLogs as $i => $log)
                        @php
                            $isSent = $log->status === 'Sent';
                            $isFailed = $log->status === 'Failed';
                        @endphp
                        <div class="sms-item {{ $i >= 5 ? 'hidden' : '' }} flex items-start gap-3 p-3 rounded-lg hover:bg-surface-container-low transition-colors">
                            <div class="mt-1 p-1.5 {{ $isSent ? 'bg-green-100' : ($isFailed ? 'bg-error-container' : 'bg-blue-100') }} rounded-full">
                                <span class="material-symbols-outlined text-xs {{ $isSent ? 'text-green-700' : ($isFailed ? 'text-error' : 'text-blue-700') }}"
                                    style="font-variation-settings: 'FILL' 1;">{{ $isSent ? 'check_circle' : ($isFailed ? 'error' : 'pending') }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between gap-2">
                                    <p class="text-sm font-bold text-on-surface truncate">{{ $log->contact_num }}</p>
                                    <span class="text-[10px] text-on-surface-variant whitespace-nowrap">{{ \Carbon\Carbon::parse($log->send_date)->diffForHumans(null, true, true) }} ago</span>
                                </div>
                                <p class="text-xs text-on-surface-variant font-medium">{{ $log->sms_type }}</p>
                                @if($isFailed && $log->error_detail)
                                <p class="text-[11px] text-error mt-0.5 truncate" title="{{ $log->error_detail }}">{{ $log->error_detail }}</p>
                                @endif
                                <span
                                    class="text-[9px] font-black {{ $isSent ? 'text-green-700' : ($isFailed ? 'text-error' : 'text-blue-600') }} uppercase tracking-widest mt-1 block">{{ $log->status }}</span>
                            </div>
                        </div>
                        @empty
                        <p class="text-xs text-on-surface-variant text-center py-8">No SMS sent yet. Reminders and late follow-ups will be logged here.</p>
                        @endforelse
                    </div>
                    @if($smsLogs->count() > 5)
                    <button type="button" id="smsToggle"
                        class="mt-6 w-full py-2.5 text-xs font-bold text-primary border border-primary/20 rounded-lg hover:bg-primary/5 transition-colors">
                        View All SMS History ({{ $smsLogs->count() }})
                    </button>
                    @endif
                </div>
            </div>
            <!-- Bottom Section: Performance by Barangay -->
            <div class="bg-surface-container-lowest rounded-lg ghost-border p-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
                    <div>
                        <h2 class="text-xl font-extrabold tracking-tighter text-on-surface">Compliance Performance by
                            Barangay</h2>
                        <p class="text-sm text-on-surface-variant">Share of due doses that were completed (on time or
                            late), by barangay</p>
                    </div>
                    <a href="{{ route('healthworker.compliance.export') }}"
                        class="px-6 py-3 bg-primary text-on-primary rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-primary/20 active:scale-95 transition-all whitespace-nowrap">
                        Download Full Compliance Report
                        <span class="material-symbols-outlined text-sm">download</span>
                    </a>
                </div>
                @if($barangays->isEmpty())
                <p class="text-sm text-on-surface-variant text-center py-6">No completed or missed doses yet to compare barangays.</p>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-8">
                    @foreach($barangays as $b)
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-on-surface">{{ $b->name }}</span>
                            <span class="text-xs font-black text-primary">{{ $b->pct }}%</span>
                        </div>
                        <div class="h-2 w-full bg-outline-variant/30 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-primary to-primary-container" style="width: {{ $b->pct }}%">
                            </div>
                        </div>
                        <p class="text-[10px] text-on-surface-variant mt-1">{{ $b->doses }} {{ \Illuminate\Support\Str::plural('dose', $b->doses) }} counted</p>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </main>
    <script>
        (function () {
            // Show / hide the older SMS entries
            const toggle = document.getElementById('smsToggle');
            if (toggle) {
                const older = document.querySelectorAll('#smsList .sms-item:nth-child(n+6)');
                const total = document.querySelectorAll('#smsList .sms-item').length;
                let open = false;
                toggle.addEventListener('click', () => {
                    open = !open;
                    older.forEach((el) => el.classList.toggle('hidden', !open));
                    toggle.textContent = open ? 'Show Less' : 'View All SMS History (' + total + ')';
                });
            }

            // The header search box searches the compliance table too (Enter to search)
            const headerSearch = document.querySelector('header input[type="text"]');
            const pageSearch = document.getElementById('complianceSearchInput');
            if (headerSearch && pageSearch) {
                headerSearch.value = pageSearch.value;
                headerSearch.addEventListener('keydown', (e) => {
                    if (e.key !== 'Enter') return;
                    pageSearch.value = headerSearch.value;
                    pageSearch.form.requestSubmit();
                });
            }
        })();
    </script>
</body>

</html>
