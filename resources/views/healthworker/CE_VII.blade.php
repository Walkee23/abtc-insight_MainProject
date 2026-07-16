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

        .step-content {
            display: none;
        }

        .step-content.active {
            display: block;
        }

        /* Conditional visibility logic via CSS peer selectors */
        .content-container {
            transition: all 0.3s ease;
        }

        .hide-on-inactive:has(~ .control-radio:not(:checked)) {
            opacity: 0.4;
            pointer-events: none;
            filter: grayscale(1);
        }

        /* Direct Peer Toggling for Tailwind */
        .section-toggle:checked~.section-content {
            display: block;
        }

        .section-toggle:not(:checked)~.section-content {
            display: none;
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
                <div
                    class="bg-surface-container-lowest rounded-xl shadow-lg shadow-blue-900/5 overflow-hidden border border-outline-variant/10 flex flex-col h-[calc(100vh-12rem)]">
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
                        <div class="px-8 pb-4">
                            <div class="flex items-center w-full">
                                <div class="flex flex-col items-center flex-1 relative group">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary/40 text-white flex items-center justify-center text-xs font-bold z-10">
                                        VI</div>
                                    <span class="text-[10px] font-bold text-outline mt-2 absolute -bottom-6 w-max">Wound
                                        Desc.</span>
                                </div>
                                <div class="flex-1 h-0.5 bg-primary/40 -mt-4"></div>
                                <div class="flex flex-col items-center flex-1 relative group">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold z-10 shadow-lg shadow-primary/20">
                                        VII</div>
                                    <span
                                        class="text-[10px] font-bold text-primary mt-2 absolute -bottom-6 w-max">Immunization</span>
                                </div>
                                <div class="flex-1 h-0.5 bg-slate-200 -mt-4"></div>
                                <div class="flex flex-col items-center flex-1 relative group">
                                    <div
                                        class="w-8 h-8 rounded-full bg-white border-2 border-outline-variant/50 text-outline flex items-center justify-center text-xs font-bold z-10">
                                        VIII</div>
                                    <span
                                        class="text-[10px] font-bold text-outline mt-2 absolute -bottom-6 w-max opacity-0">Remarks</span>
                                </div>
                                <div class="flex-1 h-0.5 bg-slate-200 -mt-4"></div>
                                <div class="flex flex-col items-center flex-1 relative group">
                                    <div
                                        class="w-8 h-8 rounded-full bg-white border-2 border-outline-variant/50 text-outline flex items-center justify-center text-xs font-bold z-10">
                                        IX</div>
                                    <span
                                        class="text-[10px] font-bold text-outline mt-2 absolute -bottom-6 w-max opacity-0">Progress</span>
                                </div>
                            </div>
                        </div>
                        <div class="h-6"></div>
                    </div>
                    <div class="flex-1 p-8 overflow-y-auto">
                        <div class="step-content active" id="step2">
                            <div class="flex items-center gap-3 mb-8">
                                <span
                                    class="w-8 h-8 rounded-lg bg-primary text-on-primary flex items-center justify-center font-bold text-sm">VII</span>
                                <h3 class="text-sm font-extrabold uppercase tracking-widest text-on-surface-variant">
                                    Immunization Schedule</h3>
                            </div>
                            <!-- Patient Weight & Category Alert -->
                            <div class="grid grid-cols-4 gap-6 mb-10">
                                <div class="col-span-1">
                                    <label
                                        class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Patient
                                        Weight (kg) <span class="text-error">*</span></label>
                                    <input
                                        class="w-full bg-surface-container-low border-none rounded-lg py-3 px-4 focus:ring-2 focus:ring-primary/20 text-on-surface font-bold text-lg"
                                        placeholder="0.0" step="0.1" type="number" />
                                </div>
                                <div
                                    class="col-span-3 bg-primary/5 rounded-xl p-5 border border-primary/10 flex items-start gap-4">
                                    <span class="material-symbols-outlined text-primary text-[24px]">info</span>
                                    <div>
                                        <p class="text-xs font-extrabold text-primary uppercase tracking-tight mb-1">
                                            Category III Alert</p>
                                        <p class="text-sm text-on-surface-variant leading-relaxed">This patient is
                                            classified as <strong>Category III</strong>. Clinical protocol requires
                                            <strong>BOTH</strong> Active Immunization (Vaccine) and Passive Immunization
                                            (RIG) for full compliance.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Anti-Tetanus Section -->
                            <div class="mb-10">
                                <h4
                                    class="text-xs font-extrabold text-outline uppercase tracking-widest mb-4 flex items-center gap-2">
                                    <span class="w-1.5 h-4 bg-primary rounded-full"></span>
                                    Anti-Tetanus Prophylaxis
                                </h4>
                                <div
                                    class="grid grid-cols-2 gap-4 bg-surface-container-low/40 p-5 rounded-xl border border-outline-variant/10">
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">TT
                                            0.5mL IM (Date Given)</label>
                                        <input
                                            class="w-full bg-white border-outline-variant/30 rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary/20 text-sm font-medium"
                                            type="date" />
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">TIG
                                            250 IU IM (Date Given)</label>
                                        <input
                                            class="w-full bg-white border-outline-variant/30 rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary/20 text-sm font-medium"
                                            type="date" />
                                    </div>
                                </div>
                            </div>
                            <!-- Active Anti-Rabies (Vaccine) -->
                            <div class="mb-10 group/active-section">
                                <div class="flex items-center justify-between mb-4">
                                    <h4
                                        class="text-xs font-extrabold text-outline uppercase tracking-widest flex items-center gap-2">
                                        <span class="w-1.5 h-4 bg-primary rounded-full"></span>
                                        Active Anti-Rabies (PVRV/PCEC)
                                    </h4>
                                    <div
                                        class="flex bg-surface-container-low p-1 rounded-lg border border-outline-variant/10">
                                        <label class="cursor-pointer group">
                                            <input checked="" class="hidden peer active-admin-toggle"
                                                name="active_admin" type="radio" value="1" />
                                            <div
                                                class="px-4 py-1.5 rounded-md peer-checked:bg-white peer-checked:shadow-sm peer-checked:text-primary text-[10px] font-extrabold uppercase transition-all text-outline-variant">
                                                Administered</div>
                                        </label>
                                        <label class="cursor-pointer group">
                                            <input class="hidden peer" name="active_admin" type="radio" value="0" />
                                            <div
                                                class="px-4 py-1.5 rounded-md peer-checked:bg-white peer-checked:shadow-sm peer-checked:text-error text-[10px] font-extrabold uppercase transition-all text-outline-variant">
                                                Not Administered</div>
                                        </label>
                                    </div>
                                </div>
                                <input checked="" class="hidden peer/toggle section-toggle" id="active_imm_toggle"
                                    type="checkbox" />
                                <div
                                    class="bg-white p-6 rounded-xl border border-outline-variant/10 shadow-sm space-y-8 transition-all peer-checked/toggle:opacity-100 peer-checked/toggle:pointer-events-auto opacity-40 pointer-events-none grayscale-[0.5]">
                                    <div class="grid grid-cols-2 gap-6">
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Vaccine
                                                Brand</label>
                                            <select
                                                class="w-full bg-surface-container-low border-none rounded-lg py-3 px-4 focus:ring-2 focus:ring-primary/20 text-sm font-bold">
                                                <option selected="">SPEEDA (PVRV)</option>
                                                <option>VERORAB (PVRV)</option>
                                                <option>VAXIRAB (PCEC)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Route
                                                of Administration</label>
                                            <div class="flex bg-surface-container-low p-1 rounded-lg">
                                                <label class="flex-1 cursor-pointer">
                                                    <input checked="" class="hidden peer" name="route" type="radio" />
                                                    <div
                                                        class="py-2 text-center rounded-md peer-checked:bg-white peer-checked:shadow-sm peer-checked:text-primary text-[11px] font-bold uppercase transition-all">
                                                        ID (Intradermal)</div>
                                                </label>
                                                <label class="flex-1 cursor-pointer">
                                                    <input class="hidden peer" name="route" type="radio" />
                                                    <div
                                                        class="py-2 text-center rounded-md peer-checked:bg-white peer-checked:shadow-sm peer-checked:text-primary text-[11px] font-bold uppercase transition-all">
                                                        IM (Intramuscular)</div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <p
                                            class="text-[10px] font-extrabold text-outline uppercase tracking-widest mb-4">
                                            Primary Course Dose Tracking Grid</p>
                                        <div class="grid grid-cols-4 gap-4">
                                            <div
                                                class="bg-white p-4 rounded-lg border border-primary/40 shadow-sm relative overflow-hidden">
                                                <div
                                                    class="absolute top-0 right-0 w-8 h-8 bg-primary/10 rounded-bl-full flex items-center justify-center">
                                                    <span
                                                        class="material-symbols-outlined text-primary text-[16px]">check</span>
                                                </div>
                                                <p class="text-[10px] font-bold text-primary uppercase mb-1">Day 0</p>
                                                <p class="text-sm font-extrabold text-on-surface">Oct 24</p>
                                                <p class="text-[9px] text-primary/70 font-semibold mt-1">GIVEN</p>
                                            </div>
                                            <div
                                                class="bg-surface-container-low p-4 rounded-lg border border-outline-variant/30">
                                                <p class="text-[10px] font-bold text-outline uppercase mb-1">Day 3</p>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-sm font-bold text-on-surface">Oct 27</span>
                                                    <input
                                                        class="w-5 h-5 rounded border-outline-variant/50 text-primary focus:ring-primary/20"
                                                        type="checkbox" />
                                                </div>
                                            </div>
                                            <div
                                                class="bg-surface-container-low/50 p-4 rounded-lg border border-dashed border-outline-variant/50">
                                                <p class="text-[10px] font-bold text-outline-variant uppercase mb-1">Day
                                                    7</p>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-sm font-medium text-outline-variant">Oct 31</span>
                                                    <span
                                                        class="material-symbols-outlined text-outline-variant/40 text-[18px]">calendar_today</span>
                                                </div>
                                            </div>
                                            <div
                                                class="bg-surface-container-low/50 p-4 rounded-lg border border-dashed border-outline-variant/50">
                                                <p class="text-[10px] font-bold text-outline-variant uppercase mb-1">Day
                                                    28</p>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-sm font-medium text-outline-variant">Nov 21</span>
                                                    <span
                                                        class="material-symbols-outlined text-outline-variant/40 text-[18px]">calendar_today</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Passive Anti-Rabies (RIG) -->
                            <div class="mb-10 group/passive-section">
                                <div class="flex items-center justify-between mb-4">
                                    <h4
                                        class="text-xs font-extrabold text-outline uppercase tracking-widest flex items-center gap-2">
                                        <span class="w-1.5 h-4 bg-primary rounded-full"></span>
                                        Passive Anti-Rabies (RIG)
                                    </h4>
                                    <div
                                        class="flex bg-surface-container-low p-1 rounded-lg border border-outline-variant/10">
                                        <label class="cursor-pointer">
                                            <input checked="" class="hidden peer" name="passive_status" type="radio"
                                                value="admin" />
                                            <div
                                                class="px-3 py-1.5 rounded-md peer-checked:bg-white peer-checked:shadow-sm peer-checked:text-primary text-[10px] font-extrabold uppercase transition-all text-outline-variant">
                                                Administered</div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input class="hidden peer" name="passive_status" type="radio"
                                                value="not_admin" />
                                            <div
                                                class="px-3 py-1.5 rounded-md peer-checked:bg-white peer-checked:shadow-sm peer-checked:text-error text-[10px] font-extrabold uppercase transition-all text-outline-variant">
                                                Not Administered</div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input class="hidden peer" name="passive_status" type="radio"
                                                value="not_req" />
                                            <div
                                                class="px-3 py-1.5 rounded-md peer-checked:bg-white peer-checked:shadow-sm peer-checked:text-secondary text-[10px] font-extrabold uppercase transition-all text-outline-variant">
                                                Not Required (Cat II)</div>
                                        </label>
                                    </div>
                                </div>
                                <div
                                    class="bg-surface-container-low/40 p-6 rounded-xl border border-outline-variant/10 space-y-6 transition-all opacity-100">
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-outline uppercase tracking-wider mb-4">Passive
                                            Agent Administered</label>
                                        <div class="flex gap-4">
                                            <label class="flex-1 cursor-pointer">
                                                <input class="hidden peer" name="passive_imm" type="radio" />
                                                <div
                                                    class="py-3 text-center rounded-lg border border-outline-variant/30 bg-white peer-checked:bg-primary-container/10 peer-checked:border-primary-container peer-checked:text-primary transition-all">
                                                    <span class="text-sm font-bold">ERIG (EQUIRAB)</span>
                                                </div>
                                            </label>
                                            <label class="flex-1 cursor-pointer">
                                                <input class="hidden peer" name="passive_imm" type="radio" />
                                                <div
                                                    class="py-3 text-center rounded-lg border border-outline-variant/30 bg-white peer-checked:bg-primary-container/10 peer-checked:border-primary-container peer-checked:text-primary transition-all">
                                                    <span class="text-sm font-bold">HRIG (BERIRAB)</span>
                                                </div>
                                            </label>
                                            <label class="flex-1 cursor-pointer">
                                                <input checked="" class="hidden peer" name="passive_imm" type="radio" />
                                                <div
                                                    class="py-3 text-center rounded-lg border border-outline-variant/30 bg-white peer-checked:bg-primary-container/10 peer-checked:border-primary-container peer-checked:text-primary transition-all">
                                                    <span class="text-sm font-bold">NONE</span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-6 pt-6 border-t border-outline-variant/20">
                                        <div>
                                            <label
                                                class="block text-[10px] font-bold text-outline uppercase tracking-wider mb-2">Skin
                                                Test Result</label>
                                            <select
                                                class="w-full bg-white border-outline-variant/30 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-primary/20 text-xs font-bold">
                                                <option selected="">Pending / Not Done</option>
                                                <option>Negative (-)</option>
                                                <option>Positive (+)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-[10px] font-bold text-outline uppercase tracking-wider mb-2">Skin
                                                Test Conducted Time</label>
                                            <input
                                                class="w-full bg-white border-outline-variant/30 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-primary/20 text-xs font-medium"
                                                type="time" />
                                        </div>
                                        <div>
                                            <label
                                                class="block text-[10px] font-bold text-outline uppercase tracking-wider mb-2">Skin
                                                Test Due (+30m)</label>
                                            <input
                                                class="w-full bg-primary/5 border border-primary/20 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-primary/20 text-xs font-bold text-primary"
                                                placeholder="Auto-calculated" type="time" />
                                        </div>
                                    </div>
                                    <div class="p-4 bg-primary/5 rounded-lg border-l-4 border-primary">
                                        <p class="text-[10px] font-bold text-primary uppercase mb-1">Dosage &amp;
                                            Infiltration Guidance</p>
                                        <p class="text-xs text-on-surface-variant leading-relaxed italic">
                                            "IU infiltrate around/into the wound as much anatomically feasible then
                                            inject rest of the vaccine deep IM at distant site."
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Booster Doses Section -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-4">
                                    <h4
                                        class="text-xs font-extrabold text-outline uppercase tracking-widest flex items-center gap-2">
                                        <span class="w-1.5 h-4 bg-secondary rounded-full"></span>
                                        Booster Doses
                                    </h4>
                                    <div
                                        class="flex bg-surface-container-low p-1 rounded-lg border border-outline-variant/10">
                                        <label class="cursor-pointer">
                                            <input class="hidden peer" name="booster_admin" type="radio" value="1" />
                                            <div
                                                class="px-4 py-1.5 rounded-md peer-checked:bg-white peer-checked:shadow-sm peer-checked:text-primary text-[10px] font-extrabold uppercase transition-all text-outline-variant">
                                                Administered</div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input checked="" class="hidden peer" name="booster_admin" type="radio"
                                                value="0" />
                                            <div
                                                class="px-4 py-1.5 rounded-md peer-checked:bg-white peer-checked:shadow-sm peer-checked:text-on-surface-variant text-[10px] font-extrabold uppercase transition-all text-outline-variant">
                                                Not Administered</div>
                                        </label>
                                    </div>
                                </div>
                                <div
                                    class="bg-secondary-container/10 p-6 rounded-xl border border-secondary-container/30 space-y-6 opacity-40 pointer-events-none grayscale">
                                    <div class="flex items-center gap-6">
                                        <div class="w-1/2">
                                            <label
                                                class="block text-[10px] font-bold text-outline uppercase tracking-wider mb-2">Booster
                                                Vaccine Brand</label>
                                            <select
                                                class="w-full bg-white border-outline-variant/30 rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-secondary/20 text-xs font-bold">
                                                <option>PVRV (SPEEDA)</option>
                                                <option>PVRV (VERORAB)</option>
                                                <option>PCEC (VAXIRAB)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div
                                            class="bg-white p-4 rounded-lg border border-outline-variant/30 flex justify-between items-center">
                                            <div>
                                                <p class="text-[10px] font-bold text-outline uppercase mb-0.5">Booster
                                                    D0</p>
                                                <p class="text-sm font-bold">Date Given</p>
                                            </div>
                                            <input
                                                class="w-5 h-5 rounded border-outline-variant/50 text-secondary focus:ring-secondary/20"
                                                type="checkbox" />
                                        </div>
                                        <div
                                            class="bg-white p-4 rounded-lg border border-outline-variant/30 flex justify-between items-center">
                                            <div>
                                                <p class="text-[10px] font-bold text-outline uppercase mb-0.5">Booster
                                                    D3</p>
                                                <p class="text-sm font-bold">Date Given</p>
                                            </div>
                                            <input
                                                class="w-5 h-5 rounded border-outline-variant/50 text-secondary focus:ring-secondary/20"
                                                type="checkbox" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="p-6 bg-surface-container-low border-t border-outline-variant/20 flex justify-between items-center px-8">
                        <button
                            class="px-6 py-2.5 text-sm font-bold text-outline hover:text-on-surface transition-all flex items-center gap-2">
                            Save as Draft
                        </button>
                        <div class="flex gap-4">
                            <button
                                class="px-8 py-2.5 text-sm font-bold text-outline hover:bg-slate-200/50 rounded-lg transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                                Back
                            </button>
                            <button
                                class="px-8 py-2.5 bg-primary text-on-primary text-sm font-bold rounded-lg shadow-md shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all flex items-center gap-2">
                                Next: Section VIII
                                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script>
        // Simple UI interactivity for the demo toggles
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', (e) => {
                const section = e.target.closest('div[class*="group/"]');
                if (!section) return;

                const content = section.querySelector('div:last-child');
                if (!content) return;

                if (e.target.value === '0' || e.target.value === 'not_admin' || e.target.value === 'not_req') {
                    content.classList.add('opacity-40', 'pointer-events-none', 'grayscale');
                } else {
                    content.classList.remove('opacity-40', 'pointer-events-none', 'grayscale');
                }
            });
        });
    </script>
</body>

</html>