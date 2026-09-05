<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>BHW Referral Dashboard | Cebu City ABTC Insight</title>
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
                        "error-container": "#ffdad6",
                        "outline-variant": "#c1c7d3",
                        "on-secondary": "#ffffff",
                        "surface-dim": "#d8dadc",
                        "secondary": "#49607f",
                        "on-tertiary-container": "#ffd7c0",
                        "primary-fixed": "#d6e3ff",
                        "on-secondary-container": "#485f7e",
                        "on-tertiary-fixed": "#311300",
                        "background": "#f7f9fb",
                        "tertiary": "#7a3800",
                        "primary-fixed-dim": "#a9c7ff",
                        "surface-container": "#eceef0",
                        "on-background": "#191c1e",
                        "on-secondary-fixed": "#011c38",
                        "outline": "#717782",
                        "inverse-surface": "#2d3133",
                        "tertiary-fixed": "#ffdbc8",
                        "error": "#ba1a1a",
                        "tertiary-container": "#9e4b00",
                        "secondary-fixed-dim": "#b1c8ec",
                        "on-primary-fixed": "#001b3d",
                        "surface": "#f7f9fb",
                        "tertiary-fixed-dim": "#ffb689",
                        "on-error": "#ffffff",
                        "inverse-on-surface": "#eff1f3",
                        "on-error-container": "#93000a",
                        "on-primary-container": "#d0dfff",
                        "on-surface": "#191c1e",
                        "secondary-fixed": "#d3e4ff",
                        "on-tertiary-fixed-variant": "#743500",
                        "surface-bright": "#f7f9fb",
                        "inverse-primary": "#a9c7ff",
                        "surface-tint": "#005db6",
                        "primary": "#004a93",
                        "on-primary": "#ffffff",
                        "surface-variant": "#e0e3e5",
                        "surface-container-highest": "#e0e3e5",
                        "on-primary-fixed-variant": "#00468c",
                        "surface-container-high": "#e6e8ea",
                        "primary-container": "#0b61bb",
                        "secondary-container": "#c1d9fd",
                        "surface-container-low": "#f2f4f6",
                        "on-surface-variant": "#414751",
                        "on-tertiary": "#ffffff",
                        "on-secondary-fixed-variant": "#314866",
                        "surface-container-lowest": "#ffffff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "1rem",
                        "xl": "1.25rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Inter"],
                        "display": ["Inter"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    }
                }
            }
        }
    </script>
<style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .custom-glass {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.85);
        }
    </style>
