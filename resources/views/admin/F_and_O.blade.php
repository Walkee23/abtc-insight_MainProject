<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Forecasting &amp; Outbreak Detection | Cebu Health Analytics</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "error-container": "#ffdad6",
                        "secondary-fixed": "#d3e4ff",
                        "on-tertiary": "#ffffff",
                        "on-background": "#191c1e",
                        "primary-fixed-dim": "#a9c7ff",
                        "outline-variant": "#c1c7d3",
                        "surface-tint": "#005db6",
                        "surface-container-highest": "#e0e3e5",
                        "surface-bright": "#f7f9fb",
                        "on-primary-fixed-variant": "#00468c",
                        "surface": "#f7f9fb",
                        "primary-fixed": "#d6e3ff",
                        "primary-container": "#0b61bb",
                        "surface-container-high": "#e6e8ea",
                        "surface-container-low": "#f2f4f6",
                        "surface-variant": "#e0e3e5",
                        "tertiary-container": "#9e4b00",
                        "on-tertiary-container": "#ffd7c0",
                        "on-secondary-container": "#485f7e",
                        "on-primary-fixed": "#001b3d",
                        "on-primary-container": "#d0dfff",
                        "tertiary": "#7a3800",
                        "error": "#ba1a1a",
                        "inverse-primary": "#a9c7ff",
                        "on-secondary-fixed-variant": "#314866",
                        "outline": "#717782",
                        "secondary-fixed-dim": "#b1c8ec",
                        "inverse-on-surface": "#eff1f3",
                        "secondary-container": "#c1d9fd",
                        "on-secondary": "#ffffff",
                        "on-surface-variant": "#414751",
                        "on-error": "#ffffff",
                        "tertiary-fixed-dim": "#ffb689",
                        "on-error-container": "#93000a",
                        "surface-dim": "#d8dadc",
                        "tertiary-fixed": "#ffdbc8",
                        "on-tertiary-fixed-variant": "#743500",
                        "on-secondary-fixed": "#011c38",
                        "secondary": "#49607f",
                        "on-tertiary-fixed": "#311300",
                        "background": "#f7f9fb",
                        "primary": "#004a93",
                        "on-surface": "#191c1e",
                        "surface-container-lowest": "#ffffff",
                        "on-primary": "#ffffff",
                        "surface-container": "#eceef0",
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
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        input[type=range] {
            -webkit-appearance: none;
            width: 100%;
            background: transparent;
        }

        input[type=range]:focus {
            outline: none;
        }

        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 6px;
            cursor: pointer;
            background: #eceef0;
            border-radius: 3px;
        }

        input[type=range]::-webkit-slider-thumb {
            height: 18px;
            width: 18px;
            border-radius: 50%;
            background: #004a93;
            cursor: pointer;
            -webkit-appearance: none;
            margin-top: -6px;
            box-shadow: 0 2px 6px rgba(0, 74, 147, 0.3);
        }

        input[type=range]:active::-webkit-slider-thumb {
            transform: scale(1.1);
        }
    </style>
</head>

