<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ABTC-Insight | Patient Lookup</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "on-secondary-fixed": "#011c38",
                    "on-primary": "#ffffff",
                    "error": "#ba1a1a",
                    "on-surface-variant": "#414751",
                    "surface-bright": "#f7f9fb",
                    "on-tertiary-fixed": "#311300",
                    "on-secondary-container": "#485f7e",
                    "on-primary-container": "#d0dfff",
                    "tertiary": "#7a3800",
                    "on-primary-fixed": "#001b3d",
                    "secondary-fixed": "#d3e4ff",
                    "primary-container": "#0b61bb",
                    "tertiary-fixed-dim": "#ffb689",
                    "on-surface": "#191c1e",
                    "outline": "#717782",
                    "background": "#f7f9fb",
                    "on-tertiary": "#ffffff",
                    "on-tertiary-container": "#ffd7c0",
                    "on-error": "#ffffff",
                    "surface-container-lowest": "#ffffff",
                    "primary-fixed-dim": "#a9c7ff",
                    "tertiary-fixed": "#ffdbc8",
                    "on-secondary": "#ffffff",
                    "outline-variant": "#c1c7d3",
                    "on-primary-fixed-variant": "#00468c",
                    "error-container": "#ffdad6",
                    "secondary-fixed-dim": "#b1c8ec",
                    "inverse-on-surface": "#eff1f3",
                    "surface-variant": "#e0e3e5",
                    "surface-container-high": "#e6e8ea",
                    "primary": "#004a93",
                    "on-error-container": "#93000a",
                    "surface-tint": "#005db6",
                    "surface-dim": "#d8dadc",
                    "inverse-primary": "#a9c7ff",
                    "on-secondary-fixed-variant": "#314866",
                    "on-background": "#191c1e",
                    "surface-container-highest": "#e0e3e5",
                    "on-tertiary-fixed-variant": "#743500",
                    "surface": "#f7f9fb",
                    "surface-container-low": "#f2f4f6",
                    "surface-container": "#eceef0",
                    "secondary-container": "#c1d9fd",
                    "tertiary-container": "#9e4b00",
                    "secondary": "#49607f",
                    "primary-fixed": "#d6e3ff",
                    "inverse-surface": "#2d3133"
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
        }
      }
    </script>
<style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .tonal-elevation {
            box-shadow: 0 24px 48px -12px rgba(25, 28, 30, 0.04);
        }
        .ghost-border {
            border: 1px solid rgba(193, 199, 211, 0.15);
        }
    </style>
</head>
<body class="bg-surface text-on-surface flex min-h-screen">

<aside class="h-screen w-64 fixed left-0 top-0 bg-slate-100 dark:bg-slate-900 flex flex-col pt-6 pb-4 gap-2 z-50">
        <!-- SideNavBar -->
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
            <!-- Queue Management -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
            href="{{ route('staff.dashboard') }}">
                <span class="material-symbols-outlined">queue</span>
                <span class="font-['Inter'] text-sm tracking-wide">Queue Management</span>
            </a>

            <!-- Patient Verification -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
            href="{{ route('staff.patient-verification') }}">
                <span class="material-symbols-outlined">verified_user</span>
                <span class="font-['Inter'] text-sm tracking-wide">Patient Verification</span>
            </a>

            <!-- Case Encoding -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
            href="{{ route('staff.case-encoding') }}">
                <span class="material-symbols-outlined">clinical_notes</span>
                <span class="font-['Inter'] text-sm tracking-wide">Case Encoding</span>
            </a>

            <!-- Patient Lookup (Active - Admin Style) -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-700 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600 translate-x-1 duration-150" 
            href="{{ route('staff.patient-lookup') }}">
                <span class="material-symbols-outlined">person_search</span>
                <span class="font-['Inter'] text-sm tracking-wide">Patient Lookup</span>
            </a>
        </nav>
</aside>
<main class="flex-1 flex flex-col ml-72">
<!-- TopNavBar -->
<header class="flex justify-between items-center w-full h-16 px-8 sticky top-0 z-30 bg-white/85 dark:bg-slate-950/85 backdrop-blur-md z-30 shadow-sm shadow-slate-200/50 dark:shadow-none border-b border-slate-100/50">
<div class="flex items-center gap-8">
<div class="relative group">
<span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-lg">search</span>
<input class="pl-10 pr-4 py-1.5 bg-surface-container-low rounded-full text-sm focus:ring-2 focus:ring-primary/20 border-none outline-none w-72 transition-all" placeholder="Search analytics or case IDs..." type="text"/>
</div>
</div>
<div class="flex items-center gap-4">
<div class="hidden lg:flex items-center gap-2 px-3 py-1 bg-green-50 text-green-700 rounded-full text-[10px] font-bold uppercase tracking-wider">
<span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                     Registered
                </div>
