<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Clinical Encoding Wizard - Section VI | ABTC-Insight</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap"
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
            -webkit-font-smoothing: antialiased;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
    
    <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-100 dark:bg-slate-900 flex flex-col pt-6 pb-4 gap-2 z-50">
        <!-- Brand / Header Section -->
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

        <!-- Navigation sits right beneath it -->
        <nav class="space-y-1 px-4 dark:bg-slate-900">
            <!-- Dashboard (Inactive) -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
            href="{{ route('healthworker.dashboard') }}">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span class="font-['Inter'] text-sm tracking-wide">Dashboard</span>
            </a>

            <!-- Clinical Encoding (Active - Admin Style) -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-700 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600 translate-x-1 duration-150" 
            href="{{ route('healthworker.clinical-encoding') }}">
                <span class="material-symbols-outlined" data-icon="medical_services">medical_services</span>
                <span class="font-['Inter'] text-sm tracking-wide">Clinical Encoding</span>
            </a>

            <!-- Treatment Tracker -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
            href="{{ route('healthworker.treatment-tracker') }}">
                <span class="material-symbols-outlined" data-icon="monitor_heart">monitor_heart</span>
                <span class="font-['Inter'] text-sm tracking-wide">Treatment Tracker</span>
            </a>

            <!-- Patient Database -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
            href="{{ route('healthworker.patient-database') }}">
                <span class="material-symbols-outlined" data-icon="database">database</span>
                <span class="font-['Inter'] text-sm tracking-wide">Patient Database</span>
            </a>

            <!-- Compliance -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
            href="{{ route('healthworker.compliance') }}">
                <span class="material-symbols-outlined" data-icon="verified_user">verified_user</span>
                <span class="font-['Inter'] text-sm tracking-wide">Compliance</span>
            </a>
        </nav>
    </aside>

    <!-- TopNavBar -->
    <header
        class="fixed top-0 w-full h-16 bg-slate-50/85 dark:bg-slate-900/85 backdrop-blur-md shadow-sm shadow-blue-900/5 z-40">
        <div class="flex justify-between items-center px-8 h-16 w-full">
            <!-- Logo on the far left -->
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white shadow-md">
                    <span class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                </div>
                <h1 class="text-blue-900 dark:text-blue-50 font-bold text-sm tracking-tight leading-none">ABTC-Insight
                </h1>
            </div>
            <!-- Search Bar -->
            <div class="flex items-center flex-1 max-w-md ml-12">
                <div class="relative w-full group">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm group-focus-within:text-blue-700 transition-colors">search</span>
                    <input
                        class="w-full bg-slate-100 dark:bg-slate-800/50 border-none rounded-full py-2 pl-9 pr-4 text-xs focus:ring-2 focus:ring-blue-700/20 placeholder:text-slate-400 font-['Inter']"
                        placeholder="Search patient by name or ID..." type="text" />
                </div>
            </div>
            <!-- Right Side Actions (Notifications, Help, Vertical Divider, Profile) -->
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
        </div>
    </header>
    <main class="ml-64 pt-16 min-h-screen bg-surface">
        <div class="max-w-[1600px] mx-auto p-8 flex gap-8">
            <section class="w-1/3 flex flex-col gap-6">
                <div class="bg-surface-container-low rounded-xl p-6 flex flex-col h-[calc(100vh-12rem)]">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold tracking-tight text-on-surface">Pending Encoding Queue</h2>
                        <span class="px-2.5 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full">{{ $queue->count() }}
                            Active</span>
                    </div>
                    <div class="mb-4">
                        <div
                            class="flex items-center bg-white rounded-lg px-3 py-2 border border-outline-variant/20 focus-within:border-primary/40 transition-all">
                            <span class="material-symbols-outlined text-outline text-[18px]">filter_list</span>
                            <input class="bg-transparent border-none focus:ring-0 text-sm w-full py-0" id="queueFilterInput"
                                placeholder="Filter queue..." type="text" />
                        </div>
                    </div>
                    <div class="flex-1 overflow-y-auto space-y-3 pr-2" id="queueList">
                        @forelse($queue as $item)
                        <a href="{{ route('healthworker.clinical-encoding', ['bite_case_id' => $item->bite_case_id]) }}"
                            class="queue-item block {{ isset($case) && $case->bite_case_id === $item->bite_case_id ? 'bg-surface-container-lowest p-4 rounded-lg border-l-4 border-primary shadow-sm' : 'bg-surface-container-lowest/50 p-4 rounded-lg border border-transparent hover:border-outline-variant/30 transition-all' }}">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-bold {{ isset($case) && $case->bite_case_id === $item->bite_case_id ? 'text-primary' : 'text-outline' }} tracking-widest uppercase">CASE NO. {{ $item->case_number }}</span>
                                <span class="text-[10px] font-medium text-outline">{{ \Carbon\Carbon::parse($item->date_verified)->diffForHumans() }}</span>
                            </div>
                            <h3 class="font-bold text-on-surface">{{ $item->patient_name }}</h3>
                            <p class="text-xs text-on-surface-variant mb-3 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                Incident: {{ \Carbon\Carbon::parse($item->date_verified)->format('M d, Y') }}
                            </p>
                            <div class="flex gap-2">
                                <span
                                    class="px-2 py-0.5 bg-error-container text-on-error-container text-[10px] font-bold rounded-full"> CAT
                                    {{ $item->category }}</span>
                                <span
                                    class="px-2 py-0.5 {{ $item->encoding_status === 'Completed' ? 'bg-emerald-100 text-emerald-700' : ($item->encoding_status === 'In Progress' ? 'bg-secondary-container text-on-secondary-container' : 'bg-surface-container-high text-on-surface-variant') }} text-[10px] font-bold rounded-full">{{ $item->encoding_status }}</span>
                            </div>
                        </a>
                        @empty
                        <p class="text-sm text-on-surface-variant text-center py-8">No cases in the queue yet. Cases
                            appear here once Staff finishes Case Encoding.</p>
                        @endforelse
                    </div>
                </div>
            </section>
            <section class="w-2/3 flex flex-col gap-6">
                @if(session('status'))
                <div class="bg-emerald-50 text-emerald-700 text-sm font-semibold px-4 py-3 rounded-lg flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    {{ session('status') }}
                </div>
                @endif
                @if($case)
                <!-- Form Card -->
                <div
                    class="bg-surface-container-lowest rounded-xl shadow-lg shadow-blue-900/5 overflow-hidden border border-outline-variant/10 flex flex-col h-[calc(100vh-12rem)]">
                    <!-- Form Header & Step Indicator -->
                    <div class="bg-surface-container-low border-b border-outline-variant/20">
                        <div class="px-8 py-6 flex justify-between items-center">
                            <div>
                                <p class="text-[10px] font-bold text-primary tracking-widest uppercase mb-1">Active
                                    Encoding Session</p>
                                <h2 class="text-2xl font-extrabold tracking-tight text-on-surface">{{ $case->patient_name ?? 'No case selected' }}</h2>
                            </div>
                            <div class="flex gap-4">
                                <div class="text-right">
                                    <p class="text-[10px] font-semibold text-outline uppercase tracking-wider">Patient
                                        ID</p>
                                    <p class="text-sm font-bold">{{ $case->patient_id ?? '—' }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Horizontal Wizard Steps -->
                        <div class="px-8 pb-4">
                            <div class="flex items-center w-full">
                                <!-- Step 1 -->
                                <div class="flex flex-col items-center flex-1 relative group">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold z-10 shadow-lg shadow-primary/20">
                                        VI</div>
                                    <span class="text-[10px] font-bold text-primary mt-2 absolute -bottom-6 w-max">Wound
                                        Desc.</span>
                                </div>
                                <div class="flex-1 h-0.5 bg-primary/20 -mt-4"></div>
                                <!-- Step 2 -->
                                <div class="flex flex-col items-center flex-1 relative group">
                                    <div
                                        class="w-8 h-8 rounded-full bg-white border-2 border-outline-variant/50 text-outline flex items-center justify-center text-xs font-bold z-10">
                                        VII</div>
                                    <span
                                        class="text-[10px] font-bold text-outline mt-2 absolute -bottom-6 w-max opacity-0">Immunization</span>
                                </div>
                                <div class="flex-1 h-0.5 bg-slate-200 -mt-4"></div>
                                <!-- Step 3 -->
                                <div class="flex flex-col items-center flex-1 relative group">
                                    <div
                                        class="w-8 h-8 rounded-full bg-white border-2 border-outline-variant/50 text-outline flex items-center justify-center text-xs font-bold z-10">
                                        VIII</div>
                                    <span
                                        class="text-[10px] font-bold text-outline mt-2 absolute -bottom-6 w-max opacity-0">Remarks</span>
                                </div>
                                <div class="flex-1 h-0.5 bg-slate-200 -mt-4"></div>
                                <!-- Step 4 -->
                                <div class="flex flex-col items-center flex-1 relative group">
                                    <div
                                        class="w-8 h-8 rounded-full bg-white border-2 border-outline-variant/50 text-outline flex items-center justify-center text-xs font-bold z-10">
                                        IX</div>
                                    <span
                                        class="text-[10px] font-bold text-outline mt-2 absolute -bottom-6 w-max opacity-0">Progress</span>
                                </div>
                            </div>
                        </div>
                        <div class="h-6"></div> <!-- Spacer for absolute text labels -->
                    </div>
                    <!-- Wizard Body -->
                    <div class="flex-1 p-8 overflow-y-auto">
                        <form id="section6Form" method="POST"
                            action="{{ $case ? route('healthworker.clinical-encoding', ['bite_case_id' => $case->bite_case_id]) : '#' }}">
                            @csrf
                            <input type="hidden" name="action" id="formActionInput" value="next" />
                            <div id="formErrorBanner"
                                class="{{ $errors->any() ? '' : 'hidden' }} mb-6 bg-error-container text-on-error-container text-sm font-semibold px-4 py-3 rounded-lg flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">error</span>
                                <span>Please fill in all required fields (marked with *) before continuing.</span>
                            </div>
                        <div class="step-content active" id="step1">
                            <div class="flex items-center gap-3 mb-8">
                                <span
                                    class="w-8 h-8 rounded-lg bg-primary text-on-primary flex items-center justify-center font-bold text-sm">VI</span>
                                <h3 class="text-sm font-extrabold uppercase tracking-widest text-on-surface-variant">
                                    Wound Description &amp; Category</h3>
                            </div>
                            <div class="grid grid-cols-2 gap-8">
                                <div class="col-span-2">
                                    <label
                                        class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Site
                                        of Bite / Exposure <span class="text-error">*</span></label>
                                    <input id="siteOfBiteInput"
                                        class="w-full bg-surface-container-low border-none rounded-lg py-3.5 px-4 ring-1 ring-transparent focus:ring-2 focus:ring-primary/20 text-on-surface font-medium"
                                        name="site_of_bite" type="text" value="{{ old('site_of_bite', $section->site_of_bite ?? '') }}" />
                                    <p id="siteOfBiteError" class="mt-1 ml-1 text-xs font-semibold text-error {{ $errors->has('site_of_bite') ? '' : 'hidden' }}">{{ $errors->first('site_of_bite') }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-outline uppercase tracking-wider mb-4">Exposure
                                        Category <span class="text-error">*</span></label>
                                    <div class="flex gap-4">
                                        @php
                                            $selectedCategory = $section->category_of_exposure ?? $case->category ?? '';
                                        @endphp
                                        @foreach(['I', 'II', 'III'] as $cat)
                                        <label class="flex-1 cursor-pointer">
                                            <input {{ $selectedCategory === $cat ? 'checked' : '' }} class="hidden peer" name="category_of_exposure" type="radio" value="{{ $cat }}" {{ $case ? '' : 'disabled' }} />
                                            <div
                                                class="py-3 text-center rounded-lg border border-outline-variant/30 peer-checked:bg-primary-container/10 peer-checked:border-primary-container peer-checked:text-primary transition-all">
                                                <span class="text-sm font-bold">Cat {{ $cat }}</span>
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-outline uppercase tracking-wider mb-4">Total
                                        Number of Wounds <span class="text-error">*</span></label>
                                    <div class="flex gap-4">
                                        <label class="flex-1 cursor-pointer">
                                            <input {{ ($section->total_wounds ?? 'Single') === 'Single' ? 'checked' : '' }} class="hidden peer" name="total_wounds" type="radio" value="Single" />
                                            <div
                                                class="py-3 text-center rounded-lg border border-outline-variant/30 peer-checked:bg-primary-container/10 peer-checked:border-primary-container peer-checked:text-primary transition-all">
                                                <span class="text-sm font-bold">Single</span>
                                            </div>
                                        </label>
                                        <label class="flex-1 cursor-pointer">
                                            <input {{ ($section->total_wounds ?? '') === 'Multiple' ? 'checked' : '' }} class="hidden peer" name="total_wounds" type="radio" value="Multiple" />
                                            <div
                                                class="py-3 text-center rounded-lg border border-outline-variant/30 peer-checked:bg-primary-container/10 peer-checked:border-primary-container peer-checked:text-primary transition-all">
                                                <span class="text-sm font-bold">Multiple</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <!-- Wizard Footer Actions -->
                    <div
                        class="p-6 bg-surface-container-low border-t border-outline-variant/20 flex justify-between items-center px-8">
                        <button type="submit" form="section6Form" id="draftBtn" {{ $case ? '' : 'disabled' }}
                            class="px-6 py-2.5 text-sm font-bold text-outline hover:text-on-surface transition-all flex items-center gap-2 {{ $case ? '' : 'opacity-40 cursor-not-allowed' }}">
                            Save as Draft
                        </button>
                        <div class="flex gap-4">
                            <button
                                class="px-6 py-2.5 text-sm font-bold text-outline hover:bg-slate-200/50 rounded-lg transition-all hidden"
                                id="backBtn">
                                Back
                            </button>
                            <button {{ $case ? '' : 'disabled' }}
                                class="px-8 py-2.5 bg-primary text-on-primary text-sm font-bold rounded-lg shadow-md shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all flex items-center gap-2 {{ $case ? '' : 'opacity-40 cursor-not-allowed' }}"
                                id="nextBtn">
                                Next Step
                                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                            </button>
                        </div>
                    </div>
                </div>
                @else
                <!-- No case selected -->
                <div
                    class="bg-surface-container-lowest rounded-xl shadow-lg shadow-blue-900/5 border border-outline-variant/10 flex flex-col items-center justify-center h-[calc(100vh-12rem)] gap-3">
                    <span class="material-symbols-outlined text-5xl text-outline-variant">folder_open</span>
                    <p class="text-sm font-bold text-on-surface-variant">Please select a case.</p>
                </div>
                @endif
            </section>
        </div>
    </main>
    <!--
    <div
        class="fixed bottom-8 right-8 bg-surface-bright/90 backdrop-blur shadow-2xl rounded-2xl p-4 border border-outline-variant/15 w-64 hidden xl:block">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
            <p class="text-[10px] font-bold text-primary tracking-widest uppercase">System Status</p>
        </div>
        <p class="text-xs font-medium text-on-surface-variant leading-relaxed">
            Wizard Mode: Authorized for encoding levels VI-IX. Progression is tracked per section.
        </p>
    </div>
    -->
    <script>
        // Simple Wizard Logic for Demo Purposes
        // The whole form card (and these buttons) only exist in the DOM when
        // a case is selected, so none of this runs otherwise.
        const backBtn = document.getElementById('backBtn');

        if (backBtn) {
            let currentStep = 1;
            const totalSteps = 4;

            const nextBtn = document.getElementById('nextBtn');
            const finalizeBtn = document.getElementById('finalizeBtn');
            const draftBtn = document.getElementById('draftBtn');
            const formActionInput = document.getElementById('formActionInput');

            function updateWizard(step) {
                // Hide all steps
                document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
                // Show current
                document.getElementById(`step${step}`).classList.add('active');

                // Update Buttons
                if (step === 1) {
                    backBtn.classList.add('hidden');
                } else {
                    backBtn.classList.remove('hidden');
                }

                if (step === totalSteps) {
                    nextBtn.classList.add('hidden');
                    finalizeBtn.classList.remove('hidden');
                } else {
                    nextBtn.classList.remove('hidden');
                    finalizeBtn.classList.add('hidden');
                }

                // Logic for updating header indicators would go here in a real app
            }

            const siteInput = document.getElementById('siteOfBiteInput');
            const siteError = document.getElementById('siteOfBiteError');
            const banner = document.getElementById('formErrorBanner');

            function showSiteError(message) {
                siteError.textContent = message || siteError.textContent;
                siteError.classList.toggle('hidden', !message);
                siteInput.classList.toggle('ring-2', !!message);
                siteInput.classList.toggle('ring-error', !!message);
                siteInput.classList.toggle('ring-transparent', !message);
                banner.classList.toggle('hidden', !message);
            }

            // Re-apply the red ring for an error rendered by the server
            if (!siteError.classList.contains('hidden')) showSiteError(siteError.textContent.trim());
            siteInput.addEventListener('input', () => {
                if (siteInput.value.trim() !== '') showSiteError('');
            });

            nextBtn.addEventListener('click', () => {
                formActionInput.value = 'next';
                if (siteInput.value.trim() === '') {
                    showSiteError('Please enter the site of bite / exposure.');
                    siteInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return;
                }
                document.getElementById('section6Form').submit();
            });

            if (draftBtn) {
                draftBtn.addEventListener('click', () => {
                    formActionInput.value = 'draft';
                });
            }

            backBtn.addEventListener('click', () => {
                if (currentStep > 1) {
                    currentStep--;
                    updateWizard(currentStep);
                }
            });
        }
    </script>
</body>

</html>