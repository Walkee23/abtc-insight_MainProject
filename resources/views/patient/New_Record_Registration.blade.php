<!DOCTYPE html>

<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Patient Registration | ABTC-Insight</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
    rel="stylesheet" />
  <style>
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }

    body {
      font-family: 'Inter', sans-serif;
    }

    .clinical-gradient {
      background: linear-gradient(135deg, #004a93 0%, #0b61bb 100%);
    }
  </style>
  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          "colors": {
            "on-primary-fixed-variant": "#00468c",
            "surface-container": "#eceef0",
            "surface-tint": "#005db6",
            "surface-variant": "#e0e3e5",
            "on-tertiary-fixed-variant": "#743500",
            "tertiary-fixed": "#ffdbc8",
            "background": "#f7f9fb",
            "on-error": "#ffffff",
            "on-error-container": "#93000a",
            "surface-container-low": "#f2f4f6",
            "tertiary-container": "#9e4b00",
            "tertiary": "#7a3800",
            "on-primary-container": "#d0dfff",
            "primary-fixed-dim": "#a9c7ff",
            "outline-variant": "#c1c7d3",
            "primary": "#004a93",
            "outline": "#717782",
            "on-surface-variant": "#414751",
            "on-secondary-fixed-variant": "#314866",
            "inverse-on-surface": "#eff1f3",
            "on-secondary-fixed": "#011c38",
            "on-tertiary-container": "#ffd7c0",
            "on-surface": "#191c1e",
            "on-primary": "#ffffff",
            "surface-container-highest": "#e0e3e5",
            "secondary-fixed-dim": "#b1c8ec",
            "on-tertiary-fixed": "#311300",
            "inverse-primary": "#a9c7ff",
            "error-container": "#ffdad6",
            "primary-fixed": "#d6e3ff",
            "surface-bright": "#f7f9fb",
            "primary-container": "#0b61bb",
            "on-tertiary": "#ffffff",
            "secondary-container": "#c1d9fd",
            "secondary": "#49607f",
            "surface-container-lowest": "#ffffff",
            "surface-container-high": "#e6e8ea",
            "on-secondary": "#ffffff",
            "on-background": "#191c1e",
            "error": "#ba1a1a",
            "secondary-fixed": "#d3e4ff",
            "surface-dim": "#d8dadc",
            "surface": "#f7f9fb",
            "on-primary-fixed": "#001b3d",
            "inverse-surface": "#2d3133",
            "tertiary-fixed-dim": "#ffb689",
            "on-secondary-container": "#485f7e"
          },
          "borderRadius": {
            "DEFAULT": "0.25rem",
            "lg": "1rem",
            "xl": "1.5rem",
            "full": "9999px"
          }
        }
      }
    }
  </script>
</head>

