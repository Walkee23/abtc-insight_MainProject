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
<!-- SideNavBar -->
<aside class="fixed left-0 top-0 h-full z-40 h-screen w-72 flex flex-col border-r border-outline-variant/10 bg-white dark:bg-slate-900 font-sans Inter antialiased">
<div class="p-8 flex items-center gap-3">
<div class="w-10 h-10 bg-primary-container rounded-xl flex items-center justify-center text-white shadow-md">
<span class="material-symbols-outlined" data-icon="shield">shield</span>
</div>
<div><h1 class="text-xl font-bold tracking-tight text-primary dark:text-blue-200">ABTC-Insight</h1></div>
</div>
<nav class="flex-1 mt-4 space-y-1 px-4">
<!-- Queue Management -->
<a class="flex items-center gap-3 px-4 py-3.5 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-blue-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors" href="{{ route('staff.dashboard') }}">
<span class="material-symbols-outlined" data-icon="queue">queue</span>
<span>Queue Management</span>
</a>
<!-- Patient Verification -->
<a class="flex items-center gap-3 px-4 py-3.5 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-blue-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors" href="{{ route('staff.patient-verification') }}">
<span class="material-symbols-outlined" data-icon="verified_user">verified_user</span>
<span>Patient Verification</span>
</a>
<!-- Case Encoding -->
<a class="flex items-center gap-3 px-4 py-3.5 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-blue-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors" href="{{ route('staff.case-encoding') }}">
<span class="material-symbols-outlined" data-icon="clinical_notes">clinical_notes</span>
<span>Case Encoding</span>
</a>
<!-- Patient Lookup - Active -->
<a class="flex items-center gap-3 px-4 py-3.5 text-primary dark:text-blue-400 font-semibold border-l-4 border-primary dark:border-blue-400 bg-primary/5 transition-all" href="#">
<span class="material-symbols-outlined" data-icon="person_search">person_search</span>
<span>Patient Lookup</span>
</a>
</nav>
<div class="mt-auto mb-4 space-y-1 px-4 border-t border-outline-variant/10 pt-4">
<a class="flex items-center gap-3 px-4 py-3.5 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-blue-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
<span>Settings</span>
</a>
<a class="flex items-center gap-3 px-4 py-3.5 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-blue-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="logout">logout</span>
<span>Logout</span>
</a>
</div>
</aside>
<main class="flex-1 flex flex-col ml-72">
<!-- TopNavBar -->
<header class="flex justify-between items-center w-full h-16 px-8 sticky top-0 z-30 bg-white/85 dark:bg-slate-900/85 backdrop-blur-md border-b border-outline-variant/10 font-sans Inter tracking-tight">
<div class="flex items-center gap-8">
<div class="flex items-center gap-2 text-primary font-bold text-lg tracking-tight">
                    ABTC-Insight
                </div>
<div class="relative group">
<span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-lg">search</span>
<input class="pl-10 pr-4 py-1.5 bg-surface-container-low rounded-full text-sm focus:ring-2 focus:ring-primary/20 border-none outline-none w-72 transition-all" placeholder="Search analytics or case IDs..." type="text"/>
</div>
</div>
<div class="flex items-center gap-4">
<div class="hidden lg:flex items-center gap-2 px-3 py-1 bg-green-50 text-green-700 rounded-full text-[10px] font-bold uppercase tracking-wider">
<span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                    12 Active
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
<div class="flex items-center gap-3 pl-2">
<div class="text-right hidden sm:block">
<p class="text-xs font-bold text-on-surface leading-tight">Dr. Elena Santos</p>
<p class="text-[10px] text-on-surface-variant leading-tight">Senior Staff Physician</p>
</div>
<div class="relative">
<img alt="Staff Profile" class="w-9 h-9 rounded-full border border-outline-variant/20 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC9XatGr4YAEN_U5F59LpiJuLypk1UE84qqND4HiNol0XC4NMhmT9nOhPZnG0ln0Nkd6-utpH-7Pvp4n39JXuYGM_aN7nshF7sO3ilVSg9Cf-OrQGfOTWSNuYavMvjMAqJvQyRrztYipPWBnMSFBASZ7ESZ9K-0cA1KQ_Fc-2JGK2S7RYYNMWDaUaON2vJpa1qMKCY8FA_-DWpGqbi6oX1EFG-YLGJcqW2vJ3qinM5W98E-0WG1esArKi5jG2gzajKi_x5jZKCs8VoC"/>
<div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
</div>
</div>
</div>
</header>
<!-- Main Content -->
<div class="p-8 max-w-7xl mx-auto w-full space-y-8">
<!-- Header Section -->
<section>
<h1 class="text-4xl font-bold text-on-surface tracking-tight mb-2">Patient Lookup &amp; Records</h1>
<p class="text-on-surface-variant font-medium">Search and retrieve comprehensive patient medical history and vaccination records.</p>
</section>
<!-- Search Area -->
<section class="bg-surface-container-lowest p-8 rounded-xl tonal-elevation ghost-border">
<div class="flex flex-col md:flex-row gap-4 items-center">
<div class="relative flex-1 w-full">
<div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
<span class="material-symbols-outlined text-outline" data-icon="search">search</span>
</div>
<input class="w-full pl-12 pr-4 py-4 bg-surface-container-highest border-none rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all text-on-surface placeholder:text-outline/70" placeholder="Search by full name or Unique Patient Identifier (e.g., CEB-20260402-20010101-001)" type="text"/>
</div>
<button class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-primary to-primary-container text-white font-bold rounded-lg hover:shadow-lg hover:shadow-primary/20 transition-all active:scale-95 duration-150">
                        Search Patient
                    </button>
