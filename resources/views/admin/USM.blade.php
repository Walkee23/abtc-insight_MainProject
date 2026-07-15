<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-low": "#f2f4f6",
                        "on-secondary": "#ffffff",
                        "primary-fixed": "#d6e3ff",
                        "on-secondary-container": "#485f7e",
                        "secondary-fixed-dim": "#b1c8ec",
                        "on-tertiary-fixed-variant": "#743500",
                        "surface-variant": "#e0e3e5",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-container": "#ffd7c0",
                        "on-primary-fixed": "#001b3d",
                        "on-surface": "#191c1e",
                        "secondary-container": "#c1d9fd",
                        "tertiary-container": "#9e4b00",
                        "secondary-fixed": "#d3e4ff",
                        "on-error-container": "#93000a",
                        "surface-tint": "#005db6",
                        "primary-fixed-dim": "#a9c7ff",
                        "error-container": "#ffdad6",
                        "tertiary-fixed": "#ffdbc8",
                        "surface-container": "#eceef0",
                        "surface-dim": "#d8dadc",
                        "on-tertiary-fixed": "#311300",
                        "on-tertiary": "#ffffff",
                        "surface": "#f7f9fb",
                        "inverse-surface": "#2d3133",
                        "surface-container-highest": "#e0e3e5",
                        "on-primary": "#ffffff",
                        "background": "#f7f9fb",
                        "error": "#ba1a1a",
                        "on-background": "#191c1e",
                        "inverse-primary": "#a9c7ff",
                        "outline": "#717782",
                        "on-secondary-fixed": "#011c38",
                        "on-primary-fixed-variant": "#00468c",
                        "tertiary": "#7a3800",
                        "primary": "#004a93",
                        "surface-container-high": "#e6e8ea",
                        "inverse-on-surface": "#eff1f3",
                        "tertiary-fixed-dim": "#ffb689",
                        "primary-container": "#0b61bb",
                        "on-surface-variant": "#414751",
                        "on-error": "#ffffff",
                        "secondary": "#49607f",
                        "surface-bright": "#f7f9fb",
                        "outline-variant": "#c1c7d3",
                        "on-primary-container": "#d0dfff",
                        "on-secondary-fixed-variant": "#314866"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "1rem",
                        "xl": "1.5rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Inter", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                        "label": ["Inter", "sans-serif"]
                    }
                },
            },
        }
    </script>
<style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .tonal-shift { transition: background-color 0.3s ease; }
    </style>