<body class="bg-surface text-on-surface selection:bg-primary-container selection:text-on-primary-container">
    <!-- Sidebar Navigation -->
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
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.dashboard') }}">
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
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-700 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600 translate-x-1 duration-150" href="{{ route('admin.forecasting') }}">
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
        <div class="p-8 space-y-10">
            <!-- Section 1: Patient Volume Forecasting -->
            <section class="space-y-6">
                <div class="flex justify-between items-end">
                    <div>
                        <h2 class="text-2xl font-bold text-on-surface tracking-tight">Patient Volume Forecasting</h2>
                        <p class="text-on-surface-variant text-sm mt-1">Holt-Winters Triple Exponential Smoothing Model</p>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <p class="text-[10px] font-bold text-outline uppercase tracking-wider">Historical Data View</p>
                        <div class="bg-surface-container-low p-1 rounded-lg flex gap-1">
                            <button class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all text-on-surface-variant hover:bg-surface-container-high">Daily</button>
                            <button class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all text-on-surface-variant hover:bg-surface-container-high">Weekly</button>
                            <button class="px-4 py-1.5 text-xs font-semibold rounded-md bg-surface-container-lowest text-primary shadow-sm">Monthly</button>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 lg:col-span-5 grid grid-cols-3 gap-4">
                        <div class="bg-surface-container-lowest p-5 rounded-xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col justify-between">
                            <p class="text-[10px] uppercase font-bold text-outline tracking-wider mb-1">Method</p>
                            <p class="text-lg font-bold text-primary">Holt-Winters</p>
                        </div>
                        <div class="bg-surface-container-lowest p-5 rounded-xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col justify-between">
                            <p class="text-[10px] uppercase font-bold text-outline tracking-wider mb-1">MAPE</p>
                            <div class="flex flex-col">
                                <p class="text-lg font-bold text-primary">3.1%</p>
                                <span class="text-[10px] text-primary/60 font-medium">Excellent</span>
                            </div>
                        </div>
                        <div class="bg-surface-container-lowest p-5 rounded-xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border-l-4 border-primary/20 flex flex-col justify-between">
                            <p class="text-[10px] uppercase font-bold text-outline tracking-wider mb-1">Confidence</p>
                            <div class="flex items-center gap-2">
                                <span class="text-lg font-bold text-on-surface">High</span>
                                <div class="w-2 h-2 rounded-full bg-primary"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-7 bg-surface-container-low/30 p-6 rounded-2xl border border-outline-variant/10 space-y-5">
                        <div class="flex justify-between items-center mb-1">
                            <h3 class="text-xs font-bold text-on-surface uppercase tracking-widest flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm" data-icon="tune">tune</span>
                                Model Parameters Tuning
                            </h3>
                            <div class="flex gap-2">
                                <button class="text-[10px] font-bold text-primary hover:underline transition-all">Reset Defaults</button>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="space-y-3 group">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-1.5 relative">
                                        <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-tight">Alpha (Level)</label>
                                        <span class="material-symbols-outlined text-[14px] text-outline cursor-help group-hover:text-primary transition-colors" title="Controls focus on most recent data. High = fast reaction, Low = smooth historical average.">info</span>
                                    </div>
                                    <span class="text-xs font-black text-primary bg-primary/5 px-2 py-0.5 rounded">0.45</span>
                                </div>
                                <input class="accent-primary" max="0.9" min="0.1" step="0.01" type="range" value="0.45" />
                                <p class="text-[10px] text-outline leading-tight italic">Focus on recent data vs. history</p>
                            </div>
                            <div class="space-y-3 group">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-1.5 relative">
                                        <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-tight">Beta (Trend)</label>
                                        <span class="material-symbols-outlined text-[14px] text-outline cursor-help group-hover:text-primary transition-colors" title="Controls reaction to data direction. High = fast trend catching, Low = steady history.">info</span>
                                    </div>
                                    <span class="text-xs font-black text-primary bg-primary/5 px-2 py-0.5 rounded">0.12</span>
                                </div>
                                <input class="accent-primary" max="0.9" min="0.1" step="0.01" type="range" value="0.12" />
                                <p class="text-[10px] text-outline leading-tight italic">Sensitivity to growth direction</p>
                            </div>
                            <div class="space-y-3 group">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-1.5 relative">
                                        <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-tight">Gamma (Seasonality)</label>
                                        <span class="material-symbols-outlined text-[14px] text-outline cursor-help group-hover:text-primary transition-colors" title="Controls adaptation to repeating patterns. High = updates based on recent cycle, Low = stable seasonal pattern.">info</span>
                                    </div>
                                    <span class="text-xs font-black text-primary bg-primary/5 px-2 py-0.5 rounded">0.30</span>
                                </div>
                                <input class="accent-primary" max="0.9" min="0.1" step="0.01" type="range" value="0.30" />
                                <p class="text-[10px] text-outline leading-tight italic">Adaptation to seasonal patterns</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-8 rounded-xl shadow-[0_8px_30px_rgba(0,0,0,0.04)] h-[440px] relative overflow-hidden group">
                    <div class="absolute inset-0 p-8 flex flex-col">
                        <div class="flex justify-between items-start mb-10">
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] font-bold text-outline uppercase tracking-widest">Historical Data (24 Months)</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-primary rounded-full"></div>
                                    <span class="text-xs font-medium text-on-surface-variant">Actual Volume</span>
                                </div>
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <span class="text-[10px] font-bold text-outline uppercase tracking-widest">Predicted Forecast Interval</span>
                                <div class="bg-surface-container-low p-1 rounded-lg flex gap-1">
                                    <button class="px-4 py-1 text-[10px] font-bold rounded-md transition-all text-on-surface-variant hover:bg-surface-container-high">Daily</button>
                                    <button class="px-4 py-1 text-[10px] font-bold rounded-md transition-all text-on-surface-variant hover:bg-surface-container-high">Weekly</button>
                                    <button class="px-4 py-1 text-[10px] font-bold rounded-md bg-surface-container-lowest text-primary shadow-sm">Monthly</button>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1">
                                <span class="text-[10px] font-bold text-outline uppercase tracking-widest">Projected (Next 6 Months)</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-[2px] border-t-2 border-dashed border-primary/60"></div>
                                    <span class="text-xs font-medium text-on-surface-variant">Predicted Trend</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow w-full relative pt-4">
                            <svg class="w-full h-full overflow-visible" viewbox="0 0 1000 280">
                                <line stroke="#eceef0" stroke-width="1" x1="0" x2="1000" y1="0" y2="0"></line>
                                <line stroke="#eceef0" stroke-width="1" x1="0" x2="1000" y1="70" y2="70"></line>
                                <line stroke="#eceef0" stroke-width="1" x1="0" x2="1000" y1="140" y2="140"></line>
                                <line stroke="#eceef0" stroke-width="1" x1="0" x2="1000" y1="210" y2="210"></line>
                                <line stroke="#eceef0" stroke-width="1" x1="0" x2="1000" y1="280" y2="280"></line>
                                <path d="M0,230 L50,200 L100,220 L150,160 L200,180 L250,120 L300,140 L350,80 L400,100 L450,50 L500,70 L550,20 L600,40 L650,0 L700,30" fill="none" stroke="#004a93" stroke-linecap="round" stroke-width="3"></path>
                                <path d="M700,30 L750,10 L800,40 L850,20 L900,-10 L950,20 L1000,0" fill="none" stroke="#004a93" stroke-dasharray="8,4" stroke-opacity="0.6" stroke-width="3"></path>
                                <path d="M700,30 L750,-10 L800,20 L850,0 L900,-30 L950,0 L1000,-20 L1000,20 L950,40 L900,10 L850,40 L800,60 L750,30 Z" fill="#004a93" fill-opacity="0.05"></path>
                                <circle cx="700" cy="30" fill="#004a93" r="4"></circle>
                                <circle cx="550" cy="20" fill="#004a93" r="4"></circle>
                                <circle cx="450" cy="50" fill="#004a93" r="4"></circle>
                            </svg>
                            <div class="absolute bottom-0 left-0 flex gap-6">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-primary/10 rounded-sm"></div>
                                    <span class="text-xs font-medium text-on-surface-variant">95% Confidence Interval</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Section 2: Outbreak Detection -->
            <section class="space-y-6">
                <div class="flex justify-between items-end">
                    <div>
                        <h2 class="text-2xl font-bold text-on-surface tracking-tight">Outbreak Detection &amp; Monitoring</h2>
                        <p class="text-on-surface-variant text-sm mt-1">Real-time surveillance of local health spikes</p>
                    </div>
                    <button class="flex items-center gap-2 px-4 py-2 text-primary font-bold text-sm hover:bg-primary/5 rounded-lg transition-colors">
                        View All Barangays
                        <span class="material-symbols-outlined text-sm" data-icon="arrow_forward">arrow_forward</span>
                    </button>
                </div>
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-3 flex flex-col gap-6">
                        <div class="bg-surface-container-low p-6 rounded-xl space-y-1">
                            <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Barangays Monitored</p>
                            <p class="text-4xl font-black text-on-surface">80</p>
                            <div class="h-1.5 w-full bg-outline-variant/20 rounded-full overflow-hidden mt-4">
                                <div class="h-full bg-primary w-[95%]"></div>
                            </div>
                        </div>
                        <div class="bg-error-container p-6 rounded-xl space-y-1 h-full flex flex-col justify-center">
                            <p class="text-xs font-bold text-on-error-container uppercase tracking-widest">Active Spike Alerts</p>
                            <p class="text-4xl font-black text-on-error-container">3</p>
                            <div class="flex items-center gap-1 text-on-error-container mt-2">
                                <span class="material-symbols-outlined text-sm" data-icon="warning">warning</span>
                                <span class="text-[10px] font-bold">Immediate attention required</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-9 space-y-4">
                        <h3 class="text-sm font-bold text-on-surface-variant px-2">Priority Alerts</h3>
                        <div class="bg-surface-container-lowest p-5 rounded-xl shadow-sm border-l-4 border-error flex items-center justify-between group hover:shadow-md transition-all">
                            <div class="flex items-center gap-6">
                                <div>
                                    <h4 class="text-lg font-bold text-on-surface pl-2">Guadalupe</h4>
                                </div>
                            </div>
                            <div class="flex gap-16 text-center pr-10">
                                <div>
                                    <p class="text-[10px] font-bold text-outline uppercase tracking-wider">Current Cases</p>
                                    <p class="text-xl font-black text-error">42</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-outline uppercase tracking-wider">7D Average</p>
                                    <p class="text-xl font-black text-on-surface">12</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-outline uppercase tracking-wider">Deviation</p>
                                    <p class="text-xl font-black text-error">+250%</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-surface-container-lowest p-5 rounded-xl shadow-sm border-l-4 border-error flex items-center justify-between group hover:shadow-md transition-all">
                            <div class="flex items-center gap-6">
                                <div>
                                    <h4 class="text-lg font-bold text-on-surface pl-2">Lahug</h4>
                                </div>
                            </div>
                            <div class="flex gap-16 text-center pr-10">
                                <div>
                                    <p class="text-[10px] font-bold text-outline uppercase tracking-wider">Current Cases</p>
                                    <p class="text-xl font-black text-error">28</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-outline uppercase tracking-wider">7D Average</p>
                                    <p class="text-xl font-black text-on-surface">9</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-outline uppercase tracking-wider">Deviation</p>
                                    <p class="text-xl font-black text-error">+211%</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-surface-container-lowest p-5 rounded-xl shadow-sm border-l-4 border-tertiary flex items-center justify-between group hover:shadow-md transition-all">
                            <div class="flex items-center gap-6">
                                <div>
                                    <h4 class="text-lg font-bold text-on-surface pl-2">Banilad</h4>
                                </div>
                            </div>
                            <div class="flex gap-16 text-center pr-10">
                                <div>
                                    <p class="text-[10px] font-bold text-outline uppercase tracking-wider">Current Cases</p>
                                    <p class="text-xl font-black text-tertiary">19</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-outline uppercase tracking-wider">7D Average</p>
                                    <p class="text-xl font-black text-on-surface">11</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-outline uppercase tracking-wider">Deviation</p>
                                    <p class="text-xl font-black text-tertiary">+72%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    ```
</body>

</html>