<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Registration Successful - Cebu Health Portal</title>
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
    </style>
</head>

<body class="bg-surface text-on-surface min-h-screen flex flex-col items-center">
    <!-- TopNavBar (matches Patient Portal style) -->
    <nav
        class="fixed top-0 w-full z-50 bg-slate-50/85 backdrop-blur-md shadow-sm shadow-blue-900/5 transition-all duration-300 ease-in-out font-sans antialiased tracking-tight">
        <div class="flex justify-between items-center px-8 py-4 max-w-full mx-auto">
            <!-- Brand -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity cursor-pointer">
                <div class="w-8 h-8 clinical-gradient rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-sm"
                        style="font-variation-settings: 'FILL' 1;">health_metrics</span>
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
                    <button type="button"
                        class="bg-primary text-on-primary px-5 py-2 rounded-full font-semibold active:scale-95 transition-transform"
                        onclick="window.location.href=`{{ route('login') }}`;">
                        Login
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <main class="flex-grow w-full max-w-4xl px-6 py-12 flex flex-col">
        <div class="mb-8 self-start">
            <a class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors group"
                href="{{ route('patient.register') }}">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span class="text-sm font-medium tracking-wide">Back to selection</span>
            </a>
        </div>
        <div class="flex-grow flex items-center justify-center">
            <div
                class="bg-surface-container-lowest rounded-lg p-10 md:p-16 w-full max-w-xl tonal-elevation text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1.5 clinical-gradient"></div>
                <div
                    class="mb-10 inline-flex items-center justify-center w-20 h-20 rounded-full bg-secondary-fixed text-primary-container">
                    <span class="material-symbols-outlined text-4xl"
                        style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-on-surface mb-2">Registration Successful</h1>
                <p class="text-on-surface-variant text-sm font-medium uppercase tracking-widest mb-12">Normal Priority
                    Queue</p>
                <div class="relative inline-block mb-12">
                    <div class="bg-surface-container-low rounded-xl px-12 py-8 relative z-10">
                        <span
                            class="block text-7xl md:text-8xl font-black text-primary tracking-tighter">{{ $queueNumber ?? 'N--' }}</span>
                    </div>
                    <div class="absolute inset-0 bg-primary/5 blur-2xl rounded-full scale-110"></div>
                </div>
                <div class="space-y-6 max-w-sm mx-auto">
                    <p class="text-on-surface leading-relaxed font-medium">
                        Please wait for your number to be called at the triage station.
                    </p>
                    <p
                        class="text-primary font-semibold mt-6 px-4 py-3 bg-primary/5 rounded-lg border border-primary/10">
                        Please take a screenshot of this page to save your queue number for verification.
                    </p>
                </div>
            </div>
        </div>
    </main>
    <footer class="w-full py-8 mt-auto bg-surface-container-low">
        <div class="flex flex-col md:flex-row justify-between items-center px-12 w-full max-w-screen-2xl mx-auto gap-4">
            <div class="text-xs font-medium uppercase tracking-widest font-['Inter'] text-on-surface-variant">
                © 2024 CEBU CITY HEALTH CENTER. CLINICAL PRECISION SYSTEM.
            </div>
            <div class="flex gap-8">
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