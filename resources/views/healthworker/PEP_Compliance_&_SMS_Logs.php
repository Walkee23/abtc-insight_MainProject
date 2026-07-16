<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>PEP Compliance Dashboard - Cebu City Health Center</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-tertiary-fixed": "#311300",
                        "on-primary": "#ffffff",
                        "inverse-surface": "#2d3133",
                        "secondary-fixed": "#d3e4ff",
                        "secondary-container": "#c1d9fd",
                        "primary-container": "#0b61bb",
                        "outline-variant": "#c1c7d3",
                        "surface-variant": "#e0e3e5",
                        "surface": "#f7f9fb",
                        "surface-dim": "#d8dadc",
                        "on-primary-container": "#d0dfff",
                        "surface-container-low": "#f2f4f6",
                        "error": "#ba1a1a",
                        "surface-tint": "#005db6",
                        "surface-container-lowest": "#ffffff",
                        "surface-container": "#eceef0",
                        "primary-fixed-dim": "#a9c7ff",
                        "on-secondary-fixed-variant": "#314866",
                        "tertiary-fixed": "#ffdbc8",
                        "on-surface-variant": "#414751",
                        "on-background": "#191c1e",
                        "on-primary-fixed-variant": "#00468c",
                        "secondary": "#49607f",
                        "inverse-on-surface": "#eff1f3",
                        "on-secondary": "#ffffff",
                        "inverse-primary": "#a9c7ff",
                        "on-surface": "#191c1e",
                        "tertiary": "#7a3800",
                        "on-error-container": "#93000a",
                        "surface-bright": "#f7f9fb",
                        "surface-container-high": "#e6e8ea",
                        "on-tertiary-container": "#ffd7c0",
                        "on-tertiary-fixed-variant": "#743500",
                        "background": "#f7f9fb",
                        "primary-fixed": "#d6e3ff",
                        "outline": "#717782",
                        "error-container": "#ffdad6",
                        "on-tertiary": "#ffffff",
                        "tertiary-container": "#9e4b00",
                        "on-secondary-container": "#485f7e",
                        "on-primary-fixed": "#001b3d",
                        "secondary-fixed-dim": "#b1c8ec",
                        "surface-container-highest": "#e0e3e5",
                        "tertiary-fixed-dim": "#ffb689",
                        "primary": "#004a93",
                        "on-error": "#ffffff",
                        "on-secondary-fixed": "#011c38"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "1rem",
                        "xl": "0.75rem",
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

        .ghost-border {
            border: 1px solid rgba(193, 199, 211, 0.15);
        }
    </style>
</head>

