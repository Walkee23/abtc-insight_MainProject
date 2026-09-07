<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Print Referral | {{ $referral->reference_no }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        
        @media print {
            @page {
                /* Setting margin to 0 removes the browser's date, URL, and page numbers */
                margin: 0;
            }
            body { 
                background-color: white; 
                margin: 0; 
                padding: 0; 
                /* Overrides the flex centering just for the printer */
                display: block !important; 
            }
            .no-print { display: none !important; }
            .print-container { 
                box-shadow: none !important; 
                /* Forces the slip to the top-left corner */
                margin: 0 !important; 
                /* Adds a tiny margin so ink doesn't bleed off the physical paper edge */
                padding: 0.25in !important; 
                width: 4.25in !important; 
                height: 5.5in !important; 
                border: none !important;
            }
        }
        
        /* Forces the web preview to match the physical slip size */
        .print-container {
            width: 4.25in;
            min-height: 5.5in;
        }
    </style>
</head>
<!-- Center on screen, but align top-left for print -->
<body class="py-10 flex flex-col items-center print:block print:py-0">

    <!-- Action Bar (Hidden when printing) -->
    <div class="w-full max-w-sm mb-6 flex justify-end gap-3 no-print">
        <button onclick="window.close()" class="px-3 py-1.5 bg-slate-200 text-slate-700 text-sm font-bold rounded hover:bg-slate-300">Close</button>
        <button onclick="window.print()" class="px-3 py-1.5 bg-blue-700 text-white text-sm font-bold rounded hover:bg-blue-800 shadow">🖨️ Print Slip</button>
    </div>

    <!-- Official Referral Slip -->
    <div class="print-container bg-white p-4 border border-slate-300 shadow-xl rounded mx-auto print:mx-0 relative">
        
        <!-- Header -->
        <div class="text-center mb-3 border-b border-slate-800 pb-2">
            <h1 class="text-[11px] font-black uppercase tracking-wider text-slate-900">Cebu City Health Dept.</h1>
            <h2 class="text-[9px] font-bold text-slate-700">Animal Bite Treatment Center</h2>
            <div class="mt-2 inline-block bg-slate-100 border border-slate-300 px-3 py-1 rounded">
                <p class="text-[7px] font-bold text-slate-500 uppercase tracking-widest mb-0.5">Referral ID</p>
                <p class="text-sm font-black text-blue-800 tracking-wide">{{ $referral->reference_no }}</p>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-2 gap-x-2 gap-y-2 mb-3">
            <div class="col-span-2">
                <p class="text-[7px] font-bold text-slate-400 uppercase">Patient Name</p>
                <p class="text-xs font-bold text-slate-900 leading-tight">{{ $referral->patient_name }}</p>
            </div>
            <div>
                <p class="text-[7px] font-bold text-slate-400 uppercase">Date of Referral</p>
                <p class="text-[10px] font-bold text-slate-800">{{ \Carbon\Carbon::parse($referral->referral_date)->format('M d, Y') }}</p>
            </div>
            <div>
                <p class="text-[7px] font-bold text-slate-400 uppercase">Demographics</p>
                <p class="text-[10px] font-medium text-slate-800">{{ $referral->age }}yo • {{ substr($referral->gender, 0, 1) }} • {{ substr($referral->civil_status, 0, 1) }}</p>
            </div>
            <div>
                <p class="text-[7px] font-bold text-slate-400 uppercase">Contact</p>
                <p class="text-[10px] font-medium text-slate-800">{{ $referral->contact_num }}</p>
            </div>
            <div>
                <p class="text-[7px] font-bold text-slate-400 uppercase">Barangay</p>
                <p class="text-[10px] font-bold text-slate-800">{{ $referral->patient_barangay }}</p>
            </div>
        </div>

        <!-- Vitals & Exposure Section -->
        <div class="bg-slate-50 p-2 rounded border border-slate-200 mb-3">
            <h3 class="text-[8px] font-bold text-slate-800 uppercase border-b border-slate-200 pb-1 mb-1.5">Clinical Assessment</h3>
            
            <div class="grid grid-cols-3 gap-1 mb-2">
                <div>
                    <p class="text-[6px] font-bold text-slate-400 uppercase">T(°C) / BP</p>
                    <p class="text-[9px] font-medium">{{ $referral->temperature ?? '-' }} / {{ $referral->blood_pressure ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[6px] font-bold text-slate-400 uppercase">PR / RR</p>
                    <p class="text-[9px] font-medium">{{ $referral->pulse_rate ?? '-' }} / {{ $referral->respiratory_rate ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[6px] font-bold text-slate-400 uppercase">Wt(kg) / Ht(cm)</p>
                    <p class="text-[9px] font-medium">{{ $referral->weight_kg ?? '-' }} / {{ $referral->height_cm ?? '-' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-1.5">
                <div>
                    <p class="text-[6px] font-bold text-slate-400 uppercase">Exposure Type</p>
                    <p class="text-[9px] font-bold text-red-600">{{ $referral->exposure_type }}</p>
                </div>
                <div>
                    <p class="text-[6px] font-bold text-slate-400 uppercase">Animal</p>
                    <p class="text-[9px] font-bold">{{ $referral->biting_animal === 'Others' ? $referral->biting_animal_other : $referral->biting_animal }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-[6px] font-bold text-slate-400 uppercase">Date & Site</p>
                    <p class="text-[9px] font-medium">{{ \Carbon\Carbon::parse($referral->exposure_datetime)->format('M d, Y g:i A') }} • {{ $referral->site_of_bite }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-[6px] font-bold text-slate-400 uppercase">Remarks / Action</p>
                    <p class="text-[9px] italic text-slate-600 truncate">{{ $referral->action_desired ?: 'None' }}</p>
                </div>
            </div>
        </div>

        <!-- Footer / Signature -->
        <div class="mt-4 pt-2 border-t border-slate-200 flex justify-between items-end">
            <div>
                <p class="text-[7px] text-slate-400 italic">System Status: <strong class="{{ $referral->status === 'Pending' ? 'text-amber-600' : 'text-emerald-600' }}">{{ $referral->status }}</strong></p>
            </div>
            <div class="text-center w-28">
                <div class="border-b border-slate-800 pb-0.5 mb-0.5">
                    <p class="font-bold text-[10px] text-slate-800 truncate">{{ $referral->referred_by }}</p>
                </div>
                <p class="text-[6px] font-bold text-slate-500 uppercase">Referring BHW</p>
            </div>
        </div>

    </div>

    <!-- Auto-print script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if(urlParams.get('autoprint') === 'true') {
                setTimeout(() => { window.print(); }, 500);
            }
        });
    </script>
</body>
</html>