<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>ABTC-Insight | Main Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "outline-variant": "#c1c7d3",
                        "on-primary-fixed": "#001b3d",
                        "tertiary-fixed": "#ffdbc8",
                        "on-tertiary": "#ffffff",
                        "background": "#f7f9fb",
                        "surface-container-lowest": "#ffffff",
                        "on-error": "#ffffff",
                        "secondary-fixed-dim": "#b1c8ec",
                        "surface-container": "#eceef0",
                        "outline": "#717782",
                        "on-error-container": "#93000a",
                        "secondary": "#49607f",
                        "primary-fixed-dim": "#a9c7ff",
                        "on-tertiary-fixed-variant": "#743500",
                        "error": "#ba1a1a",
                        "primary-container": "#0b61bb",
                        "on-secondary": "#ffffff",
                        "on-primary-fixed-variant": "#00468c",
                        "on-tertiary-container": "#ffd7c0",
                        "inverse-primary": "#a9c7ff",
                        "tertiary": "#7a3800",
                        "primary-fixed": "#d6e3ff",
                        "surface-variant": "#e0e3e5",
                        "primary": "#004a93",
                        "surface": "#f7f9fb",
                        "secondary-fixed": "#d3e4ff",
                        "inverse-surface": "#2d3133",
                        "error-container": "#ffdad6",
                        "on-secondary-fixed-variant": "#314866",
                        "on-primary-container": "#d0dfff",
                        "on-surface-variant": "#414751",
                        "surface-container-low": "#f2f4f6",
                        "surface-tint": "#005db6",
                        "secondary-container": "#c1d9fd",
                        "surface-container-high": "#e6e8ea",
                        "tertiary-container": "#9e4b00",
                        "on-secondary-fixed": "#011c38",
                        "on-primary": "#ffffff",
                        "on-tertiary-fixed": "#311300",
                        "on-surface": "#191c1e",
                        "inverse-on-surface": "#eff1f3",
                        "surface-container-highest": "#e0e3e5",
                        "on-secondary-container": "#485f7e",
                        "tertiary-fixed-dim": "#ffb689",
                        "surface-bright": "#f7f9fb",
                        "on-background": "#191c1e",
                        "surface-dim": "#d8dadc"
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "1rem",
                        "xl": "1.25rem",
                        "full": "9999px"
                    },
                    fontFamily: {
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
            background-color: #f7f9fb;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
        }
    </style>
</head>

