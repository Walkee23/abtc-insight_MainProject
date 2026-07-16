<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Clinical Encoding Wizard | ABTC-Insight</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* Custom scrollbar for clinical readability */
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

        ::-webkit-scrollbar-thumb:hover {
            background: #717782;
        }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-low": "#f2f4f6",
                        "tertiary": "#7a3800",
                        "surface-variant": "#e0e3e5",
                        "primary-container": "#0b61bb",
                        "on-secondary-container": "#485f7e",
                        "error": "#ba1a1a",
                        "primary-fixed": "#d6e3ff",
                        "tertiary-fixed": "#ffdbc8",
                        "surface": "#f7f9fb",
                        "on-surface-variant": "#414751",
                        "surface-container-highest": "#e0e3e5",
                        "secondary-fixed": "#d3e4ff",
                        "primary-fixed-dim": "#a9c7ff",
                        "inverse-primary": "#a9c7ff",
                        "on-tertiary": "#ffffff",
                        "on-tertiary-container": "#ffd7c0",
                        "on-error-container": "#93000a",
                        "on-tertiary-fixed": "#311300",
                        "on-secondary-fixed-variant": "#314866",
                        "tertiary-fixed-dim": "#ffb689",
                        "secondary-fixed-dim": "#b1c8ec",
                        "secondary": "#49607f",
                        "error-container": "#ffdad6",
                        "on-primary-fixed-variant": "#00468c",
                        "on-primary-fixed": "#001b3d",
                        "tertiary-container": "#9e4b00",
                        "on-surface": "#191c1e",
                        "on-secondary-fixed": "#011c38",
                        "surface-tint": "#005db6",
                        "secondary-container": "#c1d9fd",
                        "on-background": "#191c1e",
                        "inverse-on-surface": "#eff1f3",
                        "primary": "#004a93",
                        "surface-container": "#eceef0",
                        "on-tertiary-fixed-variant": "#743500",
                        "on-primary": "#ffffff",
                        "surface-bright": "#f7f9fb",
                        "on-secondary": "#ffffff",
                        "on-error": "#ffffff",
                        "outline-variant": "#c1c7d3",
                        "outline": "#717782",
                        "on-primary-container": "#d0dfff",
                        "surface-dim": "#d8dadc",
                        "inverse-surface": "#2d3133",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-high": "#e6e8ea",
                        "background": "#f7f9fb"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-surface text-on-surface selection:bg-primary-container selection:text-on-primary-container">
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
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-blue-700 text-blue-700 bg-blue-50 dark:bg-blue-900/20 font-semibold transition-all"
                href="{{ route('healthworker.clinical-encoding') }}">
                <span class="material-symbols-outlined"
                    style="font-variation-settings: 'FILL' 1;">medical_services</span>
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
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all"
                href="{{ route('healthworker.compliance') }}">
                <span class="material-symbols-outlined">verified_user</span>
                <span class="text-sm">Compliance</span>
            </a>
        </nav>
    </aside>
    <header
        class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/85 backdrop-blur-md flex items-center justify-between px-8 shadow-sm shadow-blue-900/5 z-40">
        <div
            class="flex items-center bg-surface-container-low rounded-full px-4 py-1.5 w-96 group focus-within:ring-2 focus-within:ring-primary/20 transition-all">
            <span class="material-symbols-outlined text-outline text-[20px]">search</span>
            <input class="bg-transparent border-none focus:ring-0 text-sm w-full placeholder:text-outline-variant"
                placeholder="Search patient by name or ID..." type="text" />
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
    <main class="ml-64 pt-16 min-h-screen bg-surface">
        <div class="max-w-[1600px] mx-auto p-8 flex gap-8">
            <section class="w-1/3 flex flex-col gap-6">
                <div class="bg-surface-container-low rounded-xl p-6 flex flex-col h-[calc(100vh-12rem)]">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold tracking-tight text-on-surface">Pending Encoding Queue</h2>
                        <span class="px-2.5 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full">12
                            Active</span>
                    </div>
                    <div class="mb-4">
                        <div
                            class="flex items-center bg-white rounded-lg px-3 py-2 border border-outline-variant/20 focus-within:border-primary/40 transition-all">
                            <span class="material-symbols-outlined text-outline text-[18px]">filter_list</span>
                            <input class="bg-transparent border-none focus:ring-0 text-sm w-full py-0"
                                placeholder="Filter queue..." type="text" />
                        </div>
                    </div>
                    <div class="flex-1 overflow-y-auto space-y-3 pr-2">
                        <div class="bg-surface-container-lowest p-4 rounded-lg border-l-4 border-primary shadow-sm">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-bold text-primary tracking-widest uppercase">Queue No.
                                    042</span>
                                <span class="text-[10px] font-medium text-outline">15 mins ago</span>
                            </div>
                            <h3 class="font-bold text-on-surface">Juan Dela Cruz</h3>
                            <p class="text-xs text-on-surface-variant mb-3 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                Incident: Oct 24, 2023
                            </p>
                            <div class="flex gap-2">
                                <span
                                    class="px-2 py-0.5 bg-error-container text-on-error-container text-[10px] font-bold rounded-full">CAT
                                    III</span>
                                <span
                                    class="px-2 py-0.5 bg-secondary-container text-on-secondary-container text-[10px] font-bold rounded-full">Urgent</span>
                            </div>
                        </div>
                        <div
                            class="bg-surface-container-lowest/50 p-4 rounded-lg border border-transparent hover:border-outline-variant/30 transition-all cursor-pointer">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-bold text-outline tracking-widest uppercase">Queue No.
                                    043</span>
                                <span class="text-[10px] font-medium text-outline">22 mins ago</span>
                            </div>
                            <h3 class="font-bold text-on-surface">Elena Soriano</h3>
                            <p class="text-xs text-on-surface-variant flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                Incident: Oct 23, 2023
                            </p>
                        </div>
                        <div
                            class="bg-surface-container-lowest/50 p-4 rounded-lg border border-transparent hover:border-outline-variant/30 transition-all cursor-pointer">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-bold text-outline tracking-widest uppercase">Queue No.
                                    044</span>
                                <span class="text-[10px] font-medium text-outline">45 mins ago</span>
                            </div>
                            <h3 class="font-bold text-on-surface">Roberto Lim</h3>
                            <p class="text-xs text-on-surface-variant flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                Incident: Oct 24, 2023
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="w-2/3 flex flex-col gap-6">
                <!-- Form Card -->
                <div
                    class="bg-surface-container-lowest rounded-xl shadow-lg shadow-blue-900/5 overflow-hidden border border-outline-variant/10 flex flex-col h-[calc(100vh-12rem)]">
                    <!-- Form Header & Step Indicator -->
                    <div class="bg-surface-container-low border-b border-outline-variant/20">
                        <div class="px-8 py-6 flex justify-between items-center">
                            <div>
                                <p class="text-[10px] font-bold text-primary tracking-widest uppercase mb-1">Active
                                    Encoding Session</p>
                                <h2 class="text-2xl font-extrabold tracking-tight text-on-surface">Juan Dela Cruz</h2>
                            </div>
                            <div class="flex gap-4">
                                <div class="text-right">
                                    <p class="text-[10px] font-semibold text-outline uppercase tracking-wider">Patient
                                        ID</p>
                                    <p class="text-sm font-bold">ABTC-2023-1042</p>
                                </div>
                            </div>
                        </div>
                        <!-- Horizontal Wizard Steps -->
                        <div class="px-8 pb-4">
                            <div class="flex items-center w-full">
                                <!-- Step 1 (VI) -->
                                <div class="flex flex-col items-center flex-1 relative group">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center text-xs font-bold z-10">
                                        VI</div>
                                    <span
                                        class="text-[10px] font-bold text-outline mt-2 absolute -bottom-6 w-max opacity-0">Wound
                                        Desc.</span>
                                </div>
                                <div class="flex-1 h-0.5 bg-primary/20 -mt-4"></div>
                                <!-- Step 2 (VII) -->
                                <div class="flex flex-col items-center flex-1 relative group">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center text-xs font-bold z-10">
                                        VII</div>
                                    <span
                                        class="text-[10px] font-bold text-outline mt-2 absolute -bottom-6 w-max opacity-0">Immunization</span>
                                </div>
                                <div class="flex-1 h-0.5 bg-primary/20 -mt-4"></div>
                                <!-- Step 3 (VIII) -->
                                <div class="flex flex-col items-center flex-1 relative group">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center text-xs font-bold z-10">
                                        VIII</div>
                                    <span
                                        class="text-[10px] font-bold text-outline mt-2 absolute -bottom-6 w-max opacity-0">Remarks</span>
                                </div>
                                <div class="flex-1 h-0.5 bg-primary -mt-4"></div>
                                <!-- Step 4 (IX) -->
                                <div class="flex flex-col items-center flex-1 relative group">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold z-10 shadow-lg shadow-primary/20">
                                        IX</div>
                                    <span
                                        class="text-[10px] font-bold text-primary mt-2 absolute -bottom-6 w-max">Progress</span>
                                </div>
                            </div>
                        </div>
                        <div class="h-6"></div> <!-- Spacer for absolute text labels -->
                    </div>
                    <!-- Wizard Body -->
                    <div class="flex-1 p-8 overflow-y-auto">
                        <!-- SECTION IX: PROGRESS NOTES -->
                        <div class="step-content block" id="step4">
                            <div class="flex items-center gap-3 mb-8">
                                <span
                                    class="w-8 h-8 rounded-lg bg-primary text-on-primary flex items-center justify-center font-bold text-sm">IX</span>
                                <h3 class="text-sm font-extrabold uppercase tracking-widest text-on-surface-variant">
                                    Progress Notes &amp; Outcome</h3>
                            </div>
                            <div class="space-y-8">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Day
                                            3 Progress</label>
                                        <textarea
                                            class="w-full bg-surface-container-low border-none rounded-lg p-3 focus:ring-2 focus:ring-primary/20 text-sm resize-none h-32"
                                            placeholder="Notes for Day 3..."></textarea>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Day
                                            7 Progress</label>
                                        <textarea
                                            class="w-full bg-surface-container-low border-none rounded-lg p-3 focus:ring-2 focus:ring-primary/20 text-sm resize-none h-32"
                                            placeholder="Notes for Day 7..."></textarea>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Day
                                            28 Progress</label>
                                        <textarea
                                            class="w-full bg-surface-container-low border-none rounded-lg p-3 focus:ring-2 focus:ring-primary/20 text-sm resize-none h-32"
                                            placeholder="Notes for Day 28..."></textarea>
                                    </div>
                                </div>
                                <div class="pt-6 border-t border-outline-variant/20">
                                    <div class="max-w-md">
                                        <label
                                            class="block text-xs font-bold text-outline uppercase tracking-wider mb-3">Case
                                            Outcome</label>
                                        <div class="relative">
                                            <select
                                                class="w-full bg-surface-container-low border-none rounded-lg py-3.5 px-4 focus:ring-2 focus:ring-primary/20 text-on-surface font-bold appearance-none">
                                                <option disabled="" selected="" value="">Select Final Outcome</option>
                                                <option>Completed</option>
                                                <option>Incomplete</option>
                                                <option>Discharged (Cat. I)</option>
                                                <option>Lost to Follow-up</option>
                                            </select>
                                            <span
                                                class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 bg-primary-container/10 border border-primary/10 rounded-lg flex gap-3">
                                    <span class="material-symbols-outlined text-primary">verified</span>
                                    <p class="text-xs text-primary font-medium leading-relaxed">
                                        Completing this section will finalize the record for this incident. Please
                                        ensure all progress notes are accurate before saving.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Wizard Footer Actions -->
                    <div
                        class="p-6 bg-surface-container-low border-t border-outline-variant/20 flex justify-end items-center px-8">
                        <div class="flex gap-4">
                            <button
                                class="px-6 py-2.5 text-sm font-bold text-outline hover:bg-slate-200/50 rounded-lg transition-all"
                                id="backBtn">
                                Back
                            </button>
                            <button
                                class="px-8 py-2.5 bg-gradient-to-r from-primary to-primary-container text-on-primary text-sm font-bold rounded-lg shadow-md shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all flex items-center gap-2"
                                id="finalizeBtn">
                                <span class="material-symbols-outlined text-[18px]">verified_user</span>
                                Save and Finalize Record
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>

</html>