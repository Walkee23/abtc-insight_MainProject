<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>ABTC-Insight | Queue Management</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
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
    <script src="{{ asset('js/sidebar-toggle.js') }}"></script>
</head>

<body class="text-on-surface select-none">
    <!-- SideNavBar -->
    <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-50 dark:bg-slate-900 flex flex-col border-r border-slate-200/50 dark:border-slate-800/50 z-50">
        <!-- Brand -->
        <div class="px-6 pt-8">
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-primary rounded-[1rem] flex items-center justify-center">
                    <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                </div>
                <div>
                    <h1 class="font-black uppercase text-primary dark:text-blue-100 text-sm tracking-wider leading-none">ABTC-Insight</h1>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="space-y-1 px-6">
            <!-- Dashboard Overview (New Dashboard on Top) -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50"
                href="{{ route('staff.newdashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-['Inter'] text-sm tracking-wide">Dashboard</span>
            </a>

            <!-- Queue Management (Active - Admin Style) -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-700 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600 translate-x-1 duration-150"
                href="{{ route('staff.dashboard') }}">
                <span class="material-symbols-outlined">queue</span>
                <span class="font-['Inter'] text-sm tracking-wide">Queue Management</span>
            </a>

            <!-- Case Encoding -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50"
                href="{{ route('staff.case-encoding') }}">
                <span class="material-symbols-outlined">clinical_notes</span>
                <span class="font-['Inter'] text-sm tracking-wide">Case Encoding</span>
            </a>

            <!-- Patient Lookup -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50"
                href="{{ route('staff.patient-lookup') }}">
                <span class="material-symbols-outlined">person_search</span>
                <span class="font-['Inter'] text-sm tracking-wide">Patient Lookup</span>
            </a>
        </nav>

    </aside>
    <!-- Main Content Area -->
    <main class="ml-64 min-h-screen">
        <!-- TopNavBar -->
        <header class="flex justify-between items-center w-full h-16 px-8 sticky top-0 z-40 bg-slate-50/85 dark:bg-slate-900/85 backdrop-blur-md shadow-sm shadow-blue-900/5">
            <div class="flex items-center gap-8">

                <form action="{{ route('staff.dashboard') }}" method="GET" class="relative group">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-lg">search</span>
                    <input id="live-search" name="search" value="{{ $search ?? '' }}" autocomplete="off"
                        class="pl-10 pr-4 py-1.5 bg-surface-container-low rounded-full text-sm focus:ring-2 focus:ring-primary/20 border-none outline-none w-72 transition-all"
                        placeholder="Search name, queue no, ID..." type="text" />
                </form>
            </div>
            <div class="flex items-center gap-4">
                <button type="button" onclick="openRegisterLogoutModal()"
                    class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold shadow-sm hover:shadow-md hover:bg-primary/90 transition-all active:scale-95 mr-2 cursor-pointer">
                    <span class="material-symbols-outlined text-[20px]" data-icon="person_add">person_add</span>
                    <span>Register New Patient</span>
                </button>

                <!--  total of pending priority and normal queue items -->
                <div class="hidden lg:flex items-center gap-2 px-3 py-1 bg-green-50 text-green-700 rounded-full text-[10px] font-bold uppercase tracking-wider">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                    {{ ($priorityQueue->count() ?? 0) + ($normalQueue->count() ?? 0) }} Pending Active
                </div>

                <div class="flex items-center gap-1 border-r border-outline-variant/20 pr-4">
                </div>

                <div class="relative group cursor-pointer pl-2">
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold text-on-surface leading-tight">{{ Auth::user()->full_name }}</p>
                            <p class="text-[10px] text-on-surface-variant leading-tight">{{ Auth::user()->role }}</p>
                        </div>
                        <div class="relative w-9 h-9">
                            <div class="w-9 h-9 rounded-full overflow-hidden ring-2 ring-slate-100 border border-slate-200">
                                <img alt="{{ Auth::user()->full_name }}" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCG2nKFZGyYwHKRYoCQT3e-DFv4lhmbOaefZN_pNQ6HkWmU6VSYzY9h1P_RiS1yqN4hdqhLCiP4K6Ea7gARSWG6HK0qt5boVFtv4S1YiWv2O1vutB_s88IrPG_wB7x02LuJj9pA0d9mKcPXNHWbCr_BIg-CKtC_tZCmVz1DmJURoecp6Re7uXEhv9FI1dvVxhWIOr9RdMIXbtQRUjsSOkEc-i5gI18j8iBFPISCiDNXnFP_TQidoFnFp1cFnCO6SpZTN3UK4BIZ1wd1" />
                            </div>
                            <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                    </div>

                    <!-- Hover Dropdown Menu -->
                    <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="p-2">
                            <button type="button" onclick="openProfileModal()" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary rounded-lg transition-colors text-left cursor-pointer">
                                <span class="material-symbols-outlined text-[18px]">person</span>
                                My Profile
                            </button>
                            <div class="h-px bg-slate-100 my-1"></div>

                            <!-- Secure Logout Form -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors text-left cursor-pointer">
                                    <span class="material-symbols-outlined text-[18px]">logout</span>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </header>
        <div class="p-8 max-w-[1600px] mx-auto pb-32">

            <!-- [ADDED]: Flash Message for Actions -->
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Title Section -->
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold tracking-tighter text-on-surface">Queue Management</h2>
                <p class="text-on-surface-variant mt-1">Monitor intake progress and verify clinical exposure details.</p>
            </div>

            <!-- Content Grid: Priority and Normal Queue -->
            <div class="grid grid-cols-12 gap-8 items-start">
                <!-- Section 2: Priority Queue -->
                <div class="col-span-12 xl:col-span-5 bg-surface-container-low rounded-lg p-6">
                    <!-- Dynamic Count -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-8 bg-green-500 rounded-full"></div>
                            <h3 class="text-lg font-bold text-on-surface">Priority Queue P-Series</h3>
                        </div>
                        <span class="text-xs bg-green-500/10 text-green-700 px-3 py-1 rounded-full font-bold uppercase">
                            {{ $priorityQueue->count() }} Patients Waiting
                        </span>
                    </div>

                    <!-- [UPDATED]: Vertical scroll only, strictly disable horizontal scroll -->
                    <div class="max-h-[380px] overflow-y-auto overflow-x-hidden rounded-xl border border-outline-variant/20 bg-white shadow-sm">
                        <table class="w-full table-fixed text-left border-collapse">
                            <!-- Sticky header stays fixed when scrolling -->
                            <thead class="sticky top-0 z-10">
                                <tr class="bg-surface-container-high border-b border-outline-variant/10 shadow-sm">
                                    <th class="w-2/12 px-3 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest bg-slate-50">Queue No</th>
                                    <th class="w-5/12 px-3 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest bg-slate-50">Patient Name</th>
                                    <th class="w-3/12 px-3 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest bg-slate-50">Barangay</th>
                                    <th class="w-2/12 px-3 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest text-right bg-slate-50">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                @forelse($priorityQueue as $patient)
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="px-3 py-4 font-black text-primary truncate">{{ $patient->queue_id }}</td>
                                    <td class="px-3 py-4">
                                        <div class="text-sm font-semibold truncate">{{ $patient->patient_name }}</div>
                                        <div class="text-[10px] text-on-surface-variant truncate">Age: {{ $patient->age }} • {{ $patient->sex }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-xs font-semibold text-on-surface-variant">
                                        {{ $patient->barangay ?? 'N/A' }}
                                    </td>
                                    <td class="px-3 py-4 text-right">
                                        <!-- Trigger Button para sa Priority Modal -->
                                        <a href="#call-priority-modal-{{ $patient->inflow_record_id }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-500/10 hover:bg-green-600 text-green-700 hover:text-white text-xs font-bold rounded-lg border border-green-500/20 transition-all shadow-sm">
                                            <span class="material-symbols-outlined text-[15px]">campaign</span>
                                            <span>Call &amp; Verify</span>
                                        </a>

                                        <!-- Pure CSS Modal (Walay JavaScript) para sa Priority Patient -->
                                        <div id="call-priority-modal-{{ $patient->inflow_record_id }}"
                                            class="fixed inset-0 z-50 hidden [&:target]:flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">

                                            <div class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden text-left">

                                                <!-- Modal Header (Green Priority Accent) -->
                                                <div class="bg-gradient-to-r from-emerald-600 to-green-700 p-6 text-white flex justify-between items-start">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white font-extrabold text-lg shadow-inner">
                                                            {{ $patient->queue_id }}
                                                        </div>
                                                        <div>
                                                            <div class="flex items-center gap-1.5">
                                                                <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                                                                <span class="text-[10px] font-extrabold tracking-widest uppercase opacity-90">Priority Lane (P-Series)</span>
                                                            </div>
                                                            <h3 class="text-xl font-bold leading-tight mt-0.5">{{ $patient->patient_name }}</h3>
                                                        </div>
                                                    </div>
                                                    <!-- Close Button (Href to #) -->
                                                    <a href="#" class="text-white/70 hover:text-white transition-colors p-1 rounded-lg hover:bg-white/10">
                                                        <span class="material-symbols-outlined text-[20px]">close</span>
                                                    </a>
                                                </div>

                                                <!-- Modal Body: Patient Quick Specs -->
                                                <div class="p-6 space-y-4">
                                                    <div class="grid grid-cols-2 gap-3 text-xs">
                                                        <div class="p-3 bg-surface-container-low rounded-xl border border-slate-100 dark:border-slate-800">
                                                            <span class="text-slate-500 block font-medium mb-0.5">Age / Sex</span>
                                                            <span class="font-bold text-slate-800 dark:text-slate-200 text-sm">{{ $patient->age }} / {{ $patient->sex }}</span>
                                                        </div>
                                                        <div class="p-3 bg-surface-container-low rounded-xl border border-slate-100 dark:border-slate-800">
                                                            <span class="text-slate-500 block font-medium mb-0.5">Priority ID Number</span>
                                                            <span class="font-bold text-emerald-700 dark:text-emerald-400 text-sm truncate block">{{ $patient->id_number ?? 'None' }}</span>
                                                        </div>
                                                        <div class="p-3 bg-surface-container-low rounded-xl border border-slate-100 dark:border-slate-800">
                                                            <span class="text-slate-500 block font-medium mb-0.5">Barangay</span>
                                                            <span class="font-bold text-slate-800 dark:text-slate-200 text-sm">{{ $patient->barangay ?? 'N/A' }}</span>
                                                        </div>
                                                        <div class="p-3 bg-surface-container-low rounded-xl border border-slate-100 dark:border-slate-800">
                                                            <span class="text-slate-500 block font-medium mb-0.5">Contact Number</span>
                                                            <span class="font-bold text-slate-800 dark:text-slate-200 text-sm">{{ $patient->contact_num ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="p-3.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200/60 dark:border-emerald-900/50 flex items-start gap-2.5 text-xs text-emerald-900 dark:text-emerald-200">
                                                        <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0">verified</span>
                                                        <p>Priority lane patient. Proceeding will load their profile in the <strong>Patient Verification</strong> screen for document checking.</p>
                                                    </div>
                                                </div>

                                                <!-- Modal Footer Actions -->
                                                <div class="p-6 bg-slate-50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3 items-center">
                                                    <!-- Cancel Link -->
                                                    <a href="#" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-xl transition-colors inline-flex items-center">
                                                        Cancel
                                                    </a>

                                                    <!-- Proceed Form -> Calls staff.call-patient without modifying status -->
                                                    <form method="POST" action="{{ route('staff.call-patient', $patient->inflow_record_id) }}">
                                                        @csrf
                                                        <button type="submit"
                                                            class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 flex items-center gap-2 transition-all">
                                                            <span>Proceed to Verification</span>
                                                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                                        </button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-xs text-slate-400 font-medium">
                                        No priority patients waiting in queue.
                                    </td>
                                </tr>
                                @endforelse
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

                    <!-- Scrollable Wrapper Container -->
                    <div class="overflow-hidden rounded-xl border border-outline-variant/20 bg-white shadow-sm">
                        <!-- Gitangtang ang overflow sa gawas ug gibutangan og max-height ug overflow-y-auto sa ubos -->
                        <div class="max-h-[400px] overflow-y-auto relative">
                            <table class="w-full text-left border-collapse">
                                <thead class="sticky top-0 z-10 bg-surface-container-high shadow-sm">
                                    <tr class="border-b border-outline-variant/10">
                                        <th class="px-4 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest bg-surface-container-high">Queue No</th>
                                        <th class="px-4 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest bg-surface-container-high">Patient</th>
                                        <th class="px-4 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest bg-surface-container-high">Barangay</th>
                                        <th class="px-4 py-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest text-right bg-surface-container-high">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-outline-variant/10">
                                    @forelse($normalQueue as $patient)
                                    <tr class="hover:bg-primary/5 transition-colors group">
                                        <!-- 1. Queue No -->
                                        <td class="px-4 py-4 font-black text-primary">{{ $patient->queue_id }}</td>

                                        <!-- 2. Patient -->
                                        <td class="px-4 py-4">
                                            <p class="text-sm font-bold">{{ $patient->patient_name }}</p>
                                            <p class="text-[10px] text-on-surface-variant">
                                                ID: {{ $patient->id_number ?? 'No ID' }} •
                                                <span class="text-primary font-bold">Age: {{ $patient->age }}</span>
                                            </p>
                                        </td>

                                        <!-- 3. Barangay -->
                                        <td class="px-4 py-4 text-xs font-semibold text-on-surface-variant">
                                            {{ $patient->barangay ?? 'N/A' }}
                                        </td>

                                        <!-- 5. Action Cell -->
                                        <td class="px-4 py-4 text-right">
                                            <!-- Button nga mo-trigger sa CSS Modal -->
                                            <a href="#call-modal-{{ $patient->inflow_record_id }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary/10 hover:bg-primary text-primary hover:text-white text-xs font-bold rounded-lg border border-primary/20 transition-all shadow-sm">
                                                <span class="material-symbols-outlined text-[15px]">campaign</span>
                                                <span>Call &amp; Verify</span>
                                            </a>

                                            <!-- Pure CSS Modal -->
                                            <div id="call-modal-{{ $patient->inflow_record_id }}"
                                                class="fixed inset-0 z-50 hidden [&:target]:flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">

                                                <div class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden text-left">

                                                    <!-- Header -->
                                                    <div class="bg-gradient-to-r from-primary to-primary-container p-6 text-white flex justify-between items-start">
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white font-bold text-lg">
                                                                {{ $patient->queue_id }}
                                                            </div>
                                                            <div>
                                                                <span class="text-[11px] font-bold tracking-wider uppercase opacity-80">Call to Counter</span>
                                                                <h3 class="text-xl font-bold leading-tight">{{ $patient->patient_name }}</h3>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="text-white/70 hover:text-white transition-colors p-1 rounded-lg hover:bg-white/10">
                                                            <span class="material-symbols-outlined text-[20px]">close</span>
                                                        </a>
                                                    </div>

                                                    <!-- Body: Patient Overview -->
                                                    <div class="p-6 space-y-4">
                                                        <div class="grid grid-cols-2 gap-3 text-xs">
                                                            <div class="p-3 bg-surface-container-low rounded-xl">
                                                                <span class="text-on-surface-variant block font-medium mb-0.5">Age / Sex</span>
                                                                <span class="font-bold text-on-surface text-sm">{{ $patient->age }} / {{ $patient->sex }}</span>
                                                            </div>
                                                            <div class="p-3 bg-surface-container-low rounded-xl">
                                                                <span class="text-on-surface-variant block font-medium mb-0.5">Valid ID / Number</span>
                                                                <span class="font-bold text-on-surface text-sm truncate block">{{ $patient->id_number ?? 'None' }}</span>
                                                            </div>
                                                            <div class="p-3 bg-surface-container-low rounded-xl">
                                                                <span class="text-on-surface-variant block font-medium mb-0.5">Barangay</span>
                                                                <span class="font-bold text-on-surface text-sm">{{ $patient->barangay ?? 'N/A' }}</span>
                                                            </div>
                                                            <div class="p-3 bg-surface-container-low rounded-xl">
                                                                <span class="text-on-surface-variant block font-medium mb-0.5">Contact Number</span>
                                                                <span class="font-bold text-on-surface text-sm">{{ $patient->contact_num ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="p-3 rounded-xl bg-blue-50 dark:bg-blue-950/40 border border-blue-100 dark:border-blue-900/50 flex items-start gap-2.5 text-xs text-blue-900 dark:text-blue-200">
                                                            <span class="material-symbols-outlined text-blue-600 text-[18px] shrink-0">info</span>
                                                            <p>Calling this ticket will mark the patient as <strong>Serving</strong> and redirect to document inspection.</p>
                                                        </div>
                                                    </div>

                                                    <!-- Footer Actions -->
                                                    <div class="p-6 bg-slate-50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3">
                                                        
                                                        <form method="POST"
                                                            action="{{ route('staff.remove-from-queue', $patient->inflow_record_id) }}"
                                                            onsubmit="return confirm('Patient not present? This will remove them from the queue.');"
                                                            class="mr-auto">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="group/remove px-4 py-2.5 text-xs font-bold text-red-600 border border-transparent rounded-xl inline-flex items-center gap-1.5 cursor-pointer
                                                                        transition-all duration-200 ease-out
                                                                        hover:bg-red-50 hover:text-red-700 hover:border-red-200 hover:shadow-md hover:shadow-red-500/10 hover:-translate-y-0.5
                                                                        active:translate-y-0 active:scale-95
                                                                        focus:outline-none focus-visible:ring-2 focus-visible:ring-red-300">
                                                                <span class="material-symbols-outlined text-[16px] transition-transform duration-200 group-hover/remove:scale-110 group-hover/remove:-rotate-12">person_off</span>
                                                                Patient Not Present
                                                            </button>
                                                        </form>

                                                        <form method="POST" action="{{ route('staff.call-patient', $patient->inflow_record_id) }}">
                                                            @csrf
                                                            <button type="submit"
                                                                class="px-5 py-2.5 bg-primary hover:bg-primary/90 text-white text-xs font-bold rounded-xl shadow-md shadow-primary/20 flex items-center gap-2">
                                                                <span>Proceed to Verification</span>
                                                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                                            </button>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-xs text-slate-400 font-medium">
                                            No patients in the normal queue.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const input = document.getElementById('live-search');
                        if (!input) return;

                        // every real patient row in the queue tables (skips the "No patients..." rows)
                        const rows = [...document.querySelectorAll('main table tbody tr')]
                            .filter(tr => !tr.querySelector('td[colspan]'));

                        const run = () => {
                            const q = input.value.trim().toLowerCase();
                            rows.forEach(tr => {
                                // only the first 3 cells: queue no, patient (name, ID, age), barangay
                                const text = [...tr.cells].slice(0, 3).map(c => c.textContent).join(' ').toLowerCase();
                                tr.classList.toggle('hidden', q !== '' && !text.includes(q));
                            });
                        };

                        input.addEventListener('input', run);
                        run(); // also applies a search that is already in the box
                    });
                </script>
    </main>
    <!-- My Profile Modal -->
    @php
    $user = Auth::user();

    // Shared placeholder descriptions (edit these)
    $hwText = 'Provides frontline health services, records and updates patient information, conducts health monitoring, and supports community health programs.';
    $staffText = 'Handles administrative and clerical tasks, manages records and documents, assists clients, and supports the daily operations of the center.';

    // Per-user job descriptions, keyed by username
    $jobDescriptions = [
    'thelmaeleccion' => 'Attending physician. Examines and treats patients, oversees health programs, and guides the health workers on patient care.',
    'otreborenriquez' => $hwText,
    'annemarielascuna' => $hwText,
    'brenalleeracaza' => $hwText,
    'richardninopangilinan' => $hwText,
    'loretaallera' => $staffText,
    'genevevecugay' => $staffText,
    'donalizanavarro' => $staffText,
    'liecelberdera' => $staffText,
    'ginaoporto' => $staffText,
    'rolandnabua' => $staffText,
    'queenieeslabon' => $staffText,
    'merlizacarunggay' => $staffText,
    ];

    $jobDescription = $jobDescriptions[$user->username]
    ?? ($user->role === 'Health Worker' ? $hwText : $staffText);

    $isHW = $user->role === 'Health Worker';
    $badgeClasses = $isHW
    ? 'bg-emerald-50 text-emerald-700 ring-emerald-200'
    : 'bg-sky-50 text-sky-700 ring-sky-200';
    @endphp

    <div id="profileModal"
        class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 opacity-0 transition-opacity duration-200"
        onclick="if(event.target === this) closeProfileModal()">

        <div id="profileCard"
            class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden scale-95 translate-y-2 transition-all duration-200">

            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">My Profile</h3>
                <button type="button" onclick="closeProfileModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-full text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <!-- Details -->
            <div class="p-6 space-y-3">

                <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="w-10 h-10 shrink-0 rounded-lg bg-white shadow-sm flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[22px]">person</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Account Name</p>
                        <p class="text-sm font-semibold text-slate-800 break-words">{{ $user->full_name }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="w-10 h-10 shrink-0 rounded-lg bg-white shadow-sm flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[22px]">admin_panel_settings</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Role in the System</p>
                        <span class="mt-1 inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold ring-1 {{ $badgeClasses }}">
                            {{ $user->role }}
                        </span>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="w-10 h-10 shrink-0 rounded-lg bg-white shadow-sm flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[22px]">work</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Job Description</p>
                        <p class="text-sm text-slate-600 leading-relaxed">{{ $jobDescription }}</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button type="button" onclick="closeProfileModal()"
                    class="px-5 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:opacity-90 transition-opacity cursor-pointer">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Register New Patient Logout Confirmation Modal -->
    <div id="registerLogoutModal"
        class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 opacity-0 transition-opacity duration-200"
        onclick="if(event.target === this) closeRegisterLogoutModal()">

        <div id="registerLogoutCard"
            class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden scale-95 translate-y-2 transition-all duration-200">

            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">warning</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Log Out Required</h3>
                </div>
                <button type="button" onclick="closeRegisterLogoutModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-full text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-3">
                <p class="text-sm text-slate-600 leading-relaxed">
                    Opening the <strong>Patient Registration Form</strong> will automatically log out your current staff session (<span class="font-semibold text-slate-800">{{ Auth::user()->full_name }}</span>) for security before redirecting.
                </p>
                <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200/70 flex items-start gap-2.5 text-xs text-amber-900">
                    <span class="material-symbols-outlined text-amber-600 text-[18px] shrink-0">info</span>
                    <p>You will need to sign in again through the staff portal after finishing the patient registration.</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" onclick="closeRegisterLogoutModal()"
                    class="px-4 py-2 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-200 transition-colors cursor-pointer">
                    Cancel
                </button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="hidden" name="redirect_to" value="/patient/New_patient">
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-colors flex items-center gap-1.5 cursor-pointer">
                        <span>Log Out &amp; Continue</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openProfileModal() {
            const modal = document.getElementById('profileModal');
            const card = document.getElementById('profileCard');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                card.classList.remove('scale-95', 'translate-y-2');
            });
        }

        function closeProfileModal() {
            const modal = document.getElementById('profileModal');
            const card = document.getElementById('profileCard');
            modal.classList.add('opacity-0');
            card.classList.add('scale-95', 'translate-y-2');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        function openRegisterLogoutModal() {
            const modal = document.getElementById('registerLogoutModal');
            const card = document.getElementById('registerLogoutCard');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                card.classList.remove('scale-95', 'translate-y-2');
            });
        }

        function closeRegisterLogoutModal() {
            const modal = document.getElementById('registerLogoutModal');
            const card = document.getElementById('registerLogoutCard');
            modal.classList.add('opacity-0');
            card.classList.add('scale-95', 'translate-y-2');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                closeProfileModal();
                closeRegisterLogoutModal();
            }
        });
    </script>
    @include('partials.idle-timeout')
</body>


</html>