</head>
<body class="bg-surface text-on-surface antialiased">
<!-- SideNavBar Component -->
<aside class="h-screen w-64 fixed left-0 top-0 overflow-y-auto bg-surface-container-low flex flex-col py-8 z-50 border-r border-outline-variant/10">
<div class="px-6 mb-8 flex items-center gap-3">
<div class="w-10 h-10 bg-primary-container rounded-xl flex items-center justify-center text-white shadow-md">
<span class="material-symbols-outlined" data-icon="shield">shield</span>
</div>
<div>
<h1 class="text-xl font-bold tracking-tight text-primary">ABTC-Insight</h1>
</div>
</div>
<nav class="flex-1 mt-4 space-y-1 px-4">
<a class="flex items-center gap-3 px-4 py-3.5 text-primary font-bold bg-primary/5 border-l-4 border-primary rounded-r-lg transition-all" href="#">
<span class="material-symbols-outlined font-variation-settings-fill">assignment_turned_in</span>
<span class="text-sm">My Referrals</span>
</a>
<a class="flex items-center gap-3 px-4 py-3.5 text-on-surface-variant hover:text-primary hover:bg-slate-50 rounded-lg transition-all" href="{{ route('bhw.referral-form') }}">
<span class="material-symbols-outlined">add_circle</span>
<span class="text-sm font-medium">Create New Referral</span>
</a>
</nav>
<div class="mt-auto px-4 pb-4">
<button class="w-full py-4 bg-primary text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-primary/20 hover:bg-primary-container transition-all">
<span class="material-symbols-outlined">add</span>
<span class="text-sm">New Referral</span>
</button>
</div>
</aside>
<!-- Main Canvas Area -->
<main class="ml-64 min-h-screen relative">
<!-- TopAppBar Component -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] z-40 bg-surface-bright/85 backdrop-blur-xl flex justify-between items-center h-20 px-8 border-b border-outline-variant/10 shadow-sm">
<div class="flex items-center gap-6">
<div class="flex items-center gap-4 bg-surface-container-highest px-4 py-2 rounded-full w-80">
<span class="material-symbols-outlined text-on-surface-variant text-xl">search</span>
<input class="bg-transparent border-none focus:ring-0 text-sm w-full placeholder:text-on-surface-variant/60" placeholder="Search Reference No. or Patient..." type="text"/>
</div>
</div>
<div class="flex items-center gap-6">
<div class="flex items-center gap-2">
<button class="p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-all">
<span class="material-symbols-outlined">help_outline</span>
</button>
<button class="p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-all relative">
<span class="material-symbols-outlined">notifications</span>
<span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-surface-bright"></span>
</button>
</div>
<div class="h-8 w-[1px] bg-outline-variant/30"></div>
<div class="flex items-center gap-3">
<div class="text-right">
<p class="text-xs font-bold text-on-surface leading-tight">Maria Santos</p>
<p class="text-[10px] text-on-surface-variant font-semibold">BHW - GUADALUPE</p>
</div>
<div class="relative">
<img alt="Maria Santos Profile" class="w-10 h-10 rounded-full object-cover border-2 border-primary/10" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCYXEfbdf1WqBtOmi-7pBaGEzvLw0ec1xSc8n2gxOR_x-J3wdc6kf9vnZ85PaHPIQCh1kv_tVfhn4Rnh61XmI4c6xTOgh7JBQwsuwAvfnnZUe9RXB8MhAI80cZskKvKdKAJZ5k7jnYHili_iuKnZkftjZN3qq74m80X9kjK0qI6g2oqTanqlzZnmzay0Z3RCJlCI04rRH-O2Hxp6Hc061pjAUy_7LOK9etgaYMxprFXpanaIhoYgcdEiaWYUEUrcuw2_cVQ3jnM9k-K"/>
<div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
</div>
</div>
</div>
</header>
<!-- Content Canvas -->
<div class="pt-28 px-10 pb-12">
<!-- Header Section -->
<div class="flex justify-between items-end mb-10">
<div>
<h1 class="text-3xl font-extrabold tracking-tight text-on-surface mb-2">My Referrals</h1>
<p class="text-on-surface-variant text-sm font-medium">Track and manage your submitted patient referrals to CHD-ABTC.</p>
</div>
<button class="px-6 py-3 bg-primary text-white rounded-xl font-bold flex items-center gap-2 shadow-xl shadow-primary/25 hover:bg-primary-container transition-all hover:-translate-y-0.5 active:translate-y-0">
<span class="material-symbols-outlined" data-icon="add_circle">add_circle</span>
                    + New Referral
                </button>
