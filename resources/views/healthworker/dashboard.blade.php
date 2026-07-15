<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Health Worker Dashboard - ABTC-Insight</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
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
        body { font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-surface text-on-surface">
<!-- SideNavBar -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-slate-100 dark:bg-slate-900 flex flex-col py-8 gap-2 z-50">
<div class="px-6 mb-8">
<div class="flex items-center gap-3 mb-8">
<div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white shadow-lg">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
</div>
<div>
<h1 class="text-blue-900 dark:text-blue-50 font-bold text-sm tracking-tight leading-none">ABTC-Insight</h1>
</div>
</div>
</div>
<nav class="flex-1 space-y-1">
<!-- Dashboard (Active) -->
<a class="flex items-center gap-3 px-4 py-3 text-blue-700 dark:text-blue-400 bg-white dark:bg-slate-800 rounded-r-full border-l-4 border-blue-700 transition-all duration-300 ease-out" href="#">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
<span class="text-sm font-medium font-['Inter']">Dashboard</span>
</a>
<!-- Clinical Encoding -->
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:translate-x-1 hover:text-blue-600 dark:hover:text-blue-300 transition-all duration-300 ease-out" href="#">
<span class="material-symbols-outlined" data-icon="medical_services">medical_services</span>
<span class="text-sm font-medium font-['Inter']">Clinical Encoding</span>
</a>
<!-- Treatment Tracker -->
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:translate-x-1 hover:text-blue-600 dark:hover:text-blue-300 transition-all duration-300 ease-out" href="#">
<span class="material-symbols-outlined" data-icon="monitor_heart">monitor_heart</span>
<span class="text-sm font-medium font-['Inter']">Treatment Tracker</span>
</a>
<!-- Patient Database -->
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:translate-x-1 hover:text-blue-600 dark:hover:text-blue-300 transition-all duration-300 ease-out" href="#">
<span class="material-symbols-outlined" data-icon="database">database</span>
<span class="text-sm font-medium font-['Inter']">Patient Database</span>
</a>
<!-- Compliance -->
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:translate-x-1 hover:text-blue-600 dark:hover:text-blue-300 transition-all duration-300 ease-out" href="#">
<span class="material-symbols-outlined" data-icon="verified_user">verified_user</span>
<span class="text-sm font-medium font-['Inter']">Compliance</span>
</a>
</nav>
<div class="mt-auto px-6 space-y-1 pt-6 border-t border-slate-200 dark:border-slate-800">
</div>
</aside>
<!-- TopNavBar (Updated to match SCREEN_12 layout) -->
<header class="fixed top-0 w-full h-16 bg-slate-50/85 dark:bg-slate-900/85 backdrop-blur-md shadow-sm shadow-blue-900/5 z-40">
<div class="flex justify-between items-center px-8 h-16 w-full">
<!-- Logo on the far left -->
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white shadow-md">
<span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
</div>
<h1 class="text-blue-900 dark:text-blue-50 font-bold text-sm tracking-tight leading-none">ABTC-Insight</h1>
</div>
<!-- Search Bar -->
<div class="flex items-center flex-1 max-w-md ml-12">
<div class="relative w-full group">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm group-focus-within:text-blue-700 transition-colors">search</span>
<input class="w-full bg-slate-100 dark:bg-slate-800/50 border-none rounded-full py-2 pl-9 pr-4 text-xs focus:ring-2 focus:ring-blue-700/20 placeholder:text-slate-400 font-['Inter']" placeholder="Search for patients..." type="text"/>
</div>
</div>
<!-- Right Side Actions (Notifications, Help, Vertical Divider, Profile) -->
<div class="flex items-center gap-4">
<button class="relative w-9 h-9 flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all rounded-full">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
<span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-slate-50"></span>
</button>
<button class="w-9 h-9 flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all rounded-full">
<span class="material-symbols-outlined" data-icon="help">help</span>
</button>
<div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-800 mx-2"></div>
<div class="flex items-center gap-3 cursor-pointer group">
<div class="text-right hidden lg:block">
<p class="text-xs font-bold text-on-surface leading-tight font-['Inter']">Dr. Elena Santos</p>
<p class="text-[10px] text-on-surface-variant font-['Inter']">Senior Health Worker</p>
</div>
<img alt="Health Worker Profile" class="w-9 h-9 rounded-full object-cover ring-2 ring-primary/10 group-hover:ring-primary/30 transition-all" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAzuEzGuKhuDJKI44bu6U1YzFdI7z5disX1FjUVLwgq07xpkF1vi2q1RQg1lWnbbzx-97qaEaUE0wHwrsBEDnQdIf8whoLOPKyx4AYqvvB-lfqq-SS3OBugICvjWAE_JcAHe0Vi0CwgldGbMzdKqqq-JDxrvKkK7FcZlxsnNKgOhrLZQUJ0ev2rjCkC13g53yP7Tgqv7JJmgsQFbx1nOvxapzia3kkgWKs_FBVNJ7u5msUyUkju3OqnpM2i3ofnQDyojEEc-LEA3xlD"/>
</div>
</div>
</div>
</header>
<!-- Main Canvas -->
<main class="ml-64 pt-24 px-10 pb-12 min-h-screen">
<!-- Header Section -->
<header class="mb-10">
<h2 class="text-3xl font-extrabold tracking-tight text-on-surface mb-1">Good morning, Dr. Elena</h2>
<p class="text-on-surface-variant font-medium">Welcome back to Cebu City Health Center's Clinical Portal.</p>
</header>
<!-- Stats Bento Grid -->
<section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
<!-- Stat Card 1 -->
<div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group hover:bg-surface-bright transition-all duration-300">
<div class="flex items-start justify-between mb-4">
<div class="p-2 bg-blue-50 rounded-lg text-primary">
<span class="material-symbols-outlined" data-icon="pending_actions">pending_actions</span>
</div>
<span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Encoding Phase</span>
</div>
<h3 class="text-label-md text-on-surface-variant mb-1">Pending Section VI-IX Encoding</h3>
<div class="flex items-baseline gap-2">
<span class="text-4xl font-extrabold tracking-tighter text-on-surface">24</span>
<span class="text-xs font-semibold text-error px-2 py-0.5 bg-error-container/30 rounded-full">High Priority</span>
</div>
<div class="absolute -bottom-4 -right-4 opacity-5 group-hover:opacity-10 transition-opacity">
<span class="material-symbols-outlined text-8xl" data-icon="clinical_notes">clinical_notes</span>
</div>
</div>
<!-- Stat Card 2 -->
<div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group hover:bg-surface-bright transition-all duration-300">
<div class="flex items-start justify-between mb-4">
<div class="p-2 bg-orange-50 rounded-lg text-tertiary">
<span class="material-symbols-outlined" data-icon="vaccines">vaccines</span>
</div>
<span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Active Cases</span>
</div>
<h3 class="text-label-md text-on-surface-variant mb-1">Active PEP Series</h3>
<div class="flex items-baseline gap-2">
<span class="text-4xl font-extrabold tracking-tighter text-on-surface">142</span>
<span class="text-xs font-semibold text-secondary-container text-on-secondary-container px-2 py-0.5 bg-secondary-container/20 rounded-full">+12 Today</span>
</div>
<div class="absolute -bottom-4 -right-4 opacity-5 group-hover:opacity-10 transition-opacity">
<span class="material-symbols-outlined text-8xl" data-icon="monitoring">monitoring</span>
</div>
</div>
<!-- Stat Card 3 -->
<div class="bg-primary p-6 rounded-xl relative overflow-hidden group shadow-lg shadow-blue-900/10 transition-all duration-300">
<div class="flex items-start justify-between mb-4 text-primary-container">
<div class="p-2 bg-white/10 rounded-lg">
<span class="material-symbols-outlined" data-icon="verified_user" style="font-variation-settings: 'FILL' 1;">verified_user</span>
</div>
<span class="text-[10px] font-bold uppercase tracking-widest text-primary-fixed-dim">Validation Hub</span>
</div>
<h3 class="text-label-md text-white/80 mb-1">Today's Verified Cases</h3>
<div class="flex items-baseline gap-2">
<span class="text-4xl font-extrabold tracking-tighter text-white">44</span>
<span class="text-xs font-semibold text-primary-fixed bg-white/10 px-2 py-0.5 rounded-full">92% Compliance</span>
</div>
<div class="absolute -bottom-4 -right-4 opacity-10 group-hover:opacity-20 transition-opacity text-white">
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
<button class="px-4 py-2 text-sm font-semibold bg-surface-container-high text-on-surface-variant rounded-full hover:bg-surface-variant transition-colors">Filter</button>
<button class="px-4 py-2 text-sm font-semibold bg-surface-container-high text-on-surface-variant rounded-full hover:bg-surface-variant transition-colors">Export</button>
</div>
</div>
<div class="overflow-x-auto no-scrollbar">
<table class="w-full text-left">
<thead>
<tr class="text-[11px] uppercase tracking-widest text-slate-400 font-bold border-b border-surface-container-low">
<th class="pb-4 pl-4 font-bold">Queue No.</th>
<th class="pb-4">Patient Name</th>
<th class="pb-4">Case Info</th>
<th class="pb-4">Priority Type</th>
<th class="pb-4 text-right pr-4">Action</th>
</tr>
</thead>
<tbody class="divide-y divide-surface-container-low">
<!-- Row 1 -->
<tr class="group hover:bg-surface/50 transition-colors">
<td class="py-5 pl-4">
<span class="text-sm font-bold text-blue-700 bg-blue-50 px-3 py-1 rounded-lg">#0824</span>
</td>
<td class="py-5">
<div>
<p class="text-sm font-bold text-on-surface">Mateo Dela Cruz</p>
<p class="text-[11px] text-on-surface-variant">ID: 294-ABTC-2023</p>
</div>
</td>
<td class="py-5">
<span class="text-xs font-medium text-slate-600 bg-slate-100 px-3 py-1 rounded-full">Returning Case #2</span>
</td>
<td class="py-5">
<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-error-container text-on-error-container">
<span class="w-1.5 h-1.5 rounded-full bg-error"></span> Urgent
                                    </span>
</td>
<td class="py-5 text-right pr-4">
<button class="text-xs font-bold text-primary hover:bg-primary/5 px-4 py-2 rounded-lg transition-colors border border-primary/10">Start Clinical Encoding</button>
</td>
</tr>
<!-- Row 2 -->
<tr class="group hover:bg-surface/50 transition-colors">
<td class="py-5 pl-4">
<span class="text-sm font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-lg">#0825</span>
</td>
<td class="py-5">
<div>
<p class="text-sm font-bold text-on-surface">Isabella Montenegro</p>
<p class="text-[11px] text-on-surface-variant">ID: 882-ABTC-2023</p>
</div>
</td>
<td class="py-5">
<span class="text-xs font-medium text-slate-600 bg-slate-100 px-3 py-1 rounded-full">New Exposure</span>
</td>
<td class="py-5">
<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-secondary-container text-on-secondary-container">
<span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Standard
                                    </span>
</td>
<td class="py-5 text-right pr-4">
<button class="text-xs font-bold text-primary hover:bg-primary/5 px-4 py-2 rounded-lg transition-colors border border-primary/10">Start Clinical Encoding</button>
</td>
</tr>
<!-- Row 3 -->
<tr class="group hover:bg-surface/50 transition-colors">
<td class="py-5 pl-4">
<span class="text-sm font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-lg">#0826</span>
</td>
<td class="py-5">
<div>
<p class="text-sm font-bold text-on-surface">Ricardo Lopez</p>
<p class="text-[11px] text-on-surface-variant">ID: 105-ABTC-2023</p>
</div>
</td>
<td class="py-5">
<span class="text-xs font-medium text-slate-600 bg-slate-100 px-3 py-1 rounded-full">Returning Case #1</span>
</td>
<td class="py-5">
<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-secondary-container text-on-secondary-container">
<span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Standard
                                    </span>
</td>
<td class="py-5 text-right pr-4">
<button class="text-xs font-bold text-primary hover:bg-primary/5 px-4 py-2 rounded-lg transition-colors border border-primary/10">Start Clinical Encoding</button>
</td>
</tr>
</tbody>
</table>
</div>
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
<!-- Reminder Item -->
<div class="flex gap-4 p-3 bg-surface-container-lowest rounded-lg border-l-4 border-error shadow-sm shadow-black/5">
<div class="mt-1">
<span class="material-symbols-outlined text-error text-lg" data-icon="error">error</span>
</div>
<div>
<p class="text-xs font-bold text-on-surface mb-0.5">Missed Appointment: #0742</p>
<p class="text-[11px] text-on-surface-variant leading-relaxed">Juan Gomez failed to appear for Day 7 PEP dose. Immediate contact required.</p>
<button class="mt-2 text-[10px] font-bold text-primary flex items-center">
                                    REACH OUT <span class="material-symbols-outlined text-[12px] ml-1" data-icon="arrow_forward">arrow_forward</span>
</button>
</div>
</div>
<!-- Reminder Item -->
<div class="flex gap-4 p-3 bg-surface-container-lowest rounded-lg border-l-4 border-tertiary shadow-sm shadow-black/5">
<div class="mt-1">
<span class="material-symbols-outlined text-tertiary text-lg" data-icon="inventory_2">inventory_2</span>
</div>
<div>
<p class="text-xs font-bold text-on-surface mb-0.5">Inventory Alert</p>
<p class="text-[11px] text-on-surface-variant leading-relaxed">RIG stock below threshold for Ward B. Restock request sent to pharmacy.</p>
</div>
</div>
</div>
</div>
<!-- Recent Activity Feed -->
<div class="bg-surface-container-lowest rounded-xl p-6">
<div class="flex items-center justify-between mb-6">
<h3 class="text-md font-bold text-on-surface">Recent Activity</h3>
<span class="material-symbols-outlined text-slate-300" data-icon="history">history</span>
</div>
<div class="space-y-6 relative before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-[2px] before:bg-slate-100">
<div class="relative pl-8">
<span class="absolute left-0 top-1 w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center border-4 border-white z-10">
<span class="material-symbols-outlined text-[12px] text-primary" data-icon="edit">edit</span>
</span>
<p class="text-[11px] text-on-surface-variant">12 minutes ago</p>
<p class="text-xs font-semibold text-on-surface">Section VI Updated</p>
<p class="text-[11px] text-slate-500">Case #0821 patient data modified by Dr. Santos.</p>
</div>
<div class="relative pl-8">
<span class="absolute left-0 top-1 w-6 h-6 rounded-full bg-green-100 flex items-center justify-center border-4 border-white z-10">
<span class="material-symbols-outlined text-[12px] text-green-600" data-icon="done_all">done_all</span>
</span>
<p class="text-[11px] text-on-surface-variant">1 hour ago</p>
<p class="text-xs font-semibold text-on-surface">Series Completed</p>
<p class="text-[11px] text-slate-500">Maria Clara finalized Day 28 PEP dosage.</p>
</div>
<div class="relative pl-8">
<span class="absolute left-0 top-1 w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center border-4 border-white z-10">
<span class="material-symbols-outlined text-[12px] text-slate-600" data-icon="person_add">person_add</span>
</span>
<p class="text-[11px] text-on-surface-variant">2 hours ago</p>
<p class="text-xs font-semibold text-on-surface">New Registration</p>
<p class="text-[11px] text-slate-500">Queue #0827 added to clinical workflow.</p>
</div>
</div>
</div>
</section>
</div>
</main>
</body></html>