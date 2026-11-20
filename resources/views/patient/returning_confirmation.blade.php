<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Check-in Complete - ABTC-Insight</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    <script src="{{ asset('js/mobile-nav.js') }}" defer></script>
</head>

<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col items-center justify-center px-6">
    <main class="w-full max-w-lg bg-white rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.06)] p-10 text-center">
        <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-4xl">check_circle</span>
        </div>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">You're checked in</h1>
        <p class="mt-3 text-slate-600">{{ $patientName }}, your <span class="font-bold">Day {{ $doseDay }}</span> dose visit has been sent to the Health Workers.</p>
        <div class="mt-8 bg-blue-50 border border-blue-100 rounded-xl px-5 py-4 text-sm text-blue-800 text-left flex gap-3">
            <span class="material-symbols-outlined text-blue-600">info</span>
            <p>You do not need a queue number. Please proceed to the Health Worker station and wait to be called.</p>
        </div>
        <a href="{{ url('/') }}" class="inline-block mt-8 text-sm font-bold text-blue-800 hover:underline">Back to home</a>
    </main>
</body>

</html>
