<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Treatment Tracker | ABTC-Insight</title>
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

            <!-- Treatment Tracker (Active - Admin Style) -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-700 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600 translate-x-1 duration-150" 
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
    <!-- MAIN CONTENT AREA -->
    <main class="ml-64 pt-24 min-h-screen flex flex-col relative">
        <!-- DASHBOARD BODY -->
        <div class="p-8 space-y-8">
            <!-- HEADER SECTION -->
            <div class="flex justify-between items-end">
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight text-on-surface">Active Treatment Tracker</h2>
                    <p class="text-on-surface-variant font-medium mt-1">Monitor and manage ongoing PEP series for
                        registered patients.</p>
                </div>
            </div>
            <!-- BENTO STATS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-black uppercase tracking-widest text-slate-400 mb-1">Total Active
                                Courses</p>
                            <h3 class="text-4xl font-black text-blue-900 tracking-tighter">{{ $stats['active'] }}</h3>
                        </div>
                        <div
                            class="p-3 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined">person_search</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs font-semibold {{ $stats['new_this_week'] > 0 ? 'text-emerald-600' : 'text-slate-500' }}">
                        <span class="material-symbols-outlined text-sm">{{ $stats['new_this_week'] > 0 ? 'trending_up' : 'remove' }}</span>
                        <span>{{ $stats['new_this_week'] > 0 ? '+' . $stats['new_this_week'] . ' started this week' : 'No new courses this week' }}</span>
                    </div>
                </div>
                <div
                    class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-black uppercase tracking-widest text-slate-400 mb-1">Due for
                                Vaccination Today</p>
                            <h3 class="text-4xl font-black text-on-tertiary-fixed-variant tracking-tighter">{{ $stats['due_today'] }}</h3>
                        </div>
                        <div
                            class="p-3 bg-tertiary-fixed text-on-tertiary-fixed-variant rounded-xl group-hover:bg-tertiary group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined">event_repeat</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs font-semibold text-slate-500">
                        <span class="material-symbols-outlined text-sm">schedule</span>
                        <span>As of {{ now('Asia/Manila')->format('g:i A') }}</span>
                    </div>
                </div>
                <div
                    class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-black uppercase tracking-widest text-slate-400 mb-1">Missed Doses</p>
                            <h3 class="text-4xl font-black text-error tracking-tighter">{{ str_pad($stats['missed'], 2, '0', STR_PAD_LEFT) }}</h3>
                        </div>
                        <div
                            class="p-3 bg-error-container text-on-error-container rounded-xl group-hover:bg-error group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined">warning</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs font-semibold {{ $stats['missed'] > 0 ? 'text-error' : 'text-emerald-600' }}">
                        <span class="material-symbols-outlined text-sm">{{ $stats['missed'] > 0 ? 'error' : 'check_circle' }}</span>
                        <span>{{ $stats['missed'] > 0 ? $stats['missed_patients'] . ' ' . \Illuminate\Support\Str::plural('patient', $stats['missed_patients']) . ' need urgent follow-up' : 'All doses are on schedule' }}</span>
                    </div>
                </div>
            </div>
            <!-- FILTERS & TABLE SECTION -->
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm overflow-hidden">
                <!-- Filter Row -->
                <form id="trackerFilters" method="GET" action="{{ route('healthworker.treatment-tracker') }}"
                    class="p-6 bg-surface-container-low flex flex-wrap gap-4 items-center justify-between">
                    <input type="hidden" name="q" id="trackerSearch" value="{{ $search }}" />
                    <div class="flex flex-wrap gap-4 items-center">
                        <div class="relative min-w-[200px]">
                            <select name="barangay" onchange="this.form.submit()"
                                class="appearance-none w-full bg-white border-none rounded-lg px-4 py-2 pr-10 text-sm font-semibold text-slate-600 focus:ring-2 focus:ring-blue-500/10 shadow-sm cursor-pointer">
                                <option value="">Filter by Barangay</option>
                                @foreach($barangays as $b)
                                <option value="{{ $b }}" {{ $barangay === $b ? 'selected' : '' }}>{{ $b }}</option>
                                @endforeach
                            </select>
                            <span
                                class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                        </div>
                        <div class="relative min-w-[200px]">
                            <select name="status" onchange="this.form.submit()"
                                class="appearance-none w-full bg-white border-none rounded-lg px-4 py-2 pr-10 text-sm font-semibold text-slate-600 focus:ring-2 focus:ring-blue-500/10 shadow-sm cursor-pointer">
                                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Dose Status: All</option>
                                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active (On Track)</option>
                                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="missed" {{ $status === 'missed' ? 'selected' : '' }}>Missed (Late)</option>
                            </select>
                            <span
                                class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                        </div>
                        @if($search !== '')
                        <a href="{{ route('healthworker.treatment-tracker', array_filter(['barangay' => $barangay, 'status' => $status === 'all' ? null : $status])) }}"
                            class="inline-flex items-center gap-1.5 bg-white rounded-full pl-3 pr-2 py-1.5 text-xs font-semibold text-slate-600 shadow-sm hover:bg-slate-50"
                            title="Clear search">
                            Search: "{{ \Illuminate\Support\Str::limit($search, 24) }}"
                            <span class="material-symbols-outlined text-[16px] text-slate-400">close</span>
                        </a>
                        @endif
                    </div>
                    <a href="{{ route('healthworker.treatment-tracker') }}"
                        class="flex items-center gap-2 text-slate-500 hover:text-blue-600 font-semibold text-sm transition-colors">
                        <span class="material-symbols-outlined">restart_alt</span>
                        Reset Filters
                    </a>
                </form>
                <!-- Treatment Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400 whitespace-nowrap">
                                    Patient Details</th>
                                <th
                                    class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400 text-center whitespace-nowrap">
                                    Exposure</th>
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400 whitespace-nowrap">
                                    Dose Schedule</th>
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400 whitespace-nowrap">
                                    Progress</th>
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400 whitespace-nowrap">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400 text-right whitespace-nowrap">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($tracker as $c)
                            @php
                                $nextDate = $c->next ? $c->next['date'] : null;
                                $nextToday = $nextDate && $nextDate->isSameDay($today);
                                $overdueDays = $nextDate && $nextDate->lt($today) ? (int) $nextDate->diffInDays($today) : 0;
                                $catStyle = $c->category === 'III' ? 'bg-secondary-container text-on-secondary-container' : 'bg-slate-100 text-slate-600';
                                $barColor = $c->state === 'Late' ? 'bg-tertiary' : ($c->state === 'Completed' ? 'bg-emerald-500' : 'bg-blue-600');
                            @endphp
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-6 py-5">
                                    <p class="text-sm font-bold text-slate-900 whitespace-nowrap">{{ $c->patient_name }}</p>
                                    <p class="text-[11px] font-mono text-slate-500 whitespace-nowrap">{{ $c->patient_id }}</p>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span
                                        class="{{ $catStyle }} px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tight whitespace-nowrap">Cat {{ $c->category }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-xs space-y-1 whitespace-nowrap">
                                        <div class="flex items-center gap-2 text-slate-500">
                                            <span class="material-symbols-outlined text-sm">history</span>
                                            <span>Last: {{ $c->last ? $c->last->format('M d') : 'None yet' }}</span>
                                        </div>
                                        @if(!$nextDate)
                                        <div class="flex items-center gap-2 font-medium text-emerald-700">
                                            <span class="material-symbols-outlined text-sm">task_alt</span>
                                            <span>Course complete</span>
                                        </div>
                                        @elseif($overdueDays > 0)
                                        <div class="flex items-center gap-2 font-bold text-error">
                                            <span class="material-symbols-outlined text-sm"
                                                style="font-variation-settings: 'FILL' 1;">notification_important</span>
                                            <span>Due: {{ $nextDate->format('M d') }} ({{ $overdueDays }}d overdue)</span>
                                        </div>
                                        @elseif($nextToday)
                                        <div class="flex items-center gap-2 font-bold text-blue-700">
                                            <span class="material-symbols-outlined text-sm"
                                                style="font-variation-settings: 'FILL' 1;">event_available</span>
                                            <span>Next: {{ $nextDate->format('M d') }} (Today)</span>
                                        </div>
                                        @else
                                        <div class="flex items-center gap-2 font-medium text-slate-600">
                                            <span class="material-symbols-outlined text-sm">calendar_month</span>
                                            <span>Next: {{ $nextDate->format('M d') }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="w-32">
                                        <div class="flex justify-between text-[10px] font-bold text-slate-500 mb-1">
                                            <span>{{ $c->given_count }}/{{ $c->total }} Doses</span>
                                            <span>{{ $c->pct }}%</span>
                                        </div>
                                        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                            <div class="{{ $barColor }} h-full" style="width: {{ $c->pct }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    @if($c->state === 'Late')
                                    <span
                                        class="inline-flex items-center gap-1.5 bg-error-container text-on-error-container px-3 py-1 rounded-full text-[10px] font-bold whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                        Late
                                    </span>
                                    @elseif($c->state === 'Completed')
                                    <span
                                        class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-[10px] font-bold whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Completed
                                    </span>
                                    @else
                                    <span
                                        class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-[10px] font-bold whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        On Track
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button type="button" class="row-menu text-slate-400 hover:text-blue-600 transition-colors"
                                        data-case="{{ route('healthworker.ce-vii', ['bite_case_id' => $c->bite_case_id]) }}"
                                        data-record="{{ route('healthworker.patient-database', ['q' => $c->patient_id]) }}"
                                        data-tel="{{ $c->contact_num }}" aria-label="Actions for {{ $c->patient_name }}">
                                        <span class="material-symbols-outlined">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-14 text-center text-sm text-slate-500">
                                    @if($search !== '' || $barangay !== '' || $status !== 'all')
                                    No treatment courses match your filters.
                                    @else
                                    No active treatment courses yet. A course starts once a case has a Day 0 date in Section VII.
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination Footer -->
                <div class="p-6 border-t border-slate-50 flex flex-wrap items-center justify-between gap-3">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                        @if($tracker->total() > 0)
                        Showing {{ $tracker->firstItem() }}-{{ $tracker->lastItem() }} of {{ $tracker->total() }}
                        {{ \Illuminate\Support\Str::plural('Course', $tracker->total()) }}
                        @else
                        No courses to show
                        @endif
                    </p>
                    @if($tracker->hasPages())
                    @php
                        $current = $tracker->currentPage();
                        $last = $tracker->lastPage();
                        $window = array_unique(array_filter([1, $current - 1, $current, $current + 1, $last], fn ($n) => $n >= 1 && $n <= $last));
                        sort($window);
                        $prev = 0;
                    @endphp
                    <div class="flex gap-2 items-center">
                        @if($tracker->onFirstPage())
                        <span class="p-2 border border-slate-100 rounded-lg text-slate-300 cursor-not-allowed"><span class="material-symbols-outlined">chevron_left</span></span>
                        @else
                        <a href="{{ $tracker->previousPageUrl() }}" class="p-2 border border-slate-100 rounded-lg text-slate-400 hover:bg-slate-50 hover:text-blue-600 transition-all"><span class="material-symbols-outlined">chevron_left</span></a>
                        @endif
                        @foreach($window as $n)
                        @if($n - $prev > 1)
                        <span class="px-1 text-slate-400 text-sm">...</span>
                        @endif
                        <a href="{{ $tracker->url($n) }}"
                            class="px-4 py-1.5 rounded-lg text-sm font-bold {{ $n === $current ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'text-slate-500 hover:bg-slate-50' }}">{{ $n }}</a>
                        @php $prev = $n; @endphp
                        @endforeach
                        @if($tracker->hasMorePages())
                        <a href="{{ $tracker->nextPageUrl() }}" class="p-2 border border-slate-100 rounded-lg text-slate-400 hover:bg-slate-50 hover:text-blue-600 transition-all"><span class="material-symbols-outlined">chevron_right</span></a>
                        @else
                        <span class="p-2 border border-slate-100 rounded-lg text-slate-300 cursor-not-allowed"><span class="material-symbols-outlined">chevron_right</span></span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            <!-- ANALYTICS CARDS (BOTTOM SECTION) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pb-8">
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-600"
                                style="font-variation-settings: 'FILL' 1;">bar_chart</span>
                            Compliance Rate Overview
                        </h4>
                        <span class="text-xs font-bold text-blue-700 bg-blue-50 px-3 py-1 rounded-lg">Last 30 Days</span>
                    </div>
                    @if($compliance->isEmpty())
                    <p class="h-48 flex items-center justify-center text-sm text-slate-500 text-center">No doses have fallen due in the last 30 days yet.</p>
                    @else
                    <div class="h-48 w-full flex items-end justify-between gap-4 px-2">
                        @foreach($compliance as $b)
                        <div class="w-full bg-blue-50 rounded-t-lg relative group" style="height: {{ max($b->pct, 4) }}%">
                            <div
                                class="absolute inset-0 bg-blue-600 rounded-t-lg scale-y-0 origin-bottom group-hover:scale-y-100 transition-transform duration-500">
                            </div>
                            <span
                                class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-blue-700 opacity-0 group-hover:opacity-100 whitespace-nowrap">{{ $b->pct }}% · {{ $b->doses }} {{ \Illuminate\Support\Str::plural('dose', $b->doses) }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between gap-4 mt-4 px-2">
                        @foreach($compliance as $b)
                        <span class="w-full text-center text-[10px] font-bold text-slate-400 truncate" title="{{ $b->name }}">{{ $b->name }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm">
                    <h4 class="text-sm font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-tertiary-container"
                            style="font-variation-settings: 'FILL' 1;">assignment_late</span>
                        Upcoming Critical Appointments
                    </h4>
                    <div class="space-y-4">
                        @forelse($appointments as $c)
                        @php
                            $date = $c->next['date'];
                            $isOverdue = $date->lt($today);
                            $doseName = 'Day ' . $c->next['day'] . ' dose';
                            $when = $isOverdue ? 'was due ' . $date->format('M d') . ' (' . (int) $date->diffInDays($today) . 'd overdue)'
                                : ($date->isSameDay($today) ? 'due today' : 'due tomorrow');
                        @endphp
                        <div class="flex items-center justify-between gap-3 p-3 rounded-xl bg-slate-50 border-l-4 {{ $isOverdue ? 'border-error' : 'border-tertiary' }}">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="material-symbols-outlined {{ $isOverdue ? 'text-error' : 'text-tertiary' }}">{{ $isOverdue ? 'priority_high' : 'notifications_active' }}</span>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-900 truncate">{{ $c->patient_name }} ({{ $c->patient_id }})</p>
                                    <p class="text-[10px] text-slate-500">{{ $doseName }} {{ $when }}</p>
                                </div>
                            </div>
                            @if($isOverdue && $c->contact_num)
                            <a href="tel:{{ preg_replace('/[^\d+]/', '', $c->contact_num) }}"
                                class="shrink-0 text-[10px] font-black text-white bg-error px-4 py-1.5 rounded-lg uppercase tracking-tight shadow-md shadow-error/20 whitespace-nowrap">Call Patient</a>
                            @else
                            <a href="{{ route('healthworker.ce-vii', ['bite_case_id' => $c->bite_case_id]) }}"
                                class="shrink-0 text-[10px] font-black text-slate-600 bg-white border border-slate-200 px-4 py-1.5 rounded-lg uppercase tracking-tight whitespace-nowrap">Open Case</a>
                            @endif
                        </div>
                        @empty
                        <p class="text-sm text-slate-500 text-center py-8">No overdue or upcoming doses right now.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Row action menu (one shared menu, positioned next to the clicked button) -->
    <div id="rowMenu" class="hidden fixed z-[60] w-52 bg-white rounded-xl shadow-lg border border-slate-100 p-2">
        <a id="rowMenuCase" href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary rounded-lg transition-colors">
            <span class="material-symbols-outlined text-[18px]">vaccines</span> Open Immunization
        </a>
        <a id="rowMenuRecord" href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary rounded-lg transition-colors">
            <span class="material-symbols-outlined text-[18px]">badge</span> Patient Record
        </a>
        <a id="rowMenuTel" href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary rounded-lg transition-colors">
            <span class="material-symbols-outlined text-[18px]">call</span> <span id="rowMenuTelText">Call Patient</span>
        </a>
    </div>
    <script>
        (function () {
            const menu = document.getElementById('rowMenu');
            const close = () => menu.classList.add('hidden');

            document.querySelectorAll('.row-menu').forEach((btn) => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (!menu.classList.contains('hidden') && menu.dataset.owner === btn.dataset.case) return close();
                    menu.dataset.owner = btn.dataset.case;
                    document.getElementById('rowMenuCase').href = btn.dataset.case;
                    document.getElementById('rowMenuRecord').href = btn.dataset.record;
                    const tel = document.getElementById('rowMenuTel');
                    const number = btn.dataset.tel || '';
                    tel.classList.toggle('hidden', !number);
                    tel.href = 'tel:' + number.replace(/[^\d+]/g, '');
                    document.getElementById('rowMenuTelText').textContent = 'Call ' + number;

                    menu.classList.remove('hidden');
                    const r = btn.getBoundingClientRect();
                    const h = menu.offsetHeight;
                    const top = r.bottom + 6 + h > window.innerHeight ? r.top - h - 6 : r.bottom + 6;
                    menu.style.top = Math.max(8, top) + 'px';
                    menu.style.left = Math.max(8, r.right - menu.offsetWidth) + 'px';
                });
            });
            document.addEventListener('click', (e) => { if (!menu.contains(e.target)) close(); });
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });
            window.addEventListener('scroll', close, true);
            window.addEventListener('resize', close);

            // The header search box searches the tracker too (Enter to search)
            const headerSearch = document.querySelector('header input[type="text"]');
            const hidden = document.getElementById('trackerSearch');
            if (headerSearch && hidden) {
                headerSearch.value = hidden.value;
                headerSearch.addEventListener('keydown', (e) => {
                    if (e.key !== 'Enter') return;
                    hidden.value = headerSearch.value;
                    hidden.form.requestSubmit();
                });
            }
        })();
    </script>
</body>

</html>
