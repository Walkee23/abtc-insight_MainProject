<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Patient Verification - ABTC-Insight</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface": "#f7f9fb",
                        "inverse-surface": "#2d3133",
                        "on-tertiary-fixed": "#311300",
                        "on-tertiary": "#ffffff",
                        "surface-container": "#eceef0",
                        "surface-dim": "#d8dadc",
                        "on-background": "#191c1e",
                        "inverse-primary": "#a9c7ff",
                        "background": "#f7f9fb",
                        "error": "#ba1a1a",
                        "on-primary": "#ffffff",
                        "surface-container-highest": "#e0e3e5",
                        "primary-container": "#0b61bb",
                        "on-surface-variant": "#414751",
                        "on-error": "#ffffff",
                        "tertiary-fixed-dim": "#ffb689",
                        "tertiary": "#7a3800",
                        "primary": "#004a93",
                        "surface-container-high": "#e6e8ea",
                        "inverse-on-surface": "#eff1f3",
                        "outline": "#717782",
                        "on-secondary-fixed": "#011c38",
                        "on-primary-fixed-variant": "#00468c",
                        "on-secondary-fixed-variant": "#314866",
                        "on-primary-container": "#d0dfff",
                        "surface-bright": "#f7f9fb",
                        "outline-variant": "#c1c7d3",
                        "secondary": "#49607f",
                        "on-tertiary-fixed-variant": "#743500",
                        "secondary-fixed-dim": "#b1c8ec",
                        "primary-fixed": "#d6e3ff",
                        "on-secondary-container": "#485f7e",
                        "surface-container-low": "#f2f4f6",
                        "on-secondary": "#ffffff",
                        "secondary-container": "#c1d9fd",
                        "on-surface": "#191c1e",
                        "surface-variant": "#e0e3e5",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-container": "#ffd7c0",
                        "on-primary-fixed": "#001b3d",
                        "secondary-fixed": "#d3e4ff",
                        "on-error-container": "#93000a",
                        "tertiary-container": "#9e4b00",
                        "tertiary-fixed": "#ffdbc8",
                        "surface-tint": "#005db6",
                        "primary-fixed-dim": "#a9c7ff",
                        "error-container": "#ffdad6"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "1rem",
                        "xl": "0.75rem",
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
        body { font-family: 'Inter', sans-serif; background-color: #F4F6F9; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .ghost-border {
            border: 1px solid rgba(193, 199, 211, 0.15);
        }
    </style>
</head>
<body class="text-on-surface antialiased">
<!-- SideNavBar -->
<aside class="fixed left-0 top-0 h-full z-40 h-screen w-72 flex flex-col border-r border-outline-variant/10 bg-white dark:bg-slate-900 font-sans Inter antialiased">
    <div class="p-8 flex items-center gap-3">
        <div class="w-10 h-10 bg-primary-container rounded-xl flex items-center justify-center text-white shadow-md">
            <span class="material-symbols-outlined" data-icon="shield">shield</span>
        </div>
        <div>
            <h1 class="text-xl font-bold tracking-tight text-primary dark:text-blue-200">ABTC-Insight</h1>
        </div>
    </div>
    <nav class="flex-1 mt-4 space-y-1 px-4">
        <a class="flex items-center gap-3 px-4 py-3.5 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-blue-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors" href="{{ route('staff.dashboard') }}">
            <span class="material-symbols-outlined" data-icon="queue">queue</span>
            <span>Queue Management</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3.5 text-primary dark:text-blue-400 font-semibold border-l-4 border-primary dark:border-blue-400 bg-primary/5 transition-all" href="#">
            <span class="material-symbols-outlined" data-icon="verified_user">verified_user</span>
            <span>Patient Verification</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3.5 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-blue-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors" href="{{ route('staff.case-encoding') }}">
            <span class="material-symbols-outlined" data-icon="clinical_notes">clinical_notes</span>
            <span>Case Encoding</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3.5 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-blue-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors" href="{{ route('staff.patient-lookup') }}">
            <span class="material-symbols-outlined" data-icon="person_search">person_search</span>
            <span>Patient Lookup</span>
        </a>
    </nav>
