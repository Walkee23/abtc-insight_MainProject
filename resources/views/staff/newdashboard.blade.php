<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>ABTC-Insight | Main Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
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
    <script src="{{ asset('js/sidebar-toggle.js') }}"></script>
</head>

<body class="text-on-surface select-none flex min-h-screen">

    <!-- SideNavBar -->
    <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-50 dark:bg-slate-900 flex flex-col border-r border-slate-200/50 dark:border-slate-800/50 z-50">
        <!-- Brand -->
        <div class="px-6 pt-8">
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-primary rounded-[1rem] flex items-center justify-center">
                    <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                </div>
                <div>
                    <h1 class="font-black uppercase text-primary dark:text-blue-100 text-sm tracking-wider leading-none">ABTC-Insight</h1>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="space-y-1 px-6">
            <!-- 1. Main Dashboard (Active) -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-700 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600 translate-x-1 duration-150" 
               href="{{ route('staff.newdashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-['Inter'] text-sm tracking-wide">Dashboard</span>
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
    <main class="flex-1 flex flex-col ml-64">
                <!-- TopNavBar -->
            <div class="flex justify-end items-center w-full h-16 px-8 sticky top-0 z-40 bg-slate-50/85 dark:bg-slate-900/85 backdrop-blur-md shadow-sm shadow-blue-900/5">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-1 border-r border-outline-variant/20 pr-4">
                </div>

                <!-- Name of the User -->

                <div class="relative group cursor-pointer pl-2">
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold text-on-surface leading-tight">{{ Auth::user()->full_name }}</p>
                            <p class="text-[10px] text-on-surface-variant leading-tight">{{ Auth::user()->role }}</p>
                        </div>
                        <div class="relative w-9 h-9">
                            <div class="w-9 h-9 rounded-full overflow-hidden ring-2 ring-slate-100 border border-slate-200">
                                <img alt="{{ Auth::user()->full_name }}" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCG2nKFZGyYwHKRYoCQT3e-DFv4lhmbOaefZN_pNQ6HkWmU6VSYzY9h1P_RiS1yqN4hdqhLCiP4K6Ea7gARSWG6HK0qt5boVFtv4S1YiWv2O1vutB_s88IrPG_wB7x02LuJj9pA0d9mKcPXNHWbCr_BIg-CKtC_tZCmVz1DmJURoecp6Re7uXEhv9FI1dvVxhWIOr9RdMIXbtQRUjsSOkEc-i5gI18j8iBFPISCiDNXnFP_TQidoFnFp1cFnCO6SpZTN3UK4BIZ1wd1" />
                            </div>
                            <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                    </div>
                    <!-- Hover Dropdown Menu -->

                    <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="p-2">
                            <button type="button" onclick="openProfileModal()" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary rounded-lg transition-colors text-left cursor-pointer">
                                <span class="material-symbols-outlined text-[18px]">person</span>
                                My Profile
                            </button>
                            <div class="h-px bg-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors text-left cursor-pointer">
                                    <span class="material-symbols-outlined text-[18px]">logout</span>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-8">
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

            <!-- Expected Follow-up Visits Card & Scrollable Name List -->
            <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/20 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-sm text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px]">event_repeat</span>
                        Scheduled Follow-Up Inflow (Due Today) — <span class="text-xs text-slate-500 font-normal">Click a card to view names</span>
                    </h3>
                    <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-emerald-50 text-emerald-700">DOH Schedule</span>
                </div>

                <!-- Clickable Cards -->
                <div class="grid grid-cols-3 gap-3 text-center mb-4">
                    <div id="cardDay3" onclick="switchPatientTab('day3')" class="p-3 bg-surface-container-low rounded-xl border-2 border-outline-variant/10 cursor-pointer hover:bg-blue-50 transition-all shadow-sm group">
                        <span class="text-[10px] font-bold text-on-surface-variant block uppercase group-hover:text-blue-700">Day 3 (Dose 2)</span>
                        <span class="text-xl font-black text-on-surface mt-1 block group-hover:text-blue-800">{{ $dueDay3Count ?? 0 }}</span>
                        <span class="text-[10px] text-primary font-semibold underline">View Names</span>
                    </div>
                    <div id="cardDay7" onclick="switchPatientTab('day7')" class="p-3 bg-surface-container-low rounded-xl border-2 border-outline-variant/10 cursor-pointer hover:bg-purple-50 transition-all shadow-sm group">
                        <span class="text-[10px] font-bold text-on-surface-variant block uppercase group-hover:text-purple-700">Day 7 (Dose 3)</span>
                        <span class="text-xl font-black text-on-surface mt-1 block group-hover:text-purple-800">{{ $dueDay7Count ?? 0 }}</span>
                        <span class="text-[10px] text-purple-700 font-semibold underline">View Names</span>
                    </div>
                    <div id="cardDay28" onclick="switchPatientTab('day28')" class="p-3 bg-surface-container-low rounded-xl border-2 border-outline-variant/10 cursor-pointer hover:bg-emerald-50 transition-all shadow-sm group">
                        <span class="text-[10px] font-bold text-on-surface-variant block uppercase group-hover:text-emerald-700">Day 28 (Dose 4)</span>
                        <span class="text-xl font-black text-on-surface mt-1 block group-hover:text-emerald-800">{{ $dueDay28Count ?? 0 }}</span>
                        <span class="text-[10px] text-emerald-700 font-semibold underline">View Names</span>
                    </div>
                </div>

                <!-- Scrollable Name List Area at the Bottom -->
                <div id="patientListContainer" class="border-t border-outline-variant/10 pt-4 mt-4 hidden">
                    <div class="flex justify-between items-center mb-3">
                        <h4 id="listTitle" class="text-xs font-bold uppercase tracking-wider text-slate-700">Returning Patient Names</h4>
                        <button onclick="closePatientList()" class="text-xs text-red-600 font-bold hover:underline">Close List</button>
                    </div>

                    <div class="max-h-56 overflow-y-auto pr-2 border border-slate-200 rounded-xl bg-white shadow-inner p-3">
                        
                    <!-- Day 3 List -->
                    <div id="content_day3" class="patient-tab-content hidden space-y-2">
                        <p class="text-[11px] font-bold text-blue-800 uppercase tracking-wide mb-2">Day 3 (Dose 2) Patients:</p>
                        @if(count($patientsDay3 ?? []) > 0)
                            <ul class="divide-y divide-slate-100">
                                @foreach($patientsDay3 as $p)
                                    <li class="py-2 px-3 hover:bg-slate-50 rounded-lg flex justify-between items-center text-xs">
                                        <span class="font-bold text-slate-950">• {{ $p->patient_name }}</span>
                                        <span class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">{{ $p->queue_id ?? 'N/A' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="py-4 text-center text-slate-400 text-xs">No patients found for Day 3.</p>
                        @endif
                    </div>

                    <!-- Day 7 List -->
                    <div id="content_day7" class="patient-tab-content hidden space-y-2">
                        <p class="text-[11px] font-bold text-purple-800 uppercase tracking-wide mb-2">Day 7 (Dose 3) Patients:</p>
                        @if(count($patientsDay7 ?? []) > 0)
                            <ul class="divide-y divide-slate-100">
                                @foreach($patientsDay7 as $p)
                                    <li class="py-2 px-3 hover:bg-slate-50 rounded-lg flex justify-between items-center text-xs">
                                        <span class="font-bold text-slate-950">• {{ $p->patient_name }}</span>
                                        <span class="text-[10px] font-semibold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full">{{ $p->queue_id ?? 'N/A' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="py-4 text-center text-slate-400 text-xs">No patients found for Day 7.</p>
                        @endif
                    </div>

                    <!-- Day 28 List -->
                    <div id="content_day28" class="patient-tab-content hidden space-y-2">
                        <p class="text-[11px] font-bold text-emerald-800 uppercase tracking-wide mb-2">Day 28 (Dose 4) Patients:</p>
                        @if(count($patientsDay28 ?? []) > 0)
                            <ul class="divide-y divide-slate-100">
                                @foreach($patientsDay28 as $p)
                                    <li class="py-2 px-3 hover:bg-slate-50 rounded-lg flex justify-between items-center text-xs">
                                        <span class="font-bold text-slate-950">• {{ $p->patient_name }}</span>
                                        <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">{{ $p->queue_id ?? 'N/A' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="py-4 text-center text-slate-400 text-xs">No patients found for Day 28.</p>
                        @endif
                    </div>
                </div>
            </div>
            <!-- JavaScript Toggle Handler -->
            <script>
            function switchPatientTab(dayKey) {
                const container = document.getElementById('patientListContainer');
                container.classList.remove('hidden');

                document.querySelectorAll('.patient-tab-content').forEach(el => el.classList.add('hidden'));
                document.getElementById('content_' + dayKey).classList.remove('hidden');

                ['day3', 'day7', 'day28'].forEach(k => {
                    const card = document.getElementById('card' + k.charAt(0).toUpperCase() + k.slice(1));
                    card.classList.remove('border-blue-500', 'border-purple-500', 'border-emerald-500', 'bg-slate-100');
                });

                const activeCard = document.getElementById('card' + dayKey.charAt(0).toUpperCase() + dayKey.slice(1));
                if(dayKey === 'day3') activeCard.classList.add('border-blue-500', 'bg-blue-50/50');
                if(dayKey === 'day7') activeCard.classList.add('border-purple-500', 'bg-purple-50/50');
                if(dayKey === 'day28') activeCard.classList.add('border-emerald-500', 'bg-emerald-50/50');

                container.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            function closePatientList() {
                document.getElementById('patientListContainer').classList.add('hidden');
                ['day3', 'day7', 'day28'].forEach(k => {
                    const card = document.getElementById('card' + k.charAt(0).toUpperCase() + k.slice(1));
                    card.classList.remove('border-blue-500', 'border-purple-500', 'border-emerald-500', 'bg-blue-50/50', 'bg-purple-50/50', 'bg-emerald-50/50');
                });
            }
            </script>
        </main>
                    <!-- My Profile Modal -->
@php
    $user = Auth::user();

    // Shared placeholder descriptions (edit these)
    $hwText = 'Provides frontline health services, records and updates patient information, conducts health monitoring, and supports community health programs.';
    $staffText = 'Handles administrative and clerical tasks, manages records and documents, assists clients, and supports the daily operations of the center.';

    // Per-user job descriptions, keyed by username
    $jobDescriptions = [
        'thelmaeleccion'        => 'Attending physician. Examines and treats patients, oversees health programs, and guides the health workers on patient care.',
        'otreborenriquez'       => $hwText,
        'annemarielascuna'      => $hwText,
        'brenalleeracaza'       => $hwText,
        'richardninopangilinan' => $hwText,
        'loretaallera'          => $staffText,
        'genevevecugay'         => $staffText,
        'donalizanavarro'       => $staffText,
        'liecelberdera'         => $staffText,
        'ginaoporto'            => $staffText,
        'rolandnabua'           => $staffText,
        'queenieeslabon'        => $staffText,
        'merlizacarunggay'      => $staffText,
    ];

    $jobDescription = $jobDescriptions[$user->username]
        ?? ($user->role === 'Health Worker' ? $hwText : $staffText);

    $isHW = $user->role === 'Health Worker';
    $badgeClasses = $isHW
        ? 'bg-emerald-50 text-emerald-700 ring-emerald-200'
        : 'bg-sky-50 text-sky-700 ring-sky-200';
@endphp

<div id="profileModal"
     class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 opacity-0 transition-opacity duration-200"
     onclick="if(event.target === this) closeProfileModal()">

    <div id="profileCard"
         class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden scale-95 translate-y-2 transition-all duration-200">

        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-800">My Profile</h3>
            <button type="button" onclick="closeProfileModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-full text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors cursor-pointer">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Details -->
        <div class="p-6 space-y-3">

            <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100">
                <div class="w-10 h-10 shrink-0 rounded-lg bg-white shadow-sm flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[22px]">person</span>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Account Name</p>
                    <p class="text-sm font-semibold text-slate-800 break-words">{{ $user->full_name }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100">
                <div class="w-10 h-10 shrink-0 rounded-lg bg-white shadow-sm flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[22px]">admin_panel_settings</span>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Role in the System</p>
                    <span class="mt-1 inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold ring-1 {{ $badgeClasses }}">
                        {{ $user->role }}
                    </span>
                </div>
            </div>

            <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100">
                <div class="w-10 h-10 shrink-0 rounded-lg bg-white shadow-sm flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[22px]">work</span>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Job Description</p>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $jobDescription }}</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
            <button type="button" onclick="closeProfileModal()"
                    class="px-5 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:opacity-90 transition-opacity cursor-pointer">
                Close
            </button>
        </div>
    </div>
</div>

<script>
    function openProfileModal() {
        const modal = document.getElementById('profileModal');
        const card = document.getElementById('profileCard');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        requestAnimationFrame(() => {
            modal.classList.remove('opacity-0');
            card.classList.remove('scale-95', 'translate-y-2');
        });
    }

    function closeProfileModal() {
        const modal = document.getElementById('profileModal');
        const card = document.getElementById('profileCard');
        modal.classList.add('opacity-0');
        card.classList.add('scale-95', 'translate-y-2');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeProfileModal();
    });
</script>
@include('partials.idle-timeout')
</body>
</html>