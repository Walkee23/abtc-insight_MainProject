<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Clinical Encoding Wizard - Section VII | ABTC-Insight</title>
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

<body class="bg-surface text-on-surface selection:bg-primary-container selection:text-on-primary-container">
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
                        <h2 class="text-lg font-bold tracking-tight text-on-surface leading-tight">Pending Encoding<br>Queue</h2>
                        <span class="px-2.5 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full whitespace-nowrap shrink-0">{{ $queue->count() }} Active</span>
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
                        <p id="queueNoMatch" class="hidden text-sm text-on-surface-variant text-center py-8">No cases match your filter.</p>
                    </div>
                </div>
            </section>
            <section class="w-2/3 min-w-0 flex flex-col gap-6">
                @if(session('status'))
                {{-- Toast: fixed bottom-right (below the form card, so it never overlaps the footer buttons), auto-dismisses after 4s --}}
                <div id="statusToast" role="status"
                    class="fixed bottom-6 right-8 z-50 max-w-sm flex items-center gap-3 bg-emerald-50 text-emerald-700 text-sm font-semibold pl-4 pr-2 py-3 rounded-lg shadow-lg shadow-blue-900/10 border border-emerald-200 transition-opacity duration-300">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    <span class="flex-1">{{ session('status') }}</span>
                    <button type="button" id="statusToastClose" aria-label="Dismiss"
                        class="w-7 h-7 flex items-center justify-center rounded-full hover:bg-emerald-100 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
                @endif
                <div
                    class="bg-surface-container-lowest rounded-xl shadow-lg shadow-blue-900/5 overflow-hidden border border-outline-variant/10 flex flex-col h-[calc(100vh-12rem)]">
                    @if($case)
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
                        <div class="px-8 pb-4">
                            <div class="flex items-center w-full">
                                <!-- Step 1 (Completed) -->
                                <div class="flex flex-col items-center flex-1 relative group">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center text-xs font-bold z-10">
                                        <span class="material-symbols-outlined text-[16px]"
                                            style="font-variation-settings: 'wght' 700;">check</span>
                                    </div>
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
                    <!-- Wizard Body (Section VII) -->
                    <div class="flex-1 p-8 overflow-y-auto">
                    <form id="section7Form" method="POST"
                        action="{{ route('healthworker.ce-vii', ['bite_case_id' => $case->bite_case_id]) }}">
                        @csrf
                        <input type="hidden" name="action" id="formActionInput" value="next" />
                        @php $val = fn ($key, $default = '') => old($key, $section->$key ?? $default); @endphp
                        @php
                            $dropdown = function ($name, $options, $bg = 'bg-surface-container-low', $fit = false) use ($val, $errors) {
                                $current = (string) $val($name);
                                $currentLabel = $options[$current] ?? null;
                                $html = '<div class="relative" data-dd>'
                                    . '<input type="hidden" name="' . e($name) . '" value="' . e($current) . '" data-field="' . e($name) . '" />'
                                    . '<button type="button" data-dd-trigger class="w-full flex items-center justify-between gap-2 ' . $bg . ' rounded-lg py-3 px-4 text-left font-medium ring-1 ring-transparent focus:outline-none focus:ring-2 focus:ring-primary/30 transition-all">'
                                    . ($fit
                                        ? '<span class="grid"><span data-dd-label class="col-start-1 row-start-1 whitespace-nowrap ' . ($currentLabel ? 'text-on-surface' : 'text-outline') . '">' . e($currentLabel ?? 'Select') . '</span>'
                                            . '<span aria-hidden="true" class="col-start-1 row-start-1 invisible whitespace-nowrap">' . e(collect($options)->sortByDesc(fn ($l) => strlen($l))->first()) . '</span></span>'
                                        : '<span data-dd-label class="truncate ' . ($currentLabel ? 'text-on-surface' : 'text-outline') . '">' . e($currentLabel ?? 'Select') . '</span>')
                                    . '<span data-dd-chevron class="material-symbols-outlined text-outline text-[20px] transition-transform">expand_more</span>'
                                    . '</button>'
                                    . '<ul data-dd-menu class="hidden absolute left-0 min-w-full w-max top-full mt-2 z-30 bg-white rounded-xl border border-outline-variant/30 shadow-xl shadow-blue-900/10 p-1.5 max-h-60 overflow-y-auto">';
                                foreach ($options as $optValue => $optLabel) {
                                    $active = $current === (string) $optValue;
                                    $html .= '<li><button type="button" data-dd-option data-value="' . e($optValue) . '" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm text-left transition-colors hover:bg-primary-fixed/60 '
                                        . ($active ? 'bg-primary-fixed text-primary font-bold' : 'text-on-surface font-medium') . '">'
                                        . '<span class="whitespace-nowrap">' . e($optLabel) . '</span>'
                                        . '<span class="material-symbols-outlined text-[18px] text-primary shrink-0 ' . ($active ? '' : 'invisible') . '" style="font-variation-settings: \'wght\' 700;">' . 'check' . '</span>'
                                        . '</button></li>';
                                }
                                return $html . '</ul>'
                                    . '<p data-error-for="' . e($name) . '" class="mt-1 ml-1 text-xs font-semibold text-error ' . ($fit ? 'w-0 min-w-full ' : '') . ($errors->has($name) ? '' : 'hidden') . '">' . e($errors->first($name)) . '</p>'
                                    . '</div>';
                            };
                        @endphp
                        {{-- Toast: fixed bottom-right, auto-dismisses after 4s (same look as the draft-saved toast) --}}
                        <div id="formErrorBanner" role="alert"
                            class="{{ $errors->any() ? '' : 'hidden opacity-0' }} fixed bottom-6 right-8 z-50 max-w-sm flex items-center gap-3 bg-error-container text-on-error-container text-sm font-semibold pl-4 pr-2 py-3 rounded-lg shadow-lg shadow-blue-900/10 border border-error/20 transition-opacity duration-300">
                            <span class="material-symbols-outlined text-[18px]">error</span>
                            <span class="flex-1">Please fill in all required fields before continuing.</span>
                            <button type="button" id="formErrorToastClose" aria-label="Dismiss"
                                class="w-7 h-7 flex items-center justify-center rounded-full hover:bg-black/5 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">close</span>
                            </button>
                        </div>
                        <div class="step-content" id="step2">
                            <div class="flex items-center gap-3 mb-8">
                                <span
                                    class="w-8 h-8 rounded-lg bg-primary text-on-primary flex items-center justify-center font-bold text-sm">VII</span>
                                <h3 class="text-sm font-extrabold uppercase tracking-widest text-on-surface-variant">
                                    Immunization Schedule</h3>
                            </div>
                            <div class="grid grid-cols-[1fr_auto_auto] gap-6 mb-8">
                                <div>
                                    <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Vaccine Brand <span class="text-error">*</span></label>
                                    {!! $dropdown('vaccine_brand', ['VERORAB' => 'VERORAB (PVRV)', 'SPEEDA' => 'SPEEDA (PVRV)', 'VAXIRAB' => 'VAXIRAB (PCEC)']) !!}
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Route <span class="text-error">*</span></label>
                                    {!! $dropdown('route', ['ID' => 'ID (Intradermal, 0.1mL)', 'IM' => 'IM (Intramuscular, 0.5mL)'], 'bg-surface-container-low', true) !!}
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Dose Type <span class="text-error">*</span></label>
                                    {!! $dropdown('dose_type', ['Primary' => 'Primary', 'Booster' => 'Booster'], 'bg-surface-container-low', true) !!}
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-6 mb-8">
                                <div>
                                    <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Patient Weight (kg) <span class="text-error">*</span></label>
                                    <input name="patient_weight" data-field="patient_weight" type="number" step="0.01" min="0" max="999.99"
                                        value="{{ $val('patient_weight') }}"
                                        class="w-full bg-surface-container-low border-none rounded-lg py-3 px-4 ring-1 ring-transparent focus:ring-2 focus:ring-primary/20 font-medium"
                                        placeholder="e.g. 55.50" />
                                    <p data-error-for="patient_weight" class="mt-1 ml-1 text-xs font-semibold text-error {{ $errors->has('patient_weight') ? '' : 'hidden' }}">{{ $errors->first('patient_weight') }}</p>
                                    <p class="mt-1 ml-1 text-[10px] text-on-surface-variant/80 italic">Used for passive immunoglobulin dosage.</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Administered By <span class="text-error">*</span></label>
                                    <input name="administered_by" data-field="administered_by" type="text"
                                        value="{{ $val('administered_by') }}"
                                        class="w-full bg-surface-container-low border-none rounded-lg py-3 px-4 ring-1 ring-transparent focus:ring-2 focus:ring-primary/20 font-medium"
                                        placeholder="Name of attending health worker" />
                                    <p data-error-for="administered_by" class="mt-1 ml-1 text-xs font-semibold text-error {{ $errors->has('administered_by') ? '' : 'hidden' }}">{{ $errors->first('administered_by') }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">30-min Skin Test Due</label>
                                    <input name="skin_test_due" type="time"
                                        value="{{ $val('skin_test_due') }}"
                                        class="w-full bg-surface-container-low border-none rounded-lg py-3 px-4 focus:ring-2 focus:ring-primary/20 font-medium" />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-6 mb-8">
                                <div class="bg-surface-container-low rounded-xl p-5">
                                    <p class="text-xs font-extrabold text-outline uppercase tracking-widest mb-3">Tetanus
                                        Prophylaxis</p>
                                    <label class="flex items-center gap-2 cursor-pointer mb-3">
                                        <input name="tetanus_given" type="checkbox" value="1"
                                            {{ ($section->tetanus_given ?? false) ? 'checked' : '' }}
                                            class="rounded text-primary focus:ring-primary/20" />
                                        <span class="text-sm font-medium">Tetanus prophylaxis given</span>
                                    </label>
                                    <input name="tetanus_details" type="text"
                                        value="{{ $section->tetanus_details ?? '' }}"
                                        class="w-full bg-white border-none rounded-lg py-2.5 px-4 text-sm focus:ring-2 focus:ring-primary/20"
                                        placeholder="Details (vaccine, dose, date)..." />
                                </div>
                                <div class="bg-surface-container-low rounded-xl p-5">
                                    <p class="text-xs font-extrabold text-outline uppercase tracking-widest mb-3">Tetanus
                                        Immune Globulin (TIG)</p>
                                    <label class="flex items-center gap-2 cursor-pointer mb-3">
                                        <input name="tig_given" type="checkbox" value="1"
                                            {{ ($section->tig_given ?? false) ? 'checked' : '' }}
                                            class="rounded text-primary focus:ring-primary/20" />
                                        <span class="text-sm font-medium">TIG given</span>
                                    </label>
                                    <input name="tig_details" type="text" value="{{ $section->tig_details ?? '' }}"
                                        class="w-full bg-white border-none rounded-lg py-2.5 px-4 text-sm focus:ring-2 focus:ring-primary/20"
                                        placeholder="Details (dose, date)..." />
                                </div>
                            </div>
                            <div class="bg-surface-container-low rounded-xl p-6 mb-8">
                                <p class="text-xs font-extrabold text-outline uppercase tracking-widest mb-4">Passive
                                    Immunization (Rabies)</p>
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Type</label>
                                        <div class="flex items-center bg-white rounded-lg p-1">
                                            @php $passiveType = $val('passive_type'); @endphp
                                            <label class="flex-1">
                                                <input class="hidden peer" name="passive_type" type="radio" value="ERIG (EQUIRAB)" {{ $passiveType === 'ERIG (EQUIRAB)' ? 'checked' : '' }} />
                                                <span class="block py-2 text-center text-xs font-bold text-outline peer-checked:bg-primary peer-checked:text-white rounded-md cursor-pointer transition-all">ERIG</span>
                                            </label>
                                            <label class="flex-1">
                                                <input class="hidden peer" name="passive_type" type="radio" value="HRIG (BERIRAB)" {{ $passiveType === 'HRIG (BERIRAB)' ? 'checked' : '' }} />
                                                <span class="block py-2 text-center text-xs font-bold text-outline peer-checked:bg-primary peer-checked:text-white rounded-md cursor-pointer transition-all">HRIG</span>
                                            </label>
                                            <label class="flex-1">
                                                <input class="hidden peer" name="passive_type" type="radio" value="" {{ $passiveType === '' ? 'checked' : '' }} />
                                                <span class="block py-2 text-center text-xs font-bold text-outline peer-checked:bg-primary peer-checked:text-white rounded-md cursor-pointer transition-all">NO</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Route <span class="text-[10px] normal-case font-medium">(required if ERIG/HRIG)</span></label>
                                        {!! $dropdown('passive_route', ['IU infiltrate' => 'IU infiltrate', 'IM' => 'IM'], 'bg-white') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="bg-surface-container-low rounded-xl p-6">
                                <p class="text-xs font-extrabold text-outline uppercase tracking-widest mb-4">Dose
                                    Tracking Grid</p>
                                <div class="grid grid-cols-4 gap-4">
                                    <div data-field-wrap="day0_date" class="bg-white p-4 rounded-lg border border-primary/20 ring-1 ring-transparent">
                                        <p class="text-[10px] font-bold text-primary uppercase mb-1">Day 0 <span class="text-error">*</span></p>
                                        <input name="day0_date" data-field="day0_date" type="date" max="{{ now()->toDateString() }}" value="{{ $val('day0_date') }}"
                                            class="w-full text-[10px] font-bold text-on-surface bg-transparent border-none p-0 focus:ring-0" />
                                        <p data-error-for="day0_date" class="mt-1 text-xs font-semibold text-error {{ $errors->has('day0_date') ? '' : 'hidden' }}">{{ $errors->first('day0_date') }}</p>
                                    </div>
                                    <div data-field-wrap="day3_date" class="bg-white p-4 rounded-lg border border-outline-variant/30 ring-1 ring-transparent">
                                        <p class="text-[10px] font-bold text-outline uppercase mb-1">Day 3</p>
                                        <input name="day3_date" data-field="day3_date" type="date" max="{{ now()->toDateString() }}" value="{{ $val('day3_date') }}"
                                            class="w-full text-[10px] font-bold text-on-surface bg-transparent border-none p-0 focus:ring-0" />
                                        <p data-error-for="day3_date" class="mt-1 text-xs font-semibold text-error {{ $errors->has('day3_date') ? '' : 'hidden' }}">{{ $errors->first('day3_date') }}</p>
                                    </div>
                                    <div data-field-wrap="day7_date" class="bg-white p-4 rounded-lg border border-outline-variant/30 ring-1 ring-transparent">
                                        <p class="text-[10px] font-bold text-outline uppercase mb-1">Day 7</p>
                                        <input name="day7_date" data-field="day7_date" type="date" max="{{ now()->toDateString() }}" value="{{ $val('day7_date') }}"
                                            class="w-full text-[10px] font-bold text-on-surface bg-transparent border-none p-0 focus:ring-0" />
                                        <p data-error-for="day7_date" class="mt-1 text-xs font-semibold text-error {{ $errors->has('day7_date') ? '' : 'hidden' }}">{{ $errors->first('day7_date') }}</p>
                                    </div>
                                    <div data-field-wrap="day28_date" class="bg-white p-4 rounded-lg border border-outline-variant/30 ring-1 ring-transparent">
                                        <p class="text-[10px] font-bold text-outline uppercase mb-1">Day 28</p>
                                        <input name="day28_date" data-field="day28_date" type="date" max="{{ now()->toDateString() }}" value="{{ $val('day28_date') }}"
                                            class="w-full text-[10px] font-bold text-on-surface bg-transparent border-none p-0 focus:ring-0" />
                                        <p data-error-for="day28_date" class="mt-1 text-xs font-semibold text-error {{ $errors->has('day28_date') ? '' : 'hidden' }}">{{ $errors->first('day28_date') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                    <div
                        class="p-6 bg-surface-container-low border-t border-outline-variant/20 flex justify-between items-center px-8">
                        <button type="submit" form="section7Form" id="draftBtn"
                            class="px-6 py-2.5 text-sm font-bold text-outline hover:text-on-surface transition-all flex items-center gap-2">
                            Save as Draft
                        </button>
                        <div class="flex gap-4">
                            <button type="button"
                                class="px-8 py-2.5 text-sm font-bold text-outline hover:bg-slate-200/50 rounded-lg transition-all flex items-center gap-2"
                                onclick="window.location.href=`{{ route('healthworker.clinical-encoding', ['bite_case_id' => $case->bite_case_id]) }}`">
                                <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                                Back
                            </button>
                            <button type="button" id="nextBtn"
                                class="px-8 py-2.5 bg-primary text-on-primary text-sm font-bold rounded-lg shadow-md shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all flex items-center gap-2">
                                Next: Section VIII
                                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                            </button>
                        </div>
                    </div>
                    @else
                    <!-- No case selected -->
                    <div class="flex-1 flex flex-col items-center justify-center gap-3">
                        <span class="material-symbols-outlined text-5xl text-outline-variant">folder_open</span>
                        <p class="text-sm font-bold text-on-surface-variant">Please select a case.</p>
                    </div>
                    @endif
                </div>
            </section>
        </div>
    </main>
    <script>
        // The form and its buttons only exist in the DOM when a case is selected
        const nextBtn = document.getElementById('nextBtn');

        if (nextBtn) {
            const form = document.getElementById('section7Form');
            const draftBtn = document.getElementById('draftBtn');
            const formActionInput = document.getElementById('formActionInput');
            const banner = document.getElementById('formErrorBanner');
            // Required-fields toast: closes on the X button or by itself after 4 seconds
            const errorToast = (() => {
                let timer;
                const hide = () => {
                    clearTimeout(timer);
                    banner.classList.add('opacity-0');
                    setTimeout(() => {
                        if (banner.classList.contains('opacity-0')) banner.classList.add('hidden');
                    }, 300);
                };
                const show = () => {
                    clearTimeout(timer);
                    banner.classList.remove('hidden');
                    void banner.offsetWidth; // let the fade-in transition run
                    banner.classList.remove('opacity-0');
                    timer = setTimeout(hide, 4000);
                };
                document.getElementById('formErrorToastClose').addEventListener('click', hide);
                if (!banner.classList.contains('hidden')) show(); // errors rendered by the server
                return { show, hide };
            })();

            // Required to move on to Section VIII. Drafts skip these.
            const REQUIRED = {
                vaccine_brand: 'Please select a vaccine brand.',
                route: 'Please select a route.',
                dose_type: 'Please select a dose type.',
                patient_weight: 'Please enter the patient weight.',
                administered_by: 'Please enter who administered the dose.',
                day0_date: 'Please set the Day 0 date.',
            };
            const DATE_FIELDS = ['day0_date', 'day3_date', 'day7_date', 'day28_date'];
            const ALL_CHECKED = Object.keys(REQUIRED).concat(['passive_route', 'day3_date', 'day7_date', 'day28_date']);

            const field = (name) => form.querySelector(`[data-field="${name}"]`);
            const errorEl = (name) => form.querySelector(`[data-error-for="${name}"]`);
            // The element that gets the red ring: the dropdown trigger, the Day 0 card, or the input itself
            const ringEl = (name) => {
                const f = field(name);
                return f.type === 'hidden'
                    ? f.closest('[data-dd]').querySelector('[data-dd-trigger]')
                    : (f.closest('[data-field-wrap]') || f);
            };

            function setError(name, message) {
                const ring = ringEl(name);
                const el = errorEl(name);
                ring.classList.toggle('ring-2', !!message);
                ring.classList.toggle('ring-error', !!message);
                ring.classList.toggle('ring-transparent', !message);
                if (el) {
                    if (message) el.textContent = message;
                    el.classList.toggle('hidden', !message);
                }
            }

            // Local date as YYYY-MM-DD, comparable with <input type="date"> values
            const todayStr = (() => {
                const d = new Date();
                return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
            })();

            // names = fields that must be filled in; the future-date check always runs
            function validate(names) {
                let firstBad = null;
                ALL_CHECKED.forEach((name) => {
                    let message = '';
                    const value = field(name).value.trim();
                    if (names.includes(name)) {
                        if (name === 'passive_route') {
                            const passive = form.querySelector('input[name="passive_type"]:checked');
                            if (passive && passive.value !== '' && value === '') {
                                message = 'Please select a route for the passive immunization.';
                            }
                        } else if (name in REQUIRED && value === '') {
                            message = REQUIRED[name];
                        }
                    }
                    if (!message && DATE_FIELDS.includes(name) && value > todayStr) {
                        message = 'Date cannot be in the future.';
                    }
                    setError(name, message);
                    if (message && !firstBad) firstBad = name;
                });
                if (firstBad) errorToast.show(); else errorToast.hide();
                if (firstBad) ringEl(firstBad).scrollIntoView({ behavior: 'smooth', block: 'center' });
                return !firstBad;
            }

            // Clear a field's error as soon as the user fixes it
            function clearIfFilled(name) {
                const f = field(name);
                const stillFuture = DATE_FIELDS.includes(name) && f && f.value > todayStr;
                if (f && f.value.trim() !== '' && !stillFuture) setError(name, '');
                if (!form.querySelector('[data-error-for]:not(.hidden)')) errorToast.hide();
            }
            form.querySelectorAll('input[data-field]').forEach((input) => {
                input.addEventListener('input', () => clearIfFilled(input.dataset.field));
                input.addEventListener('change', () => clearIfFilled(input.dataset.field));
            });
            form.querySelectorAll('input[name="passive_type"]').forEach((radio) => {
                radio.addEventListener('change', () => setError('passive_route', ''));
            });

            nextBtn.addEventListener('click', () => {
                formActionInput.value = 'next';
                if (validate(ALL_CHECKED)) form.submit();
            });

            if (draftBtn) {
                draftBtn.addEventListener('click', (e) => {
                    formActionInput.value = 'draft';
                    // A draft saves whatever is filled in, required or not
                    if (!validate([])) e.preventDefault();
                });
            }

            // Styled dropdowns
            const menus = form.querySelectorAll('[data-dd]');
            const closeAll = (except) => menus.forEach((dd) => {
                if (dd === except) return;
                dd.querySelector('[data-dd-menu]').classList.add('hidden');
                dd.querySelector('[data-dd-chevron]').classList.remove('rotate-180');
            });

            menus.forEach((dd) => {
                const trigger = dd.querySelector('[data-dd-trigger]');
                const menu = dd.querySelector('[data-dd-menu]');
                const chevron = dd.querySelector('[data-dd-chevron]');
                const input = dd.querySelector('input[type="hidden"]');
                const label = dd.querySelector('[data-dd-label]');

                trigger.addEventListener('click', () => {
                    closeAll(dd);
                    menu.classList.toggle('hidden');
                    chevron.classList.toggle('rotate-180');
                });

                dd.querySelectorAll('[data-dd-option]').forEach((opt) => {
                    opt.addEventListener('click', () => {
                        input.value = opt.dataset.value;
                        label.textContent = opt.querySelector('span').textContent;
                        label.classList.remove('text-outline');
                        label.classList.add('text-on-surface');
                        dd.querySelectorAll('[data-dd-option]').forEach((o) => {
                            const active = o === opt;
                            o.classList.toggle('bg-primary-fixed', active);
                            o.classList.toggle('text-primary', active);
                            o.classList.toggle('font-bold', active);
                            o.classList.toggle('text-on-surface', !active);
                            o.classList.toggle('font-medium', !active);
                            o.lastElementChild.classList.toggle('invisible', !active);
                        });
                        menu.classList.add('hidden');
                        chevron.classList.remove('rotate-180');
                        clearIfFilled(input.dataset.field);
                    });
                });
            });

            document.addEventListener('click', (e) => {
                if (!e.target.closest('[data-dd]')) closeAll(null);
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeAll(null);
            });

            // Re-apply red rings for errors rendered by the server
            form.querySelectorAll('[data-error-for]:not(.hidden)').forEach((el) => {
                setError(el.dataset.errorFor, el.textContent.trim());
            });
        }
</script>
    <script>
        // Draft-saved toast: closes on the X button or by itself after 4 seconds
        (function () {
            const toast = document.getElementById('statusToast');
            if (!toast) return;
            const dismiss = () => {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.remove(), 300);
            };
            document.getElementById('statusToastClose').addEventListener('click', dismiss);
            setTimeout(dismiss, 4000);
        })();
    </script>
    <script>
        // Queue filter: every word typed must match somewhere in the case card
        // (patient name, case no., category, status, incident date)
        (function () {
            const input = document.getElementById('queueFilterInput');
            const items = document.querySelectorAll('#queueList .queue-item');
            const noMatch = document.getElementById('queueNoMatch');
            if (!input) return;

            const KEY = 'ceQueueFilter';
            const apply = () => {
                const terms = input.value.toLowerCase().split(/\s+/).filter(Boolean);
                let shown = 0;
                items.forEach((item) => {
                    const text = item.textContent.toLowerCase().replace(/\s+/g, ' ');
                    const match = terms.every((t) => text.includes(t));
                    item.classList.toggle('hidden', !match);
                    if (match) shown++;
                });
                if (noMatch) noMatch.classList.toggle('hidden', shown > 0 || items.length === 0);
                try { sessionStorage.setItem(KEY, input.value); } catch (e) {}
            };

            input.addEventListener('input', apply);
            // Keep the filter when moving between sections / selecting a case
            try { input.value = sessionStorage.getItem(KEY) || ''; } catch (e) {}
            apply();
        })();
    </script>
</body>

</html>