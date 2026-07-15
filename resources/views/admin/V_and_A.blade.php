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
            }
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
</head>

<body class="text-on-surface flex min-h-screen bg-surface">
    <!-- Updated SideNavBar to match ABTC-Insight style -->
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
            </nav>
        </div>
        <div class="px-6 mt-auto pb-8">
            <button class="w-full py-3 bg-primary text-white rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                Generate Monthly Report
            </button>
        </div>
    </aside>
    <main class="ml-64 flex-1 flex flex-col min-w-0">
        <!-- Updated TopAppBar with user profile -->
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
        <div class="flex-1 overflow-y-auto p-8 space-y-8">
            <!-- SECTION 1 — PAGE HEADER -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-on-surface tracking-tight leading-none mb-2">Visual Analytics</h2>
                    <p class="text-on-surface-variant text-lg font-medium opacity-70">Query and visualize bite case data across all dimensions.</p>
                </div>
                <div class="flex gap-3">
                    <button class="flex items-center px-6 py-3 bg-primary text-white rounded-xl font-semibold shadow-xl shadow-primary/20 hover:opacity-90 transition-all">
                        Generate Official Report
                    </button>
                    <button class="flex items-center px-6 py-3 bg-[#D4AF37] text-white rounded-xl font-semibold shadow-xl shadow-yellow-700/10 hover:opacity-90 transition-all">
                        Export All Results <span class="material-symbols-outlined ml-2">arrow_forward</span> CSV
                    </button>
                </div>
            </div>
            <!-- SECTION 2 — FILTER BAR -->
            <section class="bg-surface-container-lowest rounded-xl p-6 shadow-sm space-y-6 border border-outline-variant/10">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Date Range</label>
                        <div class="flex items-center gap-2">
                            <input class="flex-1 bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20" type="date" />
                            <span class="text-on-surface-variant">to</span>
                            <input class="flex-1 bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20" type="date" />
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Period Grouping</label>
                        <div class="flex bg-surface-container-highest p-1 rounded-lg">
                            <button class="flex-1 py-1.5 text-sm font-semibold rounded-md transition-all text-on-surface-variant">Daily</button>
                            <button class="flex-1 py-1.5 text-sm font-semibold rounded-md transition-all text-on-surface-variant">Weekly</button>
                            <button class="flex-1 py-1.5 text-sm font-semibold rounded-md transition-all bg-white shadow-sm text-primary">Monthly</button>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6 border-t border-outline-variant/10 pt-6">
                    <div>
                        <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Health Area</label>
                        <select class="w-full bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20">
                            <option>All Areas</option>
                            <option>North</option>
                            <option>South</option>
                            <option>East</option>
                            <option>West</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Barangay</label>
                        <input class="w-full bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20" placeholder="Search Barangay..." type="text" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Sex</label>
                        <select class="w-full bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20">
                            <option>All</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Age Range</label>
                        <div class="flex items-center gap-2">
                            <input class="w-full bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20" placeholder="Min" type="number" />
                            <input class="w-full bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20" placeholder="Max" type="number" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Civil Status</label>
                        <select class="w-full bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20">
                            <option>All</option>
                            <option>Single</option>
                            <option>Married</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6 border-t border-outline-variant/10 pt-6">
                    <div class="col-span-1">
                        <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Exposure Category</label>
                        <div class="flex gap-4 items-center h-9">
                            <label class="flex items-center gap-2 text-xs font-medium"><input checked="" class="rounded text-primary focus:ring-primary/20" type="checkbox" /> Cat I</label>
                            <label class="flex items-center gap-2 text-xs font-medium"><input checked="" class="rounded text-primary focus:ring-primary/20" type="checkbox" /> Cat II</label>
                            <label class="flex items-center gap-2 text-xs font-medium"><input checked="" class="rounded text-primary focus:ring-primary/20" type="checkbox" /> Cat III</label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Animal Type</label>
                        <select class="w-full bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20">
                            <option>All</option>
                            <option>Dog</option>
                            <option>Cat</option>
                            <option>Others</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Exposure Type</label>
                        <select class="w-full bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20">
                            <option>All</option>
                            <option>Bite</option>
                            <option>Scratch</option>
                            <option>Lick</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Animal Status</label>
                        <select class="w-full bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20">
                            <option>All</option>
                            <option>Stray</option>
                            <option>Pet</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Animal Vax Status</label>
                        <select class="w-full bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20">
                            <option>All</option>
                            <option>Vaccinated</option>
                            <option>Unvaccinated</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center justify-between pt-6 border-t border-outline-variant/10">
                    <div class="flex items-center gap-2 text-sm text-on-surface-variant">
                        <span class="material-symbols-outlined text-primary text-lg">info</span>
                        Showing <strong class="text-on-surface">1,248 bite cases</strong> matching current filters <span class="mx-1 text-outline">•</span> 1,102 unique patients <span class="mx-1 text-outline">•</span> 850 new patients <span class="mx-1 text-outline">•</span> 252 returning patients
                    </div>
                    <div class="flex gap-3">
                        <button class="px-6 py-2 border border-outline-variant text-on-surface-variant font-semibold rounded-lg hover:bg-surface-container-low transition-colors">Reset All</button>
                        <button class="px-8 py-2 bg-primary text-white font-semibold rounded-lg shadow-lg shadow-primary/10 hover:shadow-primary/20 transition-all">Apply Filters</button>
                    </div>
                </div>
            </section>
            <!-- SECTION 3 — KPI CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm">
                    <p class="text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-4">Total Bite Cases</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-4xl font-black text-on-surface tracking-tighter">1,248</h3>
                        <span class="bg-primary/10 text-primary text-[10px] px-2 py-0.5 rounded-full font-bold mb-1">+12%</span>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm">
                    <p class="text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-4">Unique Patients</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-4xl font-black text-on-surface tracking-tighter">1,102</h3>
                        <div class="w-12 h-6 flex items-end gap-1 mb-1">
                            <div class="w-2 h-2 bg-primary/20 rounded-t-sm"></div>
                            <div class="w-2 h-4 bg-primary/40 rounded-t-sm"></div>
                            <div class="w-2 h-6 bg-primary rounded-t-sm"></div>
                        </div>
                    </div>
                </div>
                <div class="bg-error-container p-6 rounded-xl border border-error/5 shadow-sm">
                    <p class="text-xs font-bold uppercase text-on-error-container/60 tracking-widest mb-4">Category III Cases</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-4xl font-black text-on-error-container tracking-tighter">64.2%</h3>
                        <p class="text-[10px] font-bold text-on-error-container/70 mb-1">801 cases</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm">
                    <p class="text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-4">Avg Age</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-4xl font-black text-on-surface tracking-tighter">24.5</h3>
                        <p class="text-[10px] font-bold text-on-surface-variant/70 mb-1">years</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm overflow-hidden relative">
                    <p class="text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-4">PEP Completion</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-4xl font-black text-on-surface tracking-tighter">88.4%</h3>
                        <div class="flex-1 h-8 ml-4 mb-1 overflow-hidden">
                            <svg class="w-full h-full stroke-primary fill-none stroke-2" viewbox="0 0 100 30">
                                <path d="M0,25 Q10,20 20,22 T40,15 T60,18 T80,5 T100,10"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SECTION 4 — CHARTS GRID -->
            <div class="grid grid-cols-12 gap-8">
                <!-- Cases Over Time (Updated with Chart.js) -->
                <div class="col-span-12 bg-surface-container-lowest p-8 rounded-xl border border-outline-variant/10 shadow-sm">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h4 class="text-xl font-bold text-on-surface tracking-tight">Cases Over Time</h4>
                            <p class="text-sm text-on-surface-variant">Historical volume of new vs returning patient visits</p>
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
                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG'],
                                    datasets: [{
                                            label: 'Total Cases',
                                            data: [150, 165, 140, 180, 155, 175, 190, 210],
                                            borderColor: '#004a93',
                                            backgroundColor: '#004a93',
                                            borderWidth: 3,
                                            tension: 0.4,
                                            pointRadius: 4,
                                            pointBackgroundColor: '#004a93'
                                        },
                                        {
                                            label: 'New Patients',
                                            data: [110, 120, 105, 130, 115, 125, 135, 150],
                                            borderColor: '#49607f',
                                            backgroundColor: '#49607f',
                                            borderWidth: 2,
                                            borderDash: [5, 5],
                                            tension: 0.4,
                                            pointRadius: 0
                                        },
                                        {
                                            label: 'Returning',
                                            data: [40, 45, 35, 50, 40, 50, 55, 60],
                                            borderColor: '#c1c7d3',
                                            backgroundColor: '#c1c7d3',
                                            borderWidth: 2,
                                            tension: 0.4,
                                            pointRadius: 0
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            display: false
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            grid: {
                                                color: 'rgba(0,0,0,0.05)'
                                            },
                                            ticks: {
                                                font: {
                                                    size: 10,
                                                    family: 'Inter'
                                                }
                                            }
                                        },
                                        x: {
                                            grid: {
                                                display: false
                                            },
                                            ticks: {
                                                font: {
                                                    size: 10,
                                                    weight: 'bold',
                                                    family: 'Inter'
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                </div>
                <!-- Existing Charts preserved exactly as they are -->
                <div class="col-span-12 md:col-span-7 bg-surface-container-lowest p-8 rounded-xl border border-outline-variant/10 shadow-sm">
                    <h4 class="text-lg font-bold text-on-surface mb-6">Top 15 Barangays by Incidence</h4>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="w-24 text-xs font-bold text-on-surface-variant text-right">Guadalupe</span>
                            <div class="flex-1 h-3 bg-surface-container-highest rounded-full overflow-hidden">
                                <div class="h-full bg-primary" style="width: 95%;"></div>
                            </div>
                            <span class="w-8 text-[10px] font-bold text-on-surface-variant">142</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-24 text-xs font-bold text-on-surface-variant text-right">Lahug</span>
                            <div class="flex-1 h-3 bg-surface-container-highest rounded-full overflow-hidden">
                                <div class="h-full bg-primary" style="width: 82%;"></div>
                            </div>
                            <span class="w-8 text-[10px] font-bold text-on-surface-variant">118</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-24 text-xs font-bold text-on-surface-variant text-right">Talamban</span>
                            <div class="flex-1 h-3 bg-surface-container-highest rounded-full overflow-hidden">
                                <div class="h-full bg-primary" style="width: 78%;"></div>
                            </div>
                            <span class="w-8 text-[10px] font-bold text-on-surface-variant">105</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-24 text-xs font-bold text-on-surface-variant text-right">Mambaling</span>
                            <div class="flex-1 h-3 bg-surface-container-highest rounded-full overflow-hidden">
                                <div class="h-full bg-primary" style="width: 65%;"></div>
                            </div>
                            <span class="w-8 text-[10px] font-bold text-on-surface-variant">88</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-24 text-xs font-bold text-on-surface-variant text-right">Tisa</span>
                            <div class="flex-1 h-3 bg-surface-container-highest rounded-full overflow-hidden">
                                <div class="h-full bg-primary" style="width: 60%;"></div>
                            </div>
                            <span class="w-8 text-[10px] font-bold text-on-surface-variant">82</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-24 text-xs font-bold text-on-surface-variant text-right">Pardo</span>
                            <div class="flex-1 h-3 bg-surface-container-highest rounded-full overflow-hidden">
                                <div class="h-full bg-primary" style="width: 55%;"></div>
                            </div>
                            <span class="w-8 text-[10px] font-bold text-on-surface-variant">74</span>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-5 grid grid-rows-2 gap-8">
                    <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm flex items-center justify-between">
                        <div>
                            <h4 class="text-base font-bold text-on-surface mb-1">Exposure Category</h4>
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 text-[10px] font-bold"><span class="w-2 h-2 rounded-full bg-primary"></span> Category III (64%)</div>
                                <div class="flex items-center gap-2 text-[10px] font-bold"><span class="w-2 h-2 rounded-full bg-secondary"></span> Category II (31%)</div>
                                <div class="flex items-center gap-2 text-[10px] font-bold"><span class="w-2 h-2 rounded-full bg-outline"></span> Category I (5%)</div>
                            </div>
                        </div>
                        <div class="relative w-24 h-24">
                            <svg class="w-full h-full transform -rotate-90" viewbox="0 0 36 36">
                                <circle class="stroke-outline/20" cx="18" cy="18" fill="none" r="16" stroke-width="4"></circle>
                                <circle class="stroke-primary" cx="18" cy="18" fill="none" r="16" stroke-dasharray="64, 100" stroke-width="4"></circle>
                                <circle class="stroke-secondary" cx="18" cy="18" fill="none" r="16" stroke-dasharray="31, 100" stroke-dashoffset="-64" stroke-width="4"></circle>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center font-black text-primary text-sm tracking-tighter">64%</div>
                        </div>
                    </div>
                    <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm flex items-center justify-between">
                        <div>
                            <h4 class="text-base font-bold text-on-surface mb-1">Sex Distribution</h4>
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 text-[10px] font-bold"><span class="w-2 h-2 rounded-full bg-blue-500"></span> Male (52%)</div>
                                <div class="flex items-center gap-2 text-[10px] font-bold"><span class="w-2 h-2 rounded-full bg-pink-400"></span> Female (48%)</div>
                            </div>
                        </div>
                        <div class="relative w-24 h-24">
                            <svg class="w-full h-full transform -rotate-90" viewbox="0 0 36 36">
                                <circle class="stroke-pink-400" cx="18" cy="18" fill="none" r="16" stroke-width="4"></circle>
                                <circle class="stroke-blue-500" cx="18" cy="18" fill="none" r="16" stroke-dasharray="52, 100" stroke-width="4"></circle>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center font-black text-on-surface text-sm tracking-tighter">52:48</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 bg-surface-container-lowest p-8 rounded-xl border border-outline-variant/10 shadow-sm">
                    <h4 class="text-lg font-bold text-on-surface mb-6">Age Group Distribution</h4>
                    <div class="flex items-end h-48 gap-4 px-4">
                        <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                            <div class="w-full bg-primary/20 rounded-t-lg" style="height: 45%;"></div>
                            <span class="text-[10px] font-bold text-on-surface-variant">0-12</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                            <div class="w-full bg-primary/40 rounded-t-lg" style="height: 65%;"></div>
                            <span class="text-[10px] font-bold text-on-surface-variant">13-19</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                            <div class="w-full bg-primary rounded-t-lg" style="height: 100%;"></div>
                            <span class="text-[10px] font-bold text-on-surface-variant">20-39</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                            <div class="w-full bg-primary/60 rounded-t-lg" style="height: 55%;"></div>
                            <span class="text-[10px] font-bold text-on-surface-variant">40-59</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                            <div class="w-full bg-primary/30 rounded-t-lg" style="height: 25%;"></div>
                            <span class="text-[10px] font-bold text-on-surface-variant">60+</span>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 bg-surface-container-lowest p-8 rounded-xl border border-outline-variant/10 shadow-sm flex flex-col">
                    <h4 class="text-lg font-bold text-on-surface mb-6">Animal Type Distribution</h4>
                    <div class="flex items-center justify-around flex-1">
                        <div class="relative w-40 h-40">
                            <svg class="w-full h-full transform -rotate-90" viewbox="0 0 36 36">
                                <circle class="stroke-outline/10" cx="18" cy="18" fill="none" r="16" stroke-width="4"></circle>
                                <circle class="stroke-primary" cx="18" cy="18" fill="none" r="16" stroke-dasharray="82, 100" stroke-width="4"></circle>
                                <circle class="stroke-[#D4AF37]" cx="18" cy="18" fill="none" r="16" stroke-dasharray="14, 100" stroke-dashoffset="-82" stroke-width="4"></circle>
                                <circle class="stroke-secondary" cx="18" cy="18" fill="none" r="16" stroke-dasharray="4, 100" stroke-dashoffset="-96" stroke-width="4"></circle>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-2xl font-black text-on-surface tracking-tighter">1.2k</span>
                                <span class="text-[9px] uppercase tracking-widest font-bold opacity-50">Total</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="w-4 h-4 rounded bg-primary"></div>
                                <div class="text-xs">
                                    <p class="font-bold">Dogs</p>
                                    <p class="text-[10px] text-on-surface-variant/60">1,023 cases (82%)</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-4 h-4 rounded bg-[#D4AF37]"></div>
                                <div class="text-xs">
                                    <p class="font-bold">Cats</p>
                                    <p class="text-[10px] text-on-surface-variant/60">175 cases (14%)</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-4 h-4 rounded bg-secondary"></div>
                                <div class="text-xs">
                                    <p class="font-bold">Others</p>
                                    <p class="text-[10px] text-on-surface-variant/60">50 cases (4%)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SECTION 5 — EXPORT HUB -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-primary/5 p-8 rounded-xl border border-primary/10 flex items-center justify-between group hover:bg-primary/10 transition-all cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-primary flex items-center justify-center text-white shadow-lg shadow-primary/20">
                            <span class="material-symbols-outlined text-3xl">table_view</span>
                        </div>
                        <div>
                            <h5 class="text-xl font-bold text-primary">Detailed Monthly Export</h5>
                            <p class="text-sm text-on-surface-variant">Download full line-listing for internal auditing.</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-black uppercase text-primary/60 mb-2">Format: CSV</span>
                        <span class="material-symbols-outlined text-primary group-hover:translate-x-1 transition-transform">download</span>
                    </div>
                </div>
                <div class="bg-[#D4AF37]/5 p-8 rounded-xl border border-[#D4AF37]/10 flex items-center justify-between group hover:bg-[#D4AF37]/10 transition-all cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-[#D4AF37] flex items-center justify-center text-white shadow-lg shadow-yellow-700/20">
                            <span class="material-symbols-outlined text-3xl">picture_as_pdf</span>
                        </div>
                        <div>
                            <h5 class="text-xl font-bold text-[#D4AF37]">Download Summary PDF</h5>
                            <p class="text-sm text-on-surface-variant">Formatted executive summary for stakeholder review.</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-black uppercase text-[#D4AF37]/60 mb-2">Format: PDF</span>
                        <span class="material-symbols-outlined text-[#D4AF37] group-hover:translate-x-1 transition-transform">download</span>
                    </div>
                </div>
            </div>
            <!-- SECTION 6 — ANNUAL SUMMARY TABLE -->
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/10 shadow-sm overflow-hidden mb-8">
                <div class="p-6 border-b border-outline-variant/10 flex justify-between items-center">
                    <h4 class="text-lg font-bold text-on-surface tracking-tight">Annual Matrix Summary</h4>
                    <div class="flex gap-2">
                        <span class="px-3 py-1 bg-surface-container rounded-full text-[10px] font-bold text-on-surface-variant">FY 2023</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70">
                                <th class="p-4 sticky left-0 bg-surface-container-low z-10">Dimension</th>
                                <th class="p-4">Jan</th>
                                <th class="p-4">Feb</th>
                                <th class="p-4">Mar</th>
                                <th class="p-4">Apr</th>
                                <th class="p-4">May</th>
                                <th class="p-4">Jun</th>
                                <th class="p-4">Jul</th>
                                <th class="p-4">Aug</th>
                                <th class="p-4 bg-primary/5 text-primary">YTD</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/5">
                            <tr>
                                <td class="p-4 font-bold text-primary sticky left-0 bg-white z-10">Sex: Male</td>
                                <td class="p-4">88</td>
                                <td class="p-4">92</td>
                                <td class="p-4">76</td>
                                <td class="p-4">102</td>
                                <td class="p-4">84</td>
                                <td class="p-4">91</td>
                                <td class="p-4">105</td>
                                <td class="p-4">98</td>
                                <td class="p-4 font-black bg-primary/5">736</td>
                            </tr>
                            <tr>
                                <td class="p-4 font-bold text-primary sticky left-0 bg-white z-10">Sex: Female</td>
                                <td class="p-4">82</td>
                                <td class="p-4">88</td>
                                <td class="p-4">70</td>
                                <td class="p-4">95</td>
                                <td class="p-4">78</td>
                                <td class="p-4">86</td>
                                <td class="p-4">99</td>
                                <td class="p-4">92</td>
                                <td class="p-4 font-black bg-primary/5">690</td>
                            </tr>
                            <tr class="bg-surface-container-lowest/50">
                                <td class="p-4 font-bold text-secondary sticky left-0 bg-slate-50/50 z-10">Age Group: 0-12</td>
                                <td class="p-4">42</td>
                                <td class="p-4">38</td>
                                <td class="p-4">45</td>
                                <td class="p-4">50</td>
                                <td class="p-4">39</td>
                                <td class="p-4">41</td>
                                <td class="p-4">44</td>
                                <td class="p-4">46</td>
                                <td class="p-4 font-black bg-primary/5">345</td>
                            </tr>
                            <tr>
                                <td class="p-4 font-bold text-on-surface-variant sticky left-0 bg-white z-10">Animal: Stray</td>
                                <td class="p-4">110</td>
                                <td class="p-4">115</td>
                                <td class="p-4">98</td>
                                <td class="p-4">124</td>
                                <td class="p-4">108</td>
                                <td class="p-4">112</td>
                                <td class="p-4">130</td>
                                <td class="p-4">122</td>
                                <td class="p-4 font-black bg-primary/5">919</td>
                            </tr>
                            <tr>
                                <td class="p-4 font-bold text-error sticky left-0 bg-white z-10">Cat III Exposure</td>
                                <td class="p-4">98</td>
                                <td class="p-4">104</td>
                                <td class="p-4">89</td>
                                <td class="p-4">112</td>
                                <td class="p-4">96</td>
                                <td class="p-4">102</td>
                                <td class="p-4">118</td>
                                <td class="p-4">110</td>
                                <td class="p-4 font-black bg-primary/5">829</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>

</html>