</div>
<!-- Dashboard Statistics Bento Grid (Modern Insight Layer) -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10">
<p class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant mb-4">Total Submissions</p>
<div class="flex items-end justify-between">
<h3 class="text-4xl font-black text-primary leading-none">124</h3>
<span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">+12%</span>
</div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10">
<p class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant mb-4">Pending Review</p>
<h3 class="text-4xl font-black text-tertiary leading-none">08</h3>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10">
<p class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant mb-4">Received at ABTC</p>
<h3 class="text-4xl font-black text-secondary leading-none">42</h3>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 bg-gradient-to-br from-primary to-primary-container">
<p class="text-[10px] uppercase tracking-widest font-bold text-white/70 mb-4">Completed Cycles</p>
<h3 class="text-4xl font-black text-white leading-none">74</h3>
</div>
</div>
<!-- Referral Table Section (Clinical Precision) -->
<div class="bg-surface-container-lowest rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low border-b border-outline-variant/10">
<th class="px-6 py-5 text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Reference No.</th>
<th class="px-6 py-5 text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Patient Name</th>
<th class="px-6 py-5 text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Barangay</th>
<th class="px-6 py-5 text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Date Referred</th>
<th class="px-6 py-5 text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Exposure Type</th>
<th class="px-6 py-5 text-[11px] font-bold text-on-surface-variant uppercase tracking-wider text-center">Status</th>
<th class="px-6 py-5 text-[11px] font-bold text-on-surface-variant uppercase tracking-wider text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/10">
<!-- Row 1: Pending -->
<tr class="hover:bg-surface-container-low/50 transition-colors group">
<td class="px-6 py-5">
<span class="text-xs font-black font-mono text-primary bg-primary/5 px-2 py-1 rounded">BRY-001-20250501-0023</span>
</td>
<td class="px-6 py-5">
<p class="text-sm font-bold text-on-surface">Juan Dela Cruz</p>
</td>
<td class="px-6 py-5">
<p class="text-sm text-on-surface-variant">Guadalupe</p>
</td>
<td class="px-6 py-5">
<p class="text-sm text-on-surface-variant">May 01, 2025</p>
</td>
<td class="px-6 py-5">
<span class="text-xs font-semibold text-error bg-error-container/40 px-3 py-1 rounded-full">Bite</span>
</td>
<td class="px-6 py-5 text-center">
<span class="inline-flex items-center rounded-full bg-tertiary-fixed px-3 py-1 text-xs font-bold text-on-tertiary-fixed-variant">
<span class="w-1.5 h-1.5 rounded-full bg-tertiary mr-2"></span>
                                        Pending
                                    </span>
</td>
<td class="px-6 py-5 text-right">
<div class="flex justify-end gap-2">
<button class="p-2 text-on-surface-variant hover:text-primary transition-all">
<span class="material-symbols-outlined text-lg" data-icon="visibility">visibility</span>
</button>
<button class="p-2 text-on-surface-variant hover:text-primary transition-all">
<span class="material-symbols-outlined text-lg" data-icon="print">print</span>
</button>
</div>
</td>
</tr>
<!-- Row 2: Received -->
<tr class="hover:bg-surface-container-low/50 transition-colors group">
<td class="px-6 py-5">
<span class="text-xs font-black font-mono text-primary bg-primary/5 px-2 py-1 rounded">BRY-001-20250428-0019</span>
</td>
<td class="px-6 py-5">
<p class="text-sm font-bold text-on-surface">Maria Clara Ibarra</p>
</td>
<td class="px-6 py-5">
<p class="text-sm text-on-surface-variant">Guadalupe</p>
</td>
<td class="px-6 py-5">
<p class="text-sm text-on-surface-variant">Apr 28, 2025</p>
</td>
<td class="px-6 py-5">
<span class="text-xs font-semibold text-secondary bg-secondary-container/40 px-3 py-1 rounded-full">Non-Bite</span>
</td>
<td class="px-6 py-5 text-center">
<span class="inline-flex items-center rounded-full bg-secondary-fixed px-3 py-1 text-xs font-bold text-on-secondary-fixed-variant">
<span class="w-1.5 h-1.5 rounded-full bg-secondary mr-2"></span>
                                        Received
                                    </span>
</td>
<td class="px-6 py-5 text-right">
<div class="flex justify-end gap-2">
<button class="p-2 text-on-surface-variant hover:text-primary transition-all">
<span class="material-symbols-outlined text-lg" data-icon="visibility">visibility</span>
</button>
<button class="p-2 text-on-surface-variant hover:text-primary transition-all">
<span class="material-symbols-outlined text-lg" data-icon="print">print</span>
</button>
</div>
</td>
</tr>
<!-- Row 3: Completed -->
<tr class="hover:bg-surface-container-low/50 transition-colors group">
<td class="px-6 py-5">
<span class="text-xs font-black font-mono text-primary bg-primary/5 px-2 py-1 rounded">BRY-001-20250425-0012</span>
</td>
<td class="px-6 py-5">
<p class="text-sm font-bold text-on-surface">Jose Rizal</p>
</td>
<td class="px-6 py-5">
<p class="text-sm text-on-surface-variant">Guadalupe</p>
</td>
<td class="px-6 py-5">
<p class="text-sm text-on-surface-variant">Apr 25, 2025</p>
</td>
<td class="px-6 py-5">
<span class="text-xs font-semibold text-error bg-error-container/40 px-3 py-1 rounded-full">Bite</span>
</td>
<td class="px-6 py-5 text-center">
<span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-800">
<span class="w-1.5 h-1.5 rounded-full bg-green-600 mr-2"></span>
                                        Completed
                                    </span>
