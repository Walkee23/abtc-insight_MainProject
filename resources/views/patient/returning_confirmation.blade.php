<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Check-in Complete - ABTC-Insight</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#004a93",
                        "primary-container": "#0b61bb",
                        "secondary-fixed": "#d3e4ff",
                        surface: "#f7f9fb",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f2f4f6",
                        "on-surface": "#191c1e",
                        "on-surface-variant": "#414751"
                    },
                    fontFamily: { headline: ["Inter"], body: ["Inter"], label: ["Inter"] }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
        .clinical-gradient { background: linear-gradient(135deg, #004a93 0%, #0b61bb 100%); }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    <script src="{{ asset('js/mobile-nav.js') }}" defer></script>
</head>

<body class="bg-surface text-on-surface min-h-screen flex flex-col">
    <nav class="fixed top-0 w-full z-50 bg-slate-50/85 backdrop-blur-md shadow-sm shadow-blue-900/5 font-sans antialiased tracking-tight">
        <div class="flex justify-between items-center px-5 sm:px-8 py-4 max-w-full mx-auto">
            <a href="{{ url('/') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                </div>
                <span class="text-xl font-bold tracking-tighter text-blue-900">ABTC-Insight</span>
            </a>
            <div class="hidden md:flex items-center gap-8">
                <a class="text-slate-600 hover:text-blue-600 transition-colors text-sm font-medium" href="{{ route('patient.register') }}">Patient Registration</a>
                <a class="text-slate-600 hover:text-blue-600 transition-colors text-sm font-medium" href="{{ route('patient.tracking.portal') }}">Tracking Portal</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center px-4 pt-24 pb-12">
        <div class="w-full max-w-[560px] bg-surface-container-lowest rounded-xl shadow-[0_8px_32px_rgba(0,0,0,0.06)] relative overflow-hidden text-center px-6 py-10 sm:px-12 sm:py-14">
            <div class="absolute top-0 left-0 w-full h-1.5 clinical-gradient"></div>

            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 mb-6">
                <span class="material-symbols-outlined text-5xl" style="font-variation-settings: 'FILL' 1;">check_circle</span>
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-on-surface">You're checked in</h1>
            <p class="text-on-surface-variant text-sm font-medium uppercase tracking-widest mt-2">Returning Patient</p>

            <div class="mt-8 rounded-xl bg-surface-container-low px-5 py-6">
                <p class="text-sm font-semibold text-on-surface-variant">{{ $patientName }}</p>
                <p class="mt-3 text-[11px] font-black uppercase tracking-[0.2em] text-on-surface-variant">Dose visit sent</p>
                <p class="mt-1 text-5xl sm:text-6xl font-black tracking-tighter text-primary">Day {{ $doseDay }}</p>
                <p class="mt-3 text-sm text-on-surface-variant">Your visit is now with the Health Workers.</p>
            </div>

            <div class="mt-6 rounded-xl bg-primary/5 border border-primary/10 px-5 py-4 text-left flex gap-3">
                <span class="material-symbols-outlined text-primary shrink-0">info</span>
                <p class="text-sm font-medium text-primary leading-relaxed">You do not need a queue number. Please proceed to the Health Worker station and wait to be called.</p>
            </div>

            <a href="{{ url('/') }}" class="mt-8 w-full sm:w-auto inline-flex items-center justify-center gap-2 clinical-gradient text-white font-bold text-sm px-8 py-3.5 rounded-xl shadow-lg shadow-primary/20 hover:opacity-95 transition">
                <span class="material-symbols-outlined text-[18px]">home</span>
                Back to home
            </a>
        </div>
    </main>

    <footer class="w-full py-6 bg-surface-container-low">
        <div class="px-5 sm:px-12 text-center text-xs font-medium uppercase tracking-widest text-on-surface-variant">
            © {{ date('Y') }} Cebu City Health Center. Clinical Precision System.
        </div>
    </footer>
</body>

</html>
