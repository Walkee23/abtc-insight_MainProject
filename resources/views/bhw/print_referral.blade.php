<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BHW Referral - {{ $referral->reference_no }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Match print view directly to standard Short Bond Paper (8.5in x 11in) */
        @page {
            size: 8.5in 11in;
            margin: 0.5in;
        }

        @media screen {
            body {
                background: #e2e8f0;
                padding: 24px 0;
            }

            .bond-paper {
                width: 8.5in;
                min-height: 11in;
                padding: 0.5in;
                margin: 0 auto;
                background: #ffffff;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            }
        }

        @media print {

            html,
            body {
                width: 100%;
                height: 100%;
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .bond-paper {
                width: 100% !important;
                max-width: 100% !important;
                min-height: auto !important;
                padding: 0 !important;
                margin: 0 !important;
                box-shadow: none !important;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body class="text-slate-900 font-sans antialiased">

    {{-- Screen-only Action Bar --}}
    <div class="no-print max-w-[8.5in] mx-auto mb-4 flex justify-between items-center">
        <a href="{{ route('bhw.dashboard') }}" class="px-4 py-2 bg-slate-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-slate-700">
            &larr; Back to Dashboard
        </a>
        <button onclick="window.print()" class="px-4 py-2 bg-blue-700 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-800">
            Print Referral
        </button>
    </div>

    {{-- Full-width Bond Paper Container --}}
    <div class="bond-paper">

        {{-- Header with Top-Left Cebu City Seal & Top-Right CHD Logo --}}
        <div class="flex items-center justify-between border-b-2 border-slate-900 pb-4 mb-5">
            <img src="{{ asset('images/cebu_city_seal.jpg') }}"
                alt="Official Seal City of Cebu"
                class="w-20 h-20 object-contain shrink-0">

            <div class="text-center px-4">
                <p class="text-xs uppercase tracking-widest text-slate-600 font-semibold">Republic of the Philippines</p>
                <p class="text-sm uppercase font-bold text-slate-800">City Government of Cebu</p>
                <h1 class="text-xl font-extrabold uppercase tracking-tight text-slate-900 mt-0.5">
                    Cebu City Health Department
                </h1>
                <p class="text-sm font-semibold text-blue-800">Animal Bite Treatment Center (ABTC)</p>
                <p class="text-xs text-slate-500 mt-1">BARANGAY HEALTH WORKER REFERRAL SLIP</p>
            </div>

            <img src="{{ asset('images/chd_logo.jpg') }}"
                alt="City Health Department Logo"
                class="w-20 h-20 object-contain shrink-0">
        </div>

        {{-- Referral ID & Chillerlan QR Code Box --}}
        <div class="flex items-center justify-between border border-slate-300 rounded-xl p-4 mb-6 bg-slate-50">
            <div>
                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-500">Referral ID</span>
                <span class="text-2xl font-extrabold tracking-wide text-blue-700">
                    {{ $referral->reference_no }}
                </span>
                <p class="text-xs text-slate-500 mt-1">Present this slip or scan the QR code upon arrival at ABTC.</p>
            </div>

            <div class="flex flex-col items-center bg-white p-2 border border-slate-200 rounded-lg">
                <img src="{{ $qrCode }}" alt="Referral QR Code" class="w-24 h-24">
                <span class="text-[9px] font-mono text-slate-500 mt-1">{{ $referral->reference_no }}</span>
            </div>
        </div>

        {{-- Patient Details Grid --}}
        <div class="grid grid-cols-2 gap-y-4 gap-x-8 mb-6 text-sm">
            <div class="col-span-2 border-b border-slate-200 pb-2">
                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-500">Patient Name</span>
                <span class="text-lg font-bold text-slate-900">
                    {{ $referral->patient_name }}
                </span>
            </div>

            <div>
                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-500">Date of Referral</span>
                <span class="font-semibold">{{ \Carbon\Carbon::parse($referral->referral_date)->format('M d, Y') }}</span>
            </div>

            <div>
                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-500">Demographics</span>
                <span class="font-semibold">{{ $referral->age }}yo &bull; {{ $referral->gender }} &bull; {{ $referral->civil_status }}</span>
            </div>

            <div>
                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-500">Contact Number</span>
                <span class="font-semibold">{{ $referral->contact_num ?? 'N/A' }}</span>
            </div>

            <div>
                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-500">Barangay</span>
                <span class="font-semibold">{{ $referral->patient_barangay }}</span>
            </div>
        </div>

        {{-- Clinical Assessment Box --}}
        <div class="border border-slate-300 rounded-xl p-5 mb-10">
            <h2 class="text-xs font-extrabold uppercase tracking-wider text-slate-700 border-b border-slate-200 pb-2 mb-4">
                Clinical Assessment
            </h2>

            <div class="grid grid-cols-3 gap-4 mb-4 text-sm">
                <div>
                    <span class="block text-[10px] font-bold uppercase text-slate-500">T (&deg;C) / BP</span>
                    <span class="font-semibold">{{ $referral->temperature ?? '-' }} / {{ $referral->blood_pressure ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold uppercase text-slate-500">PR / RR</span>
                    <span class="font-semibold">{{ $referral->pulse_rate ?? '-' }} / {{ $referral->respiratory_rate ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold uppercase text-slate-500">WT (KG) / HT (CM)</span>
                    <span class="font-semibold">{{ $referral->weight_kg ?? '-' }} / {{ $referral->height_cm ?? '-' }}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                <div>
                    <span class="block text-[10px] font-bold uppercase text-slate-500">Exposure Type</span>
                    <span class="font-bold text-red-600">{{ $referral->exposure_type }}</span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold uppercase text-slate-500">Animal</span>
                    <span class="font-semibold">
                        {{ $referral->biting_animal === 'Others' && $referral->biting_animal_other ? $referral->biting_animal_other : $referral->biting_animal }}
                        @if($referral->animal_remarks)
                        ({{ $referral->animal_remarks }})
                        @endif
                    </span>
                </div>
            </div>

            <div class="mb-4 text-sm">
                <span class="block text-[10px] font-bold uppercase text-slate-500">Date &amp; Site of Bite</span>
                <span class="font-semibold">
                    {{ \Carbon\Carbon::parse($referral->exposure_datetime)->format('M d, Y h:i A') }} &bull; {{ $referral->site_of_bite }}
                </span>
            </div>

            <div class="text-sm">
                <span class="block text-[10px] font-bold uppercase text-slate-500">Remarks / Action</span>
                <span class="italic text-slate-700">{{ $referral->action_desired ?: 'None' }}</span>
            </div>
        </div>

        {{-- Footer & Signature Line --}}
        <div class="flex items-end justify-between pt-8 border-t border-slate-300 mt-12">
            <div class="text-xs text-slate-500">
                System Status: <span class="font-bold text-amber-600">{{ ucfirst($referral->status ?? 'Pending') }}</span>
            </div>

            <div class="text-center w-64">
                <p class="font-bold text-sm text-slate-900 pb-1 border-b border-slate-900">
                    {{ $referral->referred_by }}
                </p>
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-600 mt-1">
                    Referring BHW
                </p>
            </div>
        </div>

    </div>

</body>

</html>