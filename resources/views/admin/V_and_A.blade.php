<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Visual Analytics | ABTC-Insight</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-fixed-dim": "#ffb689",
                        "surface-container-low": "#f2f4f6",
                        "inverse-surface": "#2d3133",
                        "inverse-primary": "#a9c7ff",
                        "on-secondary-container": "#485f7e",
                        "surface-container-high": "#e6e8ea",
                        "surface-bright": "#f7f9fb",
                        "on-secondary-fixed-variant": "#314866",
                        "on-primary-fixed-variant": "#00468c",
                        "secondary-container": "#c1d9fd",
                        "primary-container": "#0b61bb",
                        "on-secondary-fixed": "#011c38",
                        "tertiary-fixed": "#ffdbc8",
                        "secondary-fixed": "#d3e4ff",
                        "on-surface-variant": "#414751",
                        "on-tertiary-fixed-variant": "#743500",
                        "on-error": "#ffffff",
                        "error-container": "#ffdad6",
                        "surface-dim": "#d8dadc",
                        "surface-container-highest": "#e0e3e5",
                        "surface-tint": "#005db6",
                        "secondary": "#49607f",
                        "tertiary": "#7a3800",
                        "outline-variant": "#c1c7d3",
                        "surface": "#f7f9fb",
                        "on-surface": "#191c1e",
                        "on-secondary": "#ffffff",
                        "secondary-fixed-dim": "#b1c8ec",
                        "on-primary": "#ffffff",
                        "inverse-on-surface": "#eff1f3",
                        "background": "#f7f9fb",
                        "primary-fixed": "#d6e3ff",
                        "on-error-container": "#93000a",
                        "tertiary-container": "#9e4b00",
                        "primary-fixed-dim": "#a9c7ff",
                        "on-primary-container": "#d0dfff",
                        "surface-variant": "#e0e3e5",
                        "on-primary-fixed": "#001b3d",
                        "on-tertiary-fixed": "#311300",
                        "on-tertiary-container": "#ffd7c0",
                        "outline": "#717782",
                        "primary": "#004a93",
                        "surface-container": "#eceef0",
                        "on-tertiary": "#ffffff",
                        "on-background": "#191c1e",
                        "error": "#ba1a1a",
                        "surface-container-lowest": "#ffffff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "1rem",
                        "xl": "1.5rem",
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
            background-color: #f7f9fb;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .clinical-shadow {
            box-shadow: 0 4px 24px -4px rgba(25, 28, 30, 0.04);
        }
        .glass-nav {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.85);
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #c1c7d3;
            border-radius: 10px;
        }
    </style>
    <script src="{{ asset('js/sidebar-toggle.js') }}"></script>
</head>