</div>
<div class="mt-4 flex gap-4 text-xs font-medium text-on-surface-variant px-2">
<span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]" data-icon="history">history</span> Recent: Maria Clara</span>
<span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]" data-icon="history">history</span> Recent: Juan Dela Cruz</span>
</div>
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
<!-- Row 1 -->
<tr class="hover:bg-surface-bright transition-colors group">
<td class="px-8 py-5">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-xs">JD</div>
<span class="font-bold text-on-surface">Juan Dela Cruz</span>
</div>
</td>
<td class="px-6 py-5">
<code class="text-xs font-mono text-primary bg-primary/5 px-2 py-1 rounded">CEB-20250110-19980305-001</code>
</td>
<td class="px-6 py-5 text-on-surface-variant font-medium">26 / M</td>
<td class="px-6 py-5 text-on-surface-variant">Brgy. Guadalupe</td>
<td class="px-6 py-5 text-on-surface-variant">Apr 04, 2026</td>
<td class="px-6 py-5 text-center">
<span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-[#ffdbc8] text-[#743500] uppercase tracking-tight">Yes (D3)</span>
</td>
<td class="px-8 py-5 text-right">
<button class="px-4 py-2 text-primary font-bold hover:bg-primary/5 rounded-lg transition-all">View Record</button>
</td>
</tr>
<!-- Row 2 -->
<tr class="hover:bg-surface-bright transition-colors group">
<td class="px-8 py-5">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-tertiary-fixed text-on-tertiary-fixed flex items-center justify-center font-bold text-xs">MC</div>
<span class="font-bold text-on-surface">Maria Clara</span>
</div>
</td>
<td class="px-6 py-5">
<code class="text-xs font-mono text-primary bg-primary/5 px-2 py-1 rounded">CEB-20260404-20040512-002</code>
</td>
<td class="px-6 py-5 text-on-surface-variant font-medium">22 / F</td>
<td class="px-6 py-5 text-on-surface-variant">Brgy. Mabolo</td>
<td class="px-6 py-5 text-on-surface-variant">Apr 04, 2026</td>
<td class="px-6 py-5 text-center">
<span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-[#ffdad6] text-[#93000a] uppercase tracking-tight">Yes (D0)</span>
</td>
<td class="px-8 py-5 text-right">
<button class="px-4 py-2 text-primary font-bold hover:bg-primary/5 rounded-lg transition-all">View Record</button>
</td>
</tr>
<!-- Row 3 (Visual Placeholder) -->
<tr class="hover:bg-surface-bright transition-colors group opacity-75">
<td class="px-8 py-5">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-outline-variant/30 text-on-surface-variant flex items-center justify-center font-bold text-xs">PR</div>
<span class="font-bold text-on-surface">Pedro Rizal</span>
</div>
</td>
<td class="px-6 py-5">
<code class="text-xs font-mono text-primary bg-primary/5 px-2 py-1 rounded">CEB-20241215-19900222-045</code>
</td>
<td class="px-6 py-5 text-on-surface-variant font-medium">34 / M</td>
<td class="px-6 py-5 text-on-surface-variant">Brgy. Lahug</td>
<td class="px-6 py-5 text-on-surface-variant">Mar 22, 2026</td>
<td class="px-6 py-5 text-center">
<span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-surface-container-highest text-outline uppercase tracking-tight">Completed</span>
</td>
<td class="px-8 py-5 text-right">
<button class="px-4 py-2 text-primary font-bold hover:bg-primary/5 rounded-lg transition-all">View Record</button>
</td>
</tr>
</tbody>
</table>
</div>
<div class="px-8 py-4 bg-surface-container-low flex justify-between items-center text-xs text-on-surface-variant font-medium">
<p>Showing 3 of 1,248 registered patients</p>
<div class="flex items-center gap-2">
<button class="p-1 hover:bg-surface-variant rounded transition-colors disabled:opacity-30" disabled="">
<span class="material-symbols-outlined text-[18px]" data-icon="chevron_left">chevron_left</span>
</button>
<span class="px-2 font-bold text-on-surface">1</span>
<button class="p-1 hover:bg-surface-variant rounded transition-colors">
<span class="material-symbols-outlined text-[18px]" data-icon="chevron_right">chevron_right</span>
</button>
</div>
</div>
</section>
<!-- Quick Access Bento Grid -->
</div>
</main>
</body></html>