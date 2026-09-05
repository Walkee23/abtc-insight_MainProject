<!DOCTYPE html>

<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>ABTC-Insight | Returning Patient Registration</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          "colors": {
            "on-primary-fixed-variant": "#00468c",
            "surface-container-lowest": "#ffffff",
            "primary-fixed-dim": "#a9c7ff",
            "outline-variant": "#c1c7d3",
            "tertiary-fixed": "#ffdbc8",
            "on-secondary": "#ffffff",
            "inverse-on-surface": "#eff1f3",
            "surface-variant": "#e0e3e5",
            "surface-container-high": "#e6e8ea",
            "primary": "#004a93",
            "on-error-container": "#93000a",
            "error-container": "#ffdad6",
            "secondary-fixed-dim": "#b1c8ec",
            "on-surface-variant": "#414751",
            "tertiary": "#7a3800",
            "surface-bright": "#f7f9fb",
            "on-tertiary-fixed": "#311300",
            "on-secondary-container": "#485f7e",
            "on-primary-container": "#d0dfff",
            "on-primary": "#ffffff",
            "error": "#ba1a1a",
            "on-secondary-fixed": "#011c38",
            "outline": "#717782",
            "background": "#f7f9fb",
            "on-tertiary-container": "#ffd7c0",
            "on-error": "#ffffff",
            "on-tertiary": "#ffffff",
            "on-primary-fixed": "#001b3d",
            "tertiary-fixed-dim": "#ffb689",
            "on-surface": "#191c1e",
            "secondary-fixed": "#d3e4ff",
            "primary-container": "#0b61bb",
            "tertiary-container": "#9e4b00",
            "secondary": "#49607f",
            "surface-container-low": "#f2f4f6",
            "surface-container": "#eceef0",
            "secondary-container": "#c1d9fd",
            "primary-fixed": "#d6e3ff",
            "inverse-surface": "#2d3133",
            "on-secondary-fixed-variant": "#314866",
            "surface-dim": "#d8dadc",
            "surface-tint": "#005db6",
            "inverse-primary": "#a9c7ff",
            "surface": "#f7f9fb",
            "surface-container-highest": "#e0e3e5",
            "on-tertiary-fixed-variant": "#743500",
            "on-background": "#191c1e"
          },
          "borderRadius": {
            "DEFAULT": "0.25rem",
            "lg": "1rem",
            "xl": "1.5rem",
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
    }

    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }

    .step-active {
      background-color: #004a93;
      color: white;
    }

    .step-complete {
      background-color: #10b981;
      color: white;
    }

    .step-inactive {
      background-color: #e0e3e5;
      color: #717782;
    }
  </style>
</head>