</aside>
<!-- Main Content Wrapper -->
<div class="pl-72 min-h-screen flex flex-col">
<!-- TopNavBar -->
<header class="flex justify-between items-center h-16 w-full pl-8 pr-8 sticky top-0 bg-white/85 dark:bg-slate-950/85 backdrop-blur-md z-30 shadow-sm shadow-slate-200/50 dark:shadow-none border-b border-slate-100/50">
<div class="flex items-center flex-1 max-w-xl">
<div class="relative w-full">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
<input class="w-full bg-slate-100/50 border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-blue-500/20 transition-all" placeholder="Global system search..." type="text"/>
</div>
</div>
<div class="flex items-center gap-4">
<button class="hover:bg-slate-50 dark:hover:bg-slate-800 rounded-full p-2 transition-all duration-300">
<span class="material-symbols-outlined text-slate-600" data-icon="notifications">notifications</span>
</button>
<button class="hover:bg-slate-50 dark:hover:bg-slate-800 rounded-full p-2 transition-all duration-300">
<span class="material-symbols-outlined text-slate-600" data-icon="help">help</span>
</button>
<div class="h-8 w-px bg-slate-200 mx-2"></div>
<div class="flex items-center gap-3 cursor-pointer">
<div class="text-right">
<div class="text-xs font-bold text-slate-900">Staff_01</div>
<div class="text-[10px] text-slate-500 uppercase tracking-tighter">Duty Officer</div>
</div>
<img alt="Staff_01 Profile" class="w-9 h-9 rounded-full object-cover border-2 border-white shadow-sm" data-alt="portrait of a professional medical staff member in a clean white laboratory coat smiling in a modern bright clinical environment" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCMPRqhKKVF_1yQwDf3jiK5jQAF993SE0DwTi03JN0jYzi2KOFBd9hvjLlgruwhYr8bcEbOkzyziXYOv7VzDdOXTKmr9ZHklhhtzrgdmFdbtM5KMy6mC4rQvXqp8fBb2R0F9rT7EuijJkInTKpGAt2n_FNSmjzUGU_gvyLe8slz-BZxohxUmY4bks5zqqWp0FyMHrv8FrFDd68kpwvrUd0hSktqwIBrmMX3kVu3bqOFbETybq_JEwMfhvCYFzSWoi0P9bmqXcpMl5Ux"/>
</div>
</div>
</header>
<!-- Page Canvas -->
<main class="p-8 space-y-8">
<!-- Page Header -->
<section class="flex justify-between items-end">
<div>
<h1 class="text-3xl font-extrabold text-on-surface tracking-tight">Patient Verification</h1>
<p class="text-on-surface-variant mt-1">Verify attendance and move inflow records to patient database.</p>
</div>
<div class="flex gap-3">
<div class="bg-surface-container-highest px-4 py-2 rounded-lg flex items-center gap-3">
<div class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></div>
<span class="text-sm font-semibold text-on-surface-variant">System Online</span>
</div>
</div>
</section>
<!-- Global Search Bar Section -->
<section class="bg-surface-container-low p-6 rounded-lg ghost-border">
<div class="flex gap-4">
<div class="relative flex-1">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary">person_search</span>
<input class="w-full h-14 pl-12 pr-4 bg-surface-container-lowest border-none rounded-lg text-lg placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 transition-all shadow-sm" placeholder="Search by name, tracking ID, or queue number..." type="text"/>
</div>
<button class="px-8 h-14 bg-primary text-white font-bold rounded-lg flex items-center gap-2 hover:bg-primary-container transition-colors shadow-lg shadow-blue-900/10 active:scale-95">
<span class="material-symbols-outlined">search</span>
                        Search Records
                    </button>
</div>
</section>
<!-- Priority Queue Section -->
<section class="bg-surface-container-lowest rounded-lg ghost-border overflow-hidden shadow-sm">
<div class="p-5 flex items-center justify-between border-b border-slate-50">
<div class="flex items-center gap-3">
<div class="w-2 h-2 rounded-full bg-green-500"></div>
<h2 class="text-lg font-bold text-on-surface tracking-tight">Priority Verification Queue (P-Series)</h2>
</div>
<span class="text-xs font-medium text-on-surface-variant bg-surface-container px-3 py-1 rounded-full uppercase tracking-wider">3 Pending</span>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left">
<thead>
<tr class="bg-surface-container-low/50">
<th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Queue No</th>
<th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Patient Name</th>
<th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Priority Type</th>
<th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider text-right">Action</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-50">
<tr class="hover:bg-slate-50/50 transition-colors group">
<td class="px-6 py-4 font-mono font-bold text-primary">P-1042</td>
<td class="px-6 py-4 font-medium">Maria Clara De los Santos</td>
<td class="px-6 py-4">
<span class="px-3 py-1 rounded-full text-[10px] font-bold bg-tertiary-fixed text-on-tertiary-fixed-variant uppercase tracking-wider">Senior Citizen</span>
</td>
<td class="px-6 py-4 text-right">
<button class="bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-primary-container transition-all active:scale-95 shadow-sm">
                                        Verify Attendance &amp; Transfer
                                    </button>