<div class="flex items-center gap-1 border-r border-outline-variant/20 pr-4">
<button class="p-2 text-slate-500 hover:bg-surface-container-high rounded-full transition-colors relative">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
<span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-white"></span>
</button>
<button class="p-2 text-slate-500 hover:bg-surface-container-high rounded-full transition-colors">
<span class="material-symbols-outlined" data-icon="help">help</span>
</button>
</div>
<div class="relative group cursor-pointer pl-2">
<div class="flex items-center gap-3">
<div class="text-right hidden sm:block">
<p class="text-xs font-bold text-on-surface leading-tight">Staff</p>
<p class="text-[10px] text-on-surface-variant leading-tight">ABTC Staff</p>
</div>
<div class="w-9 h-9 rounded-full overflow-hidden ring-2 ring-slate-100 border border-slate-200">
<img alt="Staff Avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCG2nKFZGyYwHKRYoCQT3e-DFv4lhmbOaefZN_pNQ6HkWmU6VSYzY9h1P_RiS1yqN4hdqhLCiP4K6Ea7gARSWG6HK0qt5boVFtv4S1YiWv2O1vutB_s88IrPG_wB7x02LuJj9pA0d9mKcPXNHWbCr_BIg-CKtC_tZCmVz1DmJURoecp6Re7uXEhv9FI1dvVxhWIOr9RdMIXbtQRUjsSOkEc-i5gI18j8iBFPISCiDNXnFP_TQidoFnFp1cFnCO6SpZTN3UK4BIZ1wd1" />
<div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
</div>
</div>
<!-- Hover Dropdown Menu -->
<div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
<div class="p-2">
<a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary rounded-lg transition-colors">
<span class="material-symbols-outlined text-[18px]">person</span>
My Profile
</a>
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
</header>
<!-- Main Content -->
<div class="p-8 max-w-7xl mx-auto w-full space-y-8">
<!-- Header Section -->
<section>
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-4xl font-bold text-on-surface tracking-tight mb-2">Patient Lookup &amp; Records</h1>
        <p class="text-on-surface-variant font-medium">Search and retrieve comprehensive patient medical history and vaccination records.</p>
    </div>
    <div class="bg-blue-50 border border-blue-200 text-primary px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider self-start md:self-auto">
        {{ $totalDatabasePatients ?? 0 }} Total Master Records
    </div>
</div>
</section>
<!-- Search Area -->
<section class="bg-surface-container-lowest p-8 rounded-xl tonal-elevation ghost-border">
    <form action="{{ route('staff.patient-lookup') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
        <div class="relative flex-1 w-full">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-outline" data-icon="search">search</span>
            </div>
            <input name="search" value="{{ $search ?? '' }}" class="w-full pl-12 pr-4 py-4 bg-surface-container-highest border-none rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all text-on-surface placeholder:text-outline/70" placeholder="Search by full name or Unique Patient Identifier (e.g., CEB-20260402-20010101-001)" type="text"/>
        </div>
        <button type="submit" class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-primary to-primary-container text-white font-bold rounded-lg hover:shadow-lg hover:shadow-primary/20 transition-all active:scale-95 duration-150">
            Search Patient
        </button>
        @if(!empty($search))
            <a href="{{ route('staff.patient-lookup') }}" class="px-4 py-4 text-xs font-semibold text-slate-500 hover:text-slate-800">
                Clear
            </a>
        @endif
    </form>
</section>
<!-- Results Table -->
<section class="bg-surface-container-lowest rounded-xl tonal-elevation ghost-border overflow-hidden">
<div class="px-8 py-6 border-b border-outline-variant/10 flex justify-between items-center">
<h3 class="font-bold text-on-surface flex items-center gap-2">
<span class="material-symbols-outlined text-primary" data-icon="list_alt">list_alt</span>
                        Search Results
                    </h3>
