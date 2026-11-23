<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Registration Successful - ABTC-Insight</title>
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
                        "tertiary": "#7a3800",
                        "surface-variant": "#e0e3e5",
                        "on-surface-variant": "#414751",
                        "on-secondary-fixed": "#011c38",
                        "surface-container": "#eceef0",
                        "on-tertiary-container": "#ffd7c0",
                        "tertiary-fixed": "#ffdbc8",
                        "primary-fixed-dim": "#a9c7ff",
                        "inverse-on-surface": "#eff1f3",
                        "on-secondary-fixed-variant": "#314866",
                        "on-primary-fixed-variant": "#00468c",
                        "secondary-fixed-dim": "#b1c8ec",
                        "secondary": "#49607f",
                        "background": "#f7f9fb",
                        "surface-dim": "#d8dadc",
                        "on-tertiary-fixed": "#311300",
                        "surface": "#f7f9fb",
                        "on-error": "#ffffff",
                        "on-primary-fixed": "#001b3d",
                        "on-tertiary": "#ffffff",
                        "secondary-fixed": "#d3e4ff",
                        "on-error-container": "#93000a",
                        "surface-bright": "#f7f9fb",
                        "on-primary-container": "#d0dfff",
                        "inverse-surface": "#2d3133",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary": "#ffffff",
                        "surface-container-low": "#f2f4f6",
                        "on-primary": "#ffffff",
                        "primary": "#004a93",
                        "primary-fixed": "#d6e3ff",
                        "on-background": "#191c1e",
                        "secondary-container": "#c1d9fd",
                        "error-container": "#ffdad6",
                        "surface-container-high": "#e6e8ea",
                        "outline-variant": "#c1c7d3",
                        "surface-container-highest": "#e0e3e5",
                        "on-tertiary-fixed-variant": "#743500",
                        "surface-tint": "#005db6",
                        "outline": "#717782",
                        "on-surface": "#191c1e",
                        "tertiary-container": "#9e4b00",
                        "on-secondary-container": "#485f7e",
                        "tertiary-fixed-dim": "#ffb689",
                        "error": "#ba1a1a",
                        "primary-container": "#0b61bb",
                        "inverse-primary": "#a9c7ff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "1rem",
                        "xl": "1.25rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Inter", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                        "label": ["Inter", "sans-serif"]
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
            vertical-align: middle;
        }

        .tonal-elevation {
            box-shadow: 0 24px 48px -12px rgba(25, 28, 30, 0.04);
        }

        .clinical-gradient {
            background: linear-gradient(135deg, #004a93 0%, #0b61bb 100%);
        }

        .priority-gradient {
            background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%);
        }

        /* the queue number "ticket": a dashed tear line with a notch on each side */
        .ticket-tear {
            position: relative;
            border-top: 2px dashed rgba(113, 119, 130, 0.35);
        }

        .ticket-tear::before,
        .ticket-tear::after {
            content: "";
            position: absolute;
            top: -11px;
            width: 20px;
            height: 20px;
            border-radius: 9999px;
            background: #f7f9fb;
        }

        .ticket-tear::before { left: -10px; }
        .ticket-tear::after { right: -10px; }

        @keyframes pop-in {
            0% { transform: scale(.6); opacity: 0; }
            70% { transform: scale(1.08); opacity: 1; }
            100% { transform: scale(1); }
        }

        .pop-in { animation: pop-in .5s ease-out both; }

        @media (prefers-reduced-motion: reduce) { .pop-in { animation: none; } }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    <script src="{{ asset('js/mobile-nav.js') }}" defer></script>
</head>

