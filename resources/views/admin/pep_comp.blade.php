<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>PEP Compliance &amp; SMS Logs | Cebu City Health Center</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "secondary-container": "#c1d9fd",
                        "on-error": "#ffffff",
                        "on-secondary": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "primary-fixed": "#d6e3ff",
                        "surface-tint": "#005db6",
                        "primary-fixed-dim": "#a9c7ff",
                        "outline-variant": "#c1c7d3",
                        "surface-container-low": "#f2f4f6",
                        "on-tertiary-container": "#ffd7c0",
                        "on-secondary-fixed-variant": "#314866",
                        "error": "#ba1a1a",
                        "primary": "#004a93",
                        "primary-container": "#0b61bb",
                        "on-primary": "#ffffff",
                        "tertiary-container": "#9e4b00",
                        "background": "#f7f9fb",
                        "on-surface-variant": "#414751",
                        "on-primary-fixed": "#001b3d",
                        "surface-variant": "#e0e3e5",
                        "on-primary-fixed-variant": "#00468c",
                        "secondary": "#49607f",
                        "on-tertiary-fixed": "#311300",
                        "on-background": "#191c1e",
                        "error-container": "#ffdad6",
                        "surface": "#f7f9fb",
                        "inverse-primary": "#a9c7ff",
                        "surface-bright": "#f7f9fb",
                        "on-secondary-fixed": "#011c38",
                        "on-error-container": "#93000a",
                        "tertiary-fixed": "#ffdbc8",
                        "tertiary": "#7a3800",
                        "tertiary-fixed-dim": "#ffb689",
                        "surface-container-highest": "#e0e3e5",
                        "on-tertiary-fixed-variant": "#743500",
                        "on-surface": "#191c1e",
                        "inverse-on-surface": "#eff1f3",
                        "secondary-fixed": "#d3e4ff",
                        "on-secondary-container": "#485f7e",
                        "surface-dim": "#d8dadc",
                        "inverse-surface": "#2d3133",
                        "outline": "#717782",
                        "surface-container-high": "#e6e8ea",
                        "on-tertiary": "#ffffff",
                        "secondary-fixed-dim": "#b1c8ec",
                        "on-primary-container": "#d0dfff",
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
            background-color: #f7f9fb;
            color: #191c1e;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e0e3e5;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-surface font-body selection:bg-primary-fixed selection:text-on-primary-fixed">
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
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.analytics') }}">
                    <span class="material-symbols-outlined">analytics</span>
                    <span class="font-['Inter'] text-sm tracking-wide">Analytics</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-700 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600 translate-x-1 duration-150" href="{{ route('admin.compliance') }}">
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
    <!-- Main Content Area -->
    <main class="ml-64 flex-1 flex flex-col min-w-0">
        <!-- TopAppBar -->
        <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md px-8 py-3 flex justify-between items-center border-b border-slate-100">
            <div class="flex items-center gap-6 flex-1">
                <div class="relative w-full max-w-md group">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                    <input class="w-full pl-10 pr-4 py-2 bg-slate-100 border-none rounded-full text-sm focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-400" placeholder="Search logs..." type="text" />
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
        <!-- Page Canvas -->
        <div class="p-8 max-w-[1600px] mx-auto space-y-8">
            <!-- Header & Filter Row -->
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-on-surface mb-2">PEP Compliance &amp; SMS Logs</h1>
                    <p class="text-on-surface-variant">Real-time monitoring of Post-Exposure Prophylaxis schedules and patient communication outreach.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <button class="bg-surface-container-low p-2.5 rounded-xl hover:bg-surface-container-high transition-colors">
                        <span class="material-symbols-outlined text-on-surface-variant" data-icon="calendar_month">calendar_month</span>
                    </button>
                    <button class="bg-primary px-6 py-2.5 text-on-primary rounded-xl font-bold text-sm shadow-md hover:opacity-90 transition-opacity">Export Logs</button>
                </div>
            </div>
            <!-- Compliance Overview Stat Cards (Bento Style) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-surface-container-lowest p-6 rounded-xl border-l-4 border-primary shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-primary-fixed rounded-lg">
                            <span class="material-symbols-outlined text-primary" data-icon="clinical_notes">clinical_notes</span>
                        </div>
                        <span class="text-xs font-bold text-primary bg-primary-fixed px-2 py-1 rounded-full">+2.4%</span>
                    </div>
                    <h3 class="text-3xl font-extrabold text-on-surface mb-1">94.2%</h3>
                    <p class="text-xs uppercase font-bold text-on-surface-variant tracking-widest">PEP Completion Rate</p>
                </div>
                <!-- Stat Card 2 -->
                <div class="bg-surface-container-lowest p-6 rounded-xl border-l-4 border-secondary shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-secondary-fixed rounded-lg">
                            <span class="material-symbols-outlined text-secondary" data-icon="send">send</span>
                        </div>
                        <span class="text-xs font-bold text-secondary bg-secondary-fixed px-2 py-1 rounded-full">Stable</span>
                    </div>
                    <h3 class="text-3xl font-extrabold text-on-surface mb-1">98.8%</h3>
                    <p class="text-xs uppercase font-bold text-on-surface-variant tracking-widest">SMS Success Rate</p>
                </div>
                <!-- Stat Card 3 -->
                <div class="bg-surface-container-lowest p-6 rounded-xl border-l-4 border-tertiary shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-tertiary-fixed rounded-lg">
                            <span class="material-symbols-outlined text-tertiary" data-icon="schedule_send">schedule_send</span>
                        </div>
                        <span class="text-xs font-bold text-tertiary bg-tertiary-fixed px-2 py-1 rounded-full">12 High Priority</span>
                    </div>
                    <h3 class="text-3xl font-extrabold text-on-surface mb-1">42</h3>
                    <p class="text-xs uppercase font-bold text-on-surface-variant tracking-widest">Pending Reminders</p>
                </div>
                <!-- Stat Card 4 -->
                <div class="bg-surface-container-lowest p-6 rounded-xl border-l-4 border-error shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-error-container rounded-lg">
                            <span class="material-symbols-outlined text-error" data-icon="warning">warning</span>
                        </div>
                        <span class="text-xs font-bold text-error bg-error-container px-2 py-1 rounded-full">Critical</span>
                    </div>
                    <h3 class="text-3xl font-extrabold text-on-surface mb-1">18</h3>
                    <p class="text-xs uppercase font-bold text-on-surface-variant tracking-widest">Late Follow-ups Sent</p>
                </div>
            </div>
            <!-- Asymmetric Layout: Tracking Table & SMS Logs -->
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
                <!-- PEP Compliance Tracking Table (Col-Span 7) -->
                <section class="xl:col-span-7 space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary" data-icon="task_alt">task_alt</span>
                            PEP Compliance Tracking
                        </h2>
                        <a class="text-xs font-bold text-primary hover:underline" href="#">View All Patients</a>
                    </div>
                    <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm border border-outline-variant/10">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-low">
                                    <th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-widest">Patient Name</th>
                                    <th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-widest">Scheduled Dose</th>
                                    <th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-widest">Label</th>
                                    <th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-widest">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                <tr class="hover:bg-surface-bright transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-sm">Mariano, Roberto P.</span>
                                            <span class="text-xs text-on-surface-variant">Guadalupe, Cebu City</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-on-surface">Oct 24, 2023</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 bg-surface-container-high rounded text-[10px] font-black">D7</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-tertiary-fixed text-on-tertiary-fixed-variant px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span> Pending
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-surface-bright transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-sm">Gomez, Elena S.</span>
                                            <span class="text-xs text-on-surface-variant">Lahug, Cebu City</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-on-surface">Oct 22, 2023</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 bg-surface-container-high rounded text-[10px] font-black">D3</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-primary-fixed text-on-primary-fixed-variant px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Completed On Time
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-surface-bright transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-sm">Santos, Danilo K.</span>
                                            <span class="text-xs text-on-surface-variant">Mabolo, Cebu City</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-on-surface">Oct 20, 2023</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 bg-surface-container-high rounded text-[10px] font-black">D28</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-error-container text-on-error-container px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-error"></span> Missed
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-surface-bright transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-sm">Bautista, Maria L.</span>
                                            <span class="text-xs text-on-surface-variant">Tisa, Cebu City</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-on-surface">Oct 21, 2023</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 bg-surface-container-high rounded text-[10px] font-black">D0</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-secondary-fixed text-on-secondary-fixed-variant px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Completed Late
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="p-4 bg-surface-container-low/50 text-center">
                            <button class="text-sm font-bold text-primary hover:opacity-80">Load More compliance data</button>
                        </div>
                    </div>
                </section>
                <!-- SMS Logs Section (Col-Span 5) -->
                <section class="xl:col-span-5 space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary" data-icon="history">history</span>
                            SMS Outreach Logs
                        </h2>
                        <div class="flex gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-tighter">Gateway Active</span>
                        </div>
                    </div>
                    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 flex flex-col h-[520px]">
                        <div class="p-4 bg-surface-container-low flex items-center justify-between border-b border-outline-variant/10">
                            <span class="text-[11px] font-black uppercase text-on-surface-variant tracking-widest">Recent Activity</span>
                            <span class="material-symbols-outlined text-on-surface-variant text-sm cursor-pointer" data-icon="filter_list">filter_list</span>
                        </div>
                        <div class="flex-1 overflow-y-auto custom-scrollbar">
                            <div class="divide-y divide-outline-variant/10">
                                <!-- Log Item 1 -->
                                <div class="p-5 hover:bg-surface-bright transition-colors flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-primary text-xl" data-icon="chat">chat</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start mb-1">
                                            <p class="text-sm font-bold truncate">+63 917 555 0122</p>
                                            <span class="text-[10px] font-bold text-primary bg-primary-fixed px-2 py-0.5 rounded uppercase">Sent</span>
                                        </div>
                                        <p class="text-xs text-on-surface-variant mb-2">Reminder: Your PEP Dose 3 is scheduled for tomorrow at Cebu Health Center.</p>
                                        <div class="flex justify-between items-center text-[10px] text-on-surface-variant/60 font-medium">
                                            <span>Type: Dose Reminder</span>
                                            <span>Today, 09:45 AM</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Log Item 2 -->
                                <div class="p-5 hover:bg-surface-bright transition-colors flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full bg-error-container flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-error text-xl" data-icon="sms_failed">sms_failed</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start mb-1">
                                            <p class="text-sm font-bold truncate">+63 920 123 4567</p>
                                            <span class="text-[10px] font-bold text-error bg-error-container px-2 py-0.5 rounded uppercase">Failed</span>
                                        </div>
                                        <p class="text-xs text-on-surface-variant mb-2">URGENT: You missed your scheduled PEP follow-up. Please visit the clinic immediately.</p>
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-1 text-[10px] text-error font-bold italic">
                                                <span class="material-symbols-outlined text-[12px]" data-icon="error_outline">error_outline</span>
                                                Error: Network Timeout (Provider Side)
                                            </div>
                                            <div class="flex justify-between items-center text-[10px] text-on-surface-variant/60 font-medium">
                                                <span>Type: Late Follow-up</span>
                                                <span>Today, 08:30 AM</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Log Item 3 -->
                                <div class="p-5 hover:bg-surface-bright transition-colors flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full bg-tertiary-fixed flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-tertiary text-xl" data-icon="hourglass_empty">hourglass_empty</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start mb-1">
                                            <p class="text-sm font-bold truncate">+63 918 999 8877</p>
                                            <span class="text-[10px] font-bold text-tertiary bg-tertiary-fixed px-2 py-0.5 rounded uppercase">Pending</span>
                                        </div>
                                        <p class="text-xs text-on-surface-variant mb-2">Reminder: PEP Dose 28 scheduled for Oct 25. Please confirm attendance.</p>
                                        <div class="flex justify-between items-center text-[10px] text-on-surface-variant/60 font-medium">
                                            <span>Type: Dose Reminder</span>
                                            <span>Queued: 11:00 AM</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Log Item 4 -->
                                <div class="p-5 hover:bg-surface-bright transition-colors flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-primary text-xl" data-icon="chat">chat</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start mb-1">
                                            <p class="text-sm font-bold truncate">+63 945 444 3322</p>
                                            <span class="text-[10px] font-bold text-primary bg-primary-fixed px-2 py-0.5 rounded uppercase">Sent</span>
                                        </div>
                                        <p class="text-xs text-on-surface-variant mb-2">Initial PEP protocol successfully initiated. Next visit in 3 days.</p>
                                        <div class="flex justify-between items-center text-[10px] text-on-surface-variant/60 font-medium">
                                            <span>Type: Onboarding</span>
                                            <span>Yesterday, 04:15 PM</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- Footer Compliance Visualization -->
            <div class="bg-surface-container-low rounded-xl p-8 border border-outline-variant/10">
                <div class="flex flex-col">
                    <div class="flex-1">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-6">
                            <div>
                                <h4 class="text-lg font-bold">Compliance Performance by Barangay</h4>
                                <p class="text-sm text-on-surface-variant mt-1">Summary of top-performing and action-required areas.</p>
                            </div>
                            <button class="px-4 py-2 bg-white border border-outline-variant text-primary font-bold text-xs rounded-lg hover:bg-surface-container-high transition-colors">
                                View Full Compliance Report
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                            <div>
                                <div class="flex justify-between text-xs font-bold mb-1"><span>Mabolo: 99.2%</span></div>
                                <div class="h-2 w-full bg-white rounded-full overflow-hidden">
                                    <div class="h-full bg-primary w-[99%]"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-bold mb-1"><span>Banilad: 91.2%</span></div>
                                <div class="h-2 w-full bg-white rounded-full overflow-hidden">
                                    <div class="h-full bg-primary w-[91%]"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-bold mb-1"><span>Lahug: 94.1%</span></div>
                                <div class="h-2 w-full bg-white rounded-full overflow-hidden">
                                    <div class="h-full bg-primary w-[94%]"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-bold mb-1"><span>Pardo: 88.7%</span></div>
                                <div class="h-2 w-full bg-white rounded-full overflow-hidden">
                                    <div class="h-full bg-secondary w-[88%]"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-bold mb-1"><span>Guadalupe: 82.5%</span></div>
                                <div class="h-2 w-full bg-white rounded-full overflow-hidden">
                                    <div class="h-full bg-error w-[82%]"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-bold mb-1"><span>Tisa: 82.5%</span></div>
                                <div class="h-2 w-full bg-white rounded-full overflow-hidden">
                                    <div class="h-full bg-error w-[82%]"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>