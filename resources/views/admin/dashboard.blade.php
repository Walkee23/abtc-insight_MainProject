<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>ABTC-Insight | Health Administrator Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-bright": "#f7f9fb",
                        "primary-fixed-dim": "#a9c7ff",
                        "on-surface": "#191c1e",
                        "on-secondary": "#ffffff",
                        "on-primary": "#ffffff",
                        "inverse-surface": "#2d3133",
                        "primary-container": "#0b61bb",
                        "on-tertiary-fixed-variant": "#743500",
                        "on-tertiary-fixed": "#311300",
                        "secondary-fixed-dim": "#b1c8ec",
                        "secondary-fixed": "#d3e4ff",
                        "secondary-container": "#c1d9fd",
                        "on-error-container": "#93000a",
                        "on-tertiary-container": "#ffd7c0",
                        "surface-tint": "#005db6",
                        "outline-variant": "#c1c7d3",
                        "primary-fixed": "#d6e3ff",
                        "on-secondary-fixed-variant": "#314866",
                        "on-background": "#191c1e",
                        "inverse-primary": "#a9c7ff",
                        "surface-container-high": "#e6e8ea",
                        "surface": "#f7f9fb",
                        "surface-container-low": "#f2f4f6",
                        "on-primary-fixed": "#001b3d",
                        "on-surface-variant": "#414751",
                        "primary": "#004a93",
                        "tertiary-container": "#9e4b00",
                        "tertiary-fixed": "#ffdbc8",
                        "inverse-on-surface": "#eff1f3",
                        "secondary": "#49607f",
                        "outline": "#717782",
                        "surface-variant": "#e0e3e5",
                        "on-primary-fixed-variant": "#00468c",
                        "surface-dim": "#d8dadc",
                        "on-secondary-fixed": "#011c38",
                        "error-container": "#ffdad6",
                        "background": "#f7f9fb",
                        "surface-container-highest": "#e0e3e5",
                        "on-tertiary": "#ffffff",
                        "on-primary-container": "#d0dfff",
                        "on-error": "#ffffff",
                        "error": "#ba1a1a",
                        "tertiary": "#7a3800",
                        "surface-container": "#eceef0"
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
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c7d3;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-surface text-on-surface flex min-h-screen">
    <!-- SideNavBar Component -->
    <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-50 dark:bg-slate-900 flex flex-col border-r border-slate-200/50 dark:border-slate-800/50 z-50">
        <div class="px-6 py-8">
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                </div>
                <div>
                    <h1 class="font-black uppercase text-primary dark:text-blue-100 text-sm tracking-wider leading-none">ABTC-Insight</h1>
                </div>
            </div>
            <nav class="space-y-1">
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-700 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600 translate-x-1 duration-150" href="{{ route('admin.dashboard') }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="font-['Inter'] text-sm tracking-wide">Main Overview</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.analytics') }}">
                    <span class="material-symbols-outlined">analytics</span>
                    <span class="font-['Inter'] text-sm tracking-wide">Analytics</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.compliance') }}">
                    <span class="material-symbols-outlined">security</span>
                    <span class="font-['Inter'] text-sm tracking-wide">PEP Compliance & SMS Logs</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.forecasting') }}">
                    <span class="material-symbols-outlined">query_stats</span>
                    <span class="font-['Inter'] text-sm tracking-wide">Forecasting & Outbreak Detection</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.usm') }}">
                    <span class="material-symbols-outlined">manage_accounts</span>
                    <span class="font-['Inter'] text-sm tracking-wide">User & System Management</span>
                </a>
            </nav>
        </div>
    </aside>
    <main class="ml-64 flex-1 flex flex-col min-w-0">
        <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md px-8 py-3 flex justify-between items-center border-b border-slate-100">
            <div class="flex items-center gap-6 flex-1">
                <div class="relative w-full max-w-md group">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                    <input class="w-full pl-10 pr-4 py-2 bg-slate-100 border-none rounded-full text-sm focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-400" placeholder="Search analytics or case IDs..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-colors active:scale-95 duration-200">
                    <span class="material-symbols-outlined text-xl">notifications</span>
                </button>
                <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-colors active:scale-95 duration-200 mr-2">
                    <span class="material-symbols-outlined text-xl">help</span>
                </button>
                <!-- User Profile Section with Dropdown -->
                <div class="relative group cursor-pointer pl-4 border-l border-slate-200">
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-900">{{ Auth::user()->full_name ?? 'Dr. Maria Santos' }}</p>
                            <p class="text-[10px] text-slate-500 font-medium">{{ Auth::user()->role ?? 'Health Administrator' }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-full overflow-hidden ring-2 ring-slate-100 border border-slate-200">
                            <img alt="Admin Avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAWLozmctqDvlYpuogkSKhuQXYqgyRVKTkvnu27_vfksbBi0fRp_28CpvFMkWokTvJIwFCvycusJ03sd70MxGv-IN-9EoSewtoGCMoJCboWhZiyXr9Zka7bBUMXl7Htj8b_rELNobmm3tu5deKHeXDYC1OZQpXtFhCTDycSm3-mjAqV-0zADcM6iNlwgsTmbuHbbvihLUWj2DhK1AdlgzJR_geD3xRe39h4TMEC10LJqKK5azvYdpi-szDRrOG0jL1N9x6qJeeLjIj9" />
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

                            <!-- Secure Logout Form -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors text-left">
                                    <span class="material-symbols-outlined text-[18px]">logout</span>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Content Area -->
        <div class="pt-24 px-8 pb-12">
            <!-- Welcome Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold tracking-tight text-on-surface">Welcome back, Admin!</h2>
                <p class="text-on-surface-variant mt-1">Here is what's happening with the city's health data today.</p>
            </div>
            <!-- Stats Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/15 transition-all hover:shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-blue-50 text-primary rounded-lg">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">person_filled</span>
                        </div>
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">+12.5%</span>
                    </div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">TOTAL PATIENTS (MAY 2026)</p>
                    <h3 class="text-3xl font-bold mt-1">1,284</h3>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/15 transition-all hover:shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-orange-50 text-tertiary rounded-lg">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">medical_services</span>
                        </div>
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Stable</span>
                    </div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Active PEP Courses</p>
                    <h3 class="text-3xl font-bold mt-1">412</h3>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/15 transition-all hover:shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-red-50 text-error rounded-lg">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                        </div>
                        <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-full">New Alerts</span>
                    </div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Verified Cases Today</p>
                    <h3 class="text-3xl font-bold mt-1">24</h3>
                </div>
            </div>
            <!-- Forecasting Engine Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <div class="lg:col-span-2 bg-surface-container-lowest p-8 rounded-xl shadow-sm border border-outline-variant/15">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-lg font-bold">Forecasting Engine</h3>
                            <p class="text-xs text-on-surface-variant mt-1">Time-series prediction for incident trends</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="flex items-center gap-1 text-[10px] font-bold py-1 px-3 bg-primary-container text-on-primary-container rounded-full">
                                <span class="material-symbols-outlined text-[14px]">query_stats</span>
                                MAPE 2.87%
                            </span>
                            <div class="flex items-center bg-surface-container-low p-1 rounded-lg mr-2">
                                <button class="px-3 py-1 text-[10px] font-bold text-on-surface-variant hover:text-on-surface transition-colors rounded-md">Daily</button>
                                <button class="px-3 py-1 text-[10px] font-bold text-on-surface-variant hover:text-on-surface transition-colors rounded-md">Weekly</button>
                                <button class="px-3 py-1 text-[10px] font-bold bg-primary text-white shadow-sm rounded-md transition-all">Monthly</button>
                            </div><button class="text-xs font-medium text-primary hover:underline">Full Analysis</button>
                        </div>
                    </div>
                    <!-- Simplified Visual Representation of a Line Chart -->
                    <div class="relative h-64 w-full bg-slate-50/50 rounded-lg flex items-end justify-between px-4 pb-8 border border-dashed border-outline-variant/30">
                        <!-- Chart Lines (Simulated with SVG) -->
                        <svg class="absolute inset-0 w-full h-full p-4 overflow-visible" preserveaspectratio="none">
                            <!-- Actual Line -->
                            <path d="M 0 180 Q 50 140 100 160 T 200 100 T 300 130 T 400 70 T 500 90 T 600 40" fill="none" stroke="#004a93" stroke-linecap="round" stroke-width="3"></path>
                            <!-- Predicted Line -->
                            <path d="M 400 70 Q 450 60 500 80 T 600 50 T 700 30" fill="none" stroke="#004a93" stroke-dasharray="4 4" stroke-opacity="0.5" stroke-width="2"></path>
                            <!-- Data points -->
                            <circle cx="400" cy="70" fill="#004a93" r="4"></circle>
                        </svg>
                        <!-- Grid lines simulated -->
                        <div class="absolute inset-0 flex flex-col justify-between p-4 pointer-events-none opacity-20">
                            <div class="w-full border-t border-slate-300"></div>
                            <div class="w-full border-t border-slate-300"></div>
                            <div class="w-full border-t border-slate-300"></div>
                            <div class="w-full border-t border-slate-300"></div>
                        </div>
                        <!-- Labels -->
                        <div class="text-[10px] font-bold text-slate-400">MAY</div>
                        <div class="text-[10px] font-bold text-slate-400">JUN</div>
                        <div class="text-[10px] font-bold text-slate-400">JUL</div>
                        <div class="text-[10px] font-bold text-slate-400">AUG</div>
                        <div class="text-[10px] font-bold text-slate-400">SEP</div>
                        <div class="text-[10px] font-bold text-primary font-extrabold">OCT (PROJ)</div>
                    </div>
                    <div class="mt-8 pt-6 border-t border-outline-variant/10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex-1 max-w-sm">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-bold text-on-surface uppercase tracking-tighter">Alpha Smoothing</label>
                                <span class="text-xs font-mono text-primary font-bold">0.45</span>
                            </div>
                            <div class="relative w-full h-1.5 bg-outline-variant/30 rounded-full">
                                <div class="absolute left-0 top-0 h-full w-[45%] bg-gradient-to-r from-primary to-primary-container rounded-full"></div>
                                <div class="absolute left-[45%] top-1/2 -translate-y-1/2 w-4 h-4 bg-surface-container-lowest border-2 border-primary rounded-full shadow-sm"></div>
                            </div>
                            <div class="flex justify-between mt-1">
                                <span class="text-[10px] text-slate-400">0.1</span>
                                <span class="text-[10px] text-slate-400">0.9</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-primary"></span>
                                <span class="text-[10px] font-semibold text-slate-500">ACTUAL</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full border-2 border-primary border-dashed"></span>
                                <span class="text-[10px] font-semibold text-slate-500">PREDICTED</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bite Categories Donut Chart -->
                <div class="bg-surface-container-lowest p-8 rounded-xl shadow-sm border border-outline-variant/15 flex flex-col">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-lg font-bold">Bite Categories</h3>
                        <select class="text-xs font-semibold bg-surface-container-low border-none rounded-lg py-1 px-3 focus:ring-0">
                            <option>Monthly</option>
                            <option>Quarterly</option>
                        </select>
                    </div>
                    <div class="flex-1 flex flex-col items-center justify-center">
                        <!-- Simulated Donut Chart -->
                        <div class="relative w-48 h-48 mb-8">
                            <svg class="w-full h-full transform -rotate-90" viewbox="0 0 36 36">
                                <circle cx="18" cy="18" fill="none" r="16" stroke="#f2f4f6" stroke-width="4"></circle>
                                <circle cx="18" cy="18" fill="none" r="16" stroke="#004a93" stroke-dasharray="70, 100" stroke-width="4"></circle>
                                <circle cx="18" cy="18" fill="none" r="16" stroke="#49607f" stroke-dasharray="25, 100" stroke-dashoffset="-70" stroke-width="4"></circle>
                                <circle cx="18" cy="18" fill="none" r="16" stroke="#b1c8ec" stroke-dasharray="5, 100" stroke-dashoffset="-95" stroke-width="4"></circle>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-2xl font-black text-primary">158</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase">Total Bites</span>
                            </div>
                        </div>
                        <div class="w-full space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                                    <span class="text-xs font-medium">Category II</span>
                                </div>
                                <span class="text-xs font-bold">70%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                    <span class="text-xs font-medium">Category III</span>
                                </div>
                                <span class="text-xs font-bold">25%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-secondary-fixed-dim"></span>
                                    <span class="text-xs font-medium">Category I</span>
                                </div>
                                <span class="text-xs font-bold">5%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Incident Hotspots Section -->
            <div class="grid grid-cols-1 gap-8">
                <!-- Hotspots Card -->
                <div class="bg-surface-container-lowest p-8 rounded-xl shadow-sm border border-outline-variant/15">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-lg font-bold">Top Incident Hotspots (Monthly)</h3>
                            <p class="text-xs text-on-surface-variant mt-1">Leading Barangays by bite incident records</p>
                        </div>
                        <select class="text-xs font-semibold bg-surface-container-low border-none rounded-lg py-1 px-3 focus:ring-0">
                            <option>Last 30 Days</option>
                            <option>Last 90 Days</option>
                        </select>
                    </div>
                    <!-- Horizontal Bar Chart -->
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs font-bold">
                                <span>Barangay Guadalupe</span>
                                <span class="text-primary">48 cases</span>
                            </div>
                            <div class="w-full h-3 bg-surface-container-low rounded-full overflow-hidden">
                                <div class="h-full bg-primary w-[85%] rounded-full"></div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs font-bold">
                                <span>Barangay Lahug</span>
                                <span class="text-primary">32 cases</span>
                            </div>
                            <div class="w-full h-3 bg-surface-container-low rounded-full overflow-hidden">
                                <div class="h-full bg-primary w-[65%] rounded-full"></div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs font-bold">
                                <span>Barangay Labangon</span>
                                <span class="text-primary">29 cases</span>
                            </div>
                            <div class="w-full h-3 bg-surface-container-low rounded-full overflow-hidden">
                                <div class="h-full bg-primary w-[55%] rounded-full"></div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs font-bold">
                                <span>Barangay Tisa</span>
                                <span class="text-primary">21 cases</span>
                            </div>
                            <div class="w-full h-3 bg-surface-container-low rounded-full overflow-hidden">
                                <div class="h-full bg-primary w-[40%] rounded-full"></div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs font-bold">
                                <span>Barangay Mabolo</span>
                                <span class="text-primary">18 cases</span>
                            </div>
                            <div class="w-full h-3 bg-surface-container-low rounded-full overflow-hidden">
                                <div class="h-full bg-primary w-[35%] rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Visual Diagrams Quick Filters -->
            </div>
        </div>
    </main>
    <!-- Contextual FAB (Mobile/Utility) - Only on Dashboard -->
    <button class="fixed bottom-8 right-8 w-14 h-14 bg-primary text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-105 transition-transform z-50">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">add</span>
    </button>
</body>

</html>