</head>
<body class="bg-surface text-on-surface min-h-screen flex">
<!-- Sidebar Navigation -->
<aside class="hidden lg:flex flex-col h-screen w-72 sticky top-0 left-0 bg-slate-100 py-6 pl-4">
<div class="mb-10 px-4"><div class="flex items-center gap-2"><span class="material-symbols-outlined text-primary text-2xl font-bold">health_and_safety</span><h1 class="text-xl font-bold tracking-tighter text-primary">ABTC-Insight</h1></div></div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-primary transition-colors" href="#">
<span class="material-symbols-outlined">dashboard</span>
<span class="font-sans text-sm font-medium tracking-tight">Main Overview</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-primary transition-colors" href="#">
<span class="material-symbols-outlined">analytics</span>
<span class="font-sans text-sm font-medium tracking-tight">Analytics</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-primary transition-colors" href="#">
<span class="material-symbols-outlined">security</span>
<span class="font-sans text-sm font-medium tracking-tight">PEP Compliance &amp; SMS Logs</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-primary transition-colors" href="#">
<span class="material-symbols-outlined">query_stats</span>
<span class="font-sans text-sm font-medium tracking-tight">Forecasting &amp; Outbreak Detection</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-primary bg-surface-container-lowest rounded-l-full relative after:absolute after:right-0 after:w-1 after:h-6 after:bg-primary after:rounded-l-full" href="#">
<span class="material-symbols-outlined">manage_accounts</span>
<span class="font-sans text-sm font-medium tracking-tight">User &amp; System Management</span>
</a>
</nav>
</aside>
<div class="flex-1 flex flex-col min-w-0">
<!-- Top Navigation -->
<header class="w-full h-16 sticky top-0 z-40 bg-slate-50/85 backdrop-blur-md flex justify-between items-center px-6 lg:px-10 shadow-sm shadow-blue-900/5">
<div class="flex items-center gap-4 flex-1">
<div class="relative w-full max-w-md">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">search</span>
<input class="w-full bg-surface-container-highest border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-blue-500/20 placeholder:text-on-surface-variant/60" placeholder="Search system logs or users..." type="text"/>
</div>
</div>
<div class="flex items-center gap-6">
<div class="flex items-center gap-4">
<button class="p-2 text-slate-600 hover:text-blue-600 transition-all focus:ring-2 focus:ring-blue-500/20 rounded-full">
<span class="material-symbols-outlined">notifications</span>
</button>
<button class="p-2 text-slate-600 hover:text-blue-600 transition-all focus:ring-2 focus:ring-blue-500/20 rounded-full">
<span class="material-symbols-outlined">help_outline</span>
</button>
</div>
<div class="h-8 w-px bg-outline-variant/30"></div>
<div class="flex items-center gap-3">
<div class="text-right">
<p class="font-sans text-sm font-bold text-on-surface">Admin</p>
<p class="text-[10px] font-medium text-on-surface-variant uppercase tracking-wider">Health Administrator</p>
</div>
<img alt="Administrator Profile" class="w-9 h-9 rounded-full border-2 border-primary/10 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCwfc33cppKAd_Ogl4CvOnOXY8HbOX27oAlNkhaObLJgrlGjpyOmqkaVvENicCogFqV_64OsiDnrhFIDZgt8pihhjDd94DTmnjvd2Ad5CW6H_bWDER-iJVF1LBF47nqS_RoREOnwTelWCWBg6RrMirxL_ToA2IrF_lmg3K-whhTgu1L2afBprhxV87xnLU2iN6YRIhUnyWM-EocUoNW7FXyZdjTy2HqraywvXdLQHKVJf4cYDDMIseMf-GXRVuCHEgn9m9azM-x2PDt"/>
</div>
</div>
</header>
<!-- Main Content Area -->
<main class="p-6 lg:p-10 space-y-8 max-w-7xl mx-auto w-full">
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
<div>
<h2 class="text-3xl font-extrabold tracking-tight text-on-surface">System Governance</h2>
<p class="text-on-surface-variant mt-1">Manage institutional access, security protocols, and database integrity.</p>
</div>
<!-- Database Metadata Card (Small) -->
<div class="bg-surface-container-lowest p-4 rounded-lg flex items-center gap-4 shadow-sm ring-1 ring-outline-variant/10">
<div class="flex flex-col">
<span class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant">Last Backup</span>
<span class="text-sm font-semibold text-primary">Oct 24, 2023 • 03:14 AM</span>
</div>
<div class="h-8 w-px bg-outline-variant/20"></div>
<div class="flex flex-col">
<span class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant">Server Status</span>
<div class="flex items-center gap-1.5">
<span class="w-2 h-2 rounded-full bg-emerald-500"></span>
<span class="text-sm font-semibold text-emerald-700">Operational</span>
</div>
</div>
</div>
</div>
<!-- Bento Grid Layout -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
<!-- Account Management Section -->
<section class="lg:col-span-8 flex flex-col gap-4">
<div class="flex items-center justify-between">
<h3 class="text-lg font-bold text-on-surface flex items-center gap-2">
<span class="material-symbols-outlined text-primary">group</span>
                            Account Management
                        </h3>
<button class="text-sm font-bold text-primary hover:bg-primary/5 px-4 py-2 rounded-full transition-colors">View All Accounts</button>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
<div class="bg-surface-container-lowest p-6 rounded-xl hover:bg-surface-bright transition-all group border border-transparent hover:border-outline-variant/20">
<span class="material-symbols-outlined text-primary mb-3 block opacity-60 group-hover:opacity-100">medical_services</span>
<div class="flex flex-col gap-1">
<span class="text-3xl font-black tracking-tight text-on-surface">42</span>
<span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Health Workers</span>
</div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl hover:bg-surface-bright transition-all group border border-transparent hover:border-outline-variant/20">
<span class="material-symbols-outlined text-primary mb-3 block opacity-60 group-hover:opacity-100">school</span>
<div class="flex flex-col gap-1">
<span class="text-3xl font-black tracking-tight text-on-surface">18</span>
<span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">OJT / Interns</span>
</div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl hover:bg-surface-bright transition-all group border border-transparent hover:border-outline-variant/20">
<span class="material-symbols-outlined text-primary mb-3 block opacity-60 group-hover:opacity-100">badge</span>
<div class="flex flex-col gap-1">
<span class="text-3xl font-black tracking-tight text-on-surface">12</span>
<span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Administrative Staff</span>
</div>
</div>
</div>
<!-- Recent Activity List (High-end styling) -->
<div class="bg-surface-container-low rounded-xl overflow-hidden mt-2">
<div class="px-6 py-4 bg-surface-container-high/50">
<span class="text-xs font-black text-on-surface-variant uppercase tracking-widest">Active Sessions</span>
</div>
<div class="divide-y divide-outline-variant/10">
<div class="flex items-center justify-between px-6 py-4 hover:bg-surface-container-highest/50 transition-colors">
<div class="flex items-center gap-4">
<div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">JS</div>
<div>
<p class="text-sm font-bold text-on-surface">Jane Santos</p>
<p class="text-xs text-on-surface-variant">Health Worker • Clinical Desk</p>
</div>
</div>
<span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-bold rounded-full uppercase tracking-tighter">Active Now</span>
</div>
<div class="flex items-center justify-between px-6 py-4 hover:bg-surface-container-highest/50 transition-colors">
<div class="flex items-center gap-4">
<div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold text-sm">MC</div>
<div>
<p class="text-sm font-bold text-on-surface">Mark Cruz</p>
<p class="text-xs text-on-surface-variant">OJT / Intern • Records Dept</p>
</div>
</div>
<span class="text-[10px] text-on-surface-variant font-medium uppercase tracking-tighter">14 min ago</span>
</div>
</div>
</div>
</section>
<!-- System Management Section -->
<section class="lg:col-span-4 flex flex-col gap-4">
<h3 class="text-lg font-bold text-on-surface flex items-center gap-2">
<span class="material-symbols-outlined text-primary">settings_suggest</span>
                        Control Panel
                    </h3>
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 flex flex-col gap-3">
<button class="w-full flex items-center gap-3 p-4 bg-primary text-on-primary rounded-lg font-bold text-sm transition-all active:scale-95 hover:bg-primary-container">
<span class="material-symbols-outlined text-lg">backup</span>
                            Manual Database Backup
                        </button>