<body class="text-on-surface flex min-h-screen bg-surface">
    <!-- SideNavBar -->
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
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-700 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600 translate-x-1 duration-150" href="{{ route('admin.analytics') }}">
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
        <!-- TopAppBar -->
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

        <div class="flex-1 overflow-y-auto p-8 space-y-8">
            <!-- SECTION 1 — PAGE HEADER -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-on-surface tracking-tight leading-none mb-2">Visual Analytics</h2>
                    <p class="text-on-surface-variant text-lg font-medium opacity-70">Query and visualize bite case data across all dimensions.</p>
                </div>
                @if(request()->hasAny(['group', 'health_area', 'barangay', 'sex', 'age_min', 'age_max']))
                <div class="flex gap-3">
                    <form action="{{ route('admin.generate.report') }}" method="GET" target="_blank">
                        <!-- I-pasa ang tanang kasamtangang request parameters (apil ang barangay, sex, etc.) ngadto sa report -->
                        @foreach(request()->all() as $key => $value)
                            @if(!is_array($value))
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach

                        <button type="submit" class="flex items-center px-6 py-3 bg-primary text-white rounded-xl font-semibold shadow-xl shadow-primary/20 hover:opacity-90 transition-all cursor-pointer">
                            Generate Official Report
                        </button>
                    </form>

                    <a href="{{ route('report.export.csv', request()->all()) }}" class="flex items-center px-6 py-3 bg-[#D4AF37] text-white rounded-xl font-semibold shadow-xl shadow-yellow-700/10 hover:opacity-90 transition-all cursor-pointer">
                        Export All Results <span class="material-symbols-outlined ml-2">arrow_forward</span> CSV
                    </a>
                </div>
                @endif
            </div>
    
            <!-- SECTION 2 — REAL LIVE FILTER BAR -->
            <section class="bg-surface-container-lowest rounded-xl p-6 shadow-sm space-y-6 border border-outline-variant/10">
                <form method="GET" action="{{ route('admin.analytics') }}">
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
                        
    
                        <!-- Period Grouping (takes 3 columns) -->
                        <div class="md:col-span-3">
                            <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Period Grouping</label>
                            <div class="flex bg-surface-container-highest p-1 rounded-lg">
                                @php $currentGroup = request('group'); @endphp
                                <button type="submit" name="group" value="daily" class="flex-1 py-1.5 text-xs font-semibold rounded-md transition-all {{ $currentGroup == 'daily' ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant' }}">Daily</button>
                                <button type="submit" name="group" value="weekly" class="flex-1 py-1.5 text-xs font-semibold rounded-md transition-all {{ $currentGroup == 'weekly' ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant' }}">Weekly</button>
                                <button type="submit" name="group" value="monthly" class="flex-1 py-1.5 text-xs font-semibold rounded-md transition-all {{ $currentGroup == 'monthly' ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant' }}">Monthly</button>
                                <button type="submit" name="group" value="quarterly" class="flex-1 py-1.5 text-xs font-semibold rounded-md transition-all {{ $currentGroup == 'quarterly' ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant' }}">Quarterly</button>
                                <button type="submit" name="group" value="yearly" class="flex-1 py-1.5 text-xs font-semibold rounded-md transition-all {{ $currentGroup == 'yearly' ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant' }}">Yearly</button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 border-t border-outline-variant/10 pt-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Health Area</label>
                            <select name="health_area" class="w-full bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20">
                                <option value="">All Areas</option>
                                <option value="North" {{ request('health_area') == 'North' ? 'selected' : '' }}>North</option>
                                <option value="South" {{ request('health_area') == 'South' ? 'selected' : '' }}>South</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Barangay</label>
                            <input name="barangay" value="{{ request('barangay') }}" class="w-full bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20" placeholder="Search Barangay..." type="text" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Sex</label>
                            <select name="sex" class="w-full bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20">
                                <option value="All">All</option>
                                <option value="Male" {{ request('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ request('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Age Range</label>
                            <div class="flex items-center gap-2">
                                <input name="age_min" value="{{ request('age_min') }}" class="w-full bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20" placeholder="Min" type="number" />
                                <input name="age_max" value="{{ request('age_max') }}" class="w-full bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20" placeholder="Max" type="number" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-outline-variant/10">
                        <div class="flex items-center gap-2 text-sm text-on-surface-variant">
                            <span class="material-symbols-outlined text-primary text-lg">info</span>
                            Showing <strong class="text-on-surface">{{ number_format($totalBites ?? 0) }} bite cases</strong> matching current filters 
                            <span class="mx-1 text-outline">•</span> {{ number_format($uniquePatients ?? 0) }} unique patients
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('admin.analytics') }}" class="px-6 py-2 border border-outline-variant text-on-surface-variant font-semibold rounded-lg hover:bg-surface-container-low transition-colors text-center">Reset All</a>
                            <button type="submit" class="px-8 py-2 bg-primary text-white font-semibold rounded-lg shadow-lg shadow-primary/10 hover:shadow-primary/20 transition-all">Apply Filters</button>
                        </div>
                    </div>
                </form>
            </section>

            @if(request()->hasAny(['group', 'health_area', 'barangay', 'sex', 'age_min', 'age_max']))

            <!-- SECTION 3 — REAL LIVE KPI CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                <!-- Card 1: Total Bite Cases -->
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm">
                    <p class="text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-4">Total Bite Cases</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-4xl font-black text-on-surface tracking-tighter">{{ number_format($analyticsTotalBites ?? 0) }}</h3>
                        <span class="bg-primary/10 text-primary text-[10px] px-2 py-0.5 rounded-full font-bold mb-1">Live</span>
                    </div>
                </div>

                <!-- Card 2: Unique Patients -->
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm">
                    <p class="text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-4">Unique Patients</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-4xl font-black text-on-surface tracking-tighter">{{ number_format($analyticsUniquePatients ?? 0) }}</h3>
                        <div class="w-12 h-6 flex items-end gap-1 mb-1">
                            <div class="w-2 h-2 bg-primary/20 rounded-t-sm"></div>
                            <div class="w-2 h-4 bg-primary/40 rounded-t-sm"></div>
                            <div class="w-2 h-6 bg-primary rounded-t-sm"></div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Average Age -->
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm">
                    <p class="text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-4">Avg Age</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-4xl font-black text-on-surface tracking-tighter">{{ $analyticsAvgAge ?? 0 }}</h3>
                        <p class="text-[10px] font-bold text-on-surface-variant/70 mb-1">years</p>
                    </div>
                </div>

                <!-- Card 5: PEP Completion -->
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm overflow-hidden relative">
                    <p class="text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-4">PEP Completion</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-4xl font-black text-on-surface tracking-tighter">{{ $analyticsPepCompletion ?? 0 }}%</h3>
                        <div class="flex-1 h-8 ml-4 mb-1 overflow-hidden">
                            <svg class="w-full h-full stroke-primary fill-none stroke-2" viewBox="0 0 100 30">
                                <path d="M0,25 Q10,20 20,22 T40,15 T60,18 T80,5 T100,10"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 4 — CHARTS & RANKINGS GRID -->
            <div class="grid grid-cols-12 gap-8">
                <!-- Cases Over Time (Real Database-Driven Chart) -->
                <div class="col-span-12 bg-surface-container-lowest p-8 rounded-xl border border-outline-variant/10 shadow-sm">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h4 class="text-xl font-bold text-on-surface tracking-tight">Cases Over Time</h4>
                            <p class="text-sm text-on-surface-variant">Historical volume of new vs returning patient visits matching current filters</p>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#004a93]"></span> <span class="text-xs font-medium text-on-surface-variant">Total</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#49607f]"></span> <span class="text-xs font-medium text-on-surface-variant">New</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#c1c7d3]"></span> <span class="text-xs font-medium text-on-surface-variant">Returning</span></div>
                        </div>
                    </div>
                    <div class="h-[350px] w-full">
                        <canvas id="casesOverTimeChart"></canvas>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const ctx = document.getElementById('casesOverTimeChart').getContext('2d');
                            const chartLabels = {!! json_encode($chartLabels ?? ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC']) !!};
                            const totalData = {!! json_encode($totalCasesData ?? []) !!};
                            const newData = {!! json_encode($newCasesData ?? []) !!};
                            const returningData = {!! json_encode($returningCasesData ?? []) !!};

                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: chartLabels,
                                    datasets: [
                                        {
                                            label: 'Total Cases',
                                            data: totalData,
                                            borderColor: '#004a93',
                                            backgroundColor: '#004a93',
                                            borderWidth: 3,
                                            tension: 0.4,
                                            pointRadius: 4,
                                            pointBackgroundColor: '#004a93'
                                        },
                                        {
                                            label: 'New Patients',
                                            data: newData,
                                            borderColor: '#49607f',
                                            backgroundColor: '#49607f',
                                            borderWidth: 2,
                                            borderDash: [5, 5],
                                            tension: 0.4,
                                            pointRadius: 2
                                        },
                                        {
                                            label: 'Returning',
                                            data: returningData,
                                            borderColor: '#c1c7d3',
                                            backgroundColor: '#c1c7d3',
                                            borderWidth: 2,
                                            tension: 0.4,
                                            pointRadius: 2
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: { legend: { display: false } },
                                    scales: {
                                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                                        x: { grid: { display: false } }
                                    }
                                }
                            });
                        });
                    </script>
                </div>
                    
                <!-- Top Barangays Ranking -->
                <div class="col-span-12 md:col-span-6 bg-surface-container-lowest p-8 rounded-xl border border-outline-variant/10 shadow-sm">
                    <h4 class="text-lg font-bold text-on-surface mb-6">Top 15 Barangays by Incidence</h4>
                    @if(isset($topBarangays) && $topBarangays->count() > 0)
                        <div class="space-y-3">
                            @foreach($topBarangays as $b)
                                @php
                                    $percentage = $maxBarangayTotal > 0 ? round(($b->total / $maxBarangayTotal) * 100) : 0;
                                @endphp
                                <div class="flex items-center gap-3">
                                    <span class="w-28 text-xs font-bold text-on-surface-variant text-right truncate" title="{{ $b->barangay }}">{{ $b->barangay }}</span>
                                    <div class="flex-1 h-3 bg-surface-container-highest rounded-full overflow-hidden">
                                        <div class="h-full bg-primary transition-all duration-500" style="width: {{ $percentage }}%;"></div>
                                    </div>
                                    <span class="w-8 text-[10px] font-bold text-on-surface-variant">{{ number_format($b->total) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-on-surface-variant text-center py-6">No data available for the selected filters.</p>
                    @endif
                </div>

                <div class="col-span-12 md:col-span-6 flex flex-col gap-8">
                    
                    <!-- 1. Tabbed Demographics Card (Exposure, Sex, Animal - 3 Colors na) -->
                    <div class="bg-surface-container-lowest p-8 rounded-xl border border-outline-variant/10 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <h4 class="text-lg font-bold text-on-surface">Demographic & Exposure Breakdown</h4>
                                <div class="flex bg-surface-container-high p-1 rounded-lg">
                                    <button onclick="switchDemographicTab('exposure')" id="tab-exposure" class="px-3 py-1 text-xs font-bold rounded-md bg-primary text-white shadow-sm transition-all">Exposure</button>
                                    <button onclick="switchDemographicTab('sex')" id="tab-sex" class="px-3 py-1 text-xs font-bold rounded-md text-on-surface-variant transition-all">Sex</button>
                                    <button onclick="switchDemographicTab('animal')" id="tab-animal" class="px-3 py-1 text-xs font-bold rounded-md text-on-surface-variant transition-all">Animal</button>
                                </div>
                            </div>

                            <!-- TAB 1: Exposure Category Content -->
                            <div id="content-exposure" class="demographic-tab-content flex items-center justify-between">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 text-xs font-bold"><span class="w-2 h-2 rounded-full bg-primary"></span> Category III ({{ $cat3Pct ?? 0 }}%)</div>
                                    <div class="flex items-center gap-2 text-xs font-bold"><span class="w-2 h-2 rounded-full bg-secondary"></span> Category II ({{ $cat2Pct ?? 0 }}%)</div>
                                    <div class="flex items-center gap-2 text-xs font-bold"><span class="w-2 h-2 rounded-full bg-outline"></span> Category I ({{ $cat1Pct ?? 0 }}%)</div>
                                </div>
                                <div class="relative w-28 h-28">
                                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                        <circle class="stroke-outline/20" cx="18" cy="18" fill="none" r="16" stroke-width="4"></circle>
                                        <circle class="stroke-primary" cx="18" cy="18" fill="none" r="16" stroke-dasharray="{{ $cat3Pct ?? 0 }}, 100" stroke-width="4"></circle>
                                        <circle class="stroke-secondary" cx="18" cy="18" fill="none" r="16" stroke-dasharray="{{ $cat2Pct ?? 0 }}, 100" stroke-dashoffset="-{{ $cat3Pct ?? 0 }}" stroke-width="4"></circle>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center font-black text-primary text-base tracking-tighter">{{ $cat3Pct ?? 0 }}%</div>
                                </div>
                            </div>

                            <!-- TAB 2: Sex Distribution Content -->
                            <div id="content-sex" class="demographic-tab-content hidden flex items-center justify-between">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 text-xs font-bold"><span class="w-2 h-2 rounded-full bg-blue-500"></span> Male ({{ $malePct ?? 0 }}%)</div>
                                    <div class="flex items-center gap-2 text-xs font-bold"><span class="w-2 h-2 rounded-full bg-pink-400"></span> Female ({{ $femalePct ?? 0 }}%)</div>
                                </div>
                                <div class="relative w-28 h-28">
                                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                        <circle class="stroke-pink-400" cx="18" cy="18" fill="none" r="16" stroke-width="4"></circle>
                                        <circle class="stroke-blue-500" cx="18" cy="18" fill="none" r="16" stroke-dasharray="{{ $malePct ?? 0 }}, 100" stroke-width="4"></circle>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center font-black text-on-surface text-base tracking-tighter">{{ $malePct ?? 0 }}:{{ $femalePct ?? 0 }}</div>
                                </div>
                            </div>

                            <!-- TAB 3: Animal Type Content (3 Kolor na: Dogs, Cats, Others) -->
                            <div id="content-animal" class="demographic-tab-content hidden flex items-center justify-between">
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2 text-xs font-bold"><span class="w-2 h-2 rounded-full bg-primary"></span> Dogs ({{ $dogPct ?? 0 }}%)</div>
                                    <div class="flex items-center gap-2 text-xs font-bold"><span class="w-2 h-2 rounded-full bg-[#D4AF37]"></span> Cats ({{ $catAnimalPct ?? 0 }}%)</div>
                                    <div class="flex items-center gap-2 text-xs font-bold"><span class="w-2 h-2 rounded-full bg-secondary"></span> Others ({{ $otherAnimalPct ?? 0 }}%)</div>
                                </div>
                                <div class="relative w-28 h-28">
                                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                        <circle class="stroke-outline/10" cx="18" cy="18" fill="none" r="16" stroke-width="4"></circle>
                                        <circle class="stroke-primary" cx="18" cy="18" fill="none" r="16" stroke-dasharray="{{ $dogPct ?? 0 }}, 100" stroke-width="4"></circle>
                                        <circle class="stroke-[#D4AF37]" cx="18" cy="18" fill="none" r="16" stroke-dasharray="{{ $catAnimalPct ?? 0 }}, 100" stroke-dashoffset="-{{ $dogPct ?? 0 }}" stroke-width="4"></circle>
                                        <circle class="stroke-secondary" cx="18" cy="18" fill="none" r="16" stroke-dasharray="{{ $otherAnimalPct ?? 0 }}, 100" stroke-dashoffset="-{{ ($dogPct ?? 0) + ($catAnimalPct ?? 0) }}" stroke-width="4"></circle>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center font-black text-on-surface text-base tracking-tighter">{{ number_format($analyticsTotalBites ?? 0) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function switchDemographicTab(tab) {
                            document.querySelectorAll('.demographic-tab-content').forEach(el => el.classList.add('hidden'));
                            ['exposure', 'sex', 'animal'].forEach(t => {
                                const btn = document.getElementById('tab-' + t);
                                btn.className = "px-3 py-1 text-xs font-bold rounded-md text-on-surface-variant transition-all";
                            });
                            document.getElementById('content-' + tab).classList.remove('hidden');
                            document.getElementById('tab-' + tab).className = "px-3 py-1 text-xs font-bold rounded-md bg-primary text-white shadow-sm transition-all";
                        }
                    </script>

                    <!-- 2. Age Group Distribution (DIREKTA NA NGA NAKAPAHIMUTANG SA ILAWOM SA DEMOGRAPHICS) -->
                    <div class="bg-surface-container-lowest p-8 rounded-xl border border-outline-variant/10 shadow-sm">
                        <h4 class="text-lg font-bold text-on-surface mb-6">Age Group Distribution</h4>
                        <div class="flex items-end h-48 gap-4 px-4">
                            <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                                <div class="w-full bg-primary/20 rounded-t-lg transition-all duration-500" style="height: {{ $age0_12_pct ?? 0 }}%;"></div>
                                <span class="text-[10px] font-bold text-on-surface-variant">0-12 ({{ $age0_12 ?? 0 }})</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                                <div class="w-full bg-primary/40 rounded-t-lg transition-all duration-500" style="height: {{ $age13_19_pct ?? 0 }}%;"></div>
                                <span class="text-[10px] font-bold text-on-surface-variant">13-19 ({{ $age13_19 ?? 0 }})</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                                <div class="w-full bg-primary rounded-t-lg transition-all duration-500" style="height: {{ $age20_39_pct ?? 0 }}%;"></div>
                                <span class="text-[10px] font-bold text-on-surface-variant">20-39 ({{ $age20_39 ?? 0 }})</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                                <div class="w-full bg-primary/60 rounded-t-lg transition-all duration-500" style="height: {{ $age40_59_pct ?? 0 }}%;"></div>
                                <span class="text-[10px] font-bold text-on-surface-variant">40-59 ({{ $age40_59 ?? 0 }})</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                                <div class="w-full bg-primary/30 rounded-t-lg transition-all duration-500" style="height: {{ $age60_up_pct ?? 0 }}%;"></div>
                                <span class="text-[10px] font-bold text-on-surface-variant">60+ ({{ $age60_up ?? 0 }})</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- COLLAPSIBLE ACCORDION FOR EXPORTS & ANNUAL MATRIX TABLE -->
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/10 shadow-sm overflow-hidden mb-8">
                <button onclick="toggleAccordion()" class="w-full p-6 bg-surface-container-low flex justify-between items-center text-left hover:bg-surface-container transition-colors">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">table_chart</span>
                        <div>
                            <h4 class="text-base font-bold text-on-surface tracking-tight">Annual Matrix Summary & Data Exports</h4>
                            <p class="text-xs text-on-surface-variant">Click to expand detailed reports, exports, and historical matrix data.</p>
                        </div>
                    </div>
                    <span id="accordion-icon" class="material-symbols-outlined transition-transform duration-300">expand_more</span>
                </button>
<div id="accordion-content" class="hidden p-6 space-y-8 border-t border-outline-variant/10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- CARD 1: Barangay Export --}}
        <a href="{{ route('admin.export.monthly', ['year' => request('year', date('Y'))]) }}"
           class="bg-primary/5 p-6 rounded-xl border border-primary/10 flex items-center justify-between group hover:bg-primary/15 transition-all cursor-pointer">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-primary flex items-center justify-center text-white shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-2xl">table_view</span>
                </div>
                <div>
                    <h5 class="text-lg font-bold text-primary">Annual Barangay Export</h5>
                    <p class="text-xs text-on-surface-variant">Animal bite cases per barangay, per month and quarter.</p>
                </div>
            </div>
            <div class="flex flex-col items-end">
                <span class="text-[10px] font-black uppercase text-primary/60 mb-1">Format: EXCEL</span>
                <span class="material-symbols-outlined text-primary group-hover:translate-x-1 transition-transform">download</span>
            </div>
        </a>

        {{-- CARD 2: Annual Report --}}
        <a href="{{ route('admin.export.annual', ['year' => request('year', date('Y'))]) }}"
           class="bg-primary/5 p-6 rounded-xl border border-primary/10 flex items-center justify-between group hover:bg-primary/15 transition-all cursor-pointer">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-primary flex items-center justify-center text-white shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-2xl">summarize</span>
                </div>
                <div>
                    <h5 class="text-lg font-bold text-primary">Annual Report</h5>
                    <p class="text-xs text-on-surface-variant">Monthly and quarterly summary by sex, age, animal, category and PEP.</p>
                </div>
            </div>
            <div class="flex flex-col items-end">
                <span class="text-[10px] font-black uppercase text-primary/60 mb-1">Format: EXCEL</span>
                <span class="material-symbols-outlined text-primary group-hover:translate-x-1 transition-transform">download</span>
            </div>
        </a>

    </div>
</div>
            </div>

            @else
                <!-- 👉 KINI ANG MOGAWAS KUNG WALA PA NAKA-APPLY SA FILTERS (BLANK / PLACEHOLDER STATE) -->
                <div class="bg-surface-container-lowest rounded-xl p-12 text-center border border-outline-variant/10 shadow-sm space-y-4">
                    <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto">
                        <span class="material-symbols-outlined text-3xl">filter_alt</span>
                    </div>
                    <h3 class="text-xl font-bold text-on-surface">No Filters Applied Yet</h3>
                    <p class="text-sm text-on-surface-variant max-w-md mx-auto">
                        Palihug pagpili og period grouping o ubang filters sa taas unya i-klik ang <strong>"Apply Filters"</strong> aron makita ang analytics ug mga charts.
                    </p>
                </div>
            @endif

            <script>
                function toggleAccordion() {
                    const content = document.getElementById('accordion-content');
                    const icon = document.getElementById('accordion-icon');
                    content.classList.toggle('hidden');
                    icon.classList.toggle('rotate-180');
                }
                document.addEventListener('DOMContentLoaded', function () {
        // Kunin ang kasalukuyang group mula sa URL query parameters
        const urlParams = new URLSearchParams(window.location.search);
        const currentGroup = urlParams.get('group') || 'monthly';

        // Hanapin ang download button at i-update ang href nito gamit ang saktong route
        const downloadBtn = document.getElementById('download-report-btn');
        if (downloadBtn) {
            // Gigamit nato ang Laravel route helper nga walay error
            let baseUrl = "{{ route('admin.generate.report') }}";
            downloadBtn.href = baseUrl + '?group=' + currentGroup;
        }
    });
            </script>
        </div>
    </main>
</body>

</html>