</td>
<td class="px-6 py-5 text-right">
<div class="flex justify-end gap-2">
<button class="p-2 text-on-surface-variant hover:text-primary transition-all">
<span class="material-symbols-outlined text-lg" data-icon="visibility">visibility</span>
</button>
<button class="p-2 text-on-surface-variant hover:text-primary transition-all">
<span class="material-symbols-outlined text-lg" data-icon="print">print</span>
</button>
</div>
</td>
</tr>
<!-- Row 4: Pending -->
<tr class="hover:bg-surface-container-low/50 transition-colors group">
<td class="px-6 py-5">
<span class="text-xs font-black font-mono text-primary bg-primary/5 px-2 py-1 rounded">BRY-001-20250422-0008</span>
</td>
<td class="px-6 py-5">
<p class="text-sm font-bold text-on-surface">Andres Bonifacio</p>
</td>
<td class="px-6 py-5">
<p class="text-sm text-on-surface-variant">Guadalupe</p>
</td>
<td class="px-6 py-5">
<p class="text-sm text-on-surface-variant">Apr 22, 2025</p>
</td>
<td class="px-6 py-5">
<span class="text-xs font-semibold text-error bg-error-container/40 px-3 py-1 rounded-full">Bite</span>
</td>
<td class="px-6 py-5 text-center">
<span class="inline-flex items-center rounded-full bg-tertiary-fixed px-3 py-1 text-xs font-bold text-on-tertiary-fixed-variant">
<span class="w-1.5 h-1.5 rounded-full bg-tertiary mr-2"></span>
                                        Pending
                                    </span>
</td>
<td class="px-6 py-5 text-right">
<div class="flex justify-end gap-2">
<button class="p-2 text-on-surface-variant hover:text-primary transition-all">
<span class="material-symbols-outlined text-lg" data-icon="visibility">visibility</span>
</button>
<button class="p-2 text-on-surface-variant hover:text-primary transition-all">
<span class="material-symbols-outlined text-lg" data-icon="print">print</span>
</button>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<!-- Pagination Footer -->
<div class="px-6 py-5 bg-surface-container-low/30 border-t border-outline-variant/5 flex justify-between items-center">
<p class="text-xs font-medium text-on-surface-variant">Showing 1 to 4 of 124 referrals</p>
<div class="flex gap-2">
<button class="p-2 rounded-lg border border-outline-variant/30 text-on-surface-variant hover:bg-surface-container-highest transition-all disabled:opacity-30">
<span class="material-symbols-outlined text-sm" data-icon="chevron_left">chevron_left</span>
</button>
<button class="p-2 rounded-lg border border-outline-variant/30 text-on-surface-variant hover:bg-surface-container-highest transition-all">
<span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
</button>
</div>
</div>
</div>
<!-- Contextual Help / Status Legend -->
<div class="mt-8 flex gap-8">
<div class="flex items-center gap-2">
<div class="w-2 h-2 rounded-full bg-tertiary"></div>
<span class="text-[11px] font-bold text-on-surface-variant uppercase">Pending: Waiting for health center assessment</span>
</div>
<div class="flex items-center gap-2">
<div class="w-2 h-2 rounded-full bg-secondary"></div>
<span class="text-[11px] font-bold text-on-surface-variant uppercase">Received: Patient has arrived at ABTC</span>
</div>
<div class="flex items-center gap-2">
<div class="w-2 h-2 rounded-full bg-green-600"></div>
<span class="text-[11px] font-bold text-on-surface-variant uppercase">Completed: Full vaccination series recorded</span>
</div>
</div>
</div>
</main>
</body></html>