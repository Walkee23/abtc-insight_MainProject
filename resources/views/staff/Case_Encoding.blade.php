<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Cebu Health ABTC - Case Encoding</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-surface-variant": "#414751",
                        "on-secondary-fixed": "#011c38",
                        "on-primary": "#ffffff",
                        "surface-container-low": "#f2f4f6",
                        "surface-container-high": "#e6e8ea",
                        "inverse-surface": "#2d3133",
                        "surface-container-highest": "#e0e3e5",
                        "on-secondary-fixed-variant": "#314866",
                        "primary": "#004a93",
                        "tertiary-fixed": "#ffdbc8",
                        "secondary": "#49607f",
                        "surface-tint": "#005db6",
                        "on-tertiary-container": "#ffd7c0",
                        "on-tertiary": "#ffffff",
                        "on-background": "#191c1e",
                        "on-secondary": "#ffffff",
                        "on-primary-fixed-variant": "#00468c",
                        "on-surface": "#191c1e",
                        "surface-container": "#eceef0",
                        "secondary-container": "#c1d9fd",
                        "surface": "#f7f9fb",
                        "secondary-fixed-dim": "#b1c8ec",
                        "on-error": "#ffffff",
                        "tertiary-fixed-dim": "#ffb689",
                        "outline-variant": "#c1c7d3",
                        "error-container": "#ffdad6",
                        "primary-fixed": "#d6e3ff",
                        "outline": "#717782",
                        "on-secondary-container": "#485f7e",
                        "surface-dim": "#d8dadc",
                        "primary-fixed-dim": "#a9c7ff",
                        "on-error-container": "#93000a",
                        "secondary-fixed": "#d3e4ff",
                        "on-tertiary-fixed": "#311300",
                        "primary-container": "#0b61bb",
                        "tertiary": "#7a3800",
                        "surface-variant": "#e0e3e5",
                        "error": "#ba1a1a",
                        "tertiary-container": "#9e4b00",
                        "background": "#f7f9fb",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-container": "#d0dfff",
                        "inverse-primary": "#a9c7ff",
                        "inverse-on-surface": "#eff1f3",
                        "on-tertiary-fixed-variant": "#743500",
                        "on-primary-fixed": "#001b3d",
                        "surface-bright": "#f7f9fb"
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
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #c1c7d3; border-radius: 10px; }
    </style>
</head>
<body class="bg-surface text-on-surface min-h-screen flex">
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
        <a class="flex items-center gap-3 px-4 py-3.5 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-blue-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors" href="{{ route('staff.patient-verification') }}">
            <span class="material-symbols-outlined" data-icon="verified_user">verified_user</span>
            <span>Patient Verification</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3.5 text-primary dark:text-blue-400 font-semibold border-l-4 border-primary dark:border-blue-400 bg-primary/5 transition-all" href="#">
            <span class="material-symbols-outlined" data-icon="clinical_notes">clinical_notes</span>
            <span>Case Encoding</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3.5 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-blue-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors" href="{{ route('staff.patient-lookup') }}">
            <span class="material-symbols-outlined" data-icon="person_search">person_search</span>
            <span>Patient Lookup</span>
        </a>
    </nav>
