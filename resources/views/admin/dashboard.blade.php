<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>ABTC-Insight | Health Administrator Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
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
    <script src="{{ asset('js/sidebar-toggle.js') }}"></script>
    <script src="{{ asset('js/custom-select.js') }}" defer></script>
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
                
            </div>
            <div class="flex items-center gap-2">
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
                    <div class="absolute right-0 top-full pt-2 w-48 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="bg-white rounded-xl shadow-lg border border-slate-100">
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

                <!-- Card 2: Ongoing PEP Courses -->
                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/15 transition-all hover:shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-orange-50 text-tertiary rounded-lg">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">medical_services</span>
                        </div>
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Ongoing</span>
                    </div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Ongoing PEP Courses</p>
                    <h3 class="text-3xl font-bold mt-1">{{ number_format($ongoingPepCount) }}</h3>
                </div>

                <!-- Card 3: Completed PEP Today -->
                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/15 transition-all hover:shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">task_alt</span>
                        </div>
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Today</span>
                    </div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Completed PEP Today</p>
                    <h3 class="text-3xl font-bold mt-1">{{ number_format($completedToday) }}</h3>
                </div>

            </div>
           
                        <style>
                #actual-trend-path {
                    cursor: pointer;
                    transition: stroke-width 0.2s ease, filter 0.2s ease;
                }
                #actual-trend-path:hover, #actual-trend-path:active {
                    stroke-width: 5.5px;
                    filter: drop-shadow(0px 3px 6px rgba(0, 74, 147, 0.4));
                }
            </style>

            @php
                $hotspotRange = $hotspotRange ?? 30;
                $maxHotspot   = max(1, (int) ($hotspots->max('total') ?? 0));
            @endphp

            <!-- BITE CATEGORIES + TOP HOTSPOTS (same row) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">

                <!-- Bite Categories Donut Chart -->
                <div class="bg-surface-container-lowest p-8 rounded-xl shadow-sm border border-outline-variant/15 flex flex-col relative">
                    @php
                        $filter      = $filter ?? 'monthly';
                        $biteYear    = $biteYear ?? now()->year;
                        $bitePeriod  = $bitePeriod ?? now()->month;
                        $biteYears   = $biteYears ?? [now()->year];
                        $periodLabel = $periodLabel ?? '';
                        $periodOpts  = $filter === 'quarterly'
                            ? collect(range(1, 4))->mapWithKeys(fn ($q) => [$q => 'Q' . $q . ' (' . date('M', mktime(0, 0, 0, ($q - 1) * 3 + 1, 1)) . ' - ' . date('M', mktime(0, 0, 0, $q * 3, 1)) . ')'])
                            : collect(range(1, 12))->mapWithKeys(fn ($m) => [$m => date('F', mktime(0, 0, 0, $m, 1))]);
                        $selectCls   = 'appearance-none w-full text-xs font-semibold text-on-surface bg-white border border-outline-variant/60 rounded-lg pl-3 pr-8 py-2 cursor-pointer hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors';
                    @endphp

                    <div class="mb-6">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-lg font-bold">Bite Categories</h3>
                                <p class="text-xs text-on-surface-variant mt-1">Showing <span class="font-bold text-primary">{{ $periodLabel }}</span></p>
                            </div>
                        </div>

                        <!-- Filters: period type, month / quarter, year -->
                        <div class="mt-4 space-y-3">
                            <div class="flex p-1 bg-surface-container-low rounded-lg" role="group" aria-label="Period type">
                                @foreach (['monthly' => 'Monthly', 'quarterly' => 'Quarterly', 'yearly' => 'Yearly'] as $key => $text)
                                    <button type="button" onclick="biteNav({ filter: '{{ $key }}', period: null })"
                                            class="flex-1 px-3 py-1.5 text-xs font-bold rounded-md transition-all {{ $filter === $key ? 'bg-white text-primary shadow-sm' : 'text-on-surface-variant hover:text-primary' }}"
                                            @if ($filter === $key) aria-pressed="true" @endif>{{ $text }}</button>
                                @endforeach
                            </div>

                            <div class="flex items-center gap-3">
                            @if ($filter !== 'yearly')
                                <div class="relative flex-1">
                                    <select id="bite-period" onchange="biteNav({ period: this.value })" class="{{ $selectCls }}" aria-label="{{ $filter === 'quarterly' ? 'Quarter' : 'Month' }}">
                                        @foreach ($periodOpts as $value => $text)
                                            <option value="{{ $value }}" {{ (int) $bitePeriod === (int) $value ? 'selected' : '' }}>{{ $text }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="relative {{ $filter === 'yearly' ? 'flex-1' : 'w-28' }}">
                                <select id="bite-year" onchange="biteNav({ year: this.value })" class="{{ $selectCls }}" aria-label="Year">
                                    @foreach ($biteYears as $y)
                                        <option value="{{ $y }}" {{ (int) $biteYear === (int) $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 flex flex-col items-center justify-center">
                        <div id="donut-wrap" class="relative w-48 h-48 mb-8 group">
                            <svg class="w-full h-full transform -rotate-90 overflow-visible" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" fill="none" r="16" stroke="#f2f4f6" stroke-width="4" pathLength="100"></circle>

                                <circle class="donut-seg" cx="18" cy="18" fill="none" r="16" stroke="#002d6b"
                                        pathLength="100"
                                        stroke-dasharray="{{ $cat3Pct ?? 0 }}, 100" stroke-width="4"
                                        data-label="Category III" data-cases="{{ $cat3 ?? 0 }}" data-pct="{{ $cat3Pct ?? 0 }}">
                                </circle>

                                <circle class="donut-seg" cx="18" cy="18" fill="none" r="16" stroke="#0b61bb"
                                        pathLength="100"
                                        stroke-dasharray="{{ $cat2Pct ?? 0 }}, 100" stroke-dashoffset="-{{ $cat3Pct ?? 0 }}" stroke-width="4"
                                        data-label="Category II" data-cases="{{ $cat2 ?? 0 }}" data-pct="{{ $cat2Pct ?? 0 }}">
                                </circle>

                                <circle class="donut-seg" cx="18" cy="18" fill="none" r="16" stroke="#49607f"
                                        pathLength="100"
                                        stroke-dasharray="{{ $cat1Pct ?? 0 }}, 100" stroke-dashoffset="-{{ ($cat3Pct ?? 0) + ($cat2Pct ?? 0) }}" stroke-width="4"
                                        data-label="Category I" data-cases="{{ $cat1 ?? 0 }}" data-pct="{{ $cat1Pct ?? 0 }}">
                                </circle>
                            </svg>

                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <span class="text-2xl font-black text-primary">{{ number_format($totalBites ?? 0) }}</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase">Total Bites</span>
                            </div>

                            <div id="chart-tooltip" class="absolute bg-slate-900 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg shadow-xl pointer-events-none z-50 whitespace-nowrap"></div>
                        </div>

                        @if (($totalBites ?? 0) === 0)
                            <p class="text-xs text-on-surface-variant -mt-4 mb-6 text-center">No bite cases recorded for {{ $periodLabel }}.</p>
                        @endif

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

                <!-- Hotspots Card -->
                <div class="bg-surface-container-lowest p-8 rounded-xl shadow-sm border border-outline-variant/15 flex flex-col">
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

                    <div class="space-y-6 flex-1">
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
 
    // changes = { filter, period, year }; null removes a value so the server picks its default
    function biteNav(changes) {
        var url = new URL(window.location.href);
        Object.keys(changes).forEach(function (key) {
            if (changes[key] === null) url.searchParams.delete(key);
            else url.searchParams.set(key, changes[key]);
        });
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