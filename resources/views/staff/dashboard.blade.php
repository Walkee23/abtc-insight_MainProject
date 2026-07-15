<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>ABTC-Insight | Queue Management</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "outline-variant": "#c1c7d3",
                        "on-primary-fixed": "#001b3d",
                        "tertiary-fixed": "#ffdbc8",
                        "on-tertiary": "#ffffff",
                        "background": "#f7f9fb",
                        "surface-container-lowest": "#ffffff",
                        "on-error": "#ffffff",
                        "secondary-fixed-dim": "#b1c8ec",
                        "surface-container": "#eceef0",
                        "outline": "#717782",
                        "on-error-container": "#93000a",
                        "secondary": "#49607f",
                        "primary-fixed-dim": "#a9c7ff",
                        "on-tertiary-fixed-variant": "#743500",
                        "error": "#ba1a1a",
                        "primary-container": "#0b61bb",
                        "on-secondary": "#ffffff",
                        "on-primary-fixed-variant": "#00468c",
                        "on-tertiary-container": "#ffd7c0",
                        "inverse-primary": "#a9c7ff",
                        "tertiary": "#7a3800",
                        "primary-fixed": "#d6e3ff",
                        "surface-variant": "#e0e3e5",
                        "primary": "#004a93",
                        "surface": "#f7f9fb",
                        "secondary-fixed": "#d3e4ff",
                        "inverse-surface": "#2d3133",
                        "error-container": "#ffdad6",
                        "on-secondary-fixed-variant": "#314866",
                        "on-primary-container": "#d0dfff",
                        "on-surface-variant": "#414751",
                        "surface-container-low": "#f2f4f6",
                        "surface-tint": "#005db6",
                        "secondary-container": "#c1d9fd",
                        "surface-container-high": "#e6e8ea",
                        "tertiary-container": "#9e4b00",
                        "on-secondary-fixed": "#011c38",
                        "on-primary": "#ffffff",
                        "on-tertiary-fixed": "#311300",
                        "on-surface": "#191c1e",
                        "inverse-on-surface": "#eff1f3",
                        "surface-container-highest": "#e0e3e5",
                        "on-secondary-container": "#485f7e",
                        "tertiary-fixed-dim": "#ffb689",
                        "surface-bright": "#f7f9fb",
                        "on-background": "#191c1e",
                        "surface-dim": "#d8dadc"
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "1rem",
                        "xl": "1.25rem",
                        "full": "9999px"
                    },
                    fontFamily: {
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

        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="text-on-surface select-none">
    <!-- SideNavBar -->
    <aside class="fixed left-0 top-0 h-full z-40 h-screen w-72 flex flex-col border-r border-outline-variant/10 bg-white dark:bg-slate-900 font-sans Inter antialiased">
        <div class="p-8 flex items-center gap-3">
            <div class="w-10 h-10 bg-primary-container rounded-xl flex items-center justify-center text-white shadow-md">
                <span class="material-symbols-outlined" data-icon="shield">shield</span>
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-tight text-primary dark:text-blue-200">ABTC-Insight</h1>
            </div>
        </div>
        <nav class="flex-1 mt-4 space-y-1 px-4">
            <!-- Queue Management - Active -->
            <a class="flex items-center gap-3 px-4 py-3.5 text-primary dark:text-blue-400 font-semibold border-l-4 border-primary dark:border-blue-400 bg-primary/5 transition-all" href="#">
                <span class="material-symbols-outlined" data-icon="queue">queue</span>
                <span>Queue Management</span>
            </a>
            <!-- Inactive Items -->
            <a class="flex items-center gap-3 px-4 py-3.5 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-blue-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors" href="#">
                <span class="material-symbols-outlined" data-icon="verified_user">verified_user</span>
                <span>Patient Verification</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3.5 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-blue-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors" href="#">
                <span class="material-symbols-outlined" data-icon="clinical_notes">clinical_notes</span>
                <span>Case Encoding</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3.5 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-blue-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors" href="#">
                <span class="material-symbols-outlined" data-icon="person_search">person_search</span>
                <span>Patient Lookup</span>
            </a>
        </nav>
    </aside>
    <!-- Main Content Area -->
    <main class="ml-72 min-h-screen">
        <!-- TopNavBar -->
        <header class="flex justify-between items-center w-full h-16 px-8 sticky top-0 z-30 bg-white/85 dark:bg-slate-900/85 backdrop-blur-md border-b border-outline-variant/10 font-sans Inter tracking-tight">
            <div class="flex items-center gap-8">
                <div class="flex items-center gap-2 text-primary font-bold text-lg tracking-tight">
                    ABTC-Insight
                </div>
                <div class="relative group">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-lg">search</span>
                    <input class="pl-10 pr-4 py-1.5 bg-surface-container-low rounded-full text-sm focus:ring-2 focus:ring-primary/20 border-none outline-none w-72 transition-all" placeholder="Search analytics or case IDs..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-4">
                <!-- Status/Live indicator moved or kept subtle -->
                <button class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold shadow-sm hover:shadow-md hover:bg-primary/90 transition-all active:scale-95 mr-2">
                    <span class="material-symbols-outlined text-[20px]" data-icon="person_add">person_add</span>
                    <span>Register New Patient</span>
                </button>
                <div class="hidden lg:flex items-center gap-2 px-3 py-1 bg-green-50 text-green-700 rounded-full text-[10px] font-bold uppercase tracking-wider">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                    12 Active
                </div>
                <div class="flex items-center gap-1 border-r border-outline-variant/20 pr-4">
                    <button class="p-2 text-slate-500 hover:bg-surface-container-high rounded-full transition-colors relative">
                        <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-white"></span>
                    </button>
                    <button class="p-2 text-slate-500 hover:bg-surface-container-high rounded-full transition-colors">
                        <span class="material-symbols-outlined" data-icon="help">help</span>
                    </button>
                </div>
                <div class="flex items-center gap-3 pl-2">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-on-surface leading-tight">Staff_01</p>
                        <p class="text-[10px] text-on-surface-variant leading-tight">ABTC Staff</p>
                    </div>
                    <div class="relative">
                        <img alt="User Avatar" class="w-9 h-9 rounded-full border border-outline-variant/20 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCG2nKFZGyYwHKRYoCQT3e-DFv4lhmbOaefZN_pNQ6HkWmU6VSYzY9h1P_RiS1yqN4hdqhLCiP4K6Ea7gARSWG6HK0qt5boVFtv4S1YiWv2O1vutB_s88IrPG_wB7x02LuJj9pA0d9mKcPXNHWbCr_BIg-CKtC_tZCmVz1DmJURoecp6Re7uXEhv9FI1dvVxhWIOr9RdMIXbtQRUjsSOkEc-i5gI18j8iBFPISCiDNXnFP_TQidoFnFp1cFnCO6SpZTN3UK4BIZ1wd1" />
                        <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                </div>
            </div>
        </header>
        <div class="p-8 max-w-[1600px] mx-auto pb-32">
            <!-- Title Section -->
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold tracking-tighter text-on-surface">Queue Management</h2>
                <p class="text-on-surface-variant mt-1">Monitor intake progress and verify clinical exposure details.</p>
            </div>
            <!-- Section 1: Stats Grid (Bento Style) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-surface-container-lowest p-6 rounded-lg shadow-sm border border-outline-variant/10">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-primary/5 rounded-lg text-primary">
                            <span class="material-symbols-outlined" data-icon="group">group</span>
                        </div>
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest">DAILY REGISTRATIONS</span>
                    </div>
                    <div class="text-4xl font-black text-on-surface">87</div>
                    <div class="text-xs text-on-surface-variant uppercase mt-1 tracking-widest font-semibold">Total Registered</div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-lg shadow-sm border border-outline-variant/10">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-green-500/5 rounded-lg text-green-600">
                            <span class="material-symbols-outlined" data-icon="check_circle">check_circle</span>
                        </div>
                        <span class="text-[10px] font-bold text-green-600 uppercase tracking-widest">Verified</span>
                    </div>
                    <div class="text-4xl font-black text-on-surface">43</div>
                    <div class="text-xs text-on-surface-variant uppercase mt-1 tracking-widest font-semibold">VERIFIED PATIENTS</div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-lg shadow-sm border border-outline-variant/10">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-error-container/20 rounded-lg text-error">
                            <span class="material-symbols-outlined" data-icon="pending">pending</span>
                        </div>
                        <span class="text-[10px] font-bold text-error uppercase tracking-widest">Action Required</span>
                    </div>
                    <div class="text-4xl font-black text-on-surface">44</div>
                    <div class="text-xs text-on-surface-variant uppercase mt-1 tracking-widest font-semibold">PENDING VERIFICATIONS</div>
                </div>
            </div>
            <!-- Content Grid: Priority and Normal Queue -->
            <div class="grid grid-cols-12 gap-8 items-start">
                <!-- Section 2: Priority Queue -->
                <div class="col-span-12 xl:col-span-5 bg-surface-container-low rounded-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-8 bg-green-500 rounded-full"></div>
                            <h3 class="text-lg font-bold text-on-surface">Priority Queue P-Series</h3>
                        </div>
                        <span class="text-xs bg-green-500/10 text-green-700 px-3 py-1 rounded-full font-bold uppercase">3 Patients Waiting</span>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-outline-variant/20 bg-white">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-high/50 border-b border-outline-variant/10">
                                    <th class="px-4 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Queue No</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Patient Name</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Type</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="px-4 py-4 font-black text-primary">P1</td>
                                    <td class="px-4 py-4 text-sm font-semibold">Luzviminda Cruz</td>
                                    <td class="px-4 py-4">
                                        <span class="px-2 py-1 bg-tertiary-fixed text-on-tertiary-fixed-variant text-[10px] font-bold rounded-full uppercase">Senior</span>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <button class="text-xs font-bold text-primary hover:underline">Call &amp; Verify</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="px-4 py-4 font-black text-primary">P2</td>
                                    <td class="px-4 py-4 text-sm font-semibold">Roberto Gomez</td>
                                    <td class="px-4 py-4">
                                        <span class="px-2 py-1 bg-primary-fixed text-on-primary-fixed-variant text-[10px] font-bold rounded-full uppercase">PWD</span>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <button class="text-xs font-bold text-primary hover:underline">Call &amp; Verify</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="px-4 py-4 font-black text-primary">P3</td>
                                    <td class="px-4 py-4 text-sm font-semibold">Elena Marasigan</td>
                                    <td class="px-4 py-4">
                                        <span class="px-2 py-1 bg-error-container text-on-error-container text-[10px] font-bold rounded-full uppercase">Pregnant</span>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <button class="text-xs font-bold text-primary hover:underline">Call &amp; Verify</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Section 3: Normal Queue -->
                <div class="col-span-12 xl:col-span-7 bg-surface-container-low rounded-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-8 bg-primary rounded-full"></div>
                            <h3 class="text-lg font-bold text-on-surface">Normal Queue N-Series</h3>
                        </div>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-outline-variant/20 bg-white shadow-sm">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-high/50 border-b border-outline-variant/10">
                                    <th class="px-4 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Queue No</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Patient</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Barangay</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Status</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                <tr class="hover:bg-primary/5 transition-colors group">
                                    <td class="px-4 py-4 font-black text-primary">N35</td>
                                    <td class="px-4 py-4">
                                        <p class="text-sm font-bold">Juan Dela Cruz</p>
                                        <p class="text-[10px] text-on-surface-variant">08:15 AM • <span class="text-primary font-bold">New Case</span></p>
                                    </td>
                                    <td class="px-4 py-4 text-xs font-semibold text-on-surface-variant">Brgy. Guadalupe</td>
                                    <td class="px-4 py-4">
                                        <span class="px-2 py-0.5 bg-primary/10 text-primary text-[10px] font-bold rounded-full">WAITING</span>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <button class="px-4 py-1.5 bg-surface-container-lowest text-primary text-xs font-bold rounded-lg border border-primary/20 hover:bg-primary hover:text-white transition-all">Mark Present</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-surface-container-low transition-colors group">
                                    <td class="px-4 py-4 font-black text-primary/60">N36</td>
                                    <td class="px-4 py-4">
                                        <p class="text-sm font-bold">Maria Santos</p>
                                        <p class="text-[10px] text-on-surface-variant">08:17 AM • Returning Patient</p>
                                    </td>
                                    <td class="px-4 py-4 text-xs font-semibold text-on-surface-variant">Brgy. Lahug</td>
                                    <td class="px-4 py-4">
                                        <span class="px-2 py-0.5 bg-surface-container-high text-on-surface-variant text-[10px] font-bold rounded-full uppercase">Waiting</span>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <button class="px-4 py-1.5 bg-surface-container-lowest text-on-surface-variant text-xs font-bold rounded-lg border border-outline-variant/20">Mark Present</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-surface-container-low transition-colors group">
                                    <td class="px-4 py-4 font-black text-primary/60">N37</td>
                                    <td class="px-4 py-4">
                                        <p class="text-sm font-bold">Pedro Penduko</p>
                                        <p class="text-[10px] text-on-surface-variant">08:20 AM • New Case</p>
                                    </td>
                                    <td class="px-4 py-4 text-xs font-semibold text-on-surface-variant">Brgy. Labangon</td>
                                    <td class="px-4 py-4">
                                        <span class="px-2 py-0.5 bg-surface-container-high text-on-surface-variant text-[10px] font-bold rounded-full uppercase">Waiting</span>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <button class="px-4 py-1.5 bg-surface-container-lowest text-on-surface-variant text-xs font-bold rounded-lg border border-outline-variant/20">Mark Present</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Section 5: Bottom Collapsed Patient Lookup -->
        <div class="fixed bottom-0 left-72 right-0 p-4 z-10 pointer-events-none">
            <div class="max-w-[1200px] mx-auto pointer-events-auto">
                <div class="bg-white/95 backdrop-blur-md rounded-t-2xl shadow-[0_-10px_30px_rgba(0,0,0,0.1)] border-x border-t border-outline-variant/20">
                    <div class="flex items-center justify-between px-8 py-4">
                        <div class="flex items-center gap-4">
                            <span class="material-symbols-outlined text-primary" data-icon="person_search">person_search</span>
                            <span class="text-sm font-bold text-on-surface uppercase tracking-wider">Quick Patient Lookup</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex bg-surface-container-low rounded-full px-4 py-1.5 border border-outline-variant/20 focus-within:ring-2 focus-within:ring-primary/20 transition-all">
                                <input class="bg-transparent border-0 text-xs font-medium w-64 focus:ring-0" placeholder="Search by name or case ID..." type="text" />
                                <span class="material-symbols-outlined text-sm text-on-surface-variant" data-icon="search">search</span>
                            </div>
                            <button class="p-2 hover:bg-surface-container-high rounded-full transition-colors">
                                <span class="material-symbols-outlined" data-icon="keyboard_arrow_up">keyboard_arrow_up</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>