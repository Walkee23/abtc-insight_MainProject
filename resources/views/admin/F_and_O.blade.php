<!DOCTYPE html>

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
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.gis_map') }}">
                    <span class="material-symbols-outlined">map</span>
                    <span class="font-['Inter'] text-sm tracking-wide">Spatial Map</span>
                </a>
            </nav>
        </div>
    </aside>
    <main class="ml-64 flex-1 flex flex-col min-w-0">
        <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md px-8 py-3 flex justify-between items-center border-b border-slate-100">
            <div class="flex-1"></div>
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
        <div class="p-8 space-y-10">
            @if(session('success') || session('error'))
            {{-- Toast: fixed bottom-right, auto-dismisses after 4s --}}
            <div id="statusToast" role="status"
                class="fixed bottom-6 right-8 z-50 max-w-sm flex items-center gap-3 {{ session('error') ? 'bg-error-container text-on-error-container border-error/20' : 'bg-emerald-50 text-emerald-700 border-emerald-200' }} text-sm font-semibold pl-4 pr-2 py-3 rounded-lg shadow-lg shadow-blue-900/10 border transition-opacity duration-300">
                <span class="material-symbols-outlined text-[18px]">{{ session('error') ? 'error' : 'check_circle' }}</span>
                <span class="flex-1">{{ session('success') ?? session('error') }}</span>
                <button type="button" id="statusToastClose" aria-label="Dismiss"
                    class="w-7 h-7 flex items-center justify-center rounded-full hover:bg-black/5 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
            @endif
            <!-- Section 1: Patient Volume Forecasting -->
            <section class="space-y-6">
                <div class="flex justify-between items-end">
                    <div>
                        <h2 class="text-2xl font-bold text-on-surface tracking-tight">Patient Volume Forecasting</h2>
                        <p class="text-on-surface-variant text-sm mt-1">
                            {{ $forecast['status'] === 'ok' ? $forecast['method'] : 'Exponential Smoothing' }} · patients per {{ $periods[$period]['unit'] }}
                        </p>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <p class="text-[10px] font-bold text-outline uppercase tracking-wider">View &amp; Forecast Interval</p>
                        <div class="bg-surface-container-low p-1 rounded-lg flex gap-1">
                            @foreach($periods as $key => $cfg)
                            <a href="{{ route('admin.forecasting', ['period' => $key] + array_filter($params, fn ($v, $k) => $v !== $defaults[$k], ARRAY_FILTER_USE_BOTH)) }}"
                                class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all {{ $period === $key ? 'bg-surface-container-lowest text-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' }}">{{ $cfg['label'] }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 lg:col-span-5 grid grid-cols-3 gap-4">
                        <div class="bg-surface-container-lowest p-5 rounded-xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col justify-between">
                            <p class="text-[10px] uppercase font-bold text-outline tracking-wider mb-1">Method</p>
                            <p class="text-sm font-bold text-primary leading-snug">{{ $forecast['status'] === 'ok' ? $forecast['method'] : '—' }}</p>
                            @if($forecast['status'] === 'ok' && !$forecast['seasonal'])
                            <span class="text-[10px] text-outline font-medium mt-1">Seasonality needs {{ 2 * $periods[$period]['season'] }}+ {{ $periods[$period]['unit'] }}s</span>
                            @endif
                        </div>
                        <div class="bg-surface-container-lowest p-5 rounded-xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col justify-between">
                            <p class="text-[10px] uppercase font-bold text-outline tracking-wider mb-1">MAPE</p>
                            <div class="flex flex-col">
                                <p class="text-lg font-bold text-primary">{{ $forecast['status'] === 'ok' && $forecast['mape'] !== null ? $forecast['mape'] . '%' : '—' }}</p>
                                <span class="text-[10px] text-primary/60 font-medium">{{ $forecast['status'] === 'ok' ? $forecast['mape_label'] : 'No data' }}</span>
                            </div>
                        </div>
                        <div class="bg-surface-container-lowest p-5 rounded-xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border-l-4 border-primary/20 flex flex-col justify-between">
                            <p class="text-[10px] uppercase font-bold text-outline tracking-wider mb-1">Confidence</p>
                            <div class="flex items-center gap-2">
                                <span class="text-lg font-bold text-on-surface">{{ $forecast['status'] === 'ok' ? $forecast['confidence'] : '—' }}</span>
                                @if($forecast['status'] === 'ok')
                                <div class="w-2 h-2 rounded-full {{ $forecast['confidence'] === 'High' ? 'bg-primary' : ($forecast['confidence'] === 'Moderate' ? 'bg-tertiary' : 'bg-error') }}"></div>
                                @endif
                            </div>
                            @if($forecast['status'] === 'ok')
                            <span class="text-[10px] text-outline font-medium mt-1">{{ $forecast['span_days'] }} days of data</span>
                            @endif
                        </div>
                    </div>
                    <form id="paramsForm" method="GET" action="{{ route('admin.forecasting') }}"
                        class="col-span-12 lg:col-span-7 bg-surface-container-low/30 p-6 rounded-2xl border border-outline-variant/10 space-y-5">
                        <input type="hidden" name="period" value="{{ $period }}" />
                        <div class="flex justify-between items-center mb-1">
                            <h3 class="text-xs font-bold text-on-surface uppercase tracking-widest flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm" data-icon="tune">tune</span>
                                Model Parameters Tuning
                            </h3>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.forecasting', ['period' => $period]) }}" class="text-[10px] font-bold text-primary hover:underline transition-all">Reset Defaults</a>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            @foreach([
                                'alpha' => ['Alpha (Level)', 'Controls focus on most recent data. High = fast reaction, Low = smooth historical average.', 'Focus on recent data vs. history'],
                                'beta' => ['Beta (Trend)', 'Controls reaction to data direction. High = fast trend catching, Low = steady history.', 'Sensitivity to growth direction'],
                                'gamma' => ['Gamma (Seasonality)', 'Controls adaptation to repeating patterns. High = updates based on recent cycle, Low = stable seasonal pattern.', 'Adaptation to seasonal patterns'],
                            ] as $key => [$label, $tip, $hint])
                            <div class="space-y-3 group">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-1.5 relative">
                                        <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-tight">{{ $label }}</label>
                                        <span class="material-symbols-outlined text-[14px] text-outline cursor-help group-hover:text-primary transition-colors" title="{{ $tip }}">info</span>
                                    </div>
                                    <span data-value-for="{{ $key }}" class="text-xs font-black text-primary bg-primary/5 px-2 py-0.5 rounded">{{ number_format($params[$key], 2) }}</span>
                                </div>
                                <input class="accent-primary w-full" name="{{ $key }}" max="0.9" min="0.1" step="0.01" type="range" value="{{ $params[$key] }}" />
                                <p class="text-[10px] text-outline leading-tight italic">{{ $hint }}</p>
                            </div>
                            @endforeach
                        </div>
                        @if($forecast['status'] === 'ok' && !$forecast['seasonal'])
                        <p class="text-[10px] text-outline italic">Gamma applies once there are {{ 2 * $periods[$period]['season'] }}+ completed {{ $periods[$period]['unit'] }}s.</p>
                        @endif
                    </form>
                </div>
                <div class="bg-surface-container-lowest p-8 rounded-xl shadow-[0_8px_30px_rgba(0,0,0,0.04)] relative overflow-hidden">
                    <div class="flex flex-wrap justify-between items-start gap-4 mb-6">
                        <div class="flex flex-col gap-2">
                            <span class="text-[10px] font-bold text-outline uppercase tracking-widest">
                                Historical data
                            </span>
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-primary rounded-full"></div>
                                    <span class="text-xs font-medium text-on-surface-variant">Actual Volume</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-5 border-t-2 border-dashed border-primary/60"></div>
                                    <span class="text-xs font-medium text-on-surface-variant">Predicted Trend</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-primary/10 rounded-sm"></div>
                                    <span class="text-xs font-medium text-on-surface-variant">95% Confidence Interval</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-6">
                            @if($forecast['status'] === 'ok')
                            <div class="text-right">
                                <p class="text-[10px] font-bold text-outline uppercase tracking-widest">Expected {{ $periods[$period]['unit'] === 'day' ? 'today' : 'this ' . $periods[$period]['unit'] }}</p>
                                <p class="text-xl font-black text-primary">{{ rtrim(rtrim(number_format($forecast['next_value'], 1), '0'), '.') }} <span class="text-xs font-semibold text-outline">patients</span></p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-bold text-outline uppercase tracking-widest">Next {{ $periods[$period]['horizon'] }} {{ $periods[$period]['unit'] }}s</p>
                                <p class="text-xl font-black text-on-surface">{{ rtrim(rtrim(number_format($forecast['total_horizon'], 1), '0'), '.') }} <span class="text-xs font-semibold text-outline">patients</span></p>
                            </div>
                            <form method="POST" action="{{ route('admin.forecasting.save') }}">
                                @csrf
                                <input type="hidden" name="period" value="{{ $period }}" />
                                @foreach($params as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
                                @endforeach
                                <button type="submit"
                                    class="px-4 py-2 bg-primary text-on-primary text-xs font-bold rounded-lg shadow-md shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px]">save</span> Save Forecast
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @if($forecast['status'] === 'ok')
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-4 pb-4 border-b border-outline-variant/10">
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="text-[10px] font-bold text-outline uppercase tracking-widest">Date Range</span>
                            <div id="rangePresets" class="bg-surface-container-low p-1 rounded-lg flex gap-1"></div>
                            <div class="flex items-center gap-2 text-xs text-on-surface-variant">
                                <input id="rangeFrom" type="date" aria-label="From date"
                                    class="bg-surface-container-low border-none rounded-lg px-3 py-1.5 text-xs font-semibold focus:ring-2 focus:ring-primary/20" />
                                <span>to</span>
                                <input id="rangeTo" type="date" aria-label="To date"
                                    class="bg-surface-container-low border-none rounded-lg px-3 py-1.5 text-xs font-semibold focus:ring-2 focus:ring-primary/20" />
                            </div>
                        </div>
                        <p id="rangeSummary" class="text-xs font-semibold text-on-surface-variant"></p>
                    </div>
                    <div id="chartWrap" class="relative w-full" style="aspect-ratio: 1000 / 340;">
                        <svg id="forecastChart" data-period="{{ $period }}" class="w-full h-full block touch-none" viewBox="0 0 1000 340" preserveAspectRatio="xMidYMid meet"></svg>
                        <div id="chartTip" class="hidden pointer-events-none absolute z-10 bg-slate-900/95 text-white rounded-lg px-3 py-2 shadow-xl text-xs leading-snug whitespace-nowrap"></div>
                    </div>
                    <script type="application/json" id="forecastData">@json(['history' => $forecast['history'], 'future' => $forecast['future']])</script>
                    <p class="text-[11px] text-outline mt-3">
                        {{ $saved > 0 ? $saved . ' forecast rows saved' . ($lastSaved ? ', last on ' . \Carbon\Carbon::parse($lastSaved)->format('M d, Y g:i A') : '') . '.' : 'No forecast saved yet.' }}
                        The current {{ $periods[$period]['unit'] }} is still in progress, so it starts the forecast.
                    </p>
                    @elseif($forecast['status'] === 'short')
                    <div class="h-[240px] flex flex-col items-center justify-center text-center gap-2">
                        <span class="material-symbols-outlined text-4xl text-outline-variant">query_stats</span>
                        <p class="text-sm font-bold text-on-surface-variant">Not enough {{ strtolower($periods[$period]['label']) }} data yet.</p>
                        <p class="text-xs text-outline max-w-sm">At least 3 completed {{ $periods[$period]['unit'] }}s of registrations are needed ({{ $forecast['points'] }} so far). Try another interval.</p>
                    </div>
                    @else
                    <div class="h-[240px] flex flex-col items-center justify-center text-center gap-2">
                        <span class="material-symbols-outlined text-4xl text-outline-variant">query_stats</span>
                        <p class="text-sm font-bold text-on-surface-variant">No patient registrations to forecast from yet.</p>
                    </div>
                    @endif
                </div>
            </section>
            <!-- Section 2: Outbreak Detection -->
            <section class="space-y-6">
                <div class="flex justify-between items-end">
                    <div>
                        <h2 class="text-2xl font-bold text-on-surface tracking-tight">Outbreak Detection &amp; Monitoring</h2>
                        <p class="text-on-surface-variant text-sm mt-1">Last 7 days ({{ $outbreak['from'] }} – {{ $outbreak['to'] }}) vs. each barangay's usual week</p>
                    </div>
                    <button type="button" id="toggleAllBarangays"
                        class="flex items-center gap-2 px-4 py-2 text-primary font-bold text-sm hover:bg-primary/5 rounded-lg transition-colors">
                        <span id="toggleAllLabel">View All Barangays</span>
                        <span class="material-symbols-outlined text-sm" data-icon="arrow_forward">arrow_forward</span>
                    </button>
                </div>
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 lg:col-span-3 flex flex-col gap-6">
                        <div class="bg-surface-container-low p-6 rounded-xl space-y-1">
                            <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Barangays Monitored</p>
                            <p class="text-4xl font-black text-on-surface">{{ $outbreak['monitored'] }}</p>
                            <div class="h-1.5 w-full bg-outline-variant/20 rounded-full overflow-hidden mt-4">
                                <div class="h-full bg-primary" style="width: {{ min(100, round($outbreak['with_cases'] / max(1, $outbreak['monitored']) * 100)) }}%"></div>
                            </div>
                            <p class="text-[10px] text-outline pt-1">{{ $outbreak['with_cases'] }} with cases in the last 5 weeks</p>
                        </div>
                        <div class="{{ $outbreak['spikes'] > 0 ? 'bg-error-container' : 'bg-surface-container-low' }} p-6 rounded-xl space-y-1 h-full flex flex-col justify-center">
                            <p class="text-xs font-bold {{ $outbreak['spikes'] > 0 ? 'text-on-error-container' : 'text-on-surface-variant' }} uppercase tracking-widest">Active Spike Alerts</p>
                            <p class="text-4xl font-black {{ $outbreak['spikes'] > 0 ? 'text-on-error-container' : 'text-on-surface' }}">{{ $outbreak['spikes'] }}</p>
                            <div class="flex items-center gap-1 {{ $outbreak['spikes'] > 0 ? 'text-on-error-container' : 'text-on-surface-variant' }} mt-2">
                                <span class="material-symbols-outlined text-sm" data-icon="warning">{{ $outbreak['spikes'] > 0 ? 'warning' : 'check_circle' }}</span>
                                <span class="text-[10px] font-bold">{{ $outbreak['spikes'] > 0 ? 'Immediate attention required' : 'No spikes detected' }}</span>
                            </div>
                            @if($outbreak['watch'] > 0)
                            <p class="text-[10px] font-semibold text-tertiary pt-1">{{ $outbreak['watch'] }} {{ \Illuminate\Support\Str::plural('barangay', $outbreak['watch']) }} on watch</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-9 space-y-4">
                        <h3 class="text-sm font-bold text-on-surface-variant px-2" id="alertsHeading">Priority Alerts</h3>
                        @php $alerts = array_values(array_filter($outbreak['list'], fn ($b) => $b->level !== 'normal')); @endphp
                        @foreach($outbreak['list'] as $b)
                        @php
                            $isAlert = $b->level !== 'normal';
                            $color = $b->level === 'spike' ? 'error' : ($b->level === 'watch' ? 'tertiary' : 'outline-variant');
                            $textColor = $b->level === 'spike' ? 'text-error' : ($b->level === 'watch' ? 'text-tertiary' : 'text-on-surface');
                        @endphp
                        <div data-barangay-row data-alert="{{ $isAlert ? '1' : '0' }}"
                            class="{{ $isAlert ? '' : 'hidden' }} bg-surface-container-lowest p-5 rounded-xl shadow-sm border-l-4 border-{{ $color }} flex items-center justify-between group hover:shadow-md transition-all">
                            <div class="flex items-center gap-4">
                                <h4 class="text-lg font-bold text-on-surface pl-2">{{ $b->name }}</h4>
                                <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full {{ $b->level === 'spike' ? 'bg-error-container text-on-error-container' : ($b->level === 'watch' ? 'bg-tertiary-fixed text-on-tertiary-fixed-variant' : 'bg-surface-container-high text-on-surface-variant') }}">{{ $b->level === 'spike' ? 'Spike' : ($b->level === 'watch' ? 'Watch' : 'Normal') }}</span>
                            </div>
                            <div class="flex gap-10 sm:gap-16 text-center pr-6">
                                <div>
                                    <p class="text-[10px] font-bold text-outline uppercase tracking-wider">Current Cases</p>
                                    <p class="text-xl font-black {{ $textColor }}">{{ $b->current }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-outline uppercase tracking-wider">Weekly Average</p>
                                    <p class="text-xl font-black text-on-surface">{{ rtrim(rtrim(number_format($b->baseline, 1), '0'), '.') ?: '0' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-outline uppercase tracking-wider">Deviation</p>
                                    <p class="text-xl font-black {{ $textColor }}">{{ $b->deviation === null ? ($b->current > 0 ? 'New' : '—') : ($b->deviation > 0 ? '+' : '') . $b->deviation . '%' }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <p id="noAlerts" class="{{ count($alerts) ? 'hidden' : '' }} text-sm text-on-surface-variant bg-surface-container-low rounded-xl px-5 py-6 text-center">
                            @if(empty($outbreak['list']))
                            No cases in the last 5 weeks yet.
                            @else
                            No barangay is above its usual level.
                            @endif
                        </p>
                        <p class="text-[11px] text-outline px-2">Spike: 3+ cases, over 2× the usual week. Watch: 2+ cases, 1.5× or more.</p>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script>
        (function () {
            // Slider labels follow the slider; the forecast is recalculated once it is released
            const form = document.getElementById('paramsForm');
            form.querySelectorAll('input[type="range"]').forEach((slider) => {
                const label = form.querySelector('[data-value-for="' + slider.name + '"]');
                slider.addEventListener('input', () => { label.textContent = Number(slider.value).toFixed(2); });
                slider.addEventListener('change', () => form.submit());
            });

            // Priority alerts <-> all barangays with cases
            const rows = document.querySelectorAll('[data-barangay-row]');
            const toggle = document.getElementById('toggleAllBarangays');
            const toggleLabel = document.getElementById('toggleAllLabel');
            const heading = document.getElementById('alertsHeading');
            const noAlerts = document.getElementById('noAlerts');
            let showAll = false;
            toggle.addEventListener('click', () => {
                showAll = !showAll;
                let shown = 0;
                rows.forEach((row) => {
                    const visible = showAll || row.dataset.alert === '1';
                    row.classList.toggle('hidden', !visible);
                    if (visible) shown++;
                });
                noAlerts.classList.toggle('hidden', shown > 0);
                heading.textContent = showAll ? 'All Barangays With Cases' : 'Priority Alerts';
                toggleLabel.textContent = showAll ? 'Show Priority Alerts' : 'View All Barangays';
            });

            // Forecast chart (SVG): actual line, dashed forecast and its confidence band,
            // with a date range for the history and a hover tooltip showing the cases
            const dataEl = document.getElementById('forecastData');
            const svg = document.getElementById('forecastChart');
            if (dataEl && svg) {
                const { history, future } = JSON.parse(dataEl.textContent);
                const period = svg.dataset.period;
                const unit = { daily: 'day', weekly: 'week', monthly: 'month' }[period];
                const wrap = document.getElementById('chartWrap');
                const tip = document.getElementById('chartTip');
                const fromEl = document.getElementById('rangeFrom');
                const toEl = document.getElementById('rangeTo');
                const summary = document.getElementById('rangeSummary');
                const presetBox = document.getElementById('rangePresets');
                const firstDate = history[0].date;
                const lastDate = history[history.length - 1].date;

                const W = 1000, H = 340, left = 44, right = 16, top = 16, bottom = 34;
                const NS = 'http://www.w3.org/2000/svg';
                const fmt = (v) => String(Math.round(v * 10) / 10);
                const plural = (n, word) => n + ' ' + word + (n === 1 ? '' : 's');

                // Date range: presets are measured back from the latest completed period
                fromEl.min = toEl.min = firstDate;
                fromEl.max = toEl.max = lastDate;
                fromEl.value = firstDate;
                toEl.value = lastDate;

                // [label, number of latest periods]; null = everything
                const presets = {
                    daily: [['14D', 14], ['30D', 30]],
                    weekly: [['4W', 4], ['12W', 12]],
                    monthly: [['6M', 6], ['12M', 12]],
                }[period].concat([['All', null]]);
                const presetFrom = (count) => (count === null ? firstDate : history[Math.max(0, history.length - count)].date);
                presets.forEach(([label, days]) => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.textContent = label;
                    btn.dataset.days = days === null ? 'all' : days;
                    btn.addEventListener('click', () => {
                        fromEl.value = presetFrom(days);
                        toEl.value = lastDate;
                        render();
                    });
                    presetBox.appendChild(btn);
                });
                const styleButtons = () => presetBox.querySelectorAll('button').forEach((btn) => {
                    const days = btn.dataset.days === 'all' ? null : Number(btn.dataset.days);
                    const on = fromEl.value === presetFrom(days) && toEl.value === lastDate;
                    btn.className = 'px-3 py-1 text-[11px] font-bold rounded-md transition-all ' +
                        (on ? 'bg-surface-container-lowest text-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high');
                });
                [fromEl, toEl].forEach((el) => el.addEventListener('change', () => {
                    // keep from <= to
                    if (fromEl.value && toEl.value && fromEl.value > toEl.value) {
                        if (el === fromEl) toEl.value = fromEl.value; else fromEl.value = toEl.value;
                    }
                    render();
                }));

                let plotted = [];
                let hoverLine = null, hoverRing = null;

                const add = (tag, attrs, text) => {
                    const el = document.createElementNS(NS, tag);
                    Object.entries(attrs).forEach(([k, v]) => el.setAttribute(k, v));
                    if (text !== undefined) el.textContent = text;
                    svg.appendChild(el);
                    return el;
                };

                function render() {
                    svg.replaceChildren();
                    tip.classList.add('hidden');
                    plotted = [];
                    const from = fromEl.value || firstDate;
                    const to = toEl.value || lastDate;
                    const hist = history.filter((p) => p.date >= from && p.date <= to);
                    const total = hist.reduce((sum, p) => sum + p.value, 0);
                    summary.textContent = hist.length
                        ? 'Showing ' + plural(hist.length, unit) + ' · ' + plural(Math.round(total * 10) / 10, 'case') + ' in range'
                        : 'No data in this range';
                    styleButtons();

                    if (!hist.length) {
                        add('text', { x: W / 2, y: H / 2, 'text-anchor': 'middle', 'font-size': 14, fill: '#717782' }, 'No historical data in the selected range.');
                        return;
                    }

                    // The forecast continues from the latest period, so it only shows when the range reaches it
                    const fut = hist[hist.length - 1].date === lastDate ? future : [];
                    const all = hist.concat(fut);
                    const n = all.length;
                    const maxVal = Math.max(1, ...hist.map((p) => p.value), ...fut.map((p) => p.upper));
                    const step = maxVal <= 4 ? 1 : Math.pow(10, Math.floor(Math.log10(maxVal / 4)));
                    const niceStep = [1, 2, 5, 10].map((m) => m * step).find((st) => maxVal / st <= 5) || step * 10;
                    const yMax = Math.ceil(maxVal / niceStep) * niceStep;
                    const x = (i) => left + (n === 1 ? (W - left - right) / 2 : i * (W - left - right) / (n - 1));
                    const y = (v) => top + (1 - v / yMax) * (H - top - bottom);

                    for (let v = 0; v <= yMax + 1e-9; v += niceStep) {
                        add('line', { x1: left, x2: W - right, y1: y(v), y2: y(v), stroke: '#eceef0', 'stroke-width': 1 });
                        add('text', { x: left - 8, y: y(v) + 4, 'text-anchor': 'end', 'font-size': 11, fill: '#717782' }, fmt(v));
                    }
                    const ticks = Math.min(n, 8);
                    for (let t = 0; t < ticks; t++) {
                        const i = ticks === 1 ? 0 : Math.round(t * (n - 1) / (ticks - 1));
                        add('text', { x: x(i), y: H - 10, 'text-anchor': t === ticks - 1 && ticks > 1 ? 'end' : 'middle', 'font-size': 11, fill: '#717782' }, all[i].label);
                    }

                    const h = hist.length;
                    if (fut.length) {
                        const dx = (x(h - 1) + x(h)) / 2;
                        add('line', { x1: dx, x2: dx, y1: top, y2: H - bottom, stroke: '#c1c7d3', 'stroke-dasharray': '4,4' });
                        add('text', { x: dx + 6, y: top + 10, 'font-size': 10, 'font-weight': 700, fill: '#717782' }, 'FORECAST');

                        const upper = [[x(h - 1), y(hist[h - 1].value)]].concat(fut.map((p, k) => [x(h + k), y(p.upper)]));
                        const lower = [[x(h - 1), y(hist[h - 1].value)]].concat(fut.map((p, k) => [x(h + k), y(p.lower)])).reverse();
                        add('polygon', { points: upper.concat(lower).map((pt) => pt.join(',')).join(' '), fill: '#004a93', 'fill-opacity': 0.07 });
                    }

                    add('path', { d: hist.map((p, i) => (i ? 'L' : 'M') + x(i) + ',' + y(p.value)).join(' '), fill: 'none', stroke: '#004a93', 'stroke-width': 3, 'stroke-linecap': 'round', 'stroke-linejoin': 'round' });
                    if (fut.length) {
                        add('path', { d: 'M' + x(h - 1) + ',' + y(hist[h - 1].value) + fut.map((p, k) => ' L' + x(h + k) + ',' + y(p.value)).join(''), fill: 'none', stroke: '#004a93', 'stroke-opacity': 0.6, 'stroke-width': 3, 'stroke-dasharray': '8,4', 'stroke-linecap': 'round' });
                    }

                    const r = n > 40 ? 2.5 : 4;
                    hist.forEach((p, i) => { add('circle', { cx: x(i), cy: y(p.value), r, fill: '#004a93', stroke: '#004a93', 'stroke-width': 2 }); plotted.push({ x: x(i), y: y(p.value), p, kind: 'actual' }); });
                    fut.forEach((p, k) => { add('circle', { cx: x(h + k), cy: y(p.value), r, fill: '#ffffff', stroke: '#004a93', 'stroke-width': 2 }); plotted.push({ x: x(h + k), y: y(p.value), p, kind: 'forecast' }); });

                    // Hover guides sit on top of everything else
                    hoverLine = add('line', { x1: 0, x2: 0, y1: top, y2: H - bottom, stroke: '#004a93', 'stroke-opacity': 0.35, 'stroke-width': 1.5, visibility: 'hidden' });
                    hoverRing = add('circle', { cx: 0, cy: 0, r: 7, fill: 'none', stroke: '#004a93', 'stroke-width': 2.5, visibility: 'hidden' });
                }

                function showTip(point, rect) {
                    hoverLine.setAttribute('x1', point.x); hoverLine.setAttribute('x2', point.x); hoverLine.setAttribute('visibility', 'visible');
                    hoverRing.setAttribute('cx', point.x); hoverRing.setAttribute('cy', point.y); hoverRing.setAttribute('visibility', 'visible');

                    const p = point.p;
                    tip.replaceChildren();
                    const title = document.createElement('div');
                    title.className = 'font-bold';
                    title.textContent = p.label;
                    const line = document.createElement('div');
                    line.textContent = point.kind === 'actual'
                        ? plural(p.value, 'case') + ' (actual)'
                        : fmt(p.value) + ' cases (predicted)';
                    tip.append(title, line);
                    if (point.kind === 'forecast') {
                        const range = document.createElement('div');
                        range.className = 'text-slate-300';
                        range.textContent = 'Range: ' + fmt(p.lower) + ' – ' + fmt(p.upper);
                        tip.appendChild(range);
                    }

                    tip.classList.remove('hidden');
                    const px = point.x / W * rect.width, py = point.y / H * rect.height;
                    const tw = tip.offsetWidth, th = tip.offsetHeight;
                    tip.style.left = Math.min(Math.max(8, px - tw / 2), rect.width - tw - 8) + 'px';
                    tip.style.top = (py - th - 14 < 0 ? py + 16 : py - th - 14) + 'px';
                }

                // The nearest point to the pointer (anywhere along the chart) is highlighted
                svg.addEventListener('pointermove', (e) => {
                    if (!plotted.length) return;
                    const rect = svg.getBoundingClientRect();
                    const vx = (e.clientX - rect.left) * (W / rect.width);
                    let best = plotted[0];
                    plotted.forEach((pt) => { if (Math.abs(pt.x - vx) < Math.abs(best.x - vx)) best = pt; });
                    showTip(best, rect);
                });
                svg.addEventListener('pointerleave', () => {
                    tip.classList.add('hidden');
                    if (hoverLine) { hoverLine.setAttribute('visibility', 'hidden'); hoverRing.setAttribute('visibility', 'hidden'); }
                });

                render();
            }

            // Toast
            const toast = document.getElementById('statusToast');
            if (toast) {
                const dismiss = () => { toast.classList.add('opacity-0'); setTimeout(() => toast.remove(), 300); };
                document.getElementById('statusToastClose').addEventListener('click', dismiss);
                setTimeout(dismiss, 4000);
            }
        })();
    </script>
</body>

</html>
