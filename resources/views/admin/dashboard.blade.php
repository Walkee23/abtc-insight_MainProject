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
        .donut-seg {
        cursor: pointer;
        transition: stroke-width 0.15s ease, opacity 0.15s ease;
    }
    .donut-seg:hover,
    .donut-seg.is-active {
        stroke-width: 5;
    }
    /* Dim the other segments while one is hovered */
    #donut-wrap.has-hover .donut-seg:not(:hover):not(.is-active) {
        opacity: 0.55;
    }
    #chart-tooltip {
        transform: translate(-50%, -130%);
        transition: opacity 0.12s ease;
        opacity: 0;
    }
    #chart-tooltip.show {
        opacity: 1;
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
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.gis_map') }}">
                    <span class="material-symbols-outlined">map</span>
                    <span class="font-['Inter'] text-sm tracking-wide">Spatial Map</span>
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
  
            <!-- Stats Bento Grid (Dynamic) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <!-- Card 1: Total Patients -->
                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/15 transition-all hover:shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-blue-50 text-primary rounded-lg">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">group</span>
                        </div>
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Live</span>
                    </div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">TOTAL REGISTERED PATIENTS</p>
                    <h3 class="text-3xl font-bold mt-1">{{ number_format($totalPatients) }}</h3>
                </div>

                <!-- Card 2: Active PEP Courses -->
                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/15 transition-all hover:shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-orange-50 text-tertiary rounded-lg">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">medical_services</span>
                        </div>
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Active</span>
                    </div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Active PEP Courses</p>
                    <h3 class="text-3xl font-bold mt-1">{{ number_format($activePepCount) }}</h3>
                </div>

                <!-- Card 3: Verified Cases Today -->
                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/15 transition-all hover:shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-red-50 text-error rounded-lg">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                        </div>
                        <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-full">Today</span>
                    </div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Verified Cases Today</p>
                    <h3 class="text-3xl font-bold mt-1">{{ number_format($verifiedToday) }}</h3>
                </div>

            </div>
           <!-- Forecasting Engine Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <div class="lg:col-span-2 bg-surface-container-lowest p-8 rounded-xl shadow-sm border border-outline-variant/15">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
                        <div>
                            <h3 class="text-lg font-bold">Forecasting Engine</h3>
                            <p class="text-xs text-on-surface-variant mt-1">Real-time exponential smoothing prediction based on database records</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="flex items-center gap-1 text-[10px] font-bold py-1 px-3 bg-primary-container text-on-primary-container rounded-full shadow-sm">
                                <span class="material-symbols-outlined text-[14px]">query_stats</span>
                                MAPE <span id="mape-value">2.87%</span>
                            </span>
                            
                            <!-- Filter Buttons -->
                            <div class="flex items-center bg-surface-container-low p-1 rounded-lg">
                                <button onclick="setForecastFilter('daily')" id="btn-daily" class="px-3 py-1 text-[10px] font-bold text-on-surface-variant hover:text-on-surface transition-colors rounded-md">Daily</button>
                                <button onclick="setForecastFilter('weekly')" id="btn-weekly" class="px-3 py-1 text-[10px] font-bold text-on-surface-variant hover:text-on-surface transition-colors rounded-md">Weekly</button>
                                <button onclick="setForecastFilter('monthly')" id="btn-monthly" class="px-3 py-1 text-[10px] font-bold bg-primary text-white shadow-sm rounded-md transition-all">Monthly</button>
                            </div>

                            <a href="{{ route('admin.forecasting') }}" class="text-xs font-medium text-primary hover:underline">Full Analysis</a>
                        </div>
                    </div>

                    <!-- Scrollable Chart Container (Jan - Dec Horizontal Scroll) -->
                    <div class="relative w-full overflow-x-auto pb-4 custom-scrollbar">
                        <div class="min-w-[750px] h-64 bg-slate-50/50 rounded-lg flex items-end justify-between px-6 pb-8 border border-dashed border-outline-variant/30 relative">
                            
                            <!-- Real Dynamic SVG Trend Line (Naa na ang Y-axis numbers sa left side ug uniform grid lines) -->
                            <svg class="absolute inset-0 w-full h-full p-6 overflow-visible" preserveAspectRatio="none" viewBox="0 0 700 200">
                                <defs>
                                    <!-- userSpaceOnUse so the gradient still renders on a flat (zero-height) line -->
                                    <linearGradient id="predictedGradient" gradientUnits="userSpaceOnUse" x1="0" y1="0" x2="700" y2="0">
                                        <stop offset="0%" stop-color="#004a93" stop-opacity="0.8" />
                                        <stop offset="100%" stop-color="#49607f" stop-opacity="0.45" />
                                    </linearGradient>
                                </defs>

                                <!-- DYNAMIC GRID LINES UG Y-AXIS NUMBERS SA LEFT SIDE -->
                                <g id="chart-grid-lines"></g>

                                <!-- Actual Solid Line (Naa nay hover & active glow effect) -->
                                <path id="actual-trend-path" fill="none" stroke="#004a93" stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" vector-effect="non-scaling-stroke"></path>
                                
                                <!-- Predicted dotted line: continues from the exact last point of the solid line -->
                                <path id="predicted-trend-path" fill="none" stroke="url(#predictedGradient)" stroke-dasharray="4 6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke"></path>
                                
                                <!-- Endpoint Highlight Circle -->
                                <circle id="forecast-point" fill="#ffffff" stroke="#004a93" stroke-width="3" r="5"></circle>
                            </svg>

                            <!-- Month Labels (January to December) -->
                            <div class="text-[10px] font-bold text-slate-400 z-10">JAN</div>
                            <div class="text-[10px] font-bold text-slate-400 z-10">FEB</div>
                            <div class="text-[10px] font-bold text-slate-400 z-10">MAR</div>
                            <div class="text-[10px] font-bold text-slate-400 z-10">APR</div>
                            <div class="text-[10px] font-bold text-slate-400 z-10">MAY</div>
                            <div class="text-[10px] font-bold text-slate-400 z-10">JUN</div>
                            <div class="text-[10px] font-bold text-slate-400 z-10">JUL</div>
                            <div class="text-[10px] font-bold text-slate-400 z-10">AUG</div>
                            <div class="text-[10px] font-bold text-slate-400 z-10">SEP</div>
                            <div class="text-[10px] font-bold text-slate-400 z-10">OCT</div>
                            <div class="text-[10px] font-bold text-slate-400 z-10">NOV</div>
                            <div class="text-[10px] font-bold text-primary font-extrabold z-10">DEC (PROJ)</div>
                        </div>
                    </div>

                    <p class="text-[10px] text-slate-400 text-right italic mt-1">← Scroll horizontally to view full year (Jan - Dec) →</p>

                    <!-- Alpha Smoothing Slider Controls -->
                    <div class="mt-6 pt-6 border-t border-outline-variant/10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex-1 max-w-sm">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-bold text-on-surface uppercase tracking-tighter">Alpha Smoothing (Real-time)</label>
                                <span id="alpha-value" class="text-xs font-mono text-primary font-bold">0.45</span>
                            </div>
                            <div class="relative w-full h-1.5 bg-outline-variant/30 rounded-full">
                                <input type="range" min="0.1" max="0.9" step="0.05" value="0.45" id="alpha-slider" class="absolute inset-0 w-full opacity-0 cursor-pointer z-20">
                                <div id="alpha-bar" class="absolute left-0 top-0 h-full w-[45%] bg-gradient-to-r from-primary to-primary-container rounded-full"></div>
                            </div>
                            <div class="flex justify-between mt-1">
                                <span class="text-[10px] text-slate-400">0.1</span>
                                <span class="text-[10px] text-slate-400">0.9</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-primary"></span>
                                <span class="text-[10px] font-semibold text-slate-500">ACTUAL (DB)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full border-2 border-primary border-dashed"></span>
                                <span class="text-[10px] font-semibold text-slate-500">PREDICTED</span>
                            </div>
                        </div>
                    </div>
                </div>
            

            <style>
                /* Nindot nga hover ug active glow effect para sa actual solid line */
                #actual-trend-path {
                    cursor: pointer;
                    transition: stroke-width 0.2s ease, filter 0.2s ease;
                }
                #actual-trend-path:hover, #actual-trend-path:active {
                    stroke-width: 5.5px;
                    filter: drop-shadow(0px 3px 6px rgba(0, 74, 147, 0.4));
                }
            </style>

                <!-- Bite Categories Donut Chart (Muted Grayish-Blue Category I + Interactive Tooltips) -->

                <div class="bg-surface-container-lowest p-8 rounded-xl shadow-sm border border-outline-variant/15 flex flex-col relative">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-lg font-bold">Bite Categories</h3>
                        <!-- Interactive Filter Dropdown (Monthly / Quarterly) -->
                        <select id="bite-filter" onchange="filterBiteCategories(this.value)" class="text-xs font-semibold bg-surface-container-low border-none rounded-lg py-1 px-3 focus:ring-0 cursor-pointer">
                            <option value="monthly" {{ ($filter ?? 'monthly') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="quarterly" {{ ($filter ?? 'monthly') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                        </select>
                    </div>
                
                    <div class="flex-1 flex flex-col items-center justify-center">
                        <!-- Donut Chart Container -->
                        <div id="donut-wrap" class="relative w-48 h-48 mb-8 group">
                            <svg class="w-full h-full transform -rotate-90 overflow-visible" viewBox="0 0 36 36">
                                <!-- Background Circle -->
                                <circle cx="18" cy="18" fill="none" r="16" stroke="#f2f4f6" stroke-width="4" pathLength="100"></circle>
                
                                <!-- Category III Segment (Darkest Blue) -->
                                <circle class="donut-seg" cx="18" cy="18" fill="none" r="16" stroke="#002d6b"
                                        pathLength="100"
                                        stroke-dasharray="{{ $cat3Pct ?? 0 }}, 100" stroke-width="4"
                                        data-label="Category III" data-cases="{{ $cat3 ?? 0 }}" data-pct="{{ $cat3Pct ?? 0 }}">
                                </circle>
                
                                <!-- Category II Segment (Medium Blue) -->
                                <circle class="donut-seg" cx="18" cy="18" fill="none" r="16" stroke="#0b61bb"
                                        pathLength="100"
                                        stroke-dasharray="{{ $cat2Pct ?? 0 }}, 100" stroke-dashoffset="-{{ $cat3Pct ?? 0 }}" stroke-width="4"
                                        data-label="Category II" data-cases="{{ $cat2 ?? 0 }}" data-pct="{{ $cat2Pct ?? 0 }}">
                                </circle>
                
                                <!-- Category I Segment (Muted Grayish-Blue) -->
                                <circle class="donut-seg" cx="18" cy="18" fill="none" r="16" stroke="#49607f"
                                        pathLength="100"
                                        stroke-dasharray="{{ $cat1Pct ?? 0 }}, 100" stroke-dashoffset="-{{ ($cat3Pct ?? 0) + ($cat2Pct ?? 0) }}" stroke-width="4"
                                        data-label="Category I" data-cases="{{ $cat1 ?? 0 }}" data-pct="{{ $cat1Pct ?? 0 }}">
                                </circle>
                            </svg>
                
                            <!-- Center Text -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <span class="text-2xl font-black text-primary">{{ number_format($totalBites ?? 0) }}</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase">Total Bites</span>
                            </div>
                
                            <!-- Tooltip Bubble (pops up when hovering any category, Monthly or Quarterly) -->
                            <div id="chart-tooltip" class="absolute bg-slate-900 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg shadow-xl pointer-events-none z-50 whitespace-nowrap"></div>
                        </div>
                
                        <!-- Legend -->
                        <div class="w-full space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full" style="background-color: #002d6b;"></span>
                                    <span class="text-xs font-medium">Category III</span>
                                </div>
                                <span class="text-xs font-bold">{{ $cat3Pct ?? 0 }}%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full" style="background-color: #0b61bb;"></span>
                                    <span class="text-xs font-medium">Category II</span>
                                </div>
                                <span class="text-xs font-bold">{{ $cat2Pct ?? 0 }}%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full" style="background-color: #49607f;"></span>
                                    <span class="text-xs font-medium">Category I</span>
                                </div>
                                <span class="text-xs font-bold">{{ $cat1Pct ?? 0 }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  

            @php
            $hotspotRange = $hotspotRange ?? 30;
            $maxHotspot   = max(1, (int) ($hotspots->max('total') ?? 0));
            @endphp
 
            <div class="grid grid-cols-1 gap-8">
                <!-- Hotspots Card -->
                <div class="bg-surface-container-lowest p-8 rounded-xl shadow-sm border border-outline-variant/15">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-lg font-bold">Top Incident Hotspots (Last {{ $hotspotRange }} Days)</h3>
                            <p class="text-xs text-on-surface-variant mt-1">Top 5 barangays with the most bite incident records</p>
                        </div>
                        <select id="hotspot-range" onchange="filterHotspots(this.value)" class="text-xs font-semibold bg-surface-container-low border-none rounded-lg py-1 px-3 focus:ring-0 cursor-pointer">
                            <option value="30" {{ $hotspotRange == 30 ? 'selected' : '' }}>Last 30 Days</option>
                            <option value="90" {{ $hotspotRange == 90 ? 'selected' : '' }}>Last 90 Days</option>
                        </select>
                    </div>
            
                    <!-- Horizontal Bar Chart -->
                    <div class="space-y-6">
                        @forelse ($hotspots as $spot)
                            @php
                                $name  = trim($spot->barangay);
                                $label = \Illuminate\Support\Str::startsWith(strtolower($name), 'barangay') ? $name : 'Barangay ' . $name;
                                $width = round(($spot->total / $maxHotspot) * 100);
                            @endphp
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs font-bold">
                                    <span>{{ $label }}</span>
                                    <span class="text-primary">{{ number_format($spot->total) }} {{ $spot->total == 1 ? 'case' : 'cases' }}</span>
                                </div>
                                <div class="w-full h-3 bg-surface-container-low rounded-full overflow-hidden">
                                    <div class="h-full bg-primary rounded-full transition-all duration-500" style="width: {{ $width }}%;"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-on-surface-variant text-center py-6">No bite incidents recorded in the last {{ $hotspotRange }} days.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>
    
   <script>
    // ======================================================================
    // FORECASTING ENGINE
    // Method: Holt's damped-trend exponential smoothing.
    // ======================================================================

    const rawMonthlyData = {!! json_encode($monthlyData ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!};
    const rawDailyData  = {!! json_encode($dailyData  ?? null) !!};
    const rawWeeklyData = {!! json_encode($weeklyData ?? null) !!};

    let currentFilter = 'monthly';

    const CHART_W = 700;
    const CHART_H = 180;
    const PAD_L = 45;   
    const PAD_R = 28;
    const BETA = 0.3;   
    const PHI  = 0.9;   
    const MONTHS = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
    const MONTHS_TITLE = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    const monthlySeries = Array.isArray(rawMonthlyData)
        ? rawMonthlyData.map(Number)
        : Object.values(rawMonthlyData || {}).map(Number);

    function addDays(d, n) {
        const r = new Date(d.getFullYear(), d.getMonth(), d.getDate());
        r.setDate(r.getDate() + n);
        return r;
    }

    function dailyRate(d, today) {
        const y = today.getFullYear();
        let m = d.getMonth();
        if (d.getFullYear() < y) m = 0;
        const total = monthlySeries[m] || 0;
        const denom = (m === today.getMonth())
            ? today.getDate()
            : new Date(y, m + 1, 0).getDate();
        return denom > 0 ? total / denom : 0;
    }

    function holtForecast(series, alpha, horizon) {
        const n = series.length;
        if (n === 0) return { forecast: new Array(horizon).fill(0), mape: null };

        let level = series[0];
        const k = Math.min(3, n - 1);
        let trend = k > 0 ? (series[k] - series[0]) / k : 0;

        let apeSum = 0, apeCnt = 0;
        for (let t = 1; t < n; t++) {
            const pred = level + PHI * trend;
            if (series[t] > 0) {
                apeSum += Math.abs(series[t] - pred) / series[t];
                apeCnt++;
            }
            const prevLevel = level;
            level = alpha * series[t] + (1 - alpha) * (prevLevel + PHI * trend);
            trend = BETA * (level - prevLevel) + (1 - BETA) * PHI * trend;
        }

        const forecast = [];
        let damp = 0;
        for (let h = 1; h <= horizon; h++) {
            damp += Math.pow(PHI, h);
            forecast.push(Math.max(0, level + damp * trend));
        }
        return { forecast, mape: apeCnt >= 2 ? (apeSum / apeCnt) * 100 : null };
    }

    function buildSegments(pts) {
        const segs = [];
        for (let i = 0; i < pts.length - 1; i++) {
            const p0 = pts[i - 1] || pts[i];
            const p1 = pts[i];
            const p2 = pts[i + 1];
            const p3 = pts[i + 2] || p2;
            const lo = Math.min(p1.y, p2.y), hi = Math.max(p1.y, p2.y);
            const c1x = p1.x + (p2.x - p0.x) / 6;
            const c1y = Math.min(hi, Math.max(lo, p1.y + (p2.y - p0.y) / 6));
            const c2x = p2.x - (p3.x - p1.x) / 6;
            const c2y = Math.min(hi, Math.max(lo, p2.y - (p3.y - p1.y) / 6));
            segs.push(`C ${c1x.toFixed(2)} ${c1y.toFixed(2)}, ${c2x.toFixed(2)} ${c2y.toFixed(2)}, ${p2.x.toFixed(2)} ${p2.y.toFixed(2)}`);
        }
        return segs;
    }

    function pathFrom(pts, segs, from, to) {
        return `M ${pts[from].x.toFixed(2)} ${pts[from].y.toFixed(2)} ` + segs.slice(from, to).join(' ');
    }

    // Draw chart nga naay Y-axis numbers sa LEFT side ug grid lines
    // Draw chart nga naay uniform ug rounded Y-axis numbers (0, 10, 20, 30...) para sa tanang views
    function drawChart(actualFixed, forecastDynamic, labels) {
        const all = actualFixed.concat(forecastDynamic);
        const n = all.length;
        
        // 1. Pangitaon ang pinakataas nga value
        const rawMax = Math.max(...all, 5);
        
        // 2. Siguruhon nga ang maxVal kay mo-round up gyud sa saktong multiple (maximum ceiling)
        let maxVal = Math.ceil(rawMax * 1.15);
        if (maxVal < 10) maxVal = 10; // Kung gamay ra kaayo ang data (sama sa daily), himuong at least 10
        else maxVal = Math.ceil(maxVal / 10) * 10; // I-round off sa sunod nga tens (pananglitan 15 -> 20, 53 -> 60)

        const usable = CHART_W - PAD_L - PAD_R;

        const gridGroup = document.getElementById('chart-grid-lines');
        if (gridGroup) {
            gridGroup.innerHTML = '';
            
            // 3. Himuon natong uniform ang steps (exact increments sa 10)
            const stepValue = 10; 
            const steps = Math.max(2, Math.round(maxVal / stepValue));
            const chartHeight = 200; 

            for (let i = 0; i <= steps; i++) {
                const val = stepValue * i;
                if (val > maxVal + 2) break; // Dili na mo-lapas sa maxVal
                
                const yPos = chartHeight - 30 - (val / maxVal) * (chartHeight - 50);
                
                // Horizontal grid line
                const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line.setAttribute('x1', PAD_L);
                line.setAttribute('y1', yPos);
                line.setAttribute('x2', CHART_W - PAD_R);
                line.setAttribute('y2', yPos);
                line.setAttribute('stroke', '#e2e8f0');
                line.setAttribute('stroke-width', '1');
                line.setAttribute('stroke-dasharray', '3 3');
                gridGroup.appendChild(line);

                // Y-AXIS NUMBERS SA LEFT SIDE (Uniform 0, 10, 20, 30...)
                const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                text.setAttribute('x', 10);
                text.setAttribute('y', yPos + 3);
                text.setAttribute('fill', '#94a3b8');
                text.setAttribute('font-size', '10');
                text.setAttribute('font-family', 'sans-serif');
                text.textContent = val;
                gridGroup.appendChild(text);
            }
        }

        const pts = all.map((v, i) => ({
            x: PAD_L + (n > 1 ? (i * usable) / (n - 1) : 0),
            y: 200 - 30 - (v / maxVal) * (200 - 50)
        }));

        const segs = buildSegments(pts);
        const lastActual = actualFixed.length - 1;

        document.getElementById('actual-trend-path')
            .setAttribute('d', pathFrom(pts, segs, 0, lastActual));

        document.getElementById('predicted-trend-path')
            .setAttribute('d', forecastDynamic.length ? pathFrom(pts, segs, lastActual, n - 1) : '');

        setForecastEndpoint(pts[n - 1].x, pts[n - 1].y);
        updateMonthLabels(labels);
    }

    function setMape(m) {
        const el = document.getElementById('mape-value');
        if (el) el.textContent = (m === null || !isFinite(m)) ? 'n/a' : m.toFixed(2) + '%';
    }

    function renderChart(alpha = 0.45) {
        if (currentFilter === 'daily') {
            renderDailyView(alpha);
        } else if (currentFilter === 'weekly') {
            renderWeeklyView(alpha);
        } else {
            renderMonthlyView(alpha);
        }
    }

    // --- 1. MONTHLY VIEW (Jan - Dec ug Mopadayon sa Sunod) ---
    function renderMonthlyView(alpha) {
        const today = new Date();
        const idx = today.getMonth(); // Kasamtangang buwan (Halimbawa: 10 para sa November)
        const day = today.getDate();
        const dim = new Date(today.getFullYear(), idx + 1, 0).getDate();

        // Kuhaon ang actual data hangtod sa kasamtangang buwan nga walay pagtaktak (pop)
        const actual = monthlySeries.slice(0, idx + 1);
        let lastActualIdx = idx;

        const horizon = Math.max(0, 11 - lastActualIdx); // Projekto sa nahibiling mga buwan
        const res = holtForecast(actual, alpha, horizon);

        const labels = MONTHS.slice();
        if (horizon > 0 && labels[11] !== 'DEC (PROJ)') {
            labels[11] = 'DEC (PROJ)';
        }

        // I-draw ang chart nga nagapadayon ang solid line padulong sa active month
        drawChart(actual, res.forecast, labels);
        setMape(res.mape);
    }
    // --- 2. WEEKLY VIEW ---
    function renderWeeklyView(alpha) {
        const today = new Date();
        const SHOW = 8, FIT = 12, H = 2;
        const real = Array.isArray(rawWeeklyData) && rawWeeklyData.length > 1;

        let fit;
        if (real) {
            fit = rawWeeklyData.map(Number);
        } else {
            fit = [];
            for (let i = FIT - 1; i >= 0; i--) {
                const end = addDays(today, -7 * i);
                let sum = 0;
                for (let k = 0; k < 7; k++) sum += dailyRate(addDays(end, -k), today);
                fit.push(sum);
            }
        }

        const res = holtForecast(fit, alpha, H);
        const actualFixed = fit.slice(-SHOW);

        const weekLabel = (d) => MONTHS_TITLE[d.getMonth()] + ' W' + Math.ceil(d.getDate() / 7);
        const labels = [];
        for (let i = 0; i < actualFixed.length; i++) {
            labels.push(weekLabel(addDays(today, -7 * (actualFixed.length - 1 - i))));
        }
        for (let h = 1; h <= H; h++) {
            labels.push(weekLabel(addDays(today, 7 * h)) + (h === H ? ' (Proj)' : ''));
        }

        drawChart(actualFixed, res.forecast, labels);
        setMape(real ? res.mape : null);
    }

    // --- 3. DAILY VIEW ---
    function renderDailyView(alpha) {
        const today = new Date(); // Today is Oct 22, 2026
        const SHOW = 7, FIT = 21, H = 2;
        const real = Array.isArray(rawDailyData) && rawDailyData.length > 1;

        let fit;
        if (real) {
            fit = rawDailyData.map(Number);
        } else {
            fit = [];
            for (let i = FIT - 1; i >= 0; i--) fit.push(dailyRate(addDays(today, -i), today));
        }

        const res = holtForecast(fit, alpha, H);
        const actualFixed = fit.slice(-SHOW);

        // FIX: Ensure the label mapping aligns with the actual trailing dates ending today
        const dayLabel = (d) => d.getDate() + '/' + (d.getMonth() + 1);
        const labels = [];
        for (let i = 0; i < actualFixed.length; i++) {
            // This counts backward from today: i = 0 is 6 days ago, i = SHOW-1 is today (Oct 22)
            labels.push(dayLabel(addDays(today, -(actualFixed.length - 1 - i))));
        }
        for (let h = 1; h <= H; h++) {
            // Projected days ahead (Oct 23, Oct 24)
            labels.push(dayLabel(addDays(today, h)) + (h === H ? ' (Proj)' : ''));
        }

        drawChart(actualFixed, res.forecast, labels);
        setMape(real ? res.mape : null);
    }

    function updateMonthLabels(labels) {
        const container = document.querySelector('.min-w-\\[750px\\]');
        const labelElements = container.querySelectorAll(':scope > div.text-\\[10px\\]');
        const lastIdx = labels.length - 1;

        labelElements.forEach((el, index) => {
            if (labels[index]) {
                el.style.display = 'block';
                el.innerText = labels[index];
                el.classList.remove('text-primary', 'font-extrabold', 'text-slate-400');
                el.classList.add(index === lastIdx ? 'text-primary' : 'text-slate-400');
                if (index === lastIdx) el.classList.add('font-extrabold');
            } else {
                el.style.display = 'none'; 
            }
        });
    }

    function setForecastEndpoint(x, y) {
        let circle = document.getElementById('forecast-point');
        circle.setAttribute('cx', x);
        circle.setAttribute('cy', y);
    }

    function setForecastFilter(type) {
        currentFilter = type;
        ['daily', 'weekly', 'monthly'].forEach(t => {
            const btn = document.getElementById('btn-' + t);
            if(btn) btn.className = "px-3 py-1 text-[10px] font-bold text-on-surface-variant hover:text-on-surface transition-colors rounded-md";
        });
        const activeBtn = document.getElementById('btn-' + type);
        if(activeBtn) activeBtn.className = "px-3 py-1 text-[10px] font-bold bg-primary text-white shadow-sm rounded-md transition-all";
        
        let sliderVal = document.getElementById('alpha-slider').value;
        renderChart(parseFloat(sliderVal));
    }

    document.getElementById('alpha-slider').addEventListener('input', function(e) {
        let val = e.target.value;
        document.getElementById('alpha-value').innerText = val;
        let percentage = ((val - 0.1) / (0.9 - 0.1)) * 100;
        document.getElementById('alpha-bar').style.width = percentage + '%';
        renderChart(parseFloat(val));
    });

    document.addEventListener('DOMContentLoaded', () => {
        renderChart(0.45);
    });

    (function () {
        var wrap    = document.getElementById('donut-wrap');
        var tooltip = document.getElementById('chart-tooltip');
        if (!wrap || !tooltip) return;
 
        var segments = wrap.querySelectorAll('.donut-seg');
 
        function showTooltip(evt, text) {
            var rect = wrap.getBoundingClientRect();
            tooltip.textContent = text;
            tooltip.style.left = (evt.clientX - rect.left) + 'px';
            tooltip.style.top  = (evt.clientY - rect.top) + 'px';
            tooltip.classList.add('show');
            wrap.classList.add('has-hover');
        }
 
        function hideTooltip() {
            tooltip.classList.remove('show');
            wrap.classList.remove('has-hover');
        }
 
        window.showTooltip = showTooltip;
        window.hideTooltip = hideTooltip;
 
        segments.forEach(function (seg) {
            var text = seg.dataset.label + ': ' +
                       Number(seg.dataset.cases).toLocaleString() + ' cases (' +
                       seg.dataset.pct + '%)';
 
            seg.addEventListener('mouseenter', function (e) { showTooltip(e, text); });
            seg.addEventListener('mousemove',  function (e) { showTooltip(e, text); });
            seg.addEventListener('mouseleave', hideTooltip);
 
            seg.addEventListener('touchstart', function (e) {
                var t = e.touches[0];
                segments.forEach(function (s) { s.classList.remove('is-active'); });
                seg.classList.add('is-active');
                showTooltip({ clientX: t.clientX, clientY: t.clientY }, text);
            }, { passive: true });
        });
 
        document.addEventListener('touchstart', function (e) {
            if (!wrap.contains(e.target)) {
                segments.forEach(function (s) { s.classList.remove('is-active'); });
                hideTooltip();
            }
        }, { passive: true });
    })();
 
    function filterBiteCategories(value) {
        var url = new URL(window.location.href);
        url.searchParams.set('filter', value);
        window.location.href = url.toString();
    }

    function filterHotspots(value) {
        var url = new URL(window.location.href);
        url.searchParams.set('range', value);
        window.location.href = url.toString();
    }
    </script>
</body>

</html>