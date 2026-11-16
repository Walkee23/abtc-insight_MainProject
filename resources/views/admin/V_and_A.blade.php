<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Visual Analytics | ABTC-Insight</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
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
    <script src="{{ asset('js/custom-select.js') }}" defer></script>
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
                @if(request()->hasAny(['group', 'year', 'date_from', 'date_to', 'week_from', 'week_to', 'month_from', 'month_to', 'quarter_from', 'quarter_to', 'health_area', 'barangay', 'sex', 'age_min', 'age_max']))
                <div class="flex gap-3">
                    <form action="{{ route('admin.generate.report') }}" method="GET" target="_blank">
                        <!-- I-pasa ang tanang kasamtangang request parameters (apil ang barangay, sex, etc.) ngadto sa report -->
                        @foreach(request()->all() as $key => $value)
                            @if(!is_array($value))
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        {{-- the report covers exactly the range shown on this page --}}
                        <input type="hidden" name="date_from" value="{{ $rangeFrom ?? '' }}">
                        <input type="hidden" name="date_to" value="{{ $rangeTo ?? '' }}">

                        <button type="submit" class="flex items-center px-6 py-3 bg-primary text-white rounded-xl font-semibold shadow-xl shadow-primary/20 hover:opacity-90 transition-all cursor-pointer">
                            Generate Official Report
                        </button>
                    </form>

                    <a href="{{ route('report.export.csv', request()->all()) }}" class="flex items-center px-6 py-3 bg-[#D4AF37] text-white rounded-xl font-semibold shadow-xl shadow-yellow-700/10 hover:opacity-90 transition-all cursor-pointer">
                        Export Filtered Results
                    </a>
                </div>
                @endif
            </div>
    
            <!-- SECTION 2 — REAL LIVE FILTER BAR -->
            <section class="bg-surface-container-lowest rounded-xl p-6 shadow-sm space-y-6 border border-outline-variant/10">
                <form method="GET" action="{{ route('admin.analytics') }}">
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
                        
    
                        <!-- Period Grouping (takes 3 columns). The buttons only choose; the choice is sent with "Apply Filters". -->
                        <div class="md:col-span-3">
                            <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Period Grouping</label>
                            @php $currentGroup = request('group'); @endphp
                            <div id="periodGroup" class="flex h-9 bg-surface-container-highest p-1 rounded-lg" role="group" aria-label="Period grouping">
                                @foreach (['daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly', 'quarterly' => 'Quarterly', 'yearly' => 'Yearly'] as $groupValue => $groupText)
                                    <button type="button" data-group="{{ $groupValue }}" aria-pressed="{{ $currentGroup == $groupValue ? 'true' : 'false' }}"
                                        class="flex-1 py-1.5 text-xs font-semibold rounded-md transition-all {{ $currentGroup == $groupValue ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant hover:text-primary' }}">{{ $groupText }}</button>
                                @endforeach
                            </div>
                            <input type="hidden" name="group" id="groupInput" value="{{ $currentGroup }}" @if(!$currentGroup) disabled @endif />
                        </div>

                        <!-- Range of the chosen period grouping. Only the fields of the chosen period are sent. -->
                        @php
                            $rv = $rangeValues ?? [];
                            $rb = $rangeBounds ?? ['min' => '2000-01-01', 'max' => date('Y-m-d'), 'min_month' => '2000-01', 'max_month' => date('Y-m'), 'min_week' => '2000-W01', 'max_week' => date('o-\WW')];
                            $fieldCls = 'w-full h-9 bg-surface-container-highest border-none rounded-lg px-3 text-sm focus:ring-2 focus:ring-primary/20';
                            $lblCls = 'block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2';
                            $activePanel = in_array($currentGroup, ['daily', 'weekly', 'monthly', 'quarterly', 'yearly'], true) ? $currentGroup : 'none';
                            $yearsList = $analyticsYears ?? [date('Y')];
                            $yearsAsc = array_reverse($yearsList);
                            $panelAttr = fn ($name) => 'data-range="' . $name . '" class="grid grid-cols-2 gap-6' . ($activePanel === $name ? '' : ' hidden') . '"';
                            $off = fn ($name) => $activePanel === $name ? '' : 'disabled';
                        @endphp
                        <div class="md:col-span-3">
                            <div {!! $panelAttr('none') !!}>
                                <div>
                                    <span class="{{ $lblCls }}">Year</span>
                                    <select name="year" {{ $off('none') }} class="{{ $fieldCls }}">
                                        @foreach ($yearsList as $yearOption)
                                            <option value="{{ $yearOption }}" {{ (string) ($rv['year'] ?? '') === (string) $yearOption ? 'selected' : '' }}>{{ $yearOption }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-[11px] leading-snug text-on-surface-variant self-end h-9 flex items-center">Pick a period grouping to choose a range.</p>
                            </div>

                            <div {!! $panelAttr('daily') !!}>
                                <div>
                                    <span class="{{ $lblCls }}">From date</span>
                                    <input type="date" name="date_from" value="{{ $rv['date_from'] ?? '' }}" min="{{ $rb['min'] }}" max="{{ $rb['max'] }}" {{ $off('daily') }} class="{{ $fieldCls }}" />
                                </div>
                                <div>
                                    <span class="{{ $lblCls }}">To date</span>
                                    <input type="date" name="date_to" value="{{ $rv['date_to'] ?? '' }}" min="{{ $rb['min'] }}" max="{{ $rb['max'] }}" {{ $off('daily') }} class="{{ $fieldCls }}" />
                                </div>
                            </div>

                            <div {!! $panelAttr('weekly') !!}>
                                <div>
                                    <span class="{{ $lblCls }}">From week</span>
                                    <input type="week" name="week_from" value="{{ $rv['week_from'] ?? '' }}" min="{{ $rb['min_week'] }}" max="{{ $rb['max_week'] }}" placeholder="2025-W01" pattern="\d{4}-W\d{2}" {{ $off('weekly') }} class="{{ $fieldCls }}" />
                                </div>
                                <div>
                                    <span class="{{ $lblCls }}">To week</span>
                                    <input type="week" name="week_to" value="{{ $rv['week_to'] ?? '' }}" min="{{ $rb['min_week'] }}" max="{{ $rb['max_week'] }}" placeholder="2025-W52" pattern="\d{4}-W\d{2}" {{ $off('weekly') }} class="{{ $fieldCls }}" />
                                </div>
                            </div>

                            <div {!! $panelAttr('monthly') !!}>
                                <div>
                                    <span class="{{ $lblCls }}">From month</span>
                                    <input type="month" name="month_from" value="{{ $rv['month_from'] ?? '' }}" min="{{ $rb['min_month'] }}" max="{{ $rb['max_month'] }}" placeholder="2025-01" pattern="\d{4}-\d{2}" {{ $off('monthly') }} class="{{ $fieldCls }}" />
                                </div>
                                <div>
                                    <span class="{{ $lblCls }}">To month</span>
                                    <input type="month" name="month_to" value="{{ $rv['month_to'] ?? '' }}" min="{{ $rb['min_month'] }}" max="{{ $rb['max_month'] }}" placeholder="2025-12" pattern="\d{4}-\d{2}" {{ $off('monthly') }} class="{{ $fieldCls }}" />
                                </div>
                            </div>

                            <div {!! $panelAttr('quarterly') !!}>
                                <div>
                                    <span class="{{ $lblCls }}">From quarter</span>
                                    <select name="quarter_from" {{ $off('quarterly') }} class="{{ $fieldCls }}">
                                        @foreach (($quarterOptions ?? []) as $q)
                                            <option value="{{ $q['value'] }}" {{ ($rv['quarter_from'] ?? '') === $q['value'] ? 'selected' : '' }}>{{ $q['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <span class="{{ $lblCls }}">To quarter</span>
                                    <select name="quarter_to" {{ $off('quarterly') }} class="{{ $fieldCls }}">
                                        @foreach (($quarterOptions ?? []) as $q)
                                            <option value="{{ $q['value'] }}" {{ ($rv['quarter_to'] ?? '') === $q['value'] ? 'selected' : '' }}>{{ $q['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div {!! $panelAttr('yearly') !!}>
                                <div>
                                    <span class="{{ $lblCls }}">Year</span>
                                    <select name="year" {{ $off('yearly') }} class="{{ $fieldCls }}">
                                        @foreach ($yearsAsc as $yearOption)
                                            <option value="{{ $yearOption }}" {{ (string) ($rv['year_start'] ?? '') === (string) $yearOption ? 'selected' : '' }}>{{ $yearOption }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <span class="{{ $lblCls }}">To year (optional)</span>
                                    <select name="year_to" {{ $off('yearly') }} class="{{ $fieldCls }}">
                                        <option value="">—</option>
                                        @foreach ($yearsAsc as $yearOption)
                                            <option value="{{ $yearOption }}" {{ (string) ($rv['year_end'] ?? '') === (string) $yearOption ? 'selected' : '' }}>{{ $yearOption }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @if (!empty($rangeNotice))
                                <p class="text-[11px] font-semibold text-amber-700 mt-2">{{ $rangeNotice }}</p>
                            @endif
                        </div>
                    </div>
                    <script>
                        (function () {
                            // Clicking a period highlights it straight away (clicking it again clears the choice) and shows the
                            // range fields of that period. Only the visible fields are sent when "Apply Filters" is pressed.
                            const box = document.getElementById('periodGroup');
                            const input = document.getElementById('groupInput');
                            const panels = document.querySelectorAll('[data-range]');
                            const ON = ['bg-white', 'shadow-sm', 'text-primary', 'font-bold'];
                            const OFF = ['text-on-surface-variant', 'hover:text-primary'];
                            function paint() {
                                const current = input.disabled ? 'none' : input.value;
                                box.querySelectorAll('button[data-group]').forEach((btn) => {
                                    const on = btn.dataset.group === current;
                                    ON.forEach((c) => btn.classList.toggle(c, on));
                                    OFF.forEach((c) => btn.classList.toggle(c, !on));
                                    btn.setAttribute('aria-pressed', on ? 'true' : 'false');
                                });
                                panels.forEach((panel) => {
                                    const on = panel.dataset.range === current;
                                    panel.classList.toggle('hidden', !on);
                                    panel.querySelectorAll('input, select').forEach((el) => { el.disabled = !on; });
                                });
                            }
                            box.addEventListener('click', (e) => {
                                const btn = e.target.closest('button[data-group]');
                                if (!btn) return;
                                if (!input.disabled && input.value === btn.dataset.group) {
                                    input.disabled = true;       // not sent: no period grouping
                                    input.value = '';
                                } else {
                                    input.disabled = false;
                                    input.value = btn.dataset.group;
                                }
                                paint();
                            });
                        })();
                    </script>

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 border-t border-outline-variant/10 pt-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-on-surface-variant/60 tracking-widest mb-2">Health Area</label>
                            <select name="health_area" class="w-full bg-surface-container-highest border-none rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary/20">
                                <option value="">All Areas</option>
                                <option value="North" {{ request('health_area') == 'North' ? 'selected' : '' }}>North</option>
                                <option value="South" {{ request('health_area') == 'South' ? 'selected' : '' }}>South</option>
                                <option value="East" {{ request('health_area') == 'East' ? 'selected' : '' }}>East</option>
                                <option value="West" {{ request('health_area') == 'West' ? 'selected' : '' }}>West</option>
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

            @if(request()->hasAny(['group', 'year', 'date_from', 'date_to', 'week_from', 'week_to', 'month_from', 'month_to', 'quarter_from', 'quarter_to', 'health_area', 'barangay', 'sex', 'age_min', 'age_max']))

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

               
            </div>

            <!-- SECTION 4 — CHARTS & RANKINGS GRID -->
            <div class="grid grid-cols-12 gap-8">
                <!-- Cases Over Time (Real Database-Driven Chart) -->
                <div class="col-span-12 bg-surface-container-lowest p-8 rounded-xl border border-outline-variant/10 shadow-sm">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h4 class="text-xl font-bold text-on-surface tracking-tight">Cases Over Time</h4>
                            <p class="text-sm text-on-surface-variant">Historical volume of new vs returning patient visits matching current filters @if(!empty($chartSubtitle)) · <span class="font-semibold text-primary">{{ $chartSubtitle }}</span>@endif</p>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#004a93]"></span> <span class="text-xs font-medium text-on-surface-variant">Total</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#49607f]"></span> <span class="text-xs font-medium text-on-surface-variant">New</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#c1c7d3]"></span> <span class="text-xs font-medium text-on-surface-variant">Returning</span></div>
                        </div>
                    </div>
                    <div id="casesChartWrap" class="relative w-full" style="aspect-ratio: 1000 / 340;">
                        <svg id="casesChart" class="w-full h-full block touch-none" viewBox="0 0 1000 340" preserveAspectRatio="xMidYMid meet"></svg>
                        <div id="casesTip" class="hidden pointer-events-none absolute z-10 bg-slate-900/95 text-white rounded-lg px-3 py-2 shadow-xl text-xs leading-snug whitespace-nowrap"></div>
                    </div>
                    <script type="application/json" id="casesData">{!! json_encode(['labels' => $chartLabels ?? [], 'total' => $totalCasesData ?? [], 'new' => $newCasesData ?? [], 'returning' => $returningCasesData ?? []], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
                    <script>
                        // Cases Over Time (SVG): same look as the forecasting chart - light grid, thick round line,
                        // dots, a hover guide with a dark tooltip
                        (function () {
                            const svg = document.getElementById('casesChart');
                            const tip = document.getElementById('casesTip');
                            const data = JSON.parse(document.getElementById('casesData').textContent);
                            const labels = data.labels, n = labels.length;
                            const series = [
                                { key: 'returning', name: 'Returning', color: '#c1c7d3', width: 2.5, dash: null, r: 3 },
                                { key: 'new', name: 'New', color: '#49607f', width: 2.5, dash: '7,4', r: 3 },
                                { key: 'total', name: 'Total', color: '#004a93', width: 3, dash: null, r: 4 },
                            ];
                            const W = 1000, H = 340, left = 44, right = 16, top = 16, bottom = 34;
                            const NS = 'http://www.w3.org/2000/svg';
                            const fmt = (v) => Number(v).toLocaleString();
                            const add = (tag, attrs, text) => {
                                const el = document.createElementNS(NS, tag);
                                Object.entries(attrs).forEach(([k, v]) => el.setAttribute(k, v));
                                if (text !== undefined) el.textContent = text;
                                svg.appendChild(el);
                                return el;
                            };

                            const maxVal = Math.max(1, ...data.total, ...data.new, ...data.returning);
                            const step = maxVal <= 4 ? 1 : Math.pow(10, Math.floor(Math.log10(maxVal / 4)));
                            const niceStep = [1, 2, 5, 10].map((m) => m * step).find((st) => maxVal / st <= 5) || step * 10;
                            const yMax = Math.ceil(maxVal / niceStep) * niceStep;
                            const x = (i) => left + (n === 1 ? (W - left - right) / 2 : i * (W - left - right) / (n - 1));
                            const y = (v) => top + (1 - v / yMax) * (H - top - bottom);

                            for (let v = 0; v <= yMax + 1e-9; v += niceStep) {
                                add('line', { x1: left, x2: W - right, y1: y(v), y2: y(v), stroke: '#eceef0', 'stroke-width': 1 });
                                add('text', { x: left - 8, y: y(v) + 4, 'text-anchor': 'end', 'font-size': 11, fill: '#717782' }, fmt(v));
                            }
                            const ticks = n <= 14 ? n : 8;
                            for (let t = 0; t < ticks; t++) {
                                const i = ticks === 1 ? 0 : Math.round(t * (n - 1) / (ticks - 1));
                                add('text', { x: x(i), y: H - 10, 'text-anchor': 'middle', 'font-size': 11, fill: '#717782' }, labels[i]);
                            }

                            if (!data.total.some((v) => v > 0)) {
                                add('text', { x: W / 2, y: H / 2, 'text-anchor': 'middle', 'font-size': 14, fill: '#717782' }, 'No cases match these filters in this period.');
                            }

                            // soft area under the Total line
                            if (n > 1) {
                                const pts = data.total.map((v, i) => x(i) + ',' + y(v)).join(' ');
                                add('polygon', { points: x(0) + ',' + y(0) + ' ' + pts + ' ' + x(n - 1) + ',' + y(0), fill: '#004a93', 'fill-opacity': 0.06 });
                            }
                            series.forEach((s) => {
                                const vals = data[s.key];
                                const attrs = { d: vals.map((v, i) => (i ? 'L' : 'M') + x(i) + ',' + y(v)).join(' '), fill: 'none', stroke: s.color, 'stroke-width': s.width, 'stroke-linecap': 'round', 'stroke-linejoin': 'round' };
                                if (s.dash) attrs['stroke-dasharray'] = s.dash;
                                add('path', attrs);
                                if (n <= 40) vals.forEach((v, i) => add('circle', { cx: x(i), cy: y(v), r: s.r, fill: s.color, stroke: s.color, 'stroke-width': 2 }));
                            });

                            // hover guides sit on top of everything else
                            const hoverLine = add('line', { x1: 0, x2: 0, y1: top, y2: H - bottom, stroke: '#004a93', 'stroke-opacity': 0.35, 'stroke-width': 1.5, visibility: 'hidden' });
                            const hoverRing = add('circle', { cx: 0, cy: 0, r: 7, fill: 'none', stroke: '#004a93', 'stroke-width': 2.5, visibility: 'hidden' });

                            function show(i, rect) {
                                const px = x(i), py = y(data.total[i]);
                                hoverLine.setAttribute('x1', px); hoverLine.setAttribute('x2', px); hoverLine.setAttribute('visibility', 'visible');
                                hoverRing.setAttribute('cx', px); hoverRing.setAttribute('cy', py); hoverRing.setAttribute('visibility', 'visible');

                                tip.replaceChildren();
                                const title = document.createElement('div');
                                title.className = 'font-bold';
                                title.textContent = labels[i];
                                tip.appendChild(title);
                                [['Total', 'total', '#ffffff'], ['New', 'new', '#cbd5e1'], ['Returning', 'returning', '#cbd5e1']].forEach(([name, key, color]) => {
                                    const row = document.createElement('div');
                                    row.style.color = color;
                                    row.textContent = name + ': ' + fmt(data[key][i]);
                                    tip.appendChild(row);
                                });
                                tip.classList.remove('hidden');
                                const cx = px / W * rect.width, cy = py / H * rect.height;
                                const tw = tip.offsetWidth, th = tip.offsetHeight;
                                tip.style.left = Math.min(Math.max(8, cx - tw / 2), rect.width - tw - 8) + 'px';
                                tip.style.top = (cy - th - 14 < 0 ? cy + 16 : cy - th - 14) + 'px';
                            }
                            svg.addEventListener('pointermove', (e) => {
                                if (!n) return;
                                const rect = svg.getBoundingClientRect();
                                const vx = (e.clientX - rect.left) * (W / rect.width);
                                let best = 0;
                                for (let i = 1; i < n; i++) if (Math.abs(x(i) - vx) < Math.abs(x(best) - vx)) best = i;
                                show(best, rect);
                            });
                            svg.addEventListener('pointerleave', () => {
                                tip.classList.add('hidden');
                                hoverLine.setAttribute('visibility', 'hidden');
                                hoverRing.setAttribute('visibility', 'hidden');
                            });
                        })();
                    </script>
                </div>
                    
                <!-- Top Barangays Ranking -->
                <div class="col-span-12 md:col-span-6 bg-surface-container-lowest p-8 rounded-xl border border-outline-variant/10 shadow-sm">
                    <h4 class="text-lg font-bold text-on-surface mb-6">Top 15 Barangays by Incidence</h4>
                    @php $bc = $barangayChart ?? ['rows' => [], 'total' => 0]; @endphp
                    @if(count($bc['rows']) > 0)
                        <div class="viz-rows space-y-1">
                            @foreach($bc['rows'] as $row)
                                <div class="viz-row group flex items-center gap-3 -mx-2 px-2 py-1.5 rounded-lg"
                                     data-tip-title="{{ $row['name'] }}"
                                     data-tip-lines="{{ number_format($row['count']) }} {{ $row['count'] === 1 ? 'case' : 'cases' }}|{{ number_format($row['pct'], 1) }}% of all cases">
                                    <span class="viz-name w-28 text-xs font-bold text-on-surface-variant text-right truncate transition-colors">{{ $row['name'] }}</span>
                                    <div class="viz-track flex-1 h-3 bg-surface-container-highest rounded-full overflow-hidden">
                                        <div class="viz-fill h-full bg-primary rounded-full" style="width: {{ $row['width'] }}%;"></div>
                                    </div>
                                    <span class="viz-count w-10 shrink-0 text-right text-[11px] font-bold text-on-surface-variant tabular-nums transition-colors">{{ number_format($row['count']) }}</span>
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

                            @foreach (['exposure', 'sex', 'animal'] as $tabKey)
                                @php $d = $breakdowns[$tabKey] ?? ['segments' => [], 'total' => 0]; $offset = 0; @endphp
                                <div id="content-{{ $tabKey }}" class="viz-donut demographic-tab-content {{ $tabKey === 'exposure' ? '' : 'hidden' }} flex items-center justify-between">
                                    <div class="space-y-1">
                                        @foreach ($d['segments'] as $i => $seg)
                                            <div class="viz-legend flex items-center gap-2 text-xs font-bold -ml-2 px-2 py-1 rounded-lg"
                                                 data-donut="{{ $tabKey }}" data-idx="{{ $i }}"
                                                 data-tip-title="{{ $seg['label'] }}"
                                                 data-tip-lines="{{ number_format($seg['count']) }} {{ $seg['count'] === 1 ? 'case' : 'cases' }}|{{ $seg['pct'] === 0 && $seg['count'] > 0 ? '<1' : $seg['pct'] }}% of {{ number_format($d['total']) }}">
                                                <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $seg['color'] }};"></span>
                                                <span>{{ $seg['label'] }}</span>
                                                <span class="font-semibold text-on-surface-variant">{{ $seg['pct'] === 0 && $seg['count'] > 0 ? '<1' : $seg['pct'] }}%</span>
                                            </div>
                                        @endforeach
                                        @if ($d['total'] === 0)
                                            <p class="text-xs text-on-surface-variant">No data for these filters.</p>
                                        @endif
                                    </div>
                                    <div class="relative w-28 h-28 shrink-0">
                                        <svg class="w-full h-full transform -rotate-90 overflow-visible" viewBox="0 0 36 36">
                                            <circle cx="18" cy="18" r="16" fill="none" stroke="#eceef0" stroke-width="4"></circle>
                                            @foreach ($d['segments'] as $i => $seg)
                                                @if ($seg['frac'] > 0)
                                                    <circle class="viz-seg" cx="18" cy="18" r="16" fill="none" stroke="{{ $seg['color'] }}" stroke-width="4" pathLength="100"
                                                            stroke-dasharray="{{ $seg['frac'] }} {{ round(100 - $seg['frac'], 3) }}" stroke-dashoffset="{{ -round($offset, 3) }}"
                                                            data-donut="{{ $tabKey }}" data-idx="{{ $i }}"
                                                            data-tip-title="{{ $seg['label'] }}"
                                                            data-tip-lines="{{ number_format($seg['count']) }} {{ $seg['count'] === 1 ? 'case' : 'cases' }}|{{ $seg['pct'] === 0 && $seg['count'] > 0 ? '<1' : $seg['pct'] }}% of {{ number_format($d['total']) }}"></circle>
                                                    @php $offset += $seg['frac']; @endphp
                                                @endif
                                            @endforeach
                                        </svg>
                                        <div class="absolute inset-0 flex flex-col items-center justify-center leading-none pointer-events-none">
                                            @if ($tabKey === 'sex')
                                                {{-- the ratio of the two shares (they add up to 100), e.g. 47:53 --}}
                                                <span class="font-black text-on-surface text-lg tracking-tighter tabular-nums">{{ $d['segments'][0]['pct'] ?? 0 }}:{{ $d['segments'][1]['pct'] ?? 0 }}</span>
                                                <span class="text-[9px] font-bold uppercase tracking-wider text-on-surface-variant/60 mt-1">Male : Female</span>
                                            @else
                                                <span class="font-black text-on-surface text-base tracking-tighter">{{ number_format($d['total']) }}</span>
                                                <span class="text-[9px] font-bold uppercase tracking-wider text-on-surface-variant/60 mt-1">Cases</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
                        @php $ages = $ageChart ?? ['bars' => [], 'known' => 0, 'unknown' => 0]; @endphp
                        <div class="viz-cols flex gap-4 px-2">
                            @foreach($ages['bars'] as $bar)
                                <div class="viz-col group flex-1 min-w-0 flex flex-col items-center"
                                     data-tip-title="Age {{ $bar['label'] }}"
                                     data-tip-lines="{{ number_format($bar['count']) }} {{ $bar['count'] === 1 ? 'case' : 'cases' }}|{{ number_format($bar['pct'], 1) }}% of cases with an age">
                                    {{-- fixed plot area: every bar is a share of the tallest one, and the labels sit outside it --}}
                                    <div class="h-40 w-full flex items-end">
                                        <div class="viz-bar w-full rounded-t-lg" style="height: {{ $bar['height'] }}%; background-color: {{ $bar['color'] }};"></div>
                                    </div>
                                    <div class="mt-3 text-center leading-tight">
                                        <p class="flex items-center justify-center gap-1.5 text-[11px] font-bold text-on-surface">
                                            <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $bar['color'] }};"></span>{{ $bar['label'] }}
                                        </p>
                                        <p class="text-[11px] font-semibold text-on-surface-variant mt-1 tabular-nums">{{ number_format($bar['count']) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

                    <style>
                        /* ---- hover effects of the Top Barangays, Demographic & Exposure and Age Group charts ---- */
                        .viz-tip { position: fixed; z-index: 70; pointer-events: none; opacity: 0; transform: translateY(4px) scale(.97);
                                   transition: opacity .15s ease, transform .15s ease; }
                        .viz-tip.show { opacity: 1; transform: none; }

                        /* Top barangays: the hovered row lights up, the others fade back */
                        .viz-row { transition: opacity .25s ease, background-color .25s ease; cursor: default; }
                        .viz-rows:hover .viz-row:not(:hover) { opacity: .45; }
                        .viz-row:hover { background-color: rgb(0 74 147 / .07); }
                        .viz-row .viz-track { transition: height .25s cubic-bezier(.4, 0, .2, 1); }
                        .viz-row .viz-fill { transition: filter .25s ease; }
                        /* the whole track grows (not the bar scaled inside it), so the bar keeps perfectly round ends */
                        .viz-row:hover .viz-track { height: 1rem; }
                        .viz-row:hover .viz-fill { filter: brightness(1.18); }
                        .viz-row:hover .viz-name, .viz-row:hover .viz-count { color: #004a93; }

                        /* Age groups: the hovered bar grows a little and brightens */
                        .viz-col { transition: opacity .25s ease; cursor: default; }
                        .viz-cols:hover .viz-col:not(:hover) { opacity: .45; }
                        .viz-col .viz-bar { transform-origin: bottom center; transition: transform .3s cubic-bezier(.4, 0, .2, 1), filter .25s ease; }
                        .viz-col:hover .viz-bar { transform: scaleY(1.05); filter: brightness(1.12) saturate(1.1); }

                        /* Donuts: slice and legend row light up together, the rest fade back */
                        .viz-seg { cursor: pointer; transition: stroke-width .25s cubic-bezier(.4, 0, .2, 1), opacity .25s ease; }
                        .viz-seg.is-active { stroke-width: 5.4; }
                        .viz-legend { cursor: default; transition: opacity .25s ease, background-color .25s ease; }
                        .viz-legend.is-active { background-color: rgb(0 74 147 / .07); }
                        .viz-donut.has-active .viz-seg:not(.is-active), .viz-donut.has-active .viz-legend:not(.is-active) { opacity: .4; }
                        @media (prefers-reduced-motion: reduce) {
                            .viz-tip, .viz-row, .viz-track, .viz-col, .viz-seg, .viz-legend, .viz-fill, .viz-bar { transition: none !important; }
                        }
                    </style>
                    <script>
                        (function () {
                            // One dark tooltip for all three charts: any element with data-tip-title / data-tip-lines ("a|b|c").
                            const tip = document.createElement('div');
                            tip.className = 'viz-tip bg-slate-900/95 text-white rounded-lg px-3 py-2 shadow-xl text-xs leading-snug whitespace-nowrap';
                            document.body.appendChild(tip);
                            let current = null;

                            function fill(el) {
                                tip.replaceChildren();
                                const title = document.createElement('div');
                                title.className = 'font-bold';
                                title.textContent = el.dataset.tipTitle;
                                tip.appendChild(title);
                                (el.dataset.tipLines || '').split('|').filter(Boolean).forEach((line, i) => {
                                    const row = document.createElement('div');
                                    row.className = i === 0 ? 'text-white' : 'text-slate-300';
                                    row.textContent = line;
                                    tip.appendChild(row);
                                });
                            }
                            function place(e) {
                                const w = tip.offsetWidth, h = tip.offsetHeight;
                                let x = e.clientX + 14, y = e.clientY - h - 14;
                                if (x + w > window.innerWidth - 8) x = e.clientX - w - 14;
                                if (y < 8) y = e.clientY + 18;
                                tip.style.left = Math.max(8, x) + 'px';
                                tip.style.top = y + 'px';
                            }
                            function hide() { tip.classList.remove('show'); current = null; setActive(null, null); }

                            // a donut slice and its legend row are highlighted together
                            function setActive(group, idx) {
                                document.querySelectorAll('.viz-donut').forEach((box) => {
                                    const on = group !== null && box.id === 'content-' + group;
                                    box.classList.toggle('has-active', on);
                                    box.querySelectorAll('[data-donut]').forEach((el) => el.classList.toggle('is-active', on && el.dataset.idx === String(idx)));
                                });
                            }

                            document.addEventListener('pointerover', (e) => {
                                const el = e.target.closest ? e.target.closest('[data-tip-title]') : null;
                                if (el === current) return;
                                current = el;
                                if (!el) { hide(); return; }
                                fill(el);
                                tip.classList.add('show');
                                place(e);
                                setActive(el.dataset.donut || null, el.dataset.idx);
                            });
                            document.addEventListener('pointermove', (e) => { if (current) place(e); });
                            window.addEventListener('scroll', hide, true);
                            document.addEventListener('pointerout', (e) => { if (!e.relatedTarget) hide(); });
                        })();
                    </script>

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
@php
    // the two annual files cover one whole year; offer every year that has data, newest first
    $exportYears = !empty($analyticsYears) ? $analyticsYears : [(int) date('Y')];
    $exportYear = in_array((int) ($rangeValues['year'] ?? 0), $exportYears, true) ? (int) $rangeValues['year'] : (int) $exportYears[0];
    $exportCards = [
        ['route' => 'admin.export.monthly', 'icon' => 'table_view', 'title' => 'Annual Barangay Export', 'text' => 'Animal bite cases per barangay, per month and quarter.'],
        ['route' => 'admin.export.annual', 'icon' => 'summarize', 'title' => 'Annual Report', 'text' => 'Monthly and quarterly summary by sex, age, animal, category and PEP.'],
    ];
@endphp
<div id="accordion-content" class="hidden p-6 space-y-6 border-t border-outline-variant/10">

    {{-- Year to export --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-on-surface-variant/60">Export Year</p>
            <p class="text-xs text-on-surface-variant mt-1">Both annual files cover the whole selected year, January to December.</p>
        </div>
        <select id="exportYear" aria-label="Export year" class="w-36 h-9 bg-surface-container-highest border-none rounded-lg px-3 text-sm font-semibold focus:ring-2 focus:ring-primary/20">
            @foreach ($exportYears as $yearOption)
                <option value="{{ $yearOption }}" {{ (int) $yearOption === $exportYear ? 'selected' : '' }}>{{ $yearOption }}</option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach ($exportCards as $card)
            <a href="{{ route($card['route'], ['year' => $exportYear]) }}" data-export-link data-base="{{ route($card['route']) }}"
               class="group flex items-center gap-4 p-5 rounded-xl border border-primary/10 bg-primary/5 hover:bg-primary/10 hover:border-primary/20 transition-all cursor-pointer">
                <div class="w-12 h-12 shrink-0 rounded-xl bg-primary flex items-center justify-center text-white shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-2xl">{{ $card['icon'] }}</span>
                </div>
                <div class="min-w-0 flex-1">
                    <h5 class="text-lg font-bold text-primary leading-tight">{{ $card['title'] }}</h5>
                    <p class="text-xs text-on-surface-variant leading-snug mt-1">{{ $card['text'] }}</p>
                </div>
                <div class="shrink-0 flex flex-col items-end gap-2">
                    <span class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-[10px] font-black uppercase tracking-wider text-primary whitespace-nowrap"><span data-export-year>{{ $exportYear }}</span>&nbsp;·&nbsp;Excel</span>
                    <span class="w-9 h-9 rounded-full bg-white/80 text-primary flex items-center justify-center shadow-sm transition-colors group-hover:bg-primary group-hover:text-white">
                        <span class="material-symbols-outlined text-[20px]">download</span>
                    </span>
                </div>
            </a>
        @endforeach
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
                // the year chosen for the annual exports goes into both download links (and the chip on each card)
                document.addEventListener('DOMContentLoaded', function () {
                    const select = document.getElementById('exportYear');
                    if (!select) return;
                    const sync = () => {
                        document.querySelectorAll('[data-export-link]').forEach((a) => {
                            a.href = a.dataset.base + '?year=' + encodeURIComponent(select.value);
                        });
                        document.querySelectorAll('[data-export-year]').forEach((s) => { s.textContent = select.value; });
                    };
                    select.addEventListener('change', sync);
                    sync();
                });
            </script>
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