</td>
</tr>
<tr class="hover:bg-slate-50/50 transition-colors group">
<td class="px-6 py-4 font-mono font-bold text-primary">P-1045</td>
<td class="px-6 py-4 font-medium">Elena G. Vicencio</td>
<td class="px-6 py-4">
<span class="px-3 py-1 rounded-full text-[10px] font-bold bg-error-container text-on-error-container uppercase tracking-wider">Pregnant</span>
</td>
<td class="px-6 py-4 text-right">
<button class="bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-primary-container transition-all active:scale-95 shadow-sm">
                                        Verify Attendance &amp; Transfer
                                    </button>
</td>
</tr>
<tr class="hover:bg-slate-50/50 transition-colors group">
<td class="px-6 py-4 font-mono font-bold text-primary">P-1048</td>
<td class="px-6 py-4 font-medium">Ricardo P. Dalisay</td>
<td class="px-6 py-4">
<span class="px-3 py-1 rounded-full text-[10px] font-bold bg-secondary-container text-on-secondary-container uppercase tracking-wider">PWD</span>
</td>
<td class="px-6 py-4 text-right">
<button class="bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-primary-container transition-all active:scale-95 shadow-sm">
                                        Verify Attendance &amp; Transfer
                                    </button>
</td>
</tr>
</tbody>
</table>
</div>
</section>
<!-- Normal Queue Section -->
<section class="bg-surface-container-lowest rounded-lg ghost-border overflow-hidden shadow-sm">
<div class="p-5 flex items-center justify-between border-b border-slate-50">
<h2 class="text-lg font-bold text-on-surface tracking-tight">Normal Verification Queue (N-Series)</h2>
<span class="text-xs font-medium text-on-surface-variant bg-surface-container px-3 py-1 rounded-full uppercase tracking-wider">12 Pending</span>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left">
<thead>
<tr class="bg-surface-container-low/50">
<th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Queue No</th>
<th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Patient Name</th>
<th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Barangay</th>
<th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Case Type</th>
<th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider text-right">Action</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-50">
<tr class="hover:bg-slate-50/50 transition-colors group">
<td class="px-6 py-4 font-mono font-bold text-secondary">N-4421</td>
<td class="px-6 py-4 font-medium">Juan Miguel Ramos</td>
<td class="px-6 py-4 text-sm text-on-surface-variant">Brgy. Guadalupe</td>
<td class="px-6 py-4">
<span class="px-2 py-1 rounded text-[10px] font-bold bg-blue-50 text-blue-700 uppercase">New Case</span>
</td>
<td class="px-6 py-4 text-right">
<button class="bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-primary-container transition-all active:scale-95">
                                        Verify Attendance &amp; Transfer
                                    </button>
</td>
</tr>
<tr class="hover:bg-slate-50/50 transition-colors group">
<td class="px-6 py-4 font-mono font-bold text-secondary">N-4422</td>
<td class="px-6 py-4 font-medium">Sophia Loren Cruz</td>
<td class="px-6 py-4 text-sm text-on-surface-variant">Brgy. Lahug</td>
<td class="px-6 py-4">
<span class="px-2 py-1 rounded text-[10px] font-bold bg-slate-100 text-slate-700 uppercase">Returning</span>
</td>
<td class="px-6 py-4 text-right">
<button class="bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-primary-container transition-all active:scale-95">
                                        Verify Attendance &amp; Transfer
                                    </button>
</td>
</tr>
<tr class="hover:bg-slate-50/50 transition-colors group">
<td class="px-6 py-4 font-mono font-bold text-secondary">N-4423</td>
<td class="px-6 py-4 font-medium">Pedro Manuel Kalaw</td>
<td class="px-6 py-4 text-sm text-on-surface-variant">Brgy. Labangon</td>
<td class="px-6 py-4">
<span class="px-2 py-1 rounded text-[10px] font-bold bg-blue-50 text-blue-700 uppercase">New Case</span>
</td>
<td class="px-6 py-4 text-right">
<button class="bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-primary-container transition-all active:scale-95">
                                        Verify Attendance &amp; Transfer
                                    </button>
</td>
</tr>
</tbody>
</table>
</div>
<div class="p-4 bg-slate-50/50 flex justify-center">
<button class="text-sm font-bold text-primary hover:underline flex items-center gap-1">
                        View Full Normal Queue
                        <span class="material-symbols-outlined text-sm">keyboard_double_arrow_down</span>
</button>
</div>
</section>
</main>
<!-- Footer / System Info -->
<footer class="mt-auto p-8 flex justify-between items-center text-on-surface-variant text-[10px] font-medium uppercase tracking-widest border-t border-slate-100">
<div>© 2024 Cebu City Health Center - ABTC System</div>
<div class="flex gap-6">
<span>API Status: Healthy</span>
<span>Database: bite_cases, patients</span>
<span class="text-primary font-bold">V 2.1.0-STABLE</span>
</div>
</footer>
</div>
</body></html>