<body class="bg-surface text-on-surface min-h-screen flex flex-col">
  <!-- TopNavBar (Updated to match Patient Portal style) -->
  <nav class="fixed top-0 w-full z-50 bg-slate-50/85 backdrop-blur-md shadow-sm shadow-blue-900/5 transition-all duration-300 ease-in-out font-sans antialiased tracking-tight">
    <div class="flex justify-between items-center px-8 py-4 max-w-full mx-auto">
      <!-- Brand -->
      <a href="{{ url('/') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity cursor-pointer">
        <div class="w-8 h-8 clinical-gradient rounded-lg flex items-center justify-center text-white">
          <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">health_metrics</span>
        </div>
        <span class="text-xl font-bold tracking-tighter text-blue-900">ABTC-Insight</span>
      </a>
      <!-- Links & Actions -->
      <div class="flex items-center gap-8">
        <div class="hidden md:flex items-center gap-8">
          <a class="text-slate-600 hover:text-blue-600 transition-colors text-sm font-medium" href="{{ route('patient.register') }}">Patient Registration</a>
          <a class="text-slate-600 hover:text-blue-600 transition-colors text-sm font-medium" href="{{ route('patient.tracking.portal') }}">Tracking Portal</a>
          <button type="button" class="bg-primary text-on-primary px-5 py-2 rounded-full font-semibold active:scale-95 transition-transform" onclick="window.location.href=`{{ route('login') }}`;">
            Login
          </button>
        </div>
      </div>
    </div>
  </nav>
  <main class="flex-grow flex flex-col items-center py-12 px-4">
    <!-- Breadcrumb -->
    <div class="w-full max-w-[680px] mb-6">
      <button class="flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors font-medium">
        <span class="material-symbols-outlined text-lg">arrow_back</span>
        Back to selection
      </button>
    </div>
    <!-- Main Form Card -->
    <div class="w-full max-w-[680px] bg-surface-container-lowest rounded-xl shadow-[0_8px_32px_rgba(0,0,0,0.04)] overflow-hidden">
      <div class="p-8 md:p-12">
        <!-- Header -->
        <div class="flex justify-between items-start mb-10">
          <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-on-surface">Returning Patient</h1>
            <p class="text-on-surface-variant mt-2 text-lg">Report a new bite incident using your existing ABTC record</p>
          </div>
          <span class="bg-emerald-100 text-emerald-700 px-4 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase">Existing Record</span>
        </div>
        <!-- Step Indicator -->
        <div class="flex items-center justify-between mb-12 relative">
          <div class="absolute top-1/2 left-0 w-full h-[2px] bg-surface-container-high -translate-y-1/2 z-0"></div>
          <!-- Step 1 -->
          <div class="relative z-10 flex flex-col items-center gap-2">
            <div class="w-10 h-10 rounded-full step-complete flex items-center justify-center shadow-md">
              <span class="material-symbols-outlined text-xl">check</span>
            </div>
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Find Record</span>
          </div>
          <!-- Step 2 -->
          <div class="relative z-10 flex flex-col items-center gap-2">
            <div class="w-10 h-10 rounded-full step-active flex items-center justify-center shadow-lg ring-4 ring-primary-container/20">
              <span class="font-bold">2</span>
            </div>
            <span class="text-xs font-bold text-primary uppercase tracking-wider">Confirm Details</span>
          </div>
          <!-- Step 3 -->
          <div class="relative z-10 flex flex-col items-center gap-2">
            <div class="w-10 h-10 rounded-full step-inactive flex items-center justify-center">
              <span class="font-bold">3</span>
            </div>
            <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Priority + Confirm</span>
          </div>
        </div>

        <form action="{{ route('patient.submit') }}" method="POST">
          @csrf
          <input type="hidden" name="priority_status" id="priorityInput" value="none">
          <input type="hidden" name="patient_id" id="patientIdInput" value="">

          <!-- Section 1: Record Summary (Collapsed) -->
          <div class="mb-10" id="lookupSection">
            <div class="flex gap-3 mb-4">
              <input type="text" id="searchInput" placeholder="Enter Patient ID or Full Name..." class="flex-1 bg-surface-container-highest border-0 focus:ring-2 focus:ring-primary/20 rounded-lg px-4 py-3.5 font-medium" />
                 <button type="button" id="searchBtn" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 rounded-lg transition-all">Search</button>
            </div>
           <div id="notFoundMsg" class="hidden bg-red-50 text-red-700 px-6 py-4 rounded-lg text-sm font-medium mb-4">
             No matching patient record found. Please check the ID or name and try again.
           </div>
           <div id="recordFoundBox" class="hidden bg-emerald-600 text-white px-6 py-4 rounded-lg items-center gap-3 shadow-md">
                <span class="material-symbols-outlined">person_check</span>
                <div class="text-sm">
                  <span class="font-bold">Record found:</span> <span id="foundName"></span> · <span class="font-mono text-emerald-100" id="foundId"></span>
              </div>
            </div>
          </div>
          <!-- Section 2: Details -->
          <div class="space-y-8">
            <div class="flex items-center gap-3">
              <h2 class="text-xs font-black tracking-[0.15em] text-on-surface-variant uppercase">Confirm Your Details</h2>
              <div class="h-px flex-grow bg-outline-variant opacity-20"></div>
            </div>
            <div class="bg-blue-50/80 border border-blue-100 rounded-lg p-4 flex gap-3">
              <span class="material-symbols-outlined text-blue-600">info</span>
              <p class="text-sm text-blue-800 leading-relaxed">Some fields are locked to your existing clinical record. If you need to change your name or DOB, please approach the registration desk.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Locked Fields -->
              <div class="space-y-1.5">
                <label class="text-xs font-bold text-on-surface-variant uppercase ml-1">Full Name</label>
                <div class="flex items-center justify-between bg-surface-container-low px-4 py-3.5 rounded-lg text-on-surface-variant cursor-not-allowed">
                  <span class="font-medium" id="lockedName">—</span>
                  <span class="material-symbols-outlined text-lg opacity-40">lock</span>
                </div>
              </div>
              <div class="space-y-1.5">
                <label class="text-xs font-bold text-on-surface-variant uppercase ml-1">Date of Birth</label>
                <div class="bg-surface-container-low px-4 py-3.5 rounded-lg text-on-surface-variant cursor-not-allowed font-medium" id="lockedDob">
                  -
                </div>
              </div>
              <div class="space-y-1.5">
                <label class="text-xs font-bold text-on-surface-variant uppercase ml-1">Sex</label>
                <div class="bg-surface-container-low px-4 py-3.5 rounded-lg text-on-surface-variant cursor-not-allowed font-medium" id="lockedSex">
                  -
                </div>
              </div>
              <!-- Editable Fields -->
              <div class="space-y-1.5">
                <label class="text-xs font-bold text-emerald-700 uppercase ml-1">Contact Number</label>
                <input name="contact_num" class="w-full bg-emerald-50/30 border-0 border-b-2 border-emerald-500/30 focus:border-emerald-500 focus:ring-0 text-on-surface font-medium px-4 py-3.5 rounded-t-lg transition-all" type="text" placeholder="09XX XXX XXXX" />
              </div>
              <div class="space-y-1.5">
                <label class="text-xs font-bold text-on-surface-variant uppercase ml-1">Civil Status</label>
                <select name="civil_status" class="w-full bg-surface-container-highest border-0 focus:ring-2 focus:ring-primary/20 rounded-lg px-4 py-3.5 font-medium">
                  <option value="Single" selected>Single</option>
                  <option value="Married">Married</option>
                  <option value="Widowed">Widowed</option>
                  <option value="Separated">Separated</option>
                </select>
              </div>
              <div class="space-y-1.5">
                <label class="text-xs font-bold text-on-surface-variant uppercase ml-1">PhilHealth Member?</label>
                <select name="philhealth_member" class="w-full bg-surface-container-highest border-0 focus:ring-2 focus:ring-primary/20 rounded-lg px-4 py-3.5 font-medium">
                  <option value="1" selected>Yes</option>
                  <option value="0">No</option>
                </select>
              </div>
            </div>
            <!-- Barangay Section -->
            <div class="bg-amber-50/30 border border-amber-100 rounded-xl p-6 space-y-4">
              <div class="flex items-center justify-between">
                <label class="text-sm font-bold text-on-surface flex items-center gap-1">
                  Barangay of this incident <span class="text-error">*</span>
                  <span class="material-symbols-outlined text-base text-on-surface-variant/40 ml-1">info</span>
                </label>
              </div>
              <select name="barangay" class="w-full bg-white border-2 border-amber-200 focus:border-amber-500 focus:ring-0 rounded-lg px-4 py-4 text-on-surface font-medium shadow-sm">
                <option disabled selected value="">Select Barangay...</option>
                <option value="Guadalupe">Guadalupe</option>
                <option value="Lahug">Lahug</option>
                <option value="Mabolo">Mabolo</option>
                <option value="Tisa">Tisa</option>
              </select>
              <p class="text-[11px] text-amber-700 font-medium flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">priority_high</span>
                Required for every new incident report to map local outbreaks.
              </p>
            </div>
          </div>
          <!-- Section 3: Priority -->
          <div class="mt-12 space-y-8">
            <div class="flex items-center gap-3">
              <h2 class="text-xs font-black tracking-[0.15em] text-on-surface-variant uppercase">Priority Status Today</h2>
              <div class="h-px flex-grow bg-outline-variant opacity-20"></div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
              <button class="priority-option flex flex-col items-center justify-center p-4 rounded-xl border-2 border-surface-container-high hover:border-primary-container transition-all gap-2 group" data-priority="none">
                <span class="material-symbols-outlined text-2xl text-on-surface-variant group-hover:text-primary">block</span>
                <span class="text-xs font-bold uppercase tracking-tighter">None</span>
              </button>
              <button class="priority-option flex flex-col items-center justify-center p-4 rounded-xl border-2 border-surface-container-high hover:border-primary-container transition-all gap-2 relative" data-priority="priority">
                <span class="material-symbols-outlined text-2xl text-on-surface-variant">accessible</span>
                <span class="text-xs font-bold uppercase tracking-tighter">PWD</span>
                <span class="absolute -top-2 -right-1 bg-surface-container-highest text-[9px] px-2 py-0.5 rounded-full font-bold">PERMANENT</span>
              </button>
              <button class="priority-option flex flex-col items-center justify-center p-4 rounded-xl border-2 border-surface-container-high hover:border-primary-container transition-all gap-2 relative" data-priority="priority">
                <span class="material-symbols-outlined text-2xl text-primary" data-weight="fill">elderly</span>
                <span class="text-xs font-bold uppercase tracking-tighter text-primary">Senior</span>
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-emerald-600 text-white text-[9px] px-2 py-1 rounded-full font-bold whitespace-nowrap shadow-sm">AUTO-DETECTED</div>
              </button>
              <button class="priority-option flex flex-col items-center justify-center p-4 rounded-xl border-2 border-surface-container-high hover:border-primary-container transition-all gap-2 group" data-priority="priority">
                <span class="material-symbols-outlined text-2xl text-on-surface-variant group-hover:text-primary">pregnant_woman</span>
                <span class="text-xs font-bold uppercase tracking-tighter">Pregnant</span>
              </button>
            </div>
          </div>
          <!-- Footer Actions -->
          <div class="mt-16 flex flex-col md:flex-row items-center justify-between gap-4 pt-8 border-t border-outline-variant/15">
            <button type="reset" class="text-on-surface-variant font-bold text-sm px-6 py-3 rounded-lg hover:bg-surface-container-low transition-colors">Clear Form</button>
            <button type="submit" class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-4 rounded-xl shadow-lg shadow-emerald-600/20 flex items-center justify-center gap-3 transition-transform active:scale-[0.98]">
              Confirm and Get Queue Number
              <span class="material-symbols-outlined">arrow_forward</span>
            </button>
          </div>

        </form>
      </div>
    </div>
  </main>
  <!-- Footer -->
  <footer class="flex flex-col md:flex-row justify-between items-center px-8 py-6 w-full border-t border-[#c1c7d3]/15 bg-[#f2f4f6] dark:bg-slate-950 font-['Inter'] text-sm">
    <div class="flex items-center gap-4 mb-4 md:mb-0">
      <span class="font-bold text-[#004a93]">ABTC-Insight</span>
      <span class="text-[#414751] dark:text-slate-500">© 2024 Cebu City Health Center. Clinical Precision System.</span>
    </div>
    <div class="flex gap-6">
      <a class="text-[#414751] dark:text-slate-500 hover:text-[#004a93] dark:hover:text-blue-300 transition-colors duration-200" href="#">Privacy Policy</a>
      <a class="text-[#414751] dark:text-slate-500 hover:text-[#004a93] dark:hover:text-blue-300 transition-colors duration-200" href="#">Contact Support</a>
      <a class="text-[#414751] dark:text-slate-500 hover:text-[#004a93] dark:hover:text-blue-300 transition-colors duration-200" href="#">Terms of Service</a>
    </div>
  </footer>
 
 <script>
    document.getElementById('searchBtn').addEventListener('click', async function() {
        const query = document.getElementById('searchInput').value.trim();
        if (!query) return;

        const notFoundMsg = document.getElementById('notFoundMsg');
        const recordFoundBox = document.getElementById('recordFoundBox');

        try {
            const response = await fetch(`/patient/search?query=${encodeURIComponent(query)}`);
            const data = await response.json();

            if (!data.found) {
                notFoundMsg.classList.remove('hidden');
                recordFoundBox.classList.add('hidden');
                recordFoundBox.classList.remove('flex');
                return;
            }

            notFoundMsg.classList.add('hidden');
            recordFoundBox.classList.remove('hidden');
            recordFoundBox.classList.add('flex');

            const patient = data.patient;

            // Fill in locked fields
            document.getElementById('lockedName').textContent = patient.patient_name;
            document.getElementById('lockedDob').textContent = patient.date_of_birth;
            document.getElementById('lockedSex').textContent = patient.sex;

            // Fill in record found box
            document.getElementById('foundName').textContent = patient.patient_name;
            document.getElementById('foundId').textContent = patient.patient_id;

            // Set hidden input for form submission
            document.getElementById('patientIdInput').value = patient.patient_id;

        } catch (error) {
            console.error('Search failed:', error);
            notFoundMsg.textContent = 'Something went wrong. Please try again.';
            notFoundMsg.classList.remove('hidden');
        }
    });
</script>

  <script>
    // Get the hidden input
    const priorityInput = document.getElementById('priorityInput');
    const priorityOptions = document.querySelectorAll('.priority-option');

    priorityOptions.forEach(option => {
      option.addEventListener('click', function(e) {
        // Prevent the button from submitting the form immediately
        e.preventDefault();

        // Set the hidden input value
        priorityInput.value = this.getAttribute('data-priority');

        // 1. Remove the blue highlight from ALL cards
        priorityOptions.forEach(opt => {
          opt.classList.remove('border-primary', 'bg-primary/5', 'ring-2', 'ring-primary/20');
          opt.classList.add('border-surface-container-high');
        });

        // 2. Add the blue highlight to the CLICKED card
        this.classList.remove('border-surface-container-high');
        this.classList.add('border-primary', 'bg-primary/5', 'ring-2', 'ring-primary/20');
      });
    });
  </script>
</body>

</html>