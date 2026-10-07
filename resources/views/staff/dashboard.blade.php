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
    <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-100 dark:bg-slate-900 flex flex-col pt-6 pb-4 gap-2 z-50">
    <!-- SideNavBar -->
        <div class="px-6 mb-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white shadow-lg">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                </div>
                <div>
                    <h1 class="text-blue-900 dark:text-blue-50 font-bold text-sm tracking-tight leading-none">ABTC-Insight</h1>
                </div>
            </div>
        </div>
           

        <nav class="flex-1 mt-4 space-y-1 px-4">
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
    <main class="ml-72 min-h-screen">
        <!-- TopNavBar -->
        <header class="flex justify-between items-center w-full h-16 px-8 sticky top-0 z-30 bg-white/85 dark:bg-slate-950/85 backdrop-blur-md z-30 shadow-sm shadow-slate-200/50 dark:shadow-none border-b border-slate-100/50">
            <div class="flex items-center gap-8">
                
                <form action="{{ route('staff.dashboard') }}" method="GET" class="relative group">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-lg">search</span>
                    <input name="search" value="{{ $search ?? '' }}" class="pl-10 pr-4 py-1.5 bg-surface-container-low rounded-full text-sm focus:ring-2 focus:ring-primary/20 border-none outline-none w-72 transition-all" placeholder="Search name, queue no, ID..." type="text" />
                </form>
            </div>
            <div class="flex items-center gap-4">
                <!-- Status/Live indicator moved or kept subtle -->
                <a href="{{ route('patient.new-patient') }}" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold shadow-sm hover:shadow-md hover:bg-primary/90 transition-all active:scale-95 mr-2">
                    <span class="material-symbols-outlined text-[20px]" data-icon="person_add">person_add</span>
                    <span>Register New Patient</span>
                </a>

                <!--  total of pending priority and normal queue items -->
                <div class="hidden lg:flex items-center gap-2 px-3 py-1 bg-green-50 text-green-700 rounded-full text-[10px] font-bold uppercase tracking-wider">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                    {{ ($priorityQueue->count() ?? 0) + ($normalQueue->count() ?? 0) }} Pending Active
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
                
                <!-- User Profile Section with Dropdown (Admin Format) -->
<div class="relative group cursor-pointer pl-2">
    <div class="flex items-center gap-3">
        <div class="text-right hidden sm:block">
            <p class="text-xs font-bold text-on-surface leading-tight"> Staff </p>
            <p class="text-[10px] text-on-surface-variant leading-tight"> ABTC Staff </p>
        </div>
        <div class="w-9 h-9 rounded-full overflow-hidden ring-2 ring-slate-100 border border-slate-200">
            <img alt="Staff Avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCG2nKFZGyYwHKRYoCQT3e-DFv4lhmbOaefZN_pNQ6HkWmU6VSYzY9h1P_RiS1yqN4hdqhLCiP4K6Ea7gARSWG6HK0qt5boVFtv4S1YiWv2O1vutB_s88IrPG_wB7x02LuJj9pA0d9mKcPXNHWbCr_BIg-CKtC_tZCmVz1DmJURoecp6Re7uXEhv9FI1dvVxhWIOr9RdMIXbtQRUjsSOkEc-i5gI18j8iBFPISCiDNXnFP_TQidoFnFp1cFnCO6SpZTN3UK4BIZ1wd1" />
            <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
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
                                    <td class="px-3 py-4 text-xs font-semibold text-on-surface-variant truncate">
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

                                    <!-- 4. Status -->
                                    <td class="px-4 py-4">
                                        <span class="px-2 py-0.5 bg-primary/10 text-primary text-[10px] font-bold rounded-full uppercase">
                                            {{ $patient->status }}
                                        </span>
                                    </td>
                                    
                                    <!-- 5. Action Cell (NA-MISS NGA TD KANINA) -->
                                    <td class="px-4 py-4 text-right">
                                        <!-- Button nga mo-trigger sa CSS Modal -->
                                        <a href="#call-modal-{{ $patient->inflow_record_id }}" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary/10 hover:bg-primary text-primary hover:text-white text-xs font-bold rounded-lg border border-primary/20 transition-all shadow-sm">
                                            <span class="material-symbols-outlined text-[15px]">campaign</span>
                                            <span>Call &amp; Verify</span>
                                        </a>

                                        <!-- Pure CSS Modal (Walay JavaScript) -->
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
                                                    <!-- Close button gamit ang anchor '#' -->
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
                                                    <!-- Cancel / Close button -->
                                                    <a href="#" class="px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-xl transition-colors inline-flex items-center">
                                                        Cancel
                                                    </a>

                                                    <!-- Standard Laravel Form Submission -->
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

        <!-- Section 5: Bottom Collapsed Patient Lookup -->
        <div class="fixed bottom-0 left-72 right-0 p-4 z-10 pointer-events-none">
            <div class="max-w-[1200px] mx-auto pointer-events-auto">
                <div class="bg-white/95 backdrop-blur-md rounded-t-2xl shadow-[0_-10px_30px_rgba(0,0,0,0.1)] border-x border-t border-outline-variant/20">
                    <!-- [CHANGED]: Converted to functional GET search form -->
                    <form action="{{ route('staff.dashboard') }}" method="GET" class="flex items-center justify-between px-8 py-4">
                        <div class="flex items-center gap-4">
                            <span class="material-symbols-outlined text-primary" data-icon="person_search">person_search</span>
                            <span class="text-sm font-bold text-on-surface uppercase tracking-wider">Quick Patient Lookup</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex bg-surface-container-low rounded-full px-4 py-1.5 border border-outline-variant/20 focus-within:ring-2 focus-within:ring-primary/20 transition-all">
                                <input name="search" value="{{ $search ?? '' }}" class="bg-transparent border-0 text-xs font-medium w-64 focus:ring-0 outline-none" placeholder="Search by name, ID or queue..." type="text" />
                                <button type="submit" class="text-primary hover:opacity-80">
                                    <span class="material-symbols-outlined text-sm text-on-surface-variant" data-icon="search">search</span>
                                </button>
                            </div>
                            <a href="{{ route('staff.patient-lookup') }}" class="p-2 hover:bg-surface-container-high rounded-full transition-colors text-slate-500" title="Go to Patient Lookup">
                                <span class="material-symbols-outlined" data-icon="open_in_new">open_in_new</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>