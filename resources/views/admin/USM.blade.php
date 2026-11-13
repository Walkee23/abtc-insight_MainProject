<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>ABTC-Insight | User &amp; System Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface-container-low": "#f2f4f6",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-high": "#e6e8ea",
                        "primary": "#004a93",
                        "primary-container": "#0b61bb",
                        "on-surface": "#191c1e",
                        "on-surface-variant": "#414751",
                        "outline-variant": "#c1c7d3",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                    },
                    fontFamily: {
                        "body": ["Inter", "sans-serif"]
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
    </style>
</head>
<body class="bg-[#f7f9fb] text-on-surface min-h-screen flex">

    <!-- Sidebar Navigation -->
    <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-50 dark:bg-slate-900 flex flex-col border-r border-slate-200/50 dark:border-slate-800/50 z-50">
        <div class="px-6 py-8">
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-primary rounded-[1rem] flex items-center justify-center">
                    <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                </div>
                <div>
                    <h1 class="font-black uppercase text-primary dark:text-blue-100 text-sm tracking-wider leading-none">ABTC-Insight</h1>
                </div>
            </div>
            <nav class="space-y-1">
                <a class="flex items-center gap-3 px-4 py-3 rounded-[1rem] text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.dashboard') }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="font-['Inter'] text-sm tracking-wide">Main Overview</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-[1rem] text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.analytics') }}">
                    <span class="material-symbols-outlined">analytics</span>
                    <span class="font-['Inter'] text-sm tracking-wide">Analytics</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-[1rem] text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.compliance') }}">
                    <span class="material-symbols-outlined">security</span>
                    <span class="font-['Inter'] text-sm tracking-wide">PEP Compliance & SMS Logs</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-[1rem] text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.forecasting') }}">
                    <span class="material-symbols-outlined">query_stats</span>
                    <span class="font-['Inter'] text-sm tracking-wide">Forecasting & Outbreak Detection</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-[1rem] text-blue-700 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600 translate-x-1 duration-150" href="{{ route('admin.usm') }}">
                    <span class="material-symbols-outlined">manage_accounts</span>
                    <span class="font-['Inter'] text-sm tracking-wide">User & System Management</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-[1rem] text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.gis_map') }}">
                    <span class="material-symbols-outlined">map</span>
                    <span class="font-['Inter'] text-sm tracking-wide">Spatial Map</span>
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content Area -->
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
        <div class="p-8 lg:p-10 space-y-8 max-w-7xl mx-auto w-full">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold tracking-tight text-on-surface">System Governance</h2>
                <p class="text-on-surface-variant text-sm mt-1">Manage institutional access, security protocols, and operational database integrity.</p>
            </div>
            @if(session('success'))
                <div class="px-4 py-2.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold rounded-xl flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
        </div>

        <!-- Bento Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Left Side: Role Stats & User List -->
            <section class="lg:col-span-8 flex flex-col gap-4">
                
                <!-- 3 Bento Counter Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-3xl font-black text-slate-900 block">{{ $healthWorkersCount ?? 0 }}</span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Health Workers</span>
                        </div>
                        <span class="material-symbols-outlined text-blue-700 text-3xl opacity-80">medical_services</span>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-3xl font-black text-slate-900 block">{{ $internsCount ?? 0 }}</span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">OJT / Interns</span>
                        </div>
                        <span class="material-symbols-outlined text-blue-700 text-3xl opacity-80">school</span>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-3xl font-black text-slate-900 block">{{ $staffCount ?? 0 }}</span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Administrative Staff</span>
                        </div>
                        <span class="material-symbols-outlined text-blue-700 text-3xl opacity-80">badge</span>
                    </div>
                </div>

                <!-- Registered User Accounts Table/List -->
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm mt-2">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <span class="text-xs font-black text-slate-600 uppercase tracking-widest">Registered User Accounts</span>
                    </div>
                    <div class="divide-y divide-slate-100 max-h-96 overflow-y-auto">
                        @forelse($users ?? [] as $user)
                            @php
                                $displayName = $user->full_name ?? $user->username ?? 'User';
                                $initials = strtoupper(substr($displayName, 0, 2));
                            @endphp
                            <div class="flex items-center justify-between px-6 py-3.5 hover:bg-slate-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-700 font-bold flex items-center justify-center text-xs">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800">{{ $displayName }}</p>
                                        <p class="text-[11px] text-slate-400 font-medium">@<span>{{ $user->username ?? 'no-username' }}</span></p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if(!empty($user->barangay_assignment))
                                        <span class="text-[10px] font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
                                            Brgy. {{ $user->barangay_assignment }}
                                        </span>
                                    @endif
                                    <span class="px-2.5 py-1 bg-slate-100 text-[10px] font-bold rounded uppercase text-slate-600">
                                        {{ $user->role }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-xs text-slate-400">No users found.</div>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- Right Side: Control Panel with "Create a New User" Button -->
            <section class="lg:col-span-4 flex flex-col gap-4">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col gap-3">
                    
                    <!-- CREATE A NEW USER BUTTON -->
                    <button type="button" onclick="openUserModal()" 
                            class="w-full flex items-center justify-center gap-2 p-3.5 bg-blue-700 text-white rounded-xl font-bold text-sm transition-all hover:bg-blue-800 shadow-md shadow-blue-700/20 active:scale-95">
                        <span class="material-symbols-outlined text-[20px]">person_add</span>
                        <span>Create a New User</span>
                    </button>

                    <div class="h-px bg-slate-100 my-1"></div>

                    <!-- Manual Database Backup -->
                    <button type="button" id="btnBackup" class="w-full flex items-center gap-3 p-3.5 bg-slate-50 text-slate-700 rounded-xl font-bold text-sm transition-all hover:bg-slate-100">
                        <span class="material-symbols-outlined text-[20px] text-blue-700">cloud_upload</span>
                        <span>Manual Database Backup</span>
                    </button>

                    <!-- Configure Auto-Backup -->
                    <button type="button" id="btnAuto" class="w-full flex items-center gap-3 p-3.5 bg-slate-50 text-slate-700 rounded-xl font-bold text-sm transition-all hover:bg-slate-100">
                        <span class="material-symbols-outlined text-[20px] text-blue-700">schedule</span>
                        <span>Configure Auto-Backup</span>
                    </button>

                    <!-- System Audit Logs -->
                    <button type="button" id="btnAudit" class="w-full flex items-center gap-3 p-3.5 bg-slate-50 text-slate-700 rounded-xl font-bold text-sm transition-all hover:bg-slate-100">
                        <span class="material-symbols-outlined text-[20px] text-blue-700">history_edu</span>
                        <span>System Audit Logs</span>
                    </button>

                    <!-- Server Health Check -->
                    <button type="button" id="btnHealth" class="w-full flex items-center justify-between p-3.5 bg-slate-50 text-slate-700 rounded-xl font-bold text-sm transition-all hover:bg-slate-100">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px] text-blue-700">monitor_heart</span>
                            <span>Server Health Check</span>
                        </div>
                        <span id="healthIcon" class="material-symbols-outlined text-slate-300 text-[20px]" style="font-variation-settings: 'FILL' 1;">help</span>
                    </button>
                </div>
            </section>
        </div>

    </div>
    </main>

    <!-- Modals sit outside the content container: its space-y-8 margin would offset the fixed overlays -->
        <!-- ========================================================= -->
        <!-- POP-UP MODAL: CREATE NEW USER                             -->
        <!-- ========================================================= -->
        <div id="createUserModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
            <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in-95 duration-200">
                
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-700">person_add</span>
                        <h3 class="font-bold text-slate-900 text-sm">Create New System User</h3>
                    </div>
                    <button type="button" onclick="closeUserModal()" class="text-slate-400 hover:text-slate-600 rounded-lg p-1">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.store-user') }}" class="p-6 space-y-4">
                    @csrf
                    
                    <!-- Full Name -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Full Name</label>
                        <input type="text" name="full_name" required placeholder="e.g. Maria Santos, RN" 
                               class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-600 focus:ring-blue-600 py-2.5 px-3">
                    </div>

                    <!-- Username -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Username</label>
                        <input type="text" name="username" required placeholder="e.g. msantos" 
                               class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-600 focus:ring-blue-600 py-2.5 px-3">
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Role</label>
                        <select name="role" id="userRoleSelect" onchange="toggleBarangayField(this.value)" required 
                                class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-600 focus:ring-blue-600 py-2.5 pl-3 pr-9">
                            <option value="Staff">Staff</option>
                            <option value="Health Worker">Health Worker</option>
                            <option value="Admin">Admin</option>
                            <option value="BHW">BHW (Barangay Health Worker)</option>
                        </select>
                    </div>

                    <!-- Barangay Assignment (Only for BHW) -->
                    <div id="barangayFieldContainer" class="hidden">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Barangay Assignment</label>
                        <input type="text" name="barangay_assignment" placeholder="e.g. Guadalupe, Lahug" 
                               class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-600 focus:ring-blue-600 py-2.5 px-3">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Password</label>
                        <input type="password" name="password" required placeholder="Minimum 6 characters" 
                               class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-600 focus:ring-blue-600 py-2.5 px-3">
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                        <button type="button" onclick="closeUserModal()" 
                                class="px-4 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs rounded-xl shadow-md shadow-blue-700/20">
                            Save User
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- SYSTEM TOOLS: BACKUP / AUTO-BACKUP / AUDIT LOGS / HEALTH   -->
        <!-- ========================================================= -->
        <div id="toolToast" role="status" class="hidden fixed bottom-6 right-8 z-[70] max-w-sm flex items-center gap-3 text-sm font-semibold pl-4 pr-2 py-3 rounded-lg shadow-lg border transition-opacity duration-300">
            <span id="toolToastIcon" class="material-symbols-outlined text-[18px]">check_circle</span>
            <span id="toolToastText" class="flex-1"></span>
            <button type="button" id="toolToastClose" aria-label="Dismiss" class="w-7 h-7 flex items-center justify-center rounded-full hover:bg-black/5 transition-colors">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        <!-- Backup -->
        <div id="backupModal" data-modal class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
            <div class="bg-white rounded-2xl max-w-xl w-full shadow-2xl border border-slate-100 overflow-hidden max-h-[88vh] flex flex-col">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-700">cloud_upload</span>
                        <h3 class="font-bold text-slate-900 text-sm">Database Backup</h3>
                    </div>
                    <button type="button" data-close class="text-slate-400 hover:text-slate-600 rounded-lg p-1"><span class="material-symbols-outlined text-[20px]">close</span></button>
                </div>
                <div class="p-6 space-y-4 overflow-y-auto">
                    <p class="text-xs text-slate-500 leading-relaxed">A backup is a full copy of every table (as a .sql file) saved on the server. It includes all patient data and user password hashes, so keep downloaded files somewhere safe.</p>
                    <div id="backupList" class="space-y-2"></div>
                </div>
                <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" data-close class="px-4 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">Close</button>
                    <button type="button" id="runBackup" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs rounded-xl shadow-md shadow-blue-700/20 flex items-center gap-2 disabled:opacity-60 disabled:cursor-wait">
                        <span class="material-symbols-outlined text-[16px]">cloud_upload</span><span id="runBackupLabel">Back Up Now &amp; Download</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Auto-backup -->
        <div id="autoModal" data-modal class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
            <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden max-h-[88vh] flex flex-col">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-700">schedule</span>
                        <h3 class="font-bold text-slate-900 text-sm">Configure Auto-Backup</h3>
                    </div>
                    <button type="button" data-close class="text-slate-400 hover:text-slate-600 rounded-lg p-1"><span class="material-symbols-outlined text-[20px]">close</span></button>
                </div>
                <div class="p-6 space-y-4 overflow-y-auto">
                    <label class="flex items-center justify-between gap-3 p-3 bg-slate-50 rounded-xl cursor-pointer">
                        <span class="text-xs font-bold text-slate-700">Turn on automatic backups</span>
                        <input id="autoEnabled" type="checkbox" class="rounded text-blue-700 focus:ring-blue-600 w-5 h-5" />
                    </label>
                    <div id="autoFields" class="space-y-4">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Frequency</label>
                                <select id="autoFrequency" class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-600 focus:ring-blue-600 py-2.5 pl-3 pr-9">
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                </select>
                            </div>
                            <div id="autoDayBox" class="hidden">
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Day</label>
                                <select id="autoDay" class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-600 focus:ring-blue-600 py-2.5 pl-3 pr-9">
                                    <option value="0">Sunday</option><option value="1">Monday</option><option value="2">Tuesday</option><option value="3">Wednesday</option>
                                    <option value="4">Thursday</option><option value="5">Friday</option><option value="6">Saturday</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Time</label>
                                <input id="autoTime" type="time" class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-600 focus:ring-blue-600 py-2.5 px-3" />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Keep last</label>
                                <input id="autoKeep" type="number" min="1" max="60" class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-600 focus:ring-blue-600 py-2.5 px-3" />
                            </div>
                        </div>
                        <p class="text-[11px] text-slate-400">Times are Asia/Manila. Only automatic backups are removed once more than "Keep last" exist; manual backups are never deleted.</p>
                    </div>
                    <div class="text-xs space-y-1.5 bg-slate-50 rounded-xl p-3">
                        <div class="flex justify-between gap-3"><span class="text-slate-500">Next run</span><span id="autoNext" class="font-bold text-slate-700 text-right">-</span></div>
                        <div class="flex justify-between gap-3"><span class="text-slate-500">Last run</span><span id="autoLast" class="font-bold text-slate-700 text-right">-</span></div>
                        <div class="flex justify-between gap-3"><span class="text-slate-500">Last result</span><span id="autoStatus" class="font-bold text-slate-700 text-right">-</span></div>
                    </div>
                    <p class="text-[11px] text-slate-500 leading-relaxed">Backups run while the scheduler is running (<code class="bg-slate-100 px-1 rounded">php artisan schedule:work</code>). If it is not running, a due backup also runs the next time an Admin opens this page.</p>
                </div>
                <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" data-close class="px-4 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">Cancel</button>
                    <button type="button" id="saveAuto" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs rounded-xl shadow-md shadow-blue-700/20 disabled:opacity-60">Save Schedule</button>
                </div>
            </div>
        </div>

        <!-- Audit logs -->
        <div id="auditModal" data-modal class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
            <div class="bg-white rounded-2xl max-w-5xl w-full shadow-2xl border border-slate-100 overflow-hidden max-h-[90vh] flex flex-col">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-700">history_edu</span>
                        <h3 class="font-bold text-slate-900 text-sm">System Audit Logs</h3>
                    </div>
                    <button type="button" data-close class="text-slate-400 hover:text-slate-600 rounded-lg p-1"><span class="material-symbols-outlined text-[20px]">close</span></button>
                </div>
                <div class="px-6 pt-4 flex flex-wrap items-center gap-3">
                    <div class="flex items-center bg-slate-100 rounded-xl px-3 py-2 flex-1 min-w-[220px]">
                        <span class="material-symbols-outlined text-slate-400 text-[18px]">search</span>
                        <input id="auditSearch" type="text" placeholder="Search user, action, details or IP..." class="bg-transparent border-none focus:ring-0 text-xs w-full py-0" />
                    </div>
                    <select id="auditCategory" class="min-w-[170px] text-xs font-semibold text-slate-700 rounded-xl border-slate-200 focus:border-blue-600 focus:ring-blue-600 py-2.5 pl-3 pr-10 cursor-pointer">
                        <option value="">All activity</option>
                        <option value="auth">Sign-ins</option>
                        <option value="users">User accounts</option>
                        <option value="backup">Backups</option>
                        <option value="forecast">Forecasts</option>
                    </select>
                    <a id="auditExport" href="#" class="px-4 py-2 text-xs font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-xl flex items-center gap-1.5 transition-colors">
                        <span class="material-symbols-outlined text-[16px]">download</span> Export CSV
                    </a>
                </div>
                <div class="px-6 py-4 overflow-y-auto flex-1">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] uppercase tracking-widest text-slate-400 font-bold border-b border-slate-100">
                                <th class="pb-3 pr-4 whitespace-nowrap">Time</th>
                                <th class="pb-3 pr-4">User</th>
                                <th class="pb-3 pr-4 whitespace-nowrap">Action</th>
                                <th class="pb-3 pr-4">Details</th>
                                <th class="pb-3 whitespace-nowrap">IP</th>
                            </tr>
                        </thead>
                        <tbody id="auditBody" class="divide-y divide-slate-50"></tbody>
                    </table>
                </div>
                <div class="px-6 py-3 border-t border-slate-100 flex items-center justify-between">
                    <p id="auditInfo" class="text-[11px] text-slate-500"></p>
                    <div class="flex items-center gap-2">
                        <button type="button" id="auditPrev" class="p-1.5 rounded-lg bg-slate-100 text-slate-500 hover:bg-slate-200 disabled:opacity-40 disabled:cursor-not-allowed"><span class="material-symbols-outlined text-[18px]">chevron_left</span></button>
                        <span id="auditPage" class="text-xs font-bold text-slate-600"></span>
                        <button type="button" id="auditNext" class="p-1.5 rounded-lg bg-slate-100 text-slate-500 hover:bg-slate-200 disabled:opacity-40 disabled:cursor-not-allowed"><span class="material-symbols-outlined text-[18px]">chevron_right</span></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Server health -->
        <div id="healthModal" data-modal class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
            <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden max-h-[88vh] flex flex-col">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-700">monitor_heart</span>
                        <h3 class="font-bold text-slate-900 text-sm">Server Health Check</h3>
                    </div>
                    <button type="button" data-close class="text-slate-400 hover:text-slate-600 rounded-lg p-1"><span class="material-symbols-outlined text-[20px]">close</span></button>
                </div>
                <div class="p-6 space-y-3 overflow-y-auto">
                    <div id="healthBanner" class="rounded-xl px-4 py-3 text-xs font-bold flex items-center gap-2 bg-slate-100 text-slate-600">Checking...</div>
                    <div id="healthList" class="space-y-1"></div>
                    <p id="healthTime" class="text-[11px] text-slate-400"></p>
                </div>
                <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" data-close class="px-4 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">Close</button>
                    <button type="button" id="rerunHealth" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs rounded-xl shadow-md shadow-blue-700/20 flex items-center gap-2 disabled:opacity-60">
                        <span class="material-symbols-outlined text-[16px]">refresh</span> Run Again
                    </button>
                </div>
            </div>
        </div>


    <!-- Pop-up Modal Script -->
    <script>
        function openUserModal() {
            document.getElementById('createUserModal').classList.remove('hidden');
        }

        function closeUserModal() {
            document.getElementById('createUserModal').classList.add('hidden');
        }

        function toggleBarangayField(role) {
            const bgyContainer = document.getElementById('barangayFieldContainer');
            if (role === 'BHW') {
                bgyContainer.classList.remove('hidden');
            } else {
                bgyContainer.classList.add('hidden');
            }
        }
    </script>
    <!-- System tools: backup, auto-backup, audit logs, health check -->
    <script>
        (function () {
            const URLS = {
                backups: @json(route('admin.system.backups')),
                auto: @json(route('admin.system.auto-backup')),
                audit: @json(route('admin.system.audit-logs')),
                auditExport: @json(route('admin.system.audit-logs.export')),
                health: @json(route('admin.system.health')),
            };
            const CSRF = @json(csrf_token());
            const $ = (id) => document.getElementById(id);

            // ---------------------------------------------------------- helpers
            async function api(url, options = {}) {
                const res = await fetch(url, {
                    ...options,
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest', ...(options.headers || {}) },
                });
                let data = {};
                try { data = await res.json(); } catch (e) { /* not JSON */ }
                if (!res.ok) {
                    const errors = data.errors ? Object.values(data.errors).flat().join(' ') : '';
                    throw new Error(errors || data.message || ('Request failed (' + res.status + ')'));
                }
                return data;
            }

            let toastTimer;
            function toast(message, ok = true) {
                const el = $('toolToast');
                el.className = 'fixed bottom-6 right-8 z-[70] max-w-sm flex items-center gap-3 text-sm font-semibold pl-4 pr-2 py-3 rounded-lg shadow-lg border transition-opacity duration-300 ' +
                    (ok ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-700 border-red-200');
                $('toolToastIcon').textContent = ok ? 'check_circle' : 'error';
                $('toolToastText').textContent = message;
                clearTimeout(toastTimer);
                toastTimer = setTimeout(() => el.classList.add('hidden'), 4000);
            }
            $('toolToastClose').addEventListener('click', () => $('toolToast').classList.add('hidden'));

            const modals = document.querySelectorAll('[data-modal]');
            const openModal = (id) => $(id).classList.remove('hidden');
            const closeModals = () => modals.forEach((m) => m.classList.add('hidden'));
            modals.forEach((m) => {
                m.addEventListener('click', (e) => { if (e.target === m) closeModals(); });
                m.querySelectorAll('[data-close]').forEach((b) => b.addEventListener('click', closeModals));
            });
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModals(); });

            const el = (tag, cls, text) => {
                const node = document.createElement(tag);
                if (cls) node.className = cls;
                if (text !== undefined) node.textContent = text;
                return node;
            };

            // ----------------------------------------------------------- backups
            function renderBackups(backups) {
                const list = $('backupList');
                list.replaceChildren();
                if (!backups.length) {
                    list.append(el('p', 'text-xs text-slate-400 text-center py-6', 'No backups yet. Use "Back Up Now" to create the first one.'));
                    return;
                }
                backups.forEach((b) => {
                    const row = el('div', 'flex items-center justify-between gap-3 bg-slate-50 rounded-xl px-4 py-3');
                    const info = el('div', 'min-w-0');
                    const name = el('p', 'text-xs font-bold text-slate-800 truncate', b.name);
                    const meta = el('p', 'text-[11px] text-slate-500', b.modified + ' · ' + b.size);
                    info.append(name, meta);
                    const side = el('div', 'flex items-center gap-2 shrink-0');
                    side.append(el('span', 'px-2 py-0.5 rounded text-[10px] font-bold uppercase ' + (b.type === 'auto' ? 'bg-violet-100 text-violet-700' : 'bg-blue-100 text-blue-700'), b.type));
                    const dl = el('a', 'p-1.5 rounded-lg text-blue-700 hover:bg-blue-50');
                    dl.href = b.download; dl.title = 'Download';
                    dl.append(el('span', 'material-symbols-outlined text-[18px]', 'download'));
                    const del = el('button', 'p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50');
                    del.type = 'button'; del.title = 'Delete';
                    del.append(el('span', 'material-symbols-outlined text-[18px]', 'delete'));
                    let armed = false, timer;
                    del.addEventListener('click', async () => {
                        if (!armed) {
                            armed = true;
                            del.className = 'px-2 py-1 rounded-lg text-[10px] font-bold text-white bg-red-600';
                            del.textContent = 'Sure?';
                            timer = setTimeout(() => { renderBackups(backups); }, 3000);
                            return;
                        }
                        clearTimeout(timer);
                        try {
                            const data = await api(b.download, { method: 'DELETE' });
                            renderBackups(data.backups);
                            toast(data.message);
                        } catch (e) { toast(e.message, false); renderBackups(backups); }
                    });
                    side.append(dl, del);
                    row.append(info, side);
                    list.append(row);
                });
            }

            async function loadBackups() {
                $('backupList').replaceChildren(el('p', 'text-xs text-slate-400 text-center py-6', 'Loading...'));
                try { renderBackups((await api(URLS.backups)).backups); }
                catch (e) { $('backupList').replaceChildren(el('p', 'text-xs text-red-600 text-center py-6', e.message)); }
            }

            $('btnBackup').addEventListener('click', () => { openModal('backupModal'); loadBackups(); });
            $('runBackup').addEventListener('click', async () => {
                const btn = $('runBackup');
                btn.disabled = true;
                $('runBackupLabel').textContent = 'Backing up...';
                try {
                    const data = await api(URLS.backups, { method: 'POST' });
                    renderBackups(data.backups);
                    toast(data.message);
                    window.location.href = data.download;   // start the download of the new file
                } catch (e) { toast(e.message, false); }
                btn.disabled = false;
                $('runBackupLabel').textContent = 'Back Up Now & Download';
            });

            // ------------------------------------------------------- auto-backup
            const toggleDay = () => $('autoDayBox').classList.toggle('hidden', $('autoFrequency').value !== 'weekly');
            const toggleFields = () => $('autoFields').classList.toggle('opacity-50', !$('autoEnabled').checked);
            $('autoFrequency').addEventListener('change', toggleDay);
            $('autoEnabled').addEventListener('change', toggleFields);

            function fillAuto(s) {
                $('autoEnabled').checked = s.enabled;
                $('autoFrequency').value = s.frequency;
                $('autoDay').value = s.day;
                $('autoTime').value = s.time;
                $('autoKeep').value = s.keep;
                $('autoNext').textContent = s.next_run || (s.enabled ? '-' : 'Off');
                $('autoLast').textContent = s.last_run || 'Never';
                $('autoStatus').textContent = s.last_status ? (s.last_status === 'ok' ? 'Success' : s.last_status) : '-';
                $('autoStatus').className = 'font-bold text-right ' + (s.last_status && s.last_status !== 'ok' ? 'text-red-600' : 'text-slate-700');
                toggleDay(); toggleFields();
            }

            $('btnAuto').addEventListener('click', async () => {
                openModal('autoModal');
                try { fillAuto(await api(URLS.auto)); } catch (e) { toast(e.message, false); }
            });
            $('saveAuto').addEventListener('click', async () => {
                const btn = $('saveAuto');
                btn.disabled = true;
                try {
                    const data = await api(URLS.auto, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            enabled: $('autoEnabled').checked,
                            frequency: $('autoFrequency').value,
                            day: Number($('autoDay').value),
                            time: $('autoTime').value,
                            keep: Number($('autoKeep').value),
                        }),
                    });
                    fillAuto(data);
                    toast(data.message);
                } catch (e) { toast(e.message, false); }
                btn.disabled = false;
            });

            // -------------------------------------------------------- audit logs
            const ACTIONS = {
                login: ['Sign-in', 'bg-emerald-100 text-emerald-700'],
                login_failed: ['Failed sign-in', 'bg-red-100 text-red-700'],
                logout: ['Sign-out', 'bg-slate-100 text-slate-600'],
                user_created: ['User created', 'bg-blue-100 text-blue-700'],
                backup_manual: ['Backup', 'bg-violet-100 text-violet-700'],
                backup_auto: ['Auto-backup', 'bg-violet-100 text-violet-700'],
                backup_failed: ['Backup failed', 'bg-red-100 text-red-700'],
                backup_deleted: ['Backup deleted', 'bg-amber-100 text-amber-700'],
                backup_downloaded: ['Backup download', 'bg-violet-100 text-violet-700'],
                backup_settings: ['Backup settings', 'bg-violet-100 text-violet-700'],
                forecast_saved: ['Forecast saved', 'bg-sky-100 text-sky-700'],
                case_discharged: ['Case discharged', 'bg-emerald-100 text-emerald-700'],
            };
            let auditPage = 1, auditLast = 1, searchTimer;

            const auditParams = () => {
                const p = new URLSearchParams();
                if ($('auditSearch').value.trim()) p.set('q', $('auditSearch').value.trim());
                if ($('auditCategory').value) p.set('category', $('auditCategory').value);
                return p;
            };

            async function loadAudit() {
                const p = auditParams();
                $('auditExport').href = URLS.auditExport + (p.toString() ? '?' + p : '');
                p.set('page', auditPage);
                const body = $('auditBody');
                try {
                    const data = await api(URLS.audit + '?' + p);
                    auditLast = data.last_page;
                    body.replaceChildren();
                    if (!data.logs.length) {
                        const tr = el('tr'); const td = el('td', 'py-10 text-center text-xs text-slate-400', 'No activity found.');
                        td.colSpan = 5; tr.append(td); body.append(tr);
                    }
                    data.logs.forEach((l) => {
                        const tr = el('tr', 'align-top');
                        const [label, cls] = ACTIONS[l.action] || [l.action, 'bg-slate-100 text-slate-600'];
                        const badge = el('span', 'px-2 py-0.5 rounded text-[10px] font-bold whitespace-nowrap ' + cls, label);
                        const actionTd = el('td', 'py-3 pr-4'); actionTd.append(badge);
                        tr.append(el('td', 'py-3 pr-4 text-[11px] text-slate-500 whitespace-nowrap', l.time), el('td', 'py-3 pr-4 text-xs font-bold text-slate-700', l.user), actionTd,
                                  el('td', 'py-3 pr-4 text-xs text-slate-600', l.description), el('td', 'py-3 text-[11px] text-slate-400 whitespace-nowrap', l.ip || '-'));
                        body.append(tr);
                    });
                    $('auditInfo').textContent = data.total + (data.total === 1 ? ' entry' : ' entries');
                    $('auditPage').textContent = data.page + ' / ' + data.last_page;
                    $('auditPrev').disabled = data.page <= 1;
                    $('auditNext').disabled = data.page >= data.last_page;
                } catch (e) {
                    body.replaceChildren();
                    const tr = el('tr'); const td = el('td', 'py-10 text-center text-xs text-red-600', e.message);
                    td.colSpan = 5; tr.append(td); body.append(tr);
                }
            }

            $('btnAudit').addEventListener('click', () => { openModal('auditModal'); auditPage = 1; loadAudit(); });
            $('auditCategory').addEventListener('change', () => { auditPage = 1; loadAudit(); });
            $('auditSearch').addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(() => { auditPage = 1; loadAudit(); }, 300); });
            $('auditPrev').addEventListener('click', () => { if (auditPage > 1) { auditPage--; loadAudit(); } });
            $('auditNext').addEventListener('click', () => { if (auditPage < auditLast) { auditPage++; loadAudit(); } });

            // ------------------------------------------------------ health check
            const HEALTH = {
                ok: ['check_circle', 'text-emerald-500', 'bg-emerald-50 text-emerald-700'],
                warn: ['warning', 'text-amber-500', 'bg-amber-50 text-amber-700'],
                fail: ['cancel', 'text-red-500', 'bg-red-50 text-red-700'],
            };
            function setHealthIcon(status) {
                const icon = $('healthIcon');
                if (!status) { icon.textContent = 'help'; icon.className = 'material-symbols-outlined text-slate-300 text-[20px]'; return; }
                icon.textContent = HEALTH[status][0];
                icon.className = 'material-symbols-outlined text-[20px] ' + HEALTH[status][1];
            }

            async function runHealth(silent) {
                const btn = $('rerunHealth');
                if (!silent) {
                    btn.disabled = true;
                    $('healthBanner').className = 'rounded-xl px-4 py-3 text-xs font-bold flex items-center gap-2 bg-slate-100 text-slate-600';
                    $('healthBanner').textContent = 'Checking...';
                }
                try {
                    const data = await api(URLS.health);
                    setHealthIcon(data.overall);
                    $('healthBanner').className = 'rounded-xl px-4 py-3 text-xs font-bold flex items-center gap-2 ' + HEALTH[data.overall][2];
                    $('healthBanner').replaceChildren(el('span', 'material-symbols-outlined text-[18px]', HEALTH[data.overall][0]), el('span', '', data.summary));
                    const list = $('healthList');
                    list.replaceChildren();
                    data.checks.forEach((c) => {
                        const row = el('div', 'flex items-start gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50');
                        row.append(el('span', 'material-symbols-outlined text-[20px] mt-0.5 ' + HEALTH[c.status][1], HEALTH[c.status][0]));
                        const text = el('div', 'min-w-0');
                        text.append(el('p', 'text-xs font-bold text-slate-800', c.name), el('p', 'text-[11px] text-slate-500 break-words', c.detail));
                        row.append(text);
                        list.append(row);
                    });
                    $('healthTime').textContent = 'Checked ' + data.checked_at + ' (Asia/Manila)';
                } catch (e) {
                    setHealthIcon(null);
                    if (!silent) { $('healthBanner').className = 'rounded-xl px-4 py-3 text-xs font-bold bg-red-50 text-red-700'; $('healthBanner').textContent = e.message; }
                }
                btn.disabled = false;
            }
            $('btnHealth').addEventListener('click', () => { openModal('healthModal'); runHealth(false); });
            $('rerunHealth').addEventListener('click', () => runHealth(false));
            runHealth(true);   // the card's icon reflects the current status when the page opens
        })();
    </script>
</body>
</html>