<body class="bg-surface text-on-surface selection:bg-primary-fixed">
  <!-- TopNavBar (Updated to match Patient Portal style) -->
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
  <main class="min-h-screen flex flex-col items-center px-4 py-12">
    <!-- Breadcrumb -->
    <div class="w-full max-w-[680px] mb-6 flex items-center gap-2 group cursor-pointer">
      <span class="material-symbols-outlined text-on-surface-variant text-sm">arrow_back</span>
      <span class="text-on-surface-variant text-sm font-medium group-hover:text-primary transition-colors">Back to
        selection</span>
    </div>
    <!-- Registration Form Card -->
    <div
      class="w-full max-w-[680px] bg-surface-container-lowest rounded-xl shadow-xl border border-outline-variant/30 p-10 overflow-hidden">
      <!-- Card Header -->
      <div class="flex flex-col gap-1 mb-8">
        <div class="flex items-center justify-between">
          <h1 class="text-2xl font-extrabold tracking-tight text-on-surface">New Patient Registration</h1>
          <span
            class="bg-secondary-container text-on-secondary-container px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest">New
            Patient</span>
        </div>
        <p class="text-on-surface-variant text-sm font-medium">Cebu City Animal Bite Treatment Center — CCHD</p>
      </div>
      <!-- 4-step Progress Indicator -->
      <div class="flex items-center justify-between mb-12 relative px-2">
        <div class="absolute top-1/2 left-0 w-full h-[2px] bg-surface-container-high -z-10 -translate-y-1/2"></div>
        <div class="flex flex-col items-center gap-2">
          <div
            class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold shadow-lg shadow-primary/20">
            1</div>
          <span class="text-[10px] uppercase font-bold tracking-tighter text-primary">Priority Status</span>
        </div>
        <div class="flex flex-col items-center gap-2">
          <div
            class="w-8 h-8 rounded-full bg-surface-container-high text-on-surface-variant flex items-center justify-center text-xs font-bold">
            2</div>
          <span class="text-[10px] uppercase font-bold tracking-tighter text-on-surface-variant">Personal Info</span>
        </div>
        <div class="flex flex-col items-center gap-2">
          <div
            class="w-8 h-8 rounded-full bg-surface-container-high text-on-surface-variant flex items-center justify-center text-xs font-bold">
            3</div>
          <span class="text-[10px] uppercase font-bold tracking-tighter text-on-surface-variant">Medical History</span>
        </div>
        <div class="flex flex-col items-center gap-2">
          <div
            class="w-8 h-8 rounded-full bg-surface-container-high text-on-surface-variant flex items-center justify-center text-xs font-bold">
            4</div>
          <span class="text-[10px] uppercase font-bold tracking-tighter text-on-surface-variant">Confirm</span>
        </div>
      </div>
      <!-- Form Content -->
      <form action="{{ route('patient.submit') }}" method="POST" class="space-y-12">
        @csrf

        <!-- Add this hidden input right below the form tag -->
        <input type="hidden" name="priority_status" id="priorityInput" value="none">
        <!-- Section 1: Priority Status -->
        <section>
          <div class="flex items-center gap-2 mb-6">
            <div class="w-1 h-5 bg-primary rounded-full"></div>
            <h2 class="text-sm font-bold uppercase tracking-widest text-on-surface">Step 1: Priority Status</h2>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <!-- Card: None -->
            <div
              class="priority-option border-2 border-surface-container-high p-4 rounded-lg cursor-pointer hover:bg-surface-container transition-all flex flex-col gap-3 group"
              data-priority="none">
              <div
                class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                <span class="material-symbols-outlined">block</span>
              </div>
              <div>
                <h3 class="font-bold text-sm">None</h3>
                <p class="text-xs text-on-surface-variant">Standard queue processing</p>
              </div>
            </div>
            <!-- Card: PWD -->
            <div
              class="priority-option border-2 border-surface-container-high p-4 rounded-lg cursor-pointer hover:bg-surface-container transition-all flex flex-col gap-3 relative overflow-hidden"
              data-priority="priority">
              <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white">
                <span class="material-symbols-outlined" data-icon="accessible">accessible</span>
              </div>
              <div>
                <h3 class="font-bold text-sm text-on-primary-fixed-variant">PWD</h3>
                <div class="mt-1 flex gap-2">
                  <span
                    class="bg-primary text-[9px] text-white px-2 py-0.5 rounded-full font-bold uppercase">Permanent</span>
                </div>
              </div>
            </div>
            <!-- Card: Senior Citizen -->
            <div
              class="priority-option border-2 border-surface-container-high p-4 rounded-lg cursor-pointer hover:bg-surface-container transition-all flex flex-col gap-3"
              data-priority="priority">
              <div
                class="w-10 h-10 rounded-full bg-tertiary-fixed flex items-center justify-center text-on-tertiary-fixed-variant">
                <span class="material-symbols-outlined" data-icon="elderly">elderly</span>
              </div>
              <div>
                <h3 class="font-bold text-sm text-on-tertiary-fixed-variant">Senior Citizen</h3>
                <div class="mt-1 flex gap-2">
                  <span
                    class="bg-tertiary text-[9px] text-white px-2 py-0.5 rounded-full font-bold uppercase">Permanent</span>
                </div>
              </div>
            </div>
            <!-- Card: Pregnant -->
            <div
              class="priority-option border-2 border-surface-container-high p-4 rounded-lg cursor-pointer hover:bg-surface-container transition-all flex flex-col gap-3"
              data-priority="priority">
              <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-800">
                <span class="material-symbols-outlined" data-icon="pregnant_woman">pregnant_woman</span>
              </div>
              <div>
                <h3 class="font-bold text-sm text-emerald-900">Pregnant</h3>
                <div class="mt-1 flex gap-2">
                  <span class="bg-emerald-600 text-[9px] text-white px-2 py-0.5 rounded-full font-bold uppercase">This
                    visit only</span>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Section 2: Personal Info -->
        <section>
          <div class="flex items-center gap-2 mb-6">
            <div class="w-1 h-5 bg-primary rounded-full"></div>
            <h2 class="text-sm font-bold uppercase tracking-widest text-on-surface">Step 2: Personal Information</h2>
          </div>
          <div class="grid grid-cols-2 gap-x-6 gap-y-4">
            <div class="col-span-2">
              <label class="block text-[11px] font-bold text-on-surface-variant uppercase mb-1.5 ml-1">BHW Referral ID
                <span class="text-error">*</span></label>
              <input
                class="w-full bg-surface-container-highest border-none rounded-lg p-3 text-sm focus:ring-1 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all"
                name="bhw_referral_id" placeholder="e.g., BRY-001-20250501-0023" required="" type="text" />
              <p class="mt-1.5 ml-1 text-[10px] text-on-surface-variant/80 italic">Enter the referral ID provided by
                your Barangay Health Worker.</p>
            </div>
            <div class="col-span-2">
              <label class="block text-[11px] font-bold text-on-surface-variant uppercase mb-1.5 ml-1">Full Name</label>
              <input
                class="w-full bg-surface-container-highest border-none rounded-lg p-3 text-sm focus:ring-1 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all"
                name="full_name" placeholder="Surname, Given Name, Middle Initial" required type="text" />
            </div>
            <div>
              <label class="block text-[11px] font-bold text-on-surface-variant uppercase mb-1.5 ml-1">Date of Birth</label>
              <input
                class="w-full bg-surface-container-highest border-none rounded-lg p-3 text-sm focus:ring-1 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all"
                id="dobInput" name="date_of_birth" required type="date" />
            </div>
            <div>
              <label class="block text-[11px] font-bold text-on-surface-variant uppercase mb-1.5 ml-1">Age</label>
              <input
                class="w-full bg-surface-container border-none rounded-lg p-3 text-sm text-on-surface-variant opacity-60"
                id="ageInput" name="age" placeholder="--" readonly type="text" />
            </div>
            <div>
              <label class="block text-[11px] font-bold text-on-surface-variant uppercase mb-1.5 ml-1">Sex</label>
              <select
                class="w-full bg-surface-container-highest border-none rounded-lg p-3 text-sm focus:ring-1 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all"
                name="sex" required>
                <option value="">Select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>
            <div>
              <label class="block text-[11px] font-bold text-on-surface-variant uppercase mb-1.5 ml-1">Civil
                Status</label>
              <select
                class="w-full bg-surface-container-highest border-none rounded-lg p-3 text-sm focus:ring-1 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all"
                name="civil_status" required>
                <option value="">Select</option>
                <option value="single">Single</option>
                <option value="married">Married</option>
                <option value="widowed">Widowed</option>
                <option value="separated">Separated</option>
              </select>
            </div>
            <div class="col-span-2">
              <label class="block text-[11px] font-bold text-on-surface-variant uppercase mb-1.5 ml-1">Contact
                Number</label>
              <input
                class="w-full bg-surface-container-highest border-none rounded-lg p-3 text-sm focus:ring-1 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all"
                name="contact_number" placeholder="+63 000 000 0000" required type="tel" />
            </div>
            <div class="col-span-2">
              <label class="block text-[11px] font-bold text-on-surface-variant uppercase mb-1.5 ml-1">BARANGAY OF INCIDENCE</label>
              <div class="relative">
                <input autocomplete="off"
                  class="w-full bg-surface-container-highest border-none rounded-lg p-3 pl-10 text-sm focus:ring-1 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all"
                  id="barangayInput" name="barangay_of_incidence" placeholder="Search your barangay..." required
                  type="text" />
                <span
                  class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg">search</span>
                <div
                  class="hidden absolute left-0 right-0 top-full mt-1 max-h-56 overflow-y-auto bg-surface-container-lowest rounded-lg shadow-lg border border-outline-variant/20 z-20"
                  id="barangayDropdown"></div>
              </div>
            </div>
            <div class="col-span-2">
              <label class="block text-[11px] font-bold text-on-surface-variant uppercase mb-1.5 ml-1">Valid ID Number</label>
              <input
                class="w-full bg-surface-container-highest border-none rounded-lg p-3 text-sm focus:ring-1 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all"
                name="valid_id_number" placeholder="Precinct no. / Senior Citizen ID / PWD card no." type="text" />
              <p class="mt-1.5 ml-1 text-[10px] text-on-surface-variant/80 italic">Required for Senior Citizens and PWDs
                only. Pregnant patients do not need to provide an ID number.</p>
            </div>
          </div>
        </section>
        <!-- Section 3: PhilHealth -->
        <section>
          <div class="flex items-center gap-2 mb-6">
            <div class="w-1 h-5 bg-primary rounded-full"></div>
            <h2 class="text-sm font-bold uppercase tracking-widest text-on-surface">Step 3: PhilHealth Coverage</h2>
          </div>
          <div class="bg-surface-container-low p-6 rounded-lg space-y-6">
            <div class="flex items-center justify-between">
              <span class="text-sm font-semibold">Are you a PhilHealth Member?</span>
              <div class="flex gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                  <input class="text-primary focus:ring-0" name="philhealth_member" type="radio" value="yes" />
                  <span class="text-sm">Yes</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                  <input checked class="text-primary focus:ring-0" name="philhealth_member" type="radio" value="no" />
                  <span class="text-sm">No</span>
                </label>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div class="col-span-2 md:col-span-1">
                <label class="block text-[11px] font-bold text-on-surface-variant uppercase mb-1.5">Member Full
                  Name</label>
                <input class="w-full bg-surface-container-lowest border-none rounded-lg p-3 text-sm"
                  name="philhealth_member_name" type="text" />
              </div>
              <div class="col-span-2 md:col-span-1">
                <label class="block text-[11px] font-bold text-on-surface-variant uppercase mb-1.5">Member DOB</label>
                <input class="w-full bg-surface-container-lowest border-none rounded-lg p-3 text-sm"
                  name="philhealth_member_dob" type="date" />
              </div>
            </div>
          </div>
        </section>
        <!-- Section 4: Medical History -->
        <section>
          <div class="flex items-center gap-2 mb-6">
            <div class="w-1 h-5 bg-primary rounded-full"></div>
            <h2 class="text-sm font-bold uppercase tracking-widest text-on-surface">Step 4: Medical History</h2>
          </div>
          <div class="space-y-6">
            <div>
              <label class="block text-[11px] font-bold text-on-surface-variant uppercase mb-1.5 ml-1">Current Illnesses
                or Medications</label>
              <textarea
                class="w-full bg-surface-container-highest border-none rounded-lg p-3 text-sm focus:ring-1 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all"
                name="current_illnesses"
                placeholder="Please list any ongoing health conditions or medications you are currently taking..."
                rows="3"></textarea>
            </div>
            <div>
              <label class="block text-[11px] font-bold text-on-surface-variant uppercase mb-1.5 ml-1">Known
                Allergies</label>
              <textarea
                class="w-full bg-surface-container-highest border-none rounded-lg p-3 text-sm focus:ring-1 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all"
                name="known_allergies" placeholder="e.g. Antibiotics, Food, Latex, etc." rows="3"></textarea>
            </div>
          </div>
        </section>
        <!-- Form Footer -->
        <footer class="pt-8 flex flex-col md:flex-row items-center justify-between gap-6">
          <div class="max-w-[300px]">
            <p class="text-[10px] leading-relaxed text-on-surface-variant">By submitting this form, you consent to the
              collection and processing of your personal health data for medical treatment purposes in accordance with
              the Data Privacy Act of 2012.</p>
          </div>
          <div class="flex items-center gap-4">
            <button class="text-sm font-bold text-on-surface-variant hover:text-on-surface px-4 py-2 transition-colors"
              type="reset">Clear Form</button>
            <button
              class="bg-primary text-white px-8 py-3 rounded-full font-bold text-sm flex items-center gap-2 hover:opacity-90 transition-all shadow-lg shadow-primary/20"
              type="submit">
              Submit and Get Queue Number
              <span class="material-symbols-outlined text-base">arrow_forward</span>
            </button>
          </div>
        </footer>
      </form>
    </div>
    <!-- Global Footer -->
    <footer class="w-full mt-20 border-t border-outline-variant/30 bg-transparent text-center">
      <div class="flex flex-col md:flex-row justify-between items-center gap-4 px-8 py-10 max-w-7xl mx-auto">
        <span class="text-on-surface-variant font-inter text-xs tracking-wide uppercase">© 2024 Cebu City Health Center.
          All rights reserved. Clinical Precision &amp; Editorial Authority.</span>
        <div class="flex gap-6">
          <a class="text-on-surface-variant text-xs tracking-wide uppercase hover:text-primary underline underline-offset-4 transition-opacity"
            href="#">Privacy Policy</a>
          <a class="text-on-surface-variant text-xs tracking-wide uppercase hover:text-primary underline underline-offset-4 transition-opacity"
            href="#">Terms of Service</a>
          <a class="text-on-surface-variant text-xs tracking-wide uppercase hover:text-primary underline underline-offset-4 transition-opacity"
            href="#">Help Desk</a>
        </div>
      </div>
    </footer>
  </main>

  <script>
    // Auto-calculate age from date of birth, and cap at 125 years old
    const dobInput = document.getElementById('dobInput');
    const ageInput = document.getElementById('ageInput');

    // Restrict the date picker itself: no future dates, no more than 125 years ago
    const today = new Date();
    const maxDob = today.toISOString().split('T')[0];
    const minDobDate = new Date(today.getFullYear() - 125, today.getMonth(), today.getDate());
    const minDob = minDobDate.toISOString().split('T')[0];
    dobInput.setAttribute('max', maxDob);
    dobInput.setAttribute('min', minDob);

    function calculateAge(dobValue) {
      const dob = new Date(dobValue);
      const today = new Date();
      let age = today.getFullYear() - dob.getFullYear();
      const monthDiff = today.getMonth() - dob.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
        age--;
      }
      return age;
    }

    dobInput.addEventListener('change', function () {
      if (!this.value) {
        ageInput.value = '';
        return;
      }
      const age = calculateAge(this.value);
      if (age > 125) {
        alert('Age cannot be more than 125 years old. Please check the date of birth.');
        this.value = '';
        ageInput.value = '';
        return;
      }
      ageInput.value = age >= 0 ? age : '';
    });

    // Also guard on submit in case a value slipped through
    document.querySelector('form').addEventListener('submit', function (e) {
      if (dobInput.value) {
        const age = calculateAge(dobInput.value);
        if (age > 125) {
          e.preventDefault();
          alert('Age cannot be more than 125 years old. Please check the date of birth.');
          dobInput.focus();
        }
      }
    });

    // Barangay search dropdown (custom, so it always renders below the input)
    const barangayList = ['Adlaon', 'Agsungot', 'Apas', 'Babag', 'Bacayan', 'Banawa', 'Banilad', 'Basak Pardo', 'Basak San Nicolas', 'Binaliw', 'Barrio Luz', 'Bonbon', 'Buot-Taup', 'Budlaan', 'Buhisan', 'Bulacao', 'Busay', 'Calamba', 'Cambinocot', 'Capitol', 'Carreta', 'Cogon Pardo', 'Cogon Ramos', 'Day-as', 'Duljo', 'Ermita', 'Guadalupe', 'Guba', 'Hipodromo', 'Inayawan', 'Kalubihan', 'Kalunasan', 'Kamagayan', 'Kamputhaw', 'Kasambagan', 'Kinasang-an', 'Labangon', 'Lahug', 'Lorega', 'Lusaran', 'Mabini', 'Mabolo', 'Malubog', 'Mambaling', 'Pahina Central', 'Pamutan', 'Pardo', 'Pari-an', 'Paril', 'Pasil', 'Pit-os', 'Pulangbato', 'Pung-ol', 'Punta Princesa', 'Quiot', 'Sambag I', 'Sambag II', 'San Antonio', 'San Jose', 'San Nicolas Pahina', 'San Nicolas Proper', 'San Roque', 'Sapangdaku', 'Sawang Calero', 'Sinsin', 'Sirao', 'Sta. Cruz', 'Sto. Niño', 'Suba', 'Sudlon I', 'Sudlon II', 'T. Padilla', 'Tabunan', 'Tagbao', 'Talamban', 'TapTap', 'Tejero', 'Tinago', 'Tisa', 'Toong', 'Zapatera'];
    const barangayInput = document.getElementById('barangayInput');
    const barangayDropdown = document.getElementById('barangayDropdown');

    function renderBarangayOptions(filterText) {
      const filtered = barangayList.filter(b => b.toLowerCase().includes(filterText.toLowerCase()));
      if (filtered.length === 0) {
        barangayDropdown.classList.add('hidden');
        barangayDropdown.innerHTML = '';
        return;
      }
      barangayDropdown.innerHTML = filtered.map(b =>
        `<div class="px-4 py-2.5 text-sm cursor-pointer hover:bg-surface-container transition-colors barangay-option">${b}</div>`
      ).join('');
      barangayDropdown.classList.remove('hidden');
    }

    barangayInput.addEventListener('focus', function () {
      renderBarangayOptions(this.value);
    });

    barangayInput.addEventListener('input', function () {
      renderBarangayOptions(this.value);
    });

    barangayDropdown.addEventListener('click', function (e) {
      if (e.target.classList.contains('barangay-option')) {
        barangayInput.value = e.target.textContent;
        barangayDropdown.classList.add('hidden');
        barangayDropdown.innerHTML = '';
      }
    });

    document.addEventListener('click', function (e) {
      if (!barangayInput.contains(e.target) && !barangayDropdown.contains(e.target)) {
        barangayDropdown.classList.add('hidden');
      }
    });

    // Get the hidden input
    const priorityInput = document.getElementById('priorityInput');
    const priorityOptions = document.querySelectorAll('.priority-option');

    priorityOptions.forEach(option => {
      option.addEventListener('click', function (e) {
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