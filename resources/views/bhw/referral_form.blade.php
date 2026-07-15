<!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Create New Referral | Cebu City ABTC Insight</title>
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
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Inter', sans-serif; background-color: #f7f9fb; }
        /* Clinical Ethereal Glass Effect */
        .glass-header {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="text-on-surface">
<!-- Sidebar Navigation -->
<aside class="h-screen w-72 fixed left-0 top-0 overflow-y-auto bg-white border-r border-slate-100 flex flex-col z-50">
<div class="p-8 pb-12">
<div class="flex items-center gap-3 text-primary mb-10">
<span class="material-symbols-outlined text-3xl font-bold">shield</span>
<span class="text-xl font-black tracking-tight">ABTC-Insight</span>
</div>
<nav class="space-y-2">
<a class="flex items-center gap-4 px-4 py-3 text-slate-500 hover:bg-slate-50 rounded-xl transition-all group" href="#">
<span class="material-symbols-outlined text-2xl">assignment_turned_in</span>
<span class="font-semibold">My Referrals</span>
</a>
<a class="flex items-center gap-4 px-4 py-3 bg-primary/10 text-primary rounded-xl transition-all" href="#">
<span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">add_circle</span>
<span class="font-bold">Create New Referral</span>
</a>
</nav>
</div>
</aside>
<!-- Top App Bar -->
<header class="fixed top-0 right-0 w-[calc(100%-18rem)] z-40 bg-white/80 backdrop-blur-md border-b border-slate-100 flex justify-between items-center h-20 px-10">
<div class="flex items-center gap-4">
<div class="relative">
<span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400">search</span>
<input class="pl-12 pr-6 py-2.5 bg-slate-100 border-none rounded-full text-sm focus:ring-2 focus:ring-primary/20 w-96 transition-all" placeholder="Search referrals, patients..." type="text"/>
</div>
</div>
<div class="flex items-center gap-8">
<div class="flex items-center gap-2">
<button class="p-2 text-slate-400 hover:text-primary transition-colors">
<span class="material-symbols-outlined">help</span>
</button>
<button class="p-2 text-slate-400 hover:text-primary transition-colors relative">
<span class="material-symbols-outlined">notifications</span>
<span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
</button>
</div>
<div class="h-8 w-px bg-slate-200"></div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="text-sm font-bold text-slate-900">Maria Santos</p>
<p class="text-xs font-medium text-slate-500">BHW - Guadalupe</p>
</div>
<div class="w-10 h-10 rounded-full bg-primary/10 border-2 border-white overflow-hidden shadow-sm">
<img alt="User Profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA8qvDV4dnbcoh8b4wEmWnL4jHIhPAzh0g6mS9cPqml8C2faIENYr7AA6MrWbeIhv7N3hxbsu9b16h_l6SmZnD2HYvqzz4vrHs766G_9JtppNHqJkzqXj7e5c4fgN8VUEB2fFhQDkEB2_uek3RldeGw61qJYdq_6bh17_Cp2bYJzyfGc2LKzsd0LcquIWrBLIsKZ2WeoG6ED9Ma3QxTkwWPrJZk4CfPTSaFtb1pmRJncjMncS19eeSwYdpBwUpP-czxD1ujkjn4V4IN"/>
</div>
</div>
</div>
</header>
<!-- Main Content Canvas -->
<main class="pt-24 pb-20 px-12 min-h-screen bg-surface ml-72">
<!-- Header & Breadcrumbs -->
<div class="mb-10">
<a class="text-primary flex items-center gap-2 text-sm font-medium hover:underline mb-4 group" href="#">
<span class="material-symbols-outlined text-sm group-hover:-translate-x-1 transition-transform">arrow_back</span>
                Back to My Referrals
            </a>
<h1 class="text-4xl font-extrabold tracking-tight text-on-surface">Create New Referral</h1>
<p class="text-on-surface-variant mt-2 text-lg">Initiate a patient transfer to Gen. Maxilom Ave. ABTC.</p>
</div>
<form class="space-y-8 max-w-5xl">
<!-- Section A: Referral Header -->
<section class="bg-surface-container-lowest p-8 rounded-xl shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] transition-all hover:shadow-[0_10px_30px_-15px_rgba(0,0,0,0.08)]">
<div class="flex items-center gap-3 mb-6 border-b border-outline-variant/10 pb-4">
<span class="p-2 bg-primary-fixed rounded-lg text-primary">
<span class="material-symbols-outlined">description</span>
</span>
<h2 class="text-xl font-bold tracking-tight">Referral Header</h2>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<div class="space-y-2">
<label class="text-[10px] uppercase font-bold tracking-wider text-on-surface-variant">Referral Date</label>
<div class="bg-surface-container-highest px-4 py-3 rounded-lg text-on-surface font-medium border-none opacity-80">
                            May 24, 2024 (Today)
                        </div>
</div>
<div class="space-y-2 md:col-span-1">
<label class="text-[10px] uppercase font-bold tracking-wider text-on-surface-variant">To (Destination)</label>
<div class="bg-surface-container-highest px-4 py-3 rounded-lg text-on-surface font-medium opacity-80">
                            CHD-ABTC Gen. Maxilom Ave. Ext.
                        </div>
</div>
<div class="space-y-2 md:col-span-1">
<label class="text-[10px] uppercase font-bold tracking-wider text-on-surface-variant">From (Originating Center)</label>
<div class="bg-surface-container-highest px-4 py-3 rounded-lg text-on-surface font-medium opacity-80 flex items-center gap-2">
<span class="w-2 h-2 rounded-full bg-green-500"></span>
                            Brgy. Guadalupe | Maria Santos
                        </div>
</div>
</div>
</section>
<!-- Section B: Patient Information -->
<section class="bg-surface-container-lowest p-8 rounded-xl shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)]">
<div class="flex items-center gap-3 mb-6 border-b border-outline-variant/10 pb-4">
<span class="p-2 bg-primary-fixed rounded-lg text-primary">
<span class="material-symbols-outlined">person</span>
</span>
<h2 class="text-xl font-bold tracking-tight">Patient Information</h2>
</div>
<div class="grid grid-cols-1 md:grid-cols-12 gap-6">
<div class="md:col-span-8 space-y-2">
<label class="text-xs font-semibold text-on-surface-variant ml-1">Full Patient Name</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Enter given name and surname" type="text"/>
</div>
<div class="md:col-span-4 space-y-2">
<label class="text-xs font-semibold text-on-surface-variant ml-1">Date of Birth</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20" type="date"/>
</div>
<div class="md:col-span-2 space-y-2">
<label class="text-xs font-semibold text-on-surface-variant ml-1">Age</label>
<input class="w-full bg-surface-container border-none rounded-lg px-4 py-3 text-on-surface-variant italic" placeholder="Calculated" readonly="" type="text"/>
</div>
<div class="md:col-span-3 space-y-2">
<label class="text-xs font-semibold text-on-surface-variant ml-1">Gender</label>
<select class="w-full bg-surface-container-highest border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20">
<option>Select</option>
<option>Male</option>
<option>Female</option>
<option>Other</option>
</select>
</div>
<div class="md:col-span-3 space-y-2">
<label class="text-xs font-semibold text-on-surface-variant ml-1">Civil Status</label>
<select class="w-full bg-surface-container-highest border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20">
<option>Select</option>
<option>Single</option>
<option>Married</option>
<option>Widowed</option>
</select>
</div>
<div class="md:col-span-4 space-y-2">
<label class="text-xs font-semibold text-on-surface-variant ml-1">Contact Number</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20" placeholder="09XX XXX XXXX" type="tel"/>
</div>
<div class="md:col-span-12 space-y-2">
<label class="text-xs font-semibold text-on-surface-variant ml-1">Address (Barangay)</label>
<div class="flex gap-4">
<input class="w-48 bg-surface-container border-none rounded-lg px-4 py-3 font-semibold text-primary" type="text" value="Guadalupe"/>
<input class="flex-1 bg-surface-container-highest border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20" placeholder="Street, Sitio, or Landmark" type="text"/>
</div>
</div>
</div>
</section>
<!-- Section C: Vitals Grid -->
<section class="bg-surface-container-lowest p-8 rounded-xl shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)]">
<div class="flex items-center gap-3 mb-6 border-b border-outline-variant/10 pb-4">
<span class="p-2 bg-primary-fixed rounded-lg text-primary">
<span class="material-symbols-outlined">monitoring</span>
</span>
<h2 class="text-xl font-bold tracking-tight">Vitals &amp; Assessment</h2>
</div>
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
<div class="space-y-2">
<label class="text-xs font-semibold text-on-surface-variant">Temp (°C)</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg px-4 py-3 text-center focus:ring-2 focus:ring-primary/20" placeholder="36.5" type="text"/>
</div>
<div class="space-y-2">
<label class="text-xs font-semibold text-on-surface-variant">BP (mmHg)</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg px-4 py-3 text-center focus:ring-2 focus:ring-primary/20" placeholder="120/80" type="text"/>
</div>
<div class="space-y-2">
<label class="text-xs font-semibold text-on-surface-variant">PR (bpm)</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg px-4 py-3 text-center focus:ring-2 focus:ring-primary/20" placeholder="72" type="text"/>
</div>
<div class="space-y-2">
<label class="text-xs font-semibold text-on-surface-variant">RR (cpm)</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg px-4 py-3 text-center focus:ring-2 focus:ring-primary/20" placeholder="16" type="text"/>
</div>
<div class="space-y-2">
<label class="text-xs font-semibold text-on-surface-variant">Height (cm)</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg px-4 py-3 text-center focus:ring-2 focus:ring-primary/20" placeholder="170" type="text"/>
</div>
<div class="space-y-2">
<label class="text-xs font-semibold text-on-surface-variant">Weight (kg)</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg px-4 py-3 text-center focus:ring-2 focus:ring-primary/20" placeholder="65.0" type="text"/>
</div>
</div>
</section>
<!-- Section D: Exposure Details -->
<section class="bg-surface-container-lowest p-8 rounded-xl shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)]">
<div class="flex items-center gap-3 mb-6 border-b border-outline-variant/10 pb-4">
<span class="p-2 bg-error-container rounded-lg text-error">
<span class="material-symbols-outlined">pets</span>
</span>
<h2 class="text-xl font-bold tracking-tight">Exposure Details</h2>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
<div class="space-y-6">
<div class="space-y-2">
<label class="text-xs font-semibold text-on-surface-variant">Exposure Type</label>
<div class="flex gap-4">
<label class="flex-1 cursor-pointer">
<input class="hidden peer" name="exposure" type="radio"/>
<div class="p-4 border-2 border-outline-variant/20 rounded-xl flex flex-col items-center gap-2 peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
<span class="material-symbols-outlined">medical_mask</span>
<span class="font-bold text-sm">Bite</span>
</div>
</label>
<label class="flex-1 cursor-pointer">
<input class="hidden peer" name="exposure" type="radio"/>
<div class="p-4 border-2 border-outline-variant/20 rounded-xl flex flex-col items-center gap-2 peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
<span class="material-symbols-outlined">clean_hands</span>
<span class="font-bold text-sm">Non-Bite</span>
</div>
</label>
</div>
</div>
<div class="space-y-2">
<label class="text-xs font-semibold text-on-surface-variant">Date/Time of Exposure</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20" type="datetime-local"/>
</div>
<div class="space-y-2">
<label class="text-xs font-semibold text-on-surface-variant">Anatomic Site of Bite</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20" placeholder="e.g. Left distal forearm" type="text"/>
</div>
</div>
<div class="space-y-6">
<div class="space-y-2">
<label class="text-xs font-semibold text-on-surface-variant">Biting Animal</label>
<div class="grid grid-cols-2 gap-4">
<select class="bg-surface-container-highest border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20">
<option>Dog</option>
<option>Cat</option>
<option>Others</option>
</select>
<input class="bg-surface-container-highest border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20" placeholder="Specify if 'Others'" type="text"/>
</div>
</div>
<div class="space-y-2">
<label class="text-xs font-semibold text-on-surface-variant">Lab Exam (Optional)</label>
<input class="w-full bg-surface-container-highest border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20" placeholder="e.g. Rapid Rabies Test results" type="text"/>
</div>
<div class="space-y-2">
<label class="text-xs font-semibold text-on-surface-variant">Action Desired / Remarks</label>
<textarea class="w-full bg-surface-container-highest border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 resize-none" placeholder="Specify emergency care needed or reason for transfer..." rows="3"></textarea>
</div>
</div>
</div>
</section>
<!-- Section E: Referral Sign-off -->
<section class="bg-surface-container-lowest p-8 rounded-xl shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border-l-8 border-primary">
<div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
<div class="flex items-center gap-4">
<div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center text-primary">
<span class="material-symbols-outlined">ink_pen</span>
</div>
<div>
<p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Referred By</p>
<p class="text-xl font-black text-primary">Maria Santos, BHW</p>
</div>
</div>
<div class="text-right">
<p class="text-xs text-on-surface-variant italic">Electronic authentication active</p>
<p class="text-sm font-medium">Verified for Brgy. Guadalupe Health Center</p>
</div>
</div>
</section>
<!-- Sticky Footer Controls -->
<div class="flex items-center justify-end gap-4 pt-8 pb-12">
<button class="px-8 py-4 bg-transparent border-2 border-outline-variant/30 text-on-surface-variant font-bold rounded-xl hover:bg-surface-container transition-all active:scale-95 flex items-center gap-2" type="button">
<span class="material-symbols-outlined text-sm">visibility</span>
                    Preview Referral
                </button>
<button class="px-10 py-4 bg-primary text-white font-bold rounded-xl shadow-xl shadow-primary/30 hover:bg-primary-container transition-all active:scale-95 flex items-center gap-3" type="submit">
                    Submit Referral
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
</button>
</div>
</form>
</main>
<!-- FAB Suppression Policy followed: No FAB on Create page -->
</body></html>