<body class="text-on-surface select-none flex min-h-screen">

    <!-- SideNavBar -->
    <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-100 dark:bg-slate-900 flex flex-col pt-6 pb-4 gap-2 z-50">
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

        <nav class="flex-1 mt-4 space-y-1 px-4">
            <!-- 1. Main Dashboard (Active) -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-700 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600 translate-x-1 duration-150" 
               href="{{ route('staff.newdashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-['Inter'] text-sm tracking-wide">Dashboard Overview</span>
            </a>

            <!-- 2. Queue Management -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
               href="{{ route('staff.dashboard') }}">
                <span class="material-symbols-outlined">queue</span>
                <span class="font-['Inter'] text-sm tracking-wide">Queue Management</span>
            </a>

            <!-- 3. Case Encoding -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
               href="{{ route('staff.case-encoding') }}">
                <span class="material-symbols-outlined">clinical_notes</span>
                <span class="font-['Inter'] text-sm tracking-wide">Case Encoding</span>
            </a>

            <!-- 4. Patient Lookup -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
               href="{{ route('staff.patient-lookup') }}">
                <span class="material-symbols-outlined">person_search</span>
                <span class="font-['Inter'] text-sm tracking-wide">Patient Lookup</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col ml-64 p-8">
        
        <!-- Header Section -->
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-black text-on-surface tracking-tight">Clinic Operational Dashboard</h1>
                <p class="text-xs text-on-surface-variant mt-1 font-medium">Real-time walk-in volume, verification throughput, and rabies clinical protocols.</p>
            </div>
            <div class="px-4 py-2 bg-surface-container-lowest rounded-xl border border-outline-variant/30 shadow-sm text-xs font-bold text-secondary flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px] text-primary">calendar_today</span>
                <span>{{ now()->format('F d, Y') }}</span>
            </div>
        </header>

        <!-- Section 1: Stats Grid (Exact Theme from Queue Management) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/20">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-2.5 bg-primary/10 rounded-xl text-primary">
                        <span class="material-symbols-outlined">group</span>
                    </div>
                    <span class="text-[10px] font-extrabold text-primary bg-primary/10 px-2.5 py-1 rounded-full uppercase tracking-wider">DAILY REGISTRATIONS</span>
                </div>
                <div class="text-4xl font-black text-on-surface">{{ $totalRegistered ?? 0 }}</div>
                <div class="text-[11px] text-on-surface-variant uppercase mt-1 tracking-wider font-bold">Total Inflow Intake</div>
            </div>

            <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/20">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-2.5 bg-green-500/10 rounded-xl text-green-700">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                    <span class="text-[10px] font-extrabold text-green-700 bg-green-500/10 px-2.5 py-1 rounded-full uppercase tracking-wider">Verified Patients</span>
                </div>
                <div class="text-4xl font-black text-on-surface">{{ $verifiedCount ?? 0 }}</div>
                <div class="text-[11px] text-on-surface-variant uppercase mt-1 tracking-wider font-bold">Verified &amp; Processed</div>
            </div>
            
            <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/20">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-2.5 bg-error-container/40 rounded-xl text-error">
                        <span class="material-symbols-outlined">pending</span>
                    </div>
                    <span class="text-[10px] font-extrabold text-error bg-error-container/40 px-2.5 py-1 rounded-full uppercase tracking-wider">Action Required</span>
                </div>
                <div class="text-4xl font-black text-on-surface">{{ $pendingCount ?? 0 }}</div>
                <div class="text-[11px] text-on-surface-variant uppercase mt-1 tracking-wider font-bold">Pending In Queue</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Left Card: Intake Ratio Breakdown -->
            <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/20 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-sm text-on-surface mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[18px]">pie_chart</span>
                        Today's Walk-in Ratio Breakdown
                    </h3>
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between items-center py-2.5 border-b border-surface-container">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                <span class="text-on-surface-variant font-medium">Priority Queue (P-Series: Senior, PWD, Pregnant)</span>
                            </div>
                            <span class="font-bold text-on-surface text-sm">{{ $priorityCount ?? 0 }} Patients</span>
                        </div>
                        <div class="flex justify-between items-center py-2.5 border-b border-surface-container">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                                <span class="text-on-surface-variant font-medium">Normal Queue (N-Series: Regular Walk-ins)</span>
                            </div>
                            <span class="font-bold text-on-surface text-sm">{{ $normalCount ?? 0 }} Patients</span>
                        </div>
                        <div class="flex justify-between items-center py-2.5">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                                <span class="text-on-surface-variant font-medium">Exposure Cases Encoded into Registry</span>
                            </div>
                            <span class="font-bold text-primary text-sm">{{ $encodedCount ?? 0 }} Records</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-surface-container flex items-center justify-between text-[11px] text-on-surface-variant">
                    <span class="flex items-center gap-1.5 font-medium">
                        <span class="material-symbols-outlined text-emerald-600 text-[16px]">sync_alt</span>
                        Live Inflow Stream Connected
                    </span>
                    <a href="{{ route('staff.dashboard') }}" class="font-bold text-primary hover:underline flex items-center gap-1">
                        Go to Queue Monitor
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Expected Follow-up Visits -->
            <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/20 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-sm text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px]">event_repeat</span>
                        Scheduled Follow-Up Inflow (Due Today)
                    </h3>
                    <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-emerald-50 text-emerald-700">DOH Schedule</span>
                </div>
                <div class="grid grid-cols-3 gap-3 text-center">
                    <div class="p-3 bg-surface-container-low rounded-xl border border-outline-variant/10">
                        <span class="text-[10px] font-bold text-on-surface-variant block uppercase">Day 3 (Dose 2)</span>
                        <span class="text-xl font-black text-on-surface mt-1 block">{{ $dueDay3Count ?? 0 }}</span>
                        <span class="text-[10px] text-primary font-semibold">Patients</span>
                    </div>
                    <div class="p-3 bg-surface-container-low rounded-xl border border-outline-variant/10">
                        <span class="text-[10px] font-bold text-on-surface-variant block uppercase">Day 7 (Dose 3)</span>
                        <span class="text-xl font-black text-on-surface mt-1 block">{{ $dueDay7Count ?? 0 }}</span>
                        <span class="text-[10px] text-purple-700 font-semibold">Patients</span>
                    </div>
                    <div class="p-3 bg-surface-container-low rounded-xl border border-outline-variant/10">
                        <span class="text-[10px] font-bold text-on-surface-variant block uppercase">Day 28 (Booster)</span>
                        <span class="text-xl font-black text-on-surface mt-1 block">{{ $dueDay28Count ?? 0 }}</span>
                        <span class="text-[10px] text-emerald-700 font-semibold">Patients</span>
                    </div>
                </div>
            </div>
            
        </div>

    </main>
</body>
</html>