<body class="bg-surface text-on-surface min-h-screen flex flex-col items-center">
    @php
        // Priority queue numbers start with P (P1, P2...). The view can also be told directly.
        $isPriority = $isPriority ?? str_starts_with(strtoupper((string) ($queueNumber ?? '')), 'P');
        $queueNumber = $queueNumber ?? ($isPriority ? 'P--' : 'N--');
    @endphp

    <!-- TopNavBar (matches Patient Portal style) -->
    <nav
        class="fixed top-0 w-full z-50 bg-slate-50/85 backdrop-blur-md shadow-sm shadow-blue-900/5 transition-all duration-300 ease-in-out font-sans antialiased tracking-tight">
        <div class="flex justify-between items-center px-4 sm:px-8 py-4 max-w-full mx-auto">
            <!-- Brand -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity cursor-pointer">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-sm"
                        style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                </div>
                <span class="text-xl font-bold tracking-tighter text-blue-900">ABTC-Insight</span>
            </a>
            <!-- Links & Actions -->
            <div class="flex items-center gap-8">
                <div class="hidden md:flex items-center gap-8">
                    <a class="text-slate-600 hover:text-blue-600 transition-colors text-sm font-medium"
                        href="{{ route('patient.register') }}">Patient Registration</a>
                    <a class="text-slate-600 hover:text-blue-600 transition-colors text-sm font-medium"
                        href="{{ route('patient.tracking.portal') }}">Tracking Portal</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow w-full max-w-xl px-4 sm:px-6 pt-24 pb-10 flex flex-col">
        <div class="bg-surface-container-lowest rounded-2xl w-full tonal-elevation ring-1 ring-outline-variant/10 overflow-hidden">
            <div class="h-1.5 {{ $isPriority ? 'priority-gradient' : 'clinical-gradient' }}"></div>

            <!-- Success header -->
            <div class="px-6 sm:px-10 pt-8 pb-6 text-center">
                <div class="pop-in mx-auto mb-4 inline-flex items-center justify-center w-16 h-16 rounded-full {{ $isPriority ? 'bg-amber-100 text-amber-600' : 'bg-secondary-fixed text-primary-container' }}">
                    <span class="material-symbols-outlined text-[38px]"
                        style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-on-surface">Registration Successful</h1>
                <p class="text-on-surface-variant text-sm mt-1.5">You are now in the queue at the ABTC.</p>
            </div>

            <!-- Queue number ticket -->
            <div class="px-6 sm:px-10">
                <div class="rounded-2xl {{ $isPriority ? 'bg-amber-50 ring-1 ring-amber-200' : 'bg-primary/5 ring-1 ring-primary/10' }} text-center px-4 pt-6 pb-5">
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider px-3 py-1 rounded-full {{ $isPriority ? 'bg-amber-200 text-amber-900' : 'bg-secondary-container text-on-secondary-container' }}">
                        <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">{{ $isPriority ? 'accessible' : 'confirmation_number' }}</span>
                        {{ $isPriority ? 'Priority queue' : 'Normal priority queue' }}
                    </span>
                    <p class="mt-4 text-[11px] font-bold uppercase tracking-widest text-on-surface-variant">Your queue number</p>
                    <span id="queueNumber" class="block text-7xl sm:text-8xl font-black tracking-tighter leading-none mt-1 {{ $isPriority ? 'text-amber-700' : 'text-primary' }}">{{ $queueNumber }}</span>
                </div>

                @if (!empty($patientName) || !empty($registeredAt))
                    <div class="ticket-tear my-5 -mx-6 sm:-mx-10"></div>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                        @if (!empty($patientName))
                            <div class="min-w-0">
                                <dt class="text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Patient</dt>
                                <dd class="font-bold text-on-surface break-words">{{ $patientName }}</dd>
                            </div>
                        @endif
                        @if (!empty($registeredAt))
                            <div class="min-w-0">
                                <dt class="text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Registered</dt>
                                <dd class="font-bold text-on-surface">{{ $registeredAt }}</dd>
                            </div>
                        @endif
                    </dl>
                @endif
            </div>

            <!-- What happens next -->
            <div class="px-6 sm:px-10 pt-7">
                <h2 class="text-sm font-extrabold tracking-tight text-on-surface mb-3">What happens next</h2>
                <ol class="space-y-3">
                    <li class="flex items-start gap-3">
                        <span class="shrink-0 w-7 h-7 rounded-full bg-primary/10 text-primary text-xs font-extrabold flex items-center justify-center">1</span>
                        <p class="text-sm text-on-surface-variant leading-snug pt-0.5">Wait for your number to be called at the <span class="font-bold text-on-surface">triage station</span>.</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="shrink-0 w-7 h-7 rounded-full bg-primary/10 text-primary text-xs font-extrabold flex items-center justify-center">2</span>
                        <p class="text-sm text-on-surface-variant leading-snug pt-0.5">Show this queue number and your <span class="font-bold text-on-surface">valid ID</span> to the Information Staff for verification.</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="shrink-0 w-7 h-7 rounded-full bg-primary/10 text-primary text-xs font-extrabold flex items-center justify-center">3</span>
                        <p class="text-sm text-on-surface-variant leading-snug pt-0.5">After verification you will receive your <span class="font-bold text-on-surface">Patient ID</span> and be sent to the health worker for treatment.</p>
                    </li>
                </ol>
            </div>

            <!-- Screenshot tip + action -->
            <div class="px-6 sm:px-10 pt-6 pb-8">
                <div class="flex items-start gap-3 rounded-xl bg-surface-container-low px-4 py-3.5">
                    <span class="material-symbols-outlined text-primary text-[20px] shrink-0 mt-0.5">screenshot</span>
                    <p class="text-xs sm:text-[13px] text-on-surface-variant leading-relaxed">
                        <span class="font-bold text-on-surface">Take a screenshot of this page</span> to save your queue number. You will need it for verification.
                    </p>
                </div>
                <a href="{{ url('/') }}"
                    class="mt-5 w-full inline-flex items-center justify-center gap-2 rounded-full border border-outline-variant/50 text-on-surface-variant hover:text-primary hover:border-primary/40 hover:bg-primary/5 active:scale-95 transition-all px-6 py-3 text-sm font-bold">
                    <span class="material-symbols-outlined text-[18px]">home</span>
                    Back to home
                </a>
            </div>
        </div>
    </main>

    <footer class="w-full py-8 mt-auto bg-surface-container-low">
        <div class="flex flex-col md:flex-row justify-between items-center px-6 md:px-12 w-full max-w-screen-2xl mx-auto gap-4 text-center">
            <div class="text-xs font-medium uppercase tracking-widest font-['Inter'] text-on-surface-variant">
                &copy; 2024 CEBU CITY HEALTH CENTER. CLINICAL PRECISION SYSTEM.
            </div>
            <div class="flex flex-wrap justify-center gap-x-6 gap-y-2 md:gap-8">
                <a class="text-xs font-medium uppercase tracking-widest text-on-surface-variant hover:text-primary transition-colors"
                    href="#">PRIVACY POLICY</a>
                <a class="text-xs font-medium uppercase tracking-widest text-on-surface-variant hover:text-primary transition-colors"
                    href="#">TERMS OF SERVICE</a>
                <a class="text-xs font-medium uppercase tracking-widest text-on-surface-variant hover:text-primary transition-colors"
                    href="#">SUPPORT</a>
            </div>
        </div>
    </footer>
</body>

</html>