<button class="w-full flex items-center gap-3 p-4 bg-surface-container-low text-on-surface rounded-lg font-bold text-sm transition-all active:scale-95 hover:bg-surface-container-high">
<span class="material-symbols-outlined text-lg text-primary">schedule</span>
                            Configure Auto-Backup
                        </button>
<button class="w-full flex items-center gap-3 p-4 bg-surface-container-low text-on-surface rounded-lg font-bold text-sm transition-all active:scale-95 hover:bg-surface-container-high">
<span class="material-symbols-outlined text-lg text-primary">history_edu</span>
                            System Audit Logs
                        </button>
<button class="w-full flex items-center justify-between p-4 bg-surface-container-low text-on-surface rounded-lg font-bold text-sm transition-all active:scale-95 hover:bg-surface-container-high">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-lg text-primary">monitor_heart</span>
                                Server Health Check
                            </div>
<span class="material-symbols-outlined text-emerald-500 text-base" style="font-variation-settings: 'FILL' 1;">check_circle</span>
</button>
</div>
<!-- Security Alert Mockup -->
<div class="bg-error-container p-5 rounded-xl flex items-start gap-4 ring-1 ring-on-error-container/10">
<span class="material-symbols-outlined text-on-error-container">report</span>
<div class="flex flex-col gap-1">
<span class="text-sm font-bold text-on-error-container leading-tight">Security Protocol Update</span>
<p class="text-xs text-on-error-container/80">OJT accounts with no activity for 30 days will be auto-suspended starting next cycle.</p>
</div>
</div>
</section>
</div>
<!-- System Logs Grid -->
<section class="mt-10">
<div class="flex items-center justify-between mb-6">
<h3 class="text-lg font-bold text-on-surface flex items-center gap-2">
<span class="material-symbols-outlined text-primary">history</span>
                        Recent System Events
                    </h3>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
<div class="bg-surface-container-low p-4 rounded-lg border-l-4 border-primary">
<span class="text-[10px] font-black text-on-surface-variant uppercase">Login</span>
<p class="text-sm font-semibold mt-1">Admin authorized login from IP 192.168.1.5</p>
<p class="text-[10px] text-on-surface-variant mt-2 font-medium">10:45 AM • Cebu City</p>
</div>
<div class="bg-surface-container-low p-4 rounded-lg border-l-4 border-emerald-500">
<span class="text-[10px] font-black text-on-surface-variant uppercase">Backup</span>
<p class="text-sm font-semibold mt-1">Daily clinical snapshot completed successfully.</p>
<p class="text-[10px] text-on-surface-variant mt-2 font-medium">03:00 AM • Automated</p>
</div>
<div class="bg-surface-container-low p-4 rounded-lg border-l-4 border-tertiary-container">
<span class="text-[10px] font-black text-on-surface-variant uppercase">Security</span>
<p class="text-sm font-semibold mt-1">Key rotation policy updated for Staff role.</p>
<p class="text-[10px] text-on-surface-variant mt-2 font-medium">Yesterday • System</p>
</div>
<div class="bg-surface-container-low p-4 rounded-lg border-l-4 border-on-error-container">
<span class="text-[10px] font-black text-on-surface-variant uppercase">User Mod</span>
<p class="text-sm font-semibold mt-1">Role 'Intern' permissions restricted for SMS Logs.</p>
<p class="text-[10px] text-on-surface-variant mt-2 font-medium">Yesterday • Admin</p>
</div>
</div>
</section>
</main>
</div>
<!-- Mobile Navigation Toggle (Conceptual) -->
<button class="lg:hidden fixed bottom-6 right-6 w-14 h-14 bg-primary text-on-primary rounded-full shadow-lg flex items-center justify-center z-50">
<span class="material-symbols-outlined">menu</span>
</button>
</body></html>