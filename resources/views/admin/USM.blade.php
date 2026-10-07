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
    <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-50 dark:bg-slate-900 flex flex-col border-r border-slate-200/50 z-50">
        <div class="px-6 py-8">
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white shadow-md">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                </div>
                <h1 class="font-black uppercase text-primary text-sm tracking-wider">ABTC-Insight</h1>
            </div>
            <nav class="space-y-1 text-sm font-medium">
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-slate-100 transition-all" href="{{ route('admin.dashboard') }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Main Overview</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-slate-100 transition-all" href="{{ route('admin.analytics') }}">
                    <span class="material-symbols-outlined">analytics</span>
                    <span>Analytics</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-slate-100 transition-all" href="{{ route('admin.compliance') }}">
                    <span class="material-symbols-outlined">security</span>
                    <span>PEP Compliance &amp; SMS Logs</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-slate-100 transition-all" href="{{ route('admin.forecasting') }}">
                    <span class="material-symbols-outlined">query_stats</span>
                    <span>Forecasting &amp; Outbreak Detection</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-700 font-bold bg-blue-50 border-l-4 border-blue-600 translate-x-1" href="{{ route('admin.usm') }}">
                    <span class="material-symbols-outlined">manage_accounts</span>
                    <span>User &amp; System Management</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.gis_map') }}">
                    <span class="material-symbols-outlined">map</span>
                    <span class="text-sm tracking-wide">Spatial Map</span>
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="ml-64 flex-1 p-8 lg:p-10 space-y-8 max-w-7xl mx-auto w-full">
        
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
                    <button type="button" class="w-full flex items-center gap-3 p-3.5 bg-slate-50 text-slate-700 rounded-xl font-bold text-sm transition-all hover:bg-slate-100">
                        <span class="material-symbols-outlined text-[20px] text-blue-700">cloud_upload</span>
                        <span>Manual Database Backup</span>
                    </button>

                    <!-- Configure Auto-Backup -->
                    <button type="button" class="w-full flex items-center gap-3 p-3.5 bg-slate-50 text-slate-700 rounded-xl font-bold text-sm transition-all hover:bg-slate-100">
                        <span class="material-symbols-outlined text-[20px] text-blue-700">schedule</span>
                        <span>Configure Auto-Backup</span>
                    </button>

                    <!-- System Audit Logs -->
                    <button type="button" class="w-full flex items-center gap-3 p-3.5 bg-slate-50 text-slate-700 rounded-xl font-bold text-sm transition-all hover:bg-slate-100">
                        <span class="material-symbols-outlined text-[20px] text-blue-700">history_edu</span>
                        <span>System Audit Logs</span>
                    </button>

                    <!-- Server Health Check -->
                    <div class="w-full flex items-center justify-between p-3.5 bg-slate-50 text-slate-700 rounded-xl font-bold text-sm">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px] text-blue-700">monitor_heart</span>
                            <span>Server Health Check</span>
                        </div>
                        <span class="material-symbols-outlined text-emerald-500 text-[20px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    </div>
                </div>
            </section>
        </div>

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
                                class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-600 focus:ring-blue-600 py-2.5 px-3">
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

    </main>

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
</body>
</html>