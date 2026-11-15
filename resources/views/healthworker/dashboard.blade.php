<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Health Worker Dashboard - ABTC-Insight</title>
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
    </style>
</head>

<body class="bg-surface text-on-surface">
    @php $profileName = Auth::user()->name ?? (Auth::user()->full_name ?? 'Dr. Elena Santos'); @endphp

    <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-100 dark:bg-slate-900 flex flex-col pt-6 pb-4 gap-2 z-50">
        <!-- Brand / Header Section -->
        <div class="px-6 mb-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white shadow-lg">
                    <span class="material-symbols-outlined"
                        style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                </div>
                <div>
                    <h1 class="text-blue-900 dark:text-blue-50 font-bold text-sm tracking-tight leading-none">
                        ABTC-Insight</h1>
                </div>
            </div>
        </div>

        <!-- Navigation sits right beneath it -->
        <nav class="space-y-1 px-4 dark:bg-slate-900">
            <!-- Dashboard (Active - Admin Style) -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-700 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600 translate-x-1 duration-150"
                href="{{ route('healthworker.dashboard') }}">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span class="font-['Inter'] text-sm tracking-wide">Dashboard</span>
            </a>

            <!-- Clinical Encoding -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50"
                href="{{ route('healthworker.clinical-encoding') }}">
                <span class="material-symbols-outlined" data-icon="medical_services">medical_services</span>
                <span class="font-['Inter'] text-sm tracking-wide">Clinical Encoding</span>
            </a>

            <!-- Treatment Tracker -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50"
                href="{{ route('healthworker.treatment-tracker') }}">
                <span class="material-symbols-outlined" data-icon="monitor_heart">monitor_heart</span>
                <span class="font-['Inter'] text-sm tracking-wide">Treatment Tracker</span>
            </a>

            <!-- Patient Database -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50"
                href="{{ route('healthworker.patient-database') }}">
                <span class="material-symbols-outlined" data-icon="database">database</span>
                <span class="font-['Inter'] text-sm tracking-wide">Patient Database</span>
            </a>

            <!-- Compliance -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50"
                href="{{ route('healthworker.compliance') }}">
                <span class="material-symbols-outlined" data-icon="verified_user">verified_user</span>
                <span class="font-['Inter'] text-sm tracking-wide">Compliance</span>
            </a>
        </nav>
    </aside>

    <div class="mt-auto px-6 space-y-1 pt-6 border-t border-slate-200 dark:border-slate-800">
    </div>
    </aside>
    <!-- TopNavBar (Updated to match SCREEN_12 layout) -->
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
                        id="dashboardSearch" placeholder="Search for patients..." type="text" />
                </div>
            </div>
            <!-- Right Side Actions (Notifications, Help, Vertical Divider, Profile) -->
            <div class="flex items-center gap-4">
                <button
                    class="relative w-9 h-9 flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all rounded-full">
                    <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                    @if(count($reminders))
                    <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-slate-50"></span>
                    @endif
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
    <!-- Main Canvas -->
    <main class="ml-64 pt-24 px-10 pb-12 min-h-screen">
        @php
            // Greeting follows Cebu time (the app timezone is UTC); name = title + first name
            $hour = now('Asia/Manila')->hour;
            $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
            $nameParts = preg_split('/\s+/', trim($profileName));
            $titles = ['dr', 'dra', 'mr', 'ms', 'mrs', 'engr', 'atty', 'prof'];
            $isTitle = in_array(strtolower(rtrim($nameParts[0], '.')), $titles) && count($nameParts) > 1;
            $displayName = $isTitle ? $nameParts[0] . ' ' . $nameParts[1] : $nameParts[0];
        @endphp
        @if(session('status'))
        {{-- Toast: fixed bottom-right, auto-dismisses after 4s --}}
        <div id="statusToast" role="status"
            class="fixed bottom-6 right-8 z-50 max-w-sm flex items-center gap-3 bg-emerald-50 text-emerald-700 text-sm font-semibold pl-4 pr-2 py-3 rounded-lg shadow-lg shadow-blue-900/10 border border-emerald-200 transition-opacity duration-300">
            <span class="material-symbols-outlined text-[18px]">check_circle</span>
            <span class="flex-1">{{ session('status') }}</span>
            <button type="button" id="statusToastClose" aria-label="Dismiss"
                class="w-7 h-7 flex items-center justify-center rounded-full hover:bg-emerald-100 transition-colors">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>
        @endif
        <!-- Header Section -->
        <header class="mb-10">
            <h2 class="text-3xl font-extrabold tracking-tight text-on-surface mb-1">{{ $greeting }}, {{ $displayName }}</h2>
            <p class="text-on-surface-variant font-medium">Welcome back to Cebu City Health Center's Clinical Portal.
            </p>
        </header>
        <!-- Stats Bento Grid -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Stat Card 1 -->
            <a href="{{ route('healthworker.clinical-encoding') }}"
                class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group hover:bg-surface-bright transition-all duration-300 block">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-2 bg-blue-50 rounded-lg text-primary">
                        <span class="material-symbols-outlined" data-icon="pending_actions">pending_actions</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Encoding Phase</span>
                </div>
                <h3 class="text-label-md text-on-surface-variant mb-1">Pending Section VI-IX Encoding</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-extrabold tracking-tighter text-on-surface">{{ $stats['pending'] }}</span>
                    @if($stats['pending_cat3'] > 0)
                    <span class="text-xs font-semibold text-error px-2 py-0.5 bg-error-container/30 rounded-full">{{ $stats['pending_cat3'] }}
                        urgent {{ \Illuminate\Support\Str::plural('case', $stats['pending_cat3']) }}</span>
                    @else
                    <span class="text-xs font-semibold text-on-surface-variant px-2 py-0.5 bg-surface-container-high rounded-full">No urgent cases</span>
                    @endif
                </div>
                <div class="absolute -bottom-4 -right-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="clinical_notes">clinical_notes</span>
                </div>
            </a>
            <!-- Stat Card 2 -->
            <div
                class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group hover:bg-surface-bright transition-all duration-300">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-2 bg-orange-50 rounded-lg text-tertiary">
                        <span class="material-symbols-outlined" data-icon="vaccines">vaccines</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Active Cases</span>
                </div>
                <h3 class="text-label-md text-on-surface-variant mb-1">Active PEP Series</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-extrabold tracking-tighter text-on-surface">{{ $stats['active_pep'] }}</span>
                    <span
                        class="text-xs font-semibold text-on-secondary-container px-2 py-0.5 bg-secondary-container/20 rounded-full">+{{ $stats['started_today'] }}
                        Today</span>
                </div>
                <div class="absolute -bottom-4 -right-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="monitoring">monitoring</span>
                </div>
            </div>
            <!-- Stat Card 3 -->
            <div
                class="bg-primary p-6 rounded-xl relative overflow-hidden group shadow-lg shadow-blue-900/10 transition-all duration-300">
                <div class="flex items-start justify-between mb-4 text-primary-container">
                    <div class="p-2 bg-white/10 rounded-lg">
                        <span class="material-symbols-outlined" data-icon="verified_user"
                            style="font-variation-settings: 'FILL' 1;">verified_user</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-primary-fixed-dim">Validation
                        Hub</span>
                </div>
                <h3 class="text-label-md text-white/80 mb-1">Today's Verified Cases</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-extrabold tracking-tighter text-white">{{ $stats['verified_today'] }}</span>
                    <span class="text-xs font-semibold text-primary-fixed bg-white/10 px-2 py-0.5 rounded-full">{{ $stats['encoded_pct'] }}%
                        Encoded</span>
                </div>
                <div
                    class="absolute -bottom-4 -right-4 opacity-10 group-hover:opacity-20 transition-opacity text-white">
                    <span class="material-symbols-outlined text-8xl" data-icon="check_circle">check_circle</span>
                </div>
            </div>
        </section>
        <!-- Main Content Layout -->
        <div class="grid grid-cols-12 gap-8 items-start">
            <!-- Priority Clinical Queue -->
            <section class="col-span-12 xl:col-span-8 bg-surface-container-lowest rounded-xl p-8 overflow-hidden">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-on-surface">Priority Clinical Queue</h2>
                        <p class="text-sm text-on-surface-variant">Patients awaiting Section VI-IX Clinical Encoding</p>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" id="queueFilterToggle"
                            class="px-4 py-2 text-sm font-semibold bg-surface-container-high text-on-surface-variant rounded-full hover:bg-surface-variant transition-colors">Filter</button>
                        <button type="button" id="queueExport"
                            class="px-4 py-2 text-sm font-semibold bg-surface-container-high text-on-surface-variant rounded-full hover:bg-surface-variant transition-colors">Export</button>
                    </div>
                </div>
                <div id="queueFilterRow" class="hidden mb-6">
                    <div
                        class="flex items-center bg-surface-container-low rounded-lg px-3 py-2 border border-outline-variant/20 focus-within:border-primary/40 transition-all">
                        <span class="material-symbols-outlined text-outline text-[18px]">filter_list</span>
                        <input id="queueFilterInput" type="text"
                            class="bg-transparent border-none focus:ring-0 text-sm w-full py-0"
                            placeholder="Filter by name, queue no., patient ID, case, category or status..." />
                    </div>
                </div>
                <div class="overflow-x-auto no-scrollbar">
                    <table class="w-full min-w-[520px] text-left">
                        <thead>
                            <tr
                                class="text-[11px] uppercase tracking-widest text-slate-400 font-bold border-b border-surface-container-low">
                                <th class="pb-4 pl-4 pr-5 font-bold whitespace-nowrap">Queue No.</th>
                                <th class="pb-4 pr-5 font-bold whitespace-nowrap">Patient Name</th>
                                <th class="pb-4 pr-5 font-bold whitespace-nowrap">Priority</th>
                                <th class="pb-4 text-right pr-4 font-bold whitespace-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container-low" id="queueBody">
                            @foreach($queue as $row)
                            @php
                                $caseInfo = $row->case_number > 1 ? 'Returning Case #' . $row->case_number : 'New Exposure';
                                if ($row->category === 'III') {
                                    $priority = 'Urgent';
                                } elseif ($row->queue_id && str_starts_with($row->queue_id, 'P')) {
                                    $priority = 'Priority';
                                } else {
                                    $priority = 'Standard';
                                }
                            @endphp
                            <tr class="queue-row group hover:bg-surface/50 transition-colors"
                                data-export="{{ json_encode([$row->queue_id ?? '', $row->patient_name, $row->patient_id, $caseInfo, 'Cat ' . $row->category, $priority, $row->encoding_status]) }}">
                                <td class="py-5 pl-4 pr-5 align-middle">
                                    <span
                                        class="inline-block whitespace-nowrap text-sm font-bold {{ $priority === 'Urgent' ? 'text-blue-700 bg-blue-50' : 'text-slate-600 bg-slate-100' }} px-3 py-1 rounded-lg">{{ $row->queue_id ?? '—' }}</span>
                                </td>
                                <td class="py-5 pr-5 align-middle">
                                    <div>
                                        <p class="text-sm font-bold text-on-surface whitespace-nowrap">{{ $row->patient_name }}</p>
                                        <p class="text-[11px] text-on-surface-variant whitespace-nowrap">ID: {{ $row->patient_id }}</p>
                                        <p class="mt-1 text-[11px] font-semibold whitespace-nowrap {{ $row->category === 'III' ? 'text-error' : ($row->category === 'II' ? 'text-tertiary' : 'text-on-surface-variant') }}">{{ $caseInfo }} · Cat {{ $row->category }}</p>
                                    </div>
                                </td>
                                <td class="py-5 pr-5 align-middle">
                                    @if($priority === 'Urgent')
                                    <span
                                        class="inline-flex items-center gap-1.5 whitespace-nowrap px-3 py-1 rounded-full text-[11px] font-bold bg-error-container text-on-error-container">
                                        <span class="w-1.5 h-1.5 rounded-full bg-error"></span> Urgent
                                    </span>
                                    @elseif($priority === 'Priority')
                                    <span
                                        class="inline-flex items-center gap-1.5 whitespace-nowrap px-3 py-1 rounded-full text-[11px] font-bold bg-tertiary-fixed text-on-tertiary-fixed-variant">
                                        <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span> Priority
                                    </span>
                                    @else
                                    <span
                                        class="inline-flex items-center gap-1.5 whitespace-nowrap px-3 py-1 rounded-full text-[11px] font-bold bg-secondary-container text-on-secondary-container">
                                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Standard
                                    </span>
                                    @endif
                                </td>
                                <td class="py-5 text-right pr-4 align-middle">
                                    <a href="{{ route('healthworker.clinical-encoding', ['bite_case_id' => $row->bite_case_id]) }}"
                                        class="inline-block whitespace-nowrap text-xs font-bold text-primary hover:bg-primary/5 px-4 py-2 rounded-lg transition-colors border border-primary/10">{{ $row->encoding_status === 'In Progress' ? 'Continue Encoding' : 'Start Encoding' }}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p id="queueEmpty"
                        class="{{ $queue->isEmpty() ? '' : 'hidden' }} text-sm text-on-surface-variant text-center py-10">
                        {{ $queue->isEmpty() ? 'No pending cases. New cases appear here once Staff finishes Case Encoding.' : 'No cases match your filter.' }}</p>
                </div>
                @if($stats['pending'] > $queue->count())
                <div class="mt-6 text-center">
                    <a href="{{ route('healthworker.clinical-encoding') }}"
                        class="text-xs font-bold text-primary hover:underline">View all {{ $stats['pending'] }} pending cases</a>
                </div>
                @endif
            </section>
            <!-- Sidebar Analytics/Reminders -->
            <section class="col-span-12 xl:col-span-4 space-y-8">
                <!-- Clinical Reminders -->
                <div class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/15">
                    <h3 class="text-md font-bold text-on-surface flex items-center gap-2 mb-6">
                        <span class="material-symbols-outlined text-orange-600" data-icon="alarm">alarm</span>
                        Clinical Reminders
                    </h3>
                    <div class="space-y-4">
                        @forelse($reminders as $r)
                        @php $overdue = $r->overdue_by > 0; @endphp
                        <div
                            class="flex gap-4 p-3 bg-surface-container-lowest rounded-lg border-l-4 {{ $overdue ? 'border-error' : 'border-tertiary' }} shadow-sm shadow-black/5">
                            <div class="mt-1">
                                <span class="material-symbols-outlined {{ $overdue ? 'text-error' : 'text-tertiary' }} text-lg">{{ $overdue ? 'error' : 'schedule' }}</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-on-surface mb-0.5">{{ $overdue ? 'Overdue' : 'Due Today' }}: Day {{ $r->day }} Dose</p>
                                <p class="text-[11px] text-on-surface-variant leading-relaxed">{{ $r->patient_name }}
                                    {{ $overdue ? 'was due on ' . $r->due->format('M d, Y') . ' (' . $r->overdue_by . ' ' . \Illuminate\Support\Str::plural('day', $r->overdue_by) . ' ago) and has no dose recorded.' : 'is due for the Day ' . $r->day . ' PEP dose today.' }}</p>
                                <a href="{{ route('healthworker.ce-vii', ['bite_case_id' => $r->bite_case_id]) }}"
                                    class="mt-2 text-[10px] font-bold text-primary flex items-center">
                                    OPEN CASE <span class="material-symbols-outlined text-[12px] ml-1">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                        @empty
                        <p class="text-xs text-on-surface-variant text-center py-4">No dose reminders right now.</p>
                        @endforelse
                    </div>
                </div>
                <!-- Recent Activity Feed -->
                <div class="bg-surface-container-lowest rounded-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-md font-bold text-on-surface">Recent Activity</h3>
                        <span class="material-symbols-outlined text-slate-300" data-icon="history">history</span>
                    </div>
                    @if(count($activity))
                    <div
                        class="space-y-6 relative before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-[2px] before:bg-slate-100">
                        @foreach($activity as $a)
                        <div class="relative pl-8">
                            <span
                                class="absolute left-0 top-1 w-6 h-6 rounded-full {{ $a->type === 'dose' ? 'bg-green-100' : 'bg-blue-100' }} flex items-center justify-center border-4 border-white z-10">
                                <span class="material-symbols-outlined text-[12px] {{ $a->type === 'dose' ? 'text-green-600' : 'text-primary' }}">{{ $a->type === 'dose' ? 'vaccines' : 'person_add' }}</span>
                            </span>
                            <p class="text-[11px] text-on-surface-variant">{{ $a->at->isToday() && $a->at->format('H:i') !== '00:00' ? $a->at->diffForHumans() : $a->at->format('M d, Y') }}</p>
                            <p class="text-xs font-semibold text-on-surface">{{ $a->title }}</p>
                            <p class="text-[11px] text-slate-500">{{ $a->text }}</p>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-xs text-on-surface-variant text-center py-4">No recent activity yet.</p>
                    @endif
                </div>
            </section>
        </div>
    </main>
    <script>
        // Queue filter (the Filter button and the header search box share one filter) + CSV export
        (function () {
            const rows = Array.from(document.querySelectorAll('#queueBody .queue-row'));
            const empty = document.getElementById('queueEmpty');
            const filterRow = document.getElementById('queueFilterRow');
            const filterInput = document.getElementById('queueFilterInput');
            const headerSearch = document.getElementById('dashboardSearch');

            function apply(text) {
                const terms = text.toLowerCase().split(/\s+/).filter(Boolean);
                let shown = 0;
                rows.forEach((row) => {
                    const hay = row.textContent.toLowerCase().replace(/\s+/g, ' ');
                    const match = terms.every((t) => hay.includes(t));
                    row.classList.toggle('hidden', !match);
                    if (match) shown++;
                });
                if (rows.length) {
                    empty.textContent = 'No cases match your filter.';
                    empty.classList.toggle('hidden', shown > 0);
                }
            }

            document.getElementById('queueFilterToggle').addEventListener('click', () => {
                filterRow.classList.toggle('hidden');
                if (!filterRow.classList.contains('hidden')) filterInput.focus();
            });
            filterInput.addEventListener('input', () => {
                if (headerSearch) headerSearch.value = filterInput.value;
                apply(filterInput.value);
            });
            if (headerSearch) {
                headerSearch.addEventListener('input', () => {
                    filterInput.value = headerSearch.value;
                    if (headerSearch.value) filterRow.classList.remove('hidden');
                    apply(headerSearch.value);
                });
            }

            document.getElementById('queueExport').addEventListener('click', () => {
                const visible = rows.filter((r) => !r.classList.contains('hidden'));
                if (!visible.length) return;
                const cell = (v) => '"' + String(v).replace(/"/g, '""') + '"';
                const lines = [['Queue No.', 'Patient Name', 'Patient ID', 'Case Info', 'Category', 'Priority Type', 'Status']]
                    .concat(visible.map((r) => JSON.parse(r.dataset.export)))
                    .map((cols) => cols.map(cell).join(','));
                const blob = new Blob([lines.join('\r\n')], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'priority-clinical-queue-' + new Date().toISOString().slice(0, 10) + '.csv';
                document.body.appendChild(link);
                link.click();
                link.remove();
                URL.revokeObjectURL(link.href);
            });
        })();
    </script>
    <script>
        // Status toast: closes on the X button or by itself after 4 seconds
        (function () {
            const toast = document.getElementById('statusToast');
            if (!toast) return;
            const dismiss = () => {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.remove(), 300);
            };
            document.getElementById('statusToastClose').addEventListener('click', dismiss);
            setTimeout(dismiss, 4000);
        })();
    </script>
</body>

</html>