</aside>
<!-- Main Content Area -->
<main class="ml-72 flex-1 flex flex-col min-h-screen">
<!-- TopAppBar -->
<header class="w-full sticky top-0 z-40 bg-slate-50/85 dark:bg-slate-900/85 backdrop-blur-md flex items-center justify-between px-8 py-4 shadow-sm">
<div class="flex items-center gap-8">
<div class="relative group">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
<input class="pl-10 pr-4 py-2 bg-surface-container-highest/50 border-none rounded-full text-sm w-64 focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="Search records..." type="text"/>
</div>
</div>
<div class="flex items-center gap-4">
<button class="w-10 h-10 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-200/50 transition-colors relative">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
<span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-white"></span>
</button>
<button class="w-10 h-10 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-200/50 transition-colors">
<span class="material-symbols-outlined" data-icon="help">help</span>
</button>
<div class="h-8 w-[1px] bg-slate-200 mx-2"></div>
<div class="flex items-center gap-3 cursor-pointer group">
<div class="text-right">
<p class="text-xs font-bold text-on-surface leading-tight">Dr. Arnel Ramos</p>
<p class="text-[10px] text-on-surface-variant">Attending Staff</p>
</div>
<img alt="Medical Staff Profile" class="w-9 h-9 rounded-full object-cover ring-2 ring-primary/10 group-hover:ring-primary/30 transition-all" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA9f3RaLjMq70dUf6V8ufMkAlJ1NrwDBGgDI7p5JN9E_XNc6xyb-68sYtzlWLHvq-Us3Vk0uCMemlZTbGnBOVf0wYNas_bQTwsAw_upH601REHiqPy-985CpLl14MWrSiY8IUoAsjv7uSiv31eO2uXAPBG5XRiK7Bpjwtm1TDXzzG3cSF2gF9mORW3mUu4gCHnl1izwU3lglVLIKmJjCK8WBmiBUE7YZlhsuEV2VMpwmk9ktUnUxMJEAIzVB3tvDrYKVET9NEBHg_j5"/>
</div>
</div>
</header>
<!-- Content Canvas -->
<div class="p-8 space-y-6">
<!-- Page Header & Prominent Search Bar -->
<section class="flex flex-col md:flex-row md:items-end justify-between gap-6">
<div>
<h2 class="text-2xl font-extrabold text-blue-900 tracking-tight">Case Encoding</h2>
<p class="text-on-surface-variant text-sm mt-1">Complete bite case incident data for verified patients (Sections 3-5)</p>
</div>
<div class="w-full md:w-1/2 relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary text-[24px]">person_search</span>
<input class="w-full pl-12 pr-6 py-4 bg-white border border-outline-variant rounded-2xl text-base shadow-sm focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all outline-none" placeholder="Find verified patient by name or ID..." type="text"/>
</div>
</section>
<!-- Main Two-Column Layout -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
<!-- Left Column: Expanded Patient List -->
<div class="lg:col-span-3 space-y-4 h-[calc(100vh-280px)] flex flex-col">
<div class="flex items-center justify-between px-2">
<h4 class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Verified Queue</h4>
<span class="text-[10px] bg-primary/10 text-primary font-bold px-2 py-0.5 rounded-full">12 Awaiting</span>
</div>
<div class="bg-surface-container-low rounded-lg overflow-hidden border border-outline-variant/10 flex-1 overflow-y-auto custom-scrollbar">
<table class="w-full text-left text-xs border-collapse">
<thead class="bg-surface-container-highest/30 sticky top-0 z-10 backdrop-blur-sm">
<tr>
<th class="px-4 py-3 font-bold text-on-surface-variant">Patient</th>
<th class="px-4 py-3 font-bold text-on-surface-variant">Status</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/10">
<tr class="bg-primary/5 hover:bg-primary/10 transition-colors cursor-pointer border-l-4 border-primary">
<td class="px-4 py-4">
<p class="font-bold text-on-surface">Cardo Dalisay</p>
<p class="text-[10px] text-on-surface-variant">#2024-8812</p>
</td>
<td class="px-4 py-4">
<span class="px-2 py-0.5 bg-error-container text-on-error-container rounded-full text-[9px] font-bold whitespace-nowrap">Sec 3, 5</span>
</td>
</tr>
<tr class="hover:bg-surface-bright transition-colors cursor-pointer">
<td class="px-4 py-4">
<p class="font-bold text-on-surface">Juan Luna</p>
<p class="text-[10px] text-on-surface-variant">#2024-8815</p>
</td>
<td class="px-4 py-4">
<span class="px-2 py-0.5 bg-error-container text-on-error-container rounded-full text-[9px] font-bold whitespace-nowrap">Sec 4</span>
</td>
</tr>
<tr class="hover:bg-surface-bright transition-colors cursor-pointer">
<td class="px-4 py-4">
<p class="font-bold text-on-surface">Bambam Aquas</p>
<p class="text-[10px] text-on-surface-variant">#2024-8819</p>
</td>
<td class="px-4 py-4">
<span class="px-2 py-0.5 bg-error-container text-on-error-container rounded-full text-[9px] font-bold whitespace-nowrap">Sec 3, 4</span>
</td>
</tr>
<tr class="hover:bg-surface-bright transition-colors cursor-pointer">
<td class="px-4 py-4">
<p class="font-bold text-on-surface">Rita Gomez</p>
<p class="text-[10px] text-on-surface-variant">#2024-8822</p>
</td>
<td class="px-4 py-4">
<span class="px-2 py-0.5 bg-tertiary-fixed text-on-tertiary-fixed-variant rounded-full text-[9px] font-bold whitespace-nowrap">Sec 5</span>
</td>
</tr>
<tr class="hover:bg-surface-bright transition-colors cursor-pointer">
<td class="px-4 py-4">
<p class="font-bold text-on-surface">Maria Santos</p>
<p class="text-[10px] text-on-surface-variant">#2024-8825</p>
</td>
<td class="px-4 py-4">
<span class="px-2 py-0.5 bg-error-container text-on-error-container rounded-full text-[9px] font-bold whitespace-nowrap">Sec 3, 4, 5</span>
</td>
</tr>
<tr class="hover:bg-surface-bright transition-colors cursor-pointer">
<td class="px-4 py-4">
<p class="font-bold text-on-surface">Elena Vizcara</p>
<p class="text-[10px] text-on-surface-variant">#2024-8828</p>
</td>
<td class="px-4 py-4">
<span class="px-2 py-0.5 bg-tertiary-fixed text-on-tertiary-fixed-variant rounded-full text-[9px] font-bold whitespace-nowrap">Sec 3</span>
</td>
</tr>
<tr class="hover:bg-surface-bright transition-colors cursor-pointer">
<td class="px-4 py-4">
<p class="font-bold text-on-surface">Rogelio Magno</p>
<p class="text-[10px] text-on-surface-variant">#2024-8830</p>
</td>
<td class="px-4 py-4">
<span class="px-2 py-0.5 bg-error-container text-on-error-container rounded-full text-[9px] font-bold whitespace-nowrap">Sec 4</span>
</td>
</tr>
<tr class="hover:bg-surface-bright transition-colors cursor-pointer">
<td class="px-4 py-4">
<p class="font-bold text-on-surface">Andres Bonifacio</p>
<p class="text-[10px] text-on-surface-variant">#2024-8835</p>
</td>
<td class="px-4 py-4">
<span class="px-2 py-0.5 bg-error-container text-on-error-container rounded-full text-[9px] font-bold whitespace-nowrap">Sec 3, 5</span>
</td>
</tr>
</tbody>
</table>
</div>
</div>
<!-- Right Column: Unified Encoding Form -->
<div class="lg:col-span-9">
<div class="bg-surface-container-lowest rounded-lg shadow-sm border border-outline-variant/10">
<div class="p-6 border-b border-surface-container-high flex items-center justify-between bg-primary/5 sticky top-[72px] z-30 backdrop-blur-sm">
<div>
<h3 class="text-lg font-bold text-primary">Animal Bite Case Encoding Form</h3>
<p class="text-xs text-on-surface-variant">Currently encoding: <span class="font-bold text-on-surface">Cardo Dalisay (#2024-8812)</span></p>
</div>
<div class="flex gap-2">
<button class="px-4 py-2 text-xs font-bold text-secondary bg-surface-container-high rounded-full hover:bg-surface-container-highest transition-colors">Discard</button>
<button class="px-4 py-2 text-xs font-bold text-white bg-primary rounded-full hover:bg-primary-container transition-all shadow-md active:scale-95">Save Progress</button>
</div>
</div>
<div class="p-8 space-y-12">
<!-- Section 3: Details of Exposure -->
<section class="space-y-6">
<div class="flex items-center gap-3">
<span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm">3</span>
<h4 class="text-sm font-extrabold uppercase tracking-widest text-on-surface-variant">Details of Exposure</h4>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 pl-11">
<div class="space-y-4">
<label class="block text-[11px] font-bold uppercase tracking-wide text-on-surface-variant">Animal Type</label>
<div class="flex gap-4">
<label class="flex items-center gap-2 text-sm cursor-pointer">
<input class="text-primary focus:ring-primary" name="animal_type" type="radio"/> Dog
                                            </label>
<label class="flex items-center gap-2 text-sm cursor-pointer">
<input class="text-primary focus:ring-primary" name="animal_type" type="radio"/> Cat
                                            </label>
<label class="flex items-center gap-2 text-sm cursor-pointer">
<input class="text-primary focus:ring-primary" name="animal_type" type="radio"/> Others
                                            </label><input class="ml-2 bg-surface-container-highest border-none rounded-lg text-xs px-3 py-1.5 focus:ring-2 focus:ring-primary/20 transition-all outline-none w-32" placeholder="Specify..." type="text"/>
</div>
</div>
<div class="space-y-4">
<label class="block text-[11px] font-bold uppercase tracking-wide text-on-surface-variant">Pet or Stray</label>
<div class="flex gap-4">
<label class="flex items-center gap-2 text-sm cursor-pointer">
<input class="text-primary focus:ring-primary" name="pet_status" type="radio"/> Pet
                                            </label>
<label class="flex items-center gap-2 text-sm cursor-pointer">
<input class="text-primary focus:ring-primary" name="pet_status" type="radio"/> Stray
                                            </label>
</div>
</div>
<div class="space-y-2">
<label class="block text-[11px] font-bold uppercase tracking-wide text-on-surface-variant">Date/Time of Bite</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg text-sm px-4 py-2.5 focus:ring-2 focus:ring-primary/20 transition-all outline-none" type="datetime-local"/>
</div>
<div class="space-y-4">
<label class="block text-[11px] font-bold uppercase tracking-wide text-on-surface-variant">Exposure Type</label>
<div class="flex gap-4">
<label class="flex items-center gap-2 text-sm cursor-pointer">
<input class="rounded text-primary focus:ring-primary" type="checkbox"/> Lick
                                            </label>
<label class="flex items-center gap-2 text-sm cursor-pointer">
<input class="rounded text-primary focus:ring-primary" type="checkbox"/> Scratch
                                            </label>
<label class="flex items-center gap-2 text-sm cursor-pointer">
<input class="rounded text-primary focus:ring-primary" type="checkbox"/> Bite
                                            </label>
</div>
</div>
<div class="space-y-4">
<label class="block text-[11px] font-bold uppercase tracking-wide text-on-surface-variant">Risk Indicators (Provocation &amp; Leash)</label>
<div class="grid gap-4">
<div class="flex flex-col gap-2">
<span class="text-[10px] text-on-surface-variant">Provoked</span>
<div class="flex gap-3">
<label class="text-[11px]"><input class="text-primary" name="provoked" type="radio"/> Yes</label>
<label class="text-[11px]"><input class="text-primary" name="provoked" type="radio"/> No</label>
</div>
</div>
<div class="flex flex-col gap-2">
<span class="text-[10px] text-on-surface-variant">On Leash</span>
<div class="flex gap-3">
<label class="text-[11px]"><input class="text-primary" name="leash" type="radio"/> Yes</label>
<label class="text-[11px]"><input class="text-primary" name="leash" type="radio"/> No</label>
</div>
</div>
<div class="flex flex-col gap-2">
<span class="text-[10px] text-on-surface-variant">Gate Status</span>
<div class="flex gap-3">
<label class="text-[11px]"><input class="text-primary" name="gate" type="radio"/> With gate</label>
<label class="text-[11px]"><input class="text-primary" name="gate" type="radio"/> Without gate</label>
</div>
</div></div>
</div>
<div class="space-y-2">
<label class="block text-[11px] font-bold uppercase tracking-wide text-on-surface-variant">Vax Status &amp; Date</label>
<div class="flex gap-2">
<select class="flex-1 bg-surface-container-highest border-none rounded-lg text-xs py-2 focus:ring-2 focus:ring-primary/20">
<option>Unknown</option>
<option>Vaccinated</option>
<option>Not Vaccinated</option>
</select>
<input class="flex-1 bg-surface-container-highest border-none rounded-lg text-xs py-2 focus:ring-2 focus:ring-primary/20" type="date"/>
</div>
</div>
<div class="md:col-span-2 space-y-2">
<label class="block text-[11px] font-bold uppercase tracking-wide text-on-surface-variant">Circumstances of Exposure</label>
<textarea class="w-full bg-surface-container-highest border-none rounded-lg text-sm px-4 py-3 focus:ring-2 focus:ring-primary/20 transition-all outline-none resize-none" placeholder="Brief description of the incident..." rows="3"></textarea>
</div>
<div class="md:col-span-2 grid grid-cols-2 gap-8">
<div class="space-y-4">
<label class="block text-[11px] font-bold uppercase tracking-wide text-on-surface-variant">Fate of Animal</label>
<div class="grid grid-cols-2 gap-2">
<label class="text-xs flex items-center gap-2"><input class="text-primary" name="fate" type="radio"/> Healthy</label>
<label class="text-xs flex items-center gap-2"><input class="text-primary" name="fate" type="radio"/> Sick</label>
<label class="text-xs flex items-center gap-2"><input class="text-primary" name="fate" type="radio"/> Dead</label>
<label class="text-xs flex items-center gap-2"><input class="text-primary" name="fate" type="radio"/> Lost/Stray</label>
</div>
</div>
<div class="space-y-4">
<label class="block text-[11px] font-bold uppercase tracking-wide text-on-surface-variant">14-Day Observation</label>
<div class="flex flex-col gap-2">
<label class="text-xs flex items-center gap-2"><input class="text-primary" name="obs" type="radio"/> Under Observation</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg text-xs py-2 focus:ring-2 focus:ring-primary/20" type="date"/>
</div>
</div>
</div>
</div>
</section>
<!-- Section 4: Local Wound Treatment -->
<section class="space-y-6">
<div class="flex items-center gap-3">
<span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm">4</span>
<h4 class="text-sm font-extrabold uppercase tracking-widest text-on-surface-variant">Local Wound Treatment</h4>
</div>
<div class="pl-11 grid grid-cols-1 md:grid-cols-2 gap-8">
<div class="space-y-4">
<label class="block text-[11px] font-bold uppercase tracking-wide text-on-surface-variant">Wound washed with</label>
<div class="flex flex-wrap gap-4">
<label class="flex items-center gap-2 text-sm cursor-pointer">
<input class="rounded text-primary focus:ring-primary" type="checkbox"/> Water only
                                            </label>
<label class="flex items-center gap-2 text-sm cursor-pointer">
<input class="rounded text-primary focus:ring-primary" type="checkbox"/> Soap &amp; Water
                                            </label>
<label class="flex items-center gap-2 text-sm cursor-pointer">
<input class="rounded text-primary focus:ring-primary" type="checkbox"/> Others
                                            </label><input class="ml-2 bg-surface-container-highest border-none rounded-lg text-xs px-3 py-1.5 focus:ring-2 focus:ring-primary/20 transition-all outline-none w-40" placeholder="Specify treatment..." type="text"/>
</div>
</div>
<div class="space-y-4">
<label class="block text-[11px] font-bold uppercase tracking-wide text-on-surface-variant">Local irritant applied</label>
<div class="flex flex-col gap-3">
<label class="relative inline-flex items-center cursor-pointer">
<input class="sr-only peer" type="checkbox"/>
<div class="w-11 h-6 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
<span class="ml-3 text-sm font-medium text-on-surface-variant">Yes, applied</span>
</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg text-xs px-4 py-2 focus:ring-2 focus:ring-primary/20 outline-none" placeholder="Specify (e.g., Garlic, Vinegar, etc.)" type="text"/>
</div>
</div>
</div>
</section>
<!-- Section 5: Previous Anti-Rabies Treatment -->
<section class="space-y-6">
<div class="flex items-center gap-3">
<span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm">5</span>
<h4 class="text-sm font-extrabold uppercase tracking-widest text-on-surface-variant">Previous Anti-Rabies Treatment</h4>
</div>
<div class="pl-11 space-y-6">
<div class="flex items-center gap-8">
<label class="block text-[11px] font-bold uppercase tracking-wide text-on-surface-variant">Previously Vaccinated?</label>
<div class="flex gap-4">
<label class="flex items-center gap-2 text-sm cursor-pointer font-bold text-primary">
<input checked="" class="text-primary focus:ring-primary" name="prev_vax" type="radio"/> Yes
                                            </label>
<label class="flex items-center gap-2 text-sm cursor-pointer">
<input class="text-primary focus:ring-primary" name="prev_vax" type="radio"/> No
                                            </label>
</div>
</div>
<div class="bg-tertiary-fixed p-4 rounded-lg flex gap-3 items-start border-l-4 border-on-tertiary-fixed-variant shadow-sm">
<span class="material-symbols-outlined text-on-tertiary-fixed-variant" style="font-variation-settings: 'FILL' 1;">info</span>
<p class="text-xs text-on-tertiary-fixed-variant font-medium">Check with ABTC health worker for history or record patient’s claims if medical documentation is unavailable. Incomplete history may lead to dosage errors.</p>
</div>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
<div class="space-y-2">
<label class="block text-[10px] font-bold text-on-surface-variant uppercase">Dose 1 Date</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg text-xs py-2 focus:ring-2 focus:ring-primary/20" type="date"/>
</div>
<div class="space-y-2">
<label class="block text-[10px] font-bold text-on-surface-variant uppercase">Dose 2 Date</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg text-xs py-2 focus:ring-2 focus:ring-primary/20" type="date"/>
</div>
<div class="space-y-2">
<label class="block text-[10px] font-bold text-on-surface-variant uppercase">Dose 3 Date</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg text-xs py-2 focus:ring-2 focus:ring-primary/20" type="date"/>
</div>
<div class="space-y-2">
<label class="block text-[10px] font-bold text-on-surface-variant uppercase">Booster Date</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg text-xs py-2 focus:ring-2 focus:ring-primary/20" type="date"/>
</div>
</div>
</div>
</section>
<!-- Form Submission -->
<div class="pt-8 border-t border-surface-container-high flex justify-end gap-4">
<button class="px-8 py-3 text-sm font-bold text-secondary bg-surface-container-low rounded-full hover:bg-surface-container-high transition-all">Cancel Entry</button>
<button class="px-10 py-3 text-sm font-bold text-white bg-primary rounded-full hover:bg-primary-container transition-all shadow-xl active:scale-95 flex items-center gap-2">
<span class="material-symbols-outlined text-[18px]">check_circle</span>
                                    Complete Encoding
                                </button>
</div>
</div>
</div>
</div>
</div>
</div>
</main>
</body></html>