<div class="flex gap-2">
<button class="p-2 hover:bg-surface-container-low rounded-lg transition-colors">
<span class="material-symbols-outlined text-on-surface-variant" data-icon="filter_list">filter_list</span>
</button>
<button class="p-2 hover:bg-surface-container-low rounded-lg transition-colors">
<span class="material-symbols-outlined text-on-surface-variant" data-icon="download">download</span>
</button>
</div>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low">
<th class="px-8 py-4 text-[11px] uppercase tracking-widest font-bold text-on-surface-variant">Patient Name</th>
<th class="px-6 py-4 text-[11px] uppercase tracking-widest font-bold text-on-surface-variant">Patient ID</th>
<th class="px-6 py-4 text-[11px] uppercase tracking-widest font-bold text-on-surface-variant">Age/Sex</th>
<th class="px-6 py-4 text-[11px] uppercase tracking-widest font-bold text-on-surface-variant">Barangay</th>
<th class="px-6 py-4 text-[11px] uppercase tracking-widest font-bold text-on-surface-variant">Last Visit</th>
<th class="px-6 py-4 text-[11px] uppercase tracking-widest font-bold text-on-surface-variant text-center">Active PEP</th>
<th class="px-8 py-4 text-[11px] uppercase tracking-widest font-bold text-on-surface-variant text-right">Action</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/10">
    @if(isset($patients) && $patients->count() > 0)
        @foreach($patients as $patient)
            <tr class="hover:bg-surface-bright transition-colors group">
                <td class="px-8 py-5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr($patient->patient_name ?? 'P', 0, 2)) }}
                        </div>
                        <div>
                            <span class="font-bold text-on-surface block">{{ $patient->patient_name }}</span>
                            <span class="text-[10px] text-on-surface-variant">{{ $patient->contact_num ?? 'No contact' }}</span>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-5">
                    <code class="text-xs font-mono text-primary bg-primary/5 px-2 py-1 rounded">{{ $patient->patient_id }}</code>
                </td>
                <td class="px-6 py-5 text-on-surface-variant font-medium">
                    {{ $patient->age }} / {{ substr($patient->sex ?? 'U', 0, 1) }}
                </td>
                <td class="px-6 py-5 text-on-surface-variant">
                    {{ $patient->barangay ?? 'N/A' }}
                </td>
                <td class="px-6 py-5 text-on-surface-variant">
                    {{ $patient->date_registered ? \Carbon\Carbon::parse($patient->date_registered)->format('M d, Y') : 'N/A' }}
                </td>
                
                <td class="px-6 py-5 text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tight {{ $patient->pep_badge ?? 'bg-slate-100 text-slate-500' }}">
                        {{ $patient->pep_status ?? 'No Case' }}
                    </span>
                </td>

                <td class="px-8 py-5 text-right">
                    @if($patient->inflow_record_id)
                        <a href="{{ route('staff.case-encoding', $patient->inflow_record_id) }}" class="px-3 py-1.5 bg-surface-container-lowest text-primary text-xs font-bold rounded-lg border border-primary/20 hover:bg-primary hover:text-white transition-all shadow-sm inline-block">
                            View Case
                        </a>
                    @else
                        <span class="text-xs text-slate-400 font-semibold">No Active Inflow</span>
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7" class="px-8 py-12 text-center text-slate-400 text-sm">
                No matching patient records found in the database.
            </td>
        </tr>
    @endif
</tbody>
</table>
</div>
@if(isset($patients) && $patients->total() > 0)
<div class="px-8 py-4 bg-surface-container-low flex justify-between items-center text-xs text-on-surface-variant font-medium">
    <!-- Real dynamic counts -->
    <p>
        Showing {{ $patients->firstItem() ?? 0 }} to {{ $patients->lastItem() ?? 0 }} of {{ $patients->total() }} registered patients
    </p>

    <div class="flex items-center gap-2">
        <!-- Previous Page Button -->
        @if($patients->onFirstPage())
            <span class="p-1 text-slate-300 cursor-not-allowed">
                <span class="material-symbols-outlined text-[18px]">chevron_left</span>
            </span>
        @else
            <a href="{{ $patients->previousPageUrl() }}" class="p-1 hover:bg-surface-variant rounded transition-colors text-on-surface">
                <span class="material-symbols-outlined text-[18px]">chevron_left</span>
            </a>
        @endif

        <!-- Current Page / Total Pages Indicator -->
        <span class="px-2 font-bold text-on-surface">
            Page {{ $patients->currentPage() }} of {{ $patients->lastPage() }}
        </span>

        <!-- Next Page Button -->
        @if($patients->hasMorePages())
            <a href="{{ $patients->nextPageUrl() }}" class="p-1 hover:bg-surface-variant rounded transition-colors text-on-surface">
                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </a>
        @else
            <span class="p-1 text-slate-300 cursor-not-allowed">
                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </span>
        @endif
    </div>
</div>
@endif
</section>
</div>
</main>
</body></html>