<body class="bg-surface text-on-surface">
    <!-- SideNavBar -->
    <aside
        class="h-screen w-64 fixed left-0 top-0 bg-slate-50 dark:bg-slate-900 flex flex-col border-r border-slate-200/50 dark:border-slate-800/50 py-6 font-['Inter'] tracking-tight z-50">
        <div class="px-6 mb-10 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-on-primary">
                <span class="material-symbols-outlined"
                    style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
            </div>
            <div>
                <h1 class="text-lg font-bold text-blue-900 dark:text-blue-100 leading-none">ABTC-Insight</h1>
            </div>
        </div>
        <nav class="flex-1 space-y-1 px-3">
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all"
                href="{{ route('healthworker.dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all"
                href="{{ route('healthworker.clinical-encoding') }}">
                <span class="material-symbols-outlined">medical_services</span>
                <span class="text-sm">Clinical Encoding</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all"
                href="{{ route('healthworker.treatment-tracker') }}">
                <span class="material-symbols-outlined">monitor_heart</span>
                <span class="text-sm">Treatment Tracker</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all"
                href="{{ route('healthworker.patient-database') }}">
                <span class="material-symbols-outlined">database</span>
                <span class="text-sm">Patient Database</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-blue-700 text-blue-700 bg-blue-50 dark:bg-blue-900/20 font-semibold transition-all"
                href="{{ route('healthworker.compliance') }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                <span class="text-sm">Compliance</span>
            </a>
        </nav>
    </aside>
    <!-- Main Content Area -->
    <main class="ml-64 min-h-screen bg-surface">
        <!-- TopNavBar -->
        <header
            class="w-full sticky top-0 z-40 bg-slate-50/85 dark:bg-slate-900/85 backdrop-blur-md flex items-center justify-between px-8 py-4 shadow-sm">
            <div class="flex items-center gap-8">
                <div class="relative group">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
                    <input
                        class="pl-10 pr-4 py-2 bg-surface-container-highest/50 border-none rounded-full text-sm w-64 focus:ring-2 focus:ring-primary/20 transition-all outline-none"
                        placeholder="Search records..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button
                    class="relative w-9 h-9 flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all rounded-full">
                    <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-slate-50"></span>
                </button>
                <button
                    class="w-9 h-9 flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all rounded-full">
                    <span class="material-symbols-outlined" data-icon="help">help</span>
                </button>
                <div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-800 mx-2"></div>
                <div class="flex items-center gap-3 cursor-pointer group relative">
                    <div class="text-right hidden lg:block">
                        <p class="text-xs font-bold text-on-surface leading-tight font-['Inter']">Dr. Elena Santos</p>
                        <p class="text-[10px] text-on-surface-variant font-['Inter']">Senior Health Worker</p>
                    </div>
                    <img alt="Health Worker Profile"
                        class="w-9 h-9 rounded-full object-cover ring-2 ring-primary/10 group:ring-primary/30 transition-all"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuAzuEzGuKhuDJKI44bu6U1YzFdI7z5disX1FjUVLwgq07xpkF1vi2q1RQg1lWnbbzx-97qaEaUE0wHwrsBEDnQdIf8whoLOPKyx4AYqvvB-lfqq-SS3OBugICvjWAE_JcAHe0Vi0CwgldGbMzdKqqq-JDxrvKkK7FcZlxsnNKgOhrLZQUJ0ev2rjCkC13g53yP7Tgqv7JJmgsQFbx1nOvxapzia3kkgWKs_FBVNJ7u5msUyUkju3OqnpM2i3ofnQDyojEEc-LEA3xlD" />
                    <div
                        class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="p-2">
                            <a href="#"
                                class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-[18px]">person</span>
                                My Profile
                            </a>
                            <div class="h-px bg-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors text-left">
                                    <span class="material-symbols-outlined text-[18px]">logout</span>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="p-8">
            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- PEP Completion -->
                <div
                    class="bg-surface-container-lowest p-5 rounded-lg ghost-border hover:shadow-md transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-primary/10 rounded-lg">
                            <span class="material-symbols-outlined text-primary" data-icon="task_alt">task_alt</span>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">+2.4%</span>
                    </div>
                    <p class="text-display-md text-3xl font-black text-on-surface tracking-tight">94.2%</p>
                    <p
                        class="text-label-sm text-[10px] font-bold uppercase text-on-surface-variant tracking-widest mt-1">
                        PEP Completion Rate</p>
                </div>
                <!-- SMS Success -->
                <div
                    class="bg-surface-container-lowest p-5 rounded-lg ghost-border hover:shadow-md transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-secondary/10 rounded-lg">
                            <span class="material-symbols-outlined text-secondary" data-icon="sms">sms</span>
                        </div>
                        <span
                            class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded-full italic">Stable</span>
                    </div>
                    <p class="text-display-md text-3xl font-black text-on-surface tracking-tight">98.8%</p>
                    <p
                        class="text-label-sm text-[10px] font-bold uppercase text-on-surface-variant tracking-widest mt-1">
                        SMS Success Rate</p>
                </div>
                <!-- Pending Reminders -->
                <div
                    class="bg-surface-container-lowest p-5 rounded-lg ghost-border hover:shadow-md transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-tertiary-fixed/30 rounded-lg">
                            <span class="material-symbols-outlined text-tertiary"
                                data-icon="notification_important">notification_important</span>
                        </div>
                        <span
                            class="text-xs font-bold text-on-tertiary-fixed-variant bg-tertiary-fixed px-2 py-1 rounded-full">High
                            Priority</span>
                    </div>
                    <p class="text-display-md text-3xl font-black text-on-surface tracking-tight">42</p>
                    <p
                        class="text-label-sm text-[10px] font-bold uppercase text-on-surface-variant tracking-widest mt-1">
                        Pending Reminders</p>
                </div>
                <!-- Late Follow-ups -->
                <div
                    class="bg-surface-container-lowest p-5 rounded-lg ghost-border hover:shadow-md transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-error-container rounded-lg">
                            <span class="material-symbols-outlined text-error"
                                data-icon="priority_high">priority_high</span>
                        </div>
                        <span
                            class="text-xs font-bold text-on-error-container bg-error-container px-2 py-1 rounded-full">Critical</span>
                    </div>
                    <p class="text-display-md text-3xl font-black text-on-surface tracking-tight">18</p>
                    <p
                        class="text-label-sm text-[10px] font-bold uppercase text-on-surface-variant tracking-widest mt-1">
                        Late Follow-ups Sent</p>
                </div>
            </div>
            <!-- Main Content: Tracking & Logs -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Left Column: PEP Compliance Tracking Table -->
                <div class="lg:col-span-2 bg-surface-container-lowest rounded-lg ghost-border p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-extrabold tracking-tight text-on-surface">PEP Compliance Tracking</h2>
                        <button class="text-primary text-sm font-semibold flex items-center gap-1">
                            Filter
                            <span class="material-symbols-outlined text-sm">filter_list</span>
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left">
                                    <th
                                        class="pb-4 text-[11px] font-black uppercase text-on-surface-variant tracking-widest px-2">
                                        Patient Name</th>
                                    <th
                                        class="pb-4 text-[11px] font-black uppercase text-on-surface-variant tracking-widest px-2">
                                        Scheduled Dose</th>
                                    <th
                                        class="pb-4 text-[11px] font-black uppercase text-on-surface-variant tracking-widest px-2">
                                        Label</th>
                                    <th
                                        class="pb-4 text-[11px] font-black uppercase text-on-surface-variant tracking-widest px-2">
                                        Status</th>
                                    <th
                                        class="pb-4 text-[11px] font-black uppercase text-on-surface-variant tracking-widest px-2">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="py-4 px-2">
                                        <p class="font-bold text-on-surface text-sm">Juana Dela Cruz</p>
                                        <p class="text-xs text-on-surface-variant">ID: ABTC-2024-089</p>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span class="text-sm font-medium text-on-surface">Dose 3 (D7)</span>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span
                                            class="text-xs bg-secondary-container text-on-secondary-container px-2 py-0.5 rounded font-semibold italic">Standard</span>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span
                                            class="flex items-center gap-1.5 text-xs font-bold text-on-tertiary-fixed-variant bg-tertiary-fixed px-3 py-1 rounded-full w-max">
                                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                            Pending
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 text-right">
                                        <button class="p-1 hover:bg-surface-container-high rounded-full"><span
                                                class="material-symbols-outlined text-sm">more_vert</span></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="py-4 px-2">
                                        <p class="font-bold text-on-surface text-sm">Ricardo Gomez</p>
                                        <p class="text-xs text-on-surface-variant">ID: ABTC-2024-112</p>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span class="text-sm font-medium text-on-surface">Dose 2 (D3)</span>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span
                                            class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded font-semibold italic">High
                                            Risk</span>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span
                                            class="flex items-center gap-1.5 text-xs font-bold text-green-700 bg-green-100 px-3 py-1 rounded-full w-max">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-700"></span>
                                            Completed On Time
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 text-right">
                                        <button class="p-1 hover:bg-surface-container-high rounded-full"><span
                                                class="material-symbols-outlined text-sm">more_vert</span></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="py-4 px-2">
                                        <p class="font-bold text-on-surface text-sm">Angelina Santos</p>
                                        <p class="text-xs text-on-surface-variant">ID: ABTC-2024-045</p>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span class="text-sm font-medium text-on-surface">Dose 4 (D21)</span>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span
                                            class="text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-semibold italic">Post-Exposure</span>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span
                                            class="flex items-center gap-1.5 text-xs font-bold text-on-error-container bg-error-container px-3 py-1 rounded-full w-max">
                                            <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                            Missed
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 text-right">
                                        <button class="p-1 hover:bg-surface-container-high rounded-full"><span
                                                class="material-symbols-outlined text-sm">more_vert</span></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="py-4 px-2">
                                        <p class="font-bold text-on-surface text-sm">Mateo Reyes</p>
                                        <p class="text-xs text-on-surface-variant">ID: ABTC-2024-156</p>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span class="text-sm font-medium text-on-surface">Dose 1 (D0)</span>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span
                                            class="text-xs bg-secondary-container text-on-secondary-container px-2 py-0.5 rounded font-semibold italic">Standard</span>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span
                                            class="flex items-center gap-1.5 text-xs font-bold text-green-700 bg-green-100 px-3 py-1 rounded-full w-max">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-700"></span>
                                            Completed On Time
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 text-right">
                                        <button class="p-1 hover:bg-surface-container-high rounded-full"><span
                                                class="material-symbols-outlined text-sm">more_vert</span></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Right Column: SMS Outreach Logs -->
                <div class="bg-surface-container-lowest rounded-lg ghost-border p-6 flex flex-col">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-extrabold tracking-tight text-on-surface">SMS Outreach Logs</h2>
                        <span
                            class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full uppercase tracking-tighter">Live</span>
                    </div>
                    <div class="space-y-4 flex-1">
                        <!-- Log Item -->
                        <div class="flex items-start gap-3 p-3 rounded-lg bg-surface-container-low/50">
                            <div class="mt-1 p-1.5 bg-green-100 rounded-full">
                                <span class="material-symbols-outlined text-xs text-green-700" data-icon="check_circle"
                                    style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <p class="text-sm font-bold text-on-surface">+63 917 555 0123</p>
                                    <span class="text-[10px] text-on-surface-variant">2m ago</span>
                                </div>
                                <p class="text-xs text-on-surface-variant font-medium">Next Dose Reminder (D7)</p>
                                <span
                                    class="text-[9px] font-black text-green-700 uppercase tracking-widest mt-1 block">Sent</span>
                            </div>
                        </div>
                        <!-- Log Item -->
                        <div
                            class="flex items-start gap-3 p-3 rounded-lg hover:bg-surface-container-low transition-colors">
                            <div class="mt-1 p-1.5 bg-error-container rounded-full">
                                <span class="material-symbols-outlined text-xs text-error" data-icon="error"
                                    style="font-variation-settings: 'FILL' 1;">error</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <p class="text-sm font-bold text-on-surface">+63 920 111 4489</p>
                                    <span class="text-[10px] text-on-surface-variant">15m ago</span>
                                </div>
                                <p class="text-xs text-on-surface-variant font-medium">Late Follow-up Alert</p>
                                <span
                                    class="text-[9px] font-black text-error uppercase tracking-widest mt-1 block">Failed</span>
                            </div>
                        </div>
                        <!-- Log Item -->
                        <div
                            class="flex items-start gap-3 p-3 rounded-lg hover:bg-surface-container-low transition-colors">
                            <div class="mt-1 p-1.5 bg-blue-100 rounded-full">
                                <span class="material-symbols-outlined text-xs text-blue-700"
                                    data-icon="pending">pending</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <p class="text-sm font-bold text-on-surface">+63 998 222 7733</p>
                                    <span class="text-[10px] text-on-surface-variant">42m ago</span>
                                </div>
                                <p class="text-xs text-on-surface-variant font-medium">Initial Dose Confirmation</p>
                                <span
                                    class="text-[9px] font-black text-blue-600 uppercase tracking-widest mt-1 block">Pending</span>
                            </div>
                        </div>
                        <!-- Log Item -->
                        <div
                            class="flex items-start gap-3 p-3 rounded-lg hover:bg-surface-container-low transition-colors">
                            <div class="mt-1 p-1.5 bg-green-100 rounded-full">
                                <span class="material-symbols-outlined text-xs text-green-700" data-icon="check_circle"
                                    style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <p class="text-sm font-bold text-on-surface">+63 915 888 2211</p>
                                    <span class="text-[10px] text-on-surface-variant">1h ago</span>
                                </div>
                                <p class="text-xs text-on-surface-variant font-medium">Next Dose Reminder (D3)</p>
                                <span
                                    class="text-[9px] font-black text-green-700 uppercase tracking-widest mt-1 block">Sent</span>
                            </div>
                        </div>
                    </div>
                    <button
                        class="mt-6 w-full py-2.5 text-xs font-bold text-primary border border-primary/20 rounded-lg hover:bg-primary/5 transition-colors">
                        View All SMS History
                    </button>
                </div>
            </div>
            <!-- Bottom Section: Performance by Barangay -->
            <div class="bg-surface-container-lowest rounded-lg ghost-border p-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
                    <div>
                        <h2 class="text-xl font-extrabold tracking-tighter text-on-surface">Compliance Performance by
                            Barangay</h2>
                        <p class="text-sm text-on-surface-variant">Monthly percentage of patients completing their
                            scheduled dose cycle</p>
                    </div>
                    <button
                        class="px-6 py-3 bg-primary text-on-primary rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-primary/20 active:scale-95 transition-all">
                        View Full Compliance Report
                        <span class="material-symbols-outlined text-sm">analytics</span>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-8">
                    <!-- Barangay Item -->
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-on-surface">Mabolo</span>
                            <span class="text-xs font-black text-primary">98%</span>
                        </div>
                        <div class="h-2 w-full bg-outline-variant/30 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-primary to-primary-container" style="width: 98%">
                            </div>
                        </div>
                    </div>
                    <!-- Barangay Item -->
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-on-surface">Lahug</span>
                            <span class="text-xs font-black text-primary">92%</span>
                        </div>
                        <div class="h-2 w-full bg-outline-variant/30 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-primary to-primary-container" style="width: 92%">
                            </div>
                        </div>
                    </div>
                    <!-- Barangay Item -->
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-on-surface">Guadalupe</span>
                            <span class="text-xs font-black text-primary">87%</span>
                        </div>
                        <div class="h-2 w-full bg-outline-variant/30 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-primary to-primary-container" style="width: 87%">
                            </div>
                        </div>
                    </div>
                    <!-- Barangay Item -->
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-on-surface">Banilad</span>
                            <span class="text-xs font-black text-primary">95%</span>
                        </div>
                        <div class="h-2 w-full bg-outline-variant/30 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-primary to-primary-container" style="width: 95%">
                            </div>
                        </div>
                    </div>
                    <!-- Barangay Item -->
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-on-surface">Pardo</span>
                            <span class="text-xs font-black text-primary">82%</span>
                        </div>
                        <div class="h-2 w-full bg-outline-variant/30 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-primary to-primary-container" style="width: 82%">
                            </div>
                        </div>
                    </div>
                    <!-- Barangay Item -->
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-on-surface">Tisa</span>
                            <span class="text-xs font-black text-primary">89%</span>
                        </div>
                        <div class="h-2 w-full bg-outline-variant/30 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-primary to-primary-container" style="width: 89%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>