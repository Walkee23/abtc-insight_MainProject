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
    <!-- SIDEBAR -->
    <aside
        class="h-screen w-64 fixed left-0 top-0 bg-slate-50 dark:bg-slate-900 flex flex-col border-r border-slate-200/50 dark:border-slate-800/50 py-6 font-['Inter'] tracking-tight z-50">
        <div class="px-6 mb-10 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-on-primary">
                <span class="material-symbols-outlined"
                    style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
            </div>
            <div>
                <h1 class="text-lg font-bold text-blue-900 dark:text-blue-100 leading-none">ABTC-Insight</h1>
            </div>
        </div>
        <nav class="flex-1 space-y-1 px-3">
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all"
                href="{{ route('healthworker.dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all"
                href="{{ route('healthworker.clinical-encoding') }}">
                <span class="material-symbols-outlined">medical_services</span>
                <span class="text-sm">Clinical Encoding</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-blue-700 text-blue-700 bg-blue-50 dark:bg-blue-900/20 font-semibold transition-all"
                href="{{ route('healthworker.treatment-tracker') }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">monitor_heart</span>
                <span class="text-sm">Treatment Tracker</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all"
                href="{{ route('healthworker.patient-database') }}">
                <span class="material-symbols-outlined">database</span>
                <span class="text-sm">Patient Database</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all"
                href="{{ route('healthworker.compliance') }}">
                <span class="material-symbols-outlined">verified_user</span>
                <span class="text-sm">Compliance</span>
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
                        <p class="text-xs font-bold text-on-surface leading-tight font-['Inter']">Dr. Elena Santos</p>
                        <p class="text-[10px] text-on-surface-variant font-['Inter']">Senior Health Worker</p>
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
        <!-- TOP APP BAR (Updated to match SCREEN_12 layout) -->
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
                            <h3 class="text-4xl font-black text-blue-900 tracking-tighter">142</h3>
                        </div>
                        <div
                            class="p-3 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined">person_search</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs font-semibold text-emerald-600">
                        <span class="material-symbols-outlined text-sm">trending_up</span>
                        <span>+12% from last week</span>
                    </div>
                </div>
                <div
                    class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-black uppercase tracking-widest text-slate-400 mb-1">Due for
                                Vaccination Today</p>
                            <h3 class="text-4xl font-black text-on-tertiary-fixed-variant tracking-tighter">18</h3>
                        </div>
                        <div
                            class="p-3 bg-tertiary-fixed text-on-tertiary-fixed-variant rounded-xl group-hover:bg-tertiary group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined">event_repeat</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs font-semibold text-slate-500">
                        <span class="material-symbols-outlined text-sm">schedule</span>
                        <span>Next update in 2 hours</span>
                    </div>
                </div>
                <div
                    class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-black uppercase tracking-widest text-slate-400 mb-1">Missed Doses</p>
                            <h3 class="text-4xl font-black text-error tracking-tighter">05</h3>
                        </div>
                        <div
                            class="p-3 bg-error-container text-on-error-container rounded-xl group-hover:bg-error group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined">warning</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs font-semibold text-error">
                        <span class="material-symbols-outlined text-sm">error</span>
                        <span>Requires urgent follow-up</span>
                    </div>
                </div>
            </div>
            <!-- FILTERS & TABLE SECTION -->
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm overflow-hidden">
                <!-- Filter Row -->
                <div class="p-6 bg-surface-container-low flex flex-wrap gap-4 items-center justify-between">
                    <div class="flex gap-4">
                        <div class="relative min-w-[200px]">
                            <select
                                class="appearance-none w-full bg-white border-none rounded-lg px-4 py-2 pr-10 text-sm font-semibold text-slate-600 focus:ring-2 focus:ring-blue-500/10 shadow-sm cursor-pointer">
                                <option>Filter by Barangay</option>
                                <option>Guadalupe</option>
                                <option>Lahug</option>
                                <option>Mabolo</option>
                                <option>Tisa</option>
                            </select>
                            <span
                                class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                        </div>
                        <div class="relative min-w-[200px]">
                            <select
                                class="appearance-none w-full bg-white border-none rounded-lg px-4 py-2 pr-10 text-sm font-semibold text-slate-600 focus:ring-2 focus:ring-blue-500/10 shadow-sm cursor-pointer">
                                <option>Dose Status: All</option>
                                <option>Active</option>
                                <option>Completed</option>
                                <option>Missed</option>
                            </select>
                            <span
                                class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                        </div>
                    </div>
                    <button
                        class="flex items-center gap-2 text-slate-500 hover:text-blue-600 font-semibold text-sm transition-colors">
                        <span class="material-symbols-outlined">restart_alt</span>
                        Reset Filters
                    </button>
                </div>
                <!-- Treatment Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400">
                                    Patient Details</th>
                                <th
                                    class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400 text-center">
                                    Exposure</th>
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400">
                                    Dose Schedule</th>
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400">
                                    Progress</th>
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400 text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <!-- Row 1 -->
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-700 transition-colors">
                                            JD</div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">Juan Dela Cruz</p>
                                            <p class="text-[11px] font-mono text-slate-500">CEB-20250110-001</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span
                                        class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tight">Cat
                                        III</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-xs space-y-1">
                                        <div class="flex items-center gap-2 text-slate-500">
                                            <span class="material-symbols-outlined text-sm">history</span>
                                            <span>Last: Oct 12</span>
                                        </div>
                                        <div class="flex items-center gap-2 font-bold text-blue-700">
                                            <span class="material-symbols-outlined text-sm"
                                                style="font-variation-settings: 'FILL' 1;">event_available</span>
                                            <span>Next: Oct 15 (Today)</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="w-32">
                                        <div class="flex justify-between text-[10px] font-bold text-slate-500 mb-1">
                                            <span>2/3 Doses</span>
                                            <span>66%</span>
                                        </div>
                                        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                            <div class="bg-blue-600 h-full w-[66%]"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-[10px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        On Track
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button class="text-slate-400 hover:text-blue-600 transition-colors">
                                        <span class="material-symbols-outlined">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                            <!-- Row 2 -->
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-700 transition-colors">
                                            MC</div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">Maria Clara</p>
                                            <p class="text-[11px] font-mono text-slate-500">CEB-20250214-042</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span
                                        class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tight">Cat
                                        II</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-xs space-y-1">
                                        <div class="flex items-center gap-2 text-slate-500">
                                            <span class="material-symbols-outlined text-sm">history</span>
                                            <span>Last: Oct 10</span>
                                        </div>
                                        <div class="flex items-center gap-2 font-medium text-slate-600">
                                            <span class="material-symbols-outlined text-sm">calendar_month</span>
                                            <span>Next: Oct 17</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="w-32">
                                        <div class="flex justify-between text-[10px] font-bold text-slate-500 mb-1">
                                            <span>1/3 Doses</span>
                                            <span>33%</span>
                                        </div>
                                        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                            <div class="bg-blue-400 h-full w-[33%]"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-[10px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        On Track
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button class="text-slate-400 hover:text-blue-600 transition-colors">
                                        <span class="material-symbols-outlined">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                            <!-- Row 3 -->
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-700 transition-colors">
                                            PR</div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">Pedro Rizal</p>
                                            <p class="text-[11px] font-mono text-slate-500">CEB-20241215-045</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span
                                        class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tight">Cat
                                        III</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-xs space-y-1">
                                        <div class="flex items-center gap-2 text-slate-500">
                                            <span class="material-symbols-outlined text-sm">history</span>
                                            <span>Last: Oct 01</span>
                                        </div>
                                        <div class="flex items-center gap-2 font-bold text-error">
                                            <span class="material-symbols-outlined text-sm"
                                                style="font-variation-settings: 'FILL' 1;">notification_important</span>
                                            <span>Next: Oct 29</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="w-32">
                                        <div class="flex justify-between text-[10px] font-bold text-slate-500 mb-1">
                                            <span>3/4 Doses</span>
                                            <span>75%</span>
                                        </div>
                                        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                            <div class="bg-tertiary h-full w-[75%]"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="inline-flex items-center gap-1.5 bg-error-container text-on-error-container px-3 py-1 rounded-full text-[10px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                        Late
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button class="text-slate-400 hover:text-blue-600 transition-colors">
                                        <span class="material-symbols-outlined">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination Footer -->
                <div class="p-6 border-t border-slate-50 flex items-center justify-between">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Showing 3 of 142 Active
                        Patients</p>
                    <div class="flex gap-2">
                        <button
                            class="p-2 border border-slate-100 rounded-lg text-slate-400 hover:bg-slate-50 hover:text-blue-600 transition-all">
                            <span class="material-symbols-outlined">chevron_left</span>
                        </button>
                        <button
                            class="px-4 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-bold border border-blue-100">1</button>
                        <button
                            class="px-4 py-1.5 text-slate-500 hover:bg-slate-50 rounded-lg text-sm font-bold">2</button>
                        <button
                            class="px-4 py-1.5 text-slate-500 hover:bg-slate-50 rounded-lg text-sm font-bold">3</button>
                        <button
                            class="p-2 border border-slate-100 rounded-lg text-slate-400 hover:bg-slate-50 hover:text-blue-600 transition-all">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- ANALYTICS PREVIEW CARDS (BOTTOM SECTION) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pb-8">
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-600"
                                style="font-variation-settings: 'FILL' 1;">bar_chart</span>
                            Compliance Rate Overview
                        </h4>
                        <button class="text-xs font-bold text-blue-700 bg-blue-50 px-3 py-1 rounded-lg">Last 30
                            Days</button>
                    </div>
                    <div class="h-48 w-full flex items-end justify-between gap-4 px-2">
                        <!-- Simplified Bar Chart -->
                        <div class="w-full bg-blue-50 h-[80%] rounded-t-lg relative group">
                            <div
                                class="absolute inset-0 bg-blue-600 rounded-t-lg scale-y-0 origin-bottom group-hover:scale-y-100 transition-transform duration-500">
                            </div>
                            <span
                                class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-blue-700 opacity-0 group-hover:opacity-100">80%</span>
                        </div>
                        <div class="w-full bg-blue-50 h-[65%] rounded-t-lg relative group">
                            <div
                                class="absolute inset-0 bg-blue-600 rounded-t-lg scale-y-0 origin-bottom group-hover:scale-y-100 transition-transform duration-500">
                            </div>
                            <span
                                class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-blue-700 opacity-0 group-hover:opacity-100">65%</span>
                        </div>
                        <div class="w-full bg-blue-50 h-[92%] rounded-t-lg relative group">
                            <div
                                class="absolute inset-0 bg-blue-600 rounded-t-lg scale-y-0 origin-bottom group-hover:scale-y-100 transition-transform duration-500">
                            </div>
                            <span
                                class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-blue-700 opacity-0 group-hover:opacity-100">92%</span>
                        </div>
                        <div class="w-full bg-blue-50 h-[74%] rounded-t-lg relative group">
                            <div
                                class="absolute inset-0 bg-blue-600 rounded-t-lg scale-y-0 origin-bottom group-hover:scale-y-100 transition-transform duration-500">
                            </div>
                            <span
                                class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-blue-700 opacity-0 group-hover:opacity-100">74%</span>
                        </div>
                        <div class="w-full bg-blue-50 h-[88%] rounded-t-lg relative group">
                            <div
                                class="absolute inset-0 bg-blue-600 rounded-t-lg scale-y-0 origin-bottom group-hover:scale-y-100 transition-transform duration-500">
                            </div>
                            <span
                                class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-blue-700 opacity-0 group-hover:opacity-100">88%</span>
                        </div>
                    </div>
                    <div class="flex justify-between mt-4 px-2">
                        <span class="text-[10px] font-bold text-slate-400">Guadalupe</span>
                        <span class="text-[10px] font-bold text-slate-400">Lahug</span>
                        <span class="text-[10px] font-bold text-slate-400">Mabolo</span>
                        <span class="text-[10px] font-bold text-slate-400">Tisa</span>
                        <span class="text-[10px] font-bold text-slate-400">Talamban</span>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm">
                    <h4 class="text-sm font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-tertiary-container"
                            style="font-variation-settings: 'FILL' 1;">assignment_late</span>
                        Upcoming Critical Appointments
                    </h4>
                    <div class="space-y-4">
                        <div
                            class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border-l-4 border-error">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-error">priority_high</span>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Jose Mari Chan (CEB-2025-098)</p>
                                    <p class="text-[10px] text-slate-500">Final Dose due 1 hour ago</p>
                                </div>
                            </div>
                            <button
                                class="text-[10px] font-black text-white bg-error px-4 py-1.5 rounded-lg uppercase tracking-tight shadow-md shadow-error/20">Call
                                Patient</button>
                        </div>
                        <div
                            class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border-l-4 border-tertiary">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-tertiary">notifications_active</span>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Angel Locsin (CEB-2025-112)</p>
                                    <p class="text-[10px] text-slate-500">Day 7 Dose due in 3 hours</p>
                                </div>
                            </div>
                            <button
                                class="text-[10px] font-black text-slate-600 bg-white border border-slate-200 px-4 py-1.5 rounded-lg uppercase tracking-tight">Remind
                                SMS</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>