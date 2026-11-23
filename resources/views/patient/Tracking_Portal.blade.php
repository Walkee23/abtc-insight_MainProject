<!DOCTYPE html>

<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>ABTC-Insight Patient Portal | Track Your Health Journey</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
    rel="stylesheet" />
  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "surface-container-lowest": "#ffffff",
            "secondary-container": "#c1d9fd",
            "surface-dim": "#d8dadc",
            "secondary-fixed-dim": "#b1c8ec",
            "on-primary-fixed": "#001b3d",
            "inverse-surface": "#2d3133",
            "outline-variant": "#c1c7d3",
            "on-secondary-container": "#485f7e",
            "surface-container-highest": "#e0e3e5",
            "on-secondary-fixed": "#011c38",
            "on-primary-fixed-variant": "#00468c",
            "surface-variant": "#e0e3e5",
            "surface-container": "#eceef0",
            "on-secondary-fixed-variant": "#314866",
            "error-container": "#ffdad6",
            "on-tertiary": "#ffffff",
            "primary": "#004a93",
            "on-tertiary-fixed": "#311300",
            "tertiary-fixed-dim": "#ffb689",
            "tertiary-container": "#9e4b00",
            "surface-tint": "#005db6",
            "surface-container-low": "#f2f4f6",
            "error": "#ba1a1a",
            "tertiary": "#7a3800",
            "on-tertiary-fixed-variant": "#743500",
            "secondary": "#49607f",
            "on-tertiary-container": "#ffd7c0",
            "primary-fixed": "#d6e3ff",
            "inverse-primary": "#a9c7ff",
            "secondary-fixed": "#d3e4ff",
            "tertiary-fixed": "#ffdbc8",
            "primary-container": "#0b61bb",
            "background": "#f7f9fb",
            "on-background": "#191c1e",
            "inverse-on-surface": "#eff1f3",
            "surface-container-high": "#e6e8ea",
            "surface-bright": "#f7f9fb",
            "on-secondary": "#ffffff",
            "surface": "#f7f9fb",
            "on-primary": "#ffffff",
            "outline": "#717782",
            "on-error": "#ffffff",
            "on-primary-container": "#d0dfff",
            "on-surface-variant": "#414751",
            "primary-fixed-dim": "#a9c7ff",
            "on-surface": "#191c1e",
            "on-error-container": "#93000a"
          },
          fontFamily: {
            "headline": ["Inter"],
            "body": ["Inter"],
            "label": ["Inter"]
          },
          borderRadius: {
            "DEFAULT": "0.25rem",
            "lg": "0.5rem",
            "xl": "0.75rem",
            "full": "9999px"
          },
        },
      },
    }
  </script>
  <style>
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
      display: inline-block;
      line-height: 1;
      text-transform: none;
      letter-spacing: normal;
      word-wrap: normal;
      white-space: nowrap;
      direction: ltr;
    }

    .clinical-blur {
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
    }

    .soft-elevation {
      shadow: 0 24px 48px -12px rgba(25, 28, 30, 0.04);
    }
  </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    <script src="{{ asset('js/mobile-nav.js') }}" defer></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script src="{{ asset('js/patient-qr.js') }}"></script>
</head>

<body class="bg-surface font-body text-on-background min-h-screen flex flex-col selection:bg-primary-fixed">
  <!-- TopNavBar (Updated to match Patient Portal style) -->
  <nav
    class="fixed top-0 w-full z-50 bg-slate-50/85 backdrop-blur-md shadow-sm shadow-blue-900/5 transition-all duration-300 ease-in-out font-sans antialiased tracking-tight">
    <div class="flex justify-between items-center px-8 py-4 max-w-full mx-auto">
      <!-- Brand -->
      <a href="{{ url('/') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity cursor-pointer">
        <div class="w-8 h-8 bg-primary rounded-[1rem] flex items-center justify-center text-white">
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
  <main class="flex-grow flex items-center justify-center px-4 pt-24 pb-12">
    <!-- Background Ethereal Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-primary-fixed/20 rounded-full blur-[120px]"></div>
      <div class="absolute top-[60%] -right-[5%] w-[30%] h-[30%] bg-secondary-container/30 rounded-full blur-[100px]">
      </div>
    </div>
    <!-- Central Soft UI Card -->
    <div class="relative w-full max-w-[480px] z-10">
      <div
        class="bg-surface-container-lowest rounded-xl p-8 md:p-12 shadow-[0_24px_48px_-12px_rgba(25,28,30,0.04)] ring-1 ring-outline-variant/10">
        <!-- Editorial Header Section -->
        <div class="mb-10 text-center md:text-left">
          <span
            class="inline-block px-3 py-1 mb-4 rounded-full bg-secondary-fixed text-on-secondary-fixed-variant text-[10px] font-bold uppercase tracking-widest"
            style="">Patient Portal</span>
          <h1 class="text-display-md font-headline font-extrabold tracking-tight text-on-surface mb-3 leading-tight"
            style="">
            Track Your Health Journey
          </h1>
          <p class="text-on-surface-variant text-sm leading-relaxed max-w-[340px]" style="">
            Enter your Tracking ID and Date of Birth to access your treatment status.
          </p>
        </div>
        <!-- Form Section -->
        <form id="trackForm" class="space-y-6" novalidate>
          @csrf
          <div class="mb-8">
            <button id="scanQrBtn"
              class="w-full flex flex-col items-center justify-center p-6 border-2 border-dashed border-primary/30 rounded-xl bg-primary/5 hover:bg-primary/10 transition-colors group"
              type="button">
              <div
                class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-primary text-[32px]">qr_code_scanner</span>
              </div>
              <span class="text-sm font-bold text-primary uppercase tracking-wider mb-1">Scan QR Code</span>
              <span class="text-[11px] text-on-surface-variant text-center">Scan or upload your Patient ID QR code to fill in your Tracking ID</span>
            </button>
            <div class="relative flex py-6 items-center">
              <div class="flex-grow border-t border-outline-variant/30"></div>
              <span class="flex-shrink mx-4 text-[10px] font-bold text-outline uppercase tracking-widest">OR ENTER
                MANUALLY</span>
              <div class="flex-grow border-t border-outline-variant/30"></div>
            </div>
          </div>
          <div class="space-y-2">
            <label class="text-label-md font-semibold text-on-surface-variant flex items-center gap-2 ml-1"
              for="tracking-id" style="">
              <span class="material-symbols-outlined text-[16px]" style="">fingerprint</span>
              Tracking ID
            </label>
            <div class="relative group">
              <input
                class="w-full h-14 bg-surface-container-highest border-none rounded-lg px-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all duration-300"
                id="tracking-id" name="tracking_id" placeholder="e.g., CEB-20261120-19840910-001" type="text"
                autocomplete="off" spellcheck="false" autocapitalize="characters" />
            </div>
          </div>
          <div class="space-y-2">
            <label class="text-label-md font-semibold text-on-surface-variant flex items-center gap-2 ml-1" for="dob"
              style="">
              <span class="material-symbols-outlined text-[16px]" style="">calendar_today</span>
              Date of Birth
            </label>
            <div class="relative">
              <input
                class="w-full h-14 bg-surface-container-highest border-none rounded-lg px-4 text-on-surface focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all duration-300 appearance-none"
                id="dob" name="dob" type="date" />
            </div>
          </div>
          <p id="trackError" role="alert" class="hidden text-xs text-error font-semibold bg-error-container/50 py-2.5 px-3 rounded-lg"></p>
          <div class="pt-4">
            <button id="trackBtn"
              class="w-full h-14 bg-gradient-to-r from-primary to-primary-container text-on-primary font-bold rounded-lg shadow-lg shadow-primary/10 active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 group disabled:opacity-60 disabled:cursor-not-allowed"
              style="" type="submit">
              <span id="trackBtnText">Track Status</span>
              <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform"
                style="">arrow_forward</span>
            </button>
          </div>
        </form>
        <!-- Status Alerts Context (As per Status Badges rule) -->
        <div class="mt-8 flex items-center justify-center gap-4 border-t border-outline-variant/10 pt-8">
          <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-error animate-pulse"></div>
            <span class="text-[11px] font-medium text-on-surface-variant uppercase tracking-wider" style="">Live
              Processing</span>
          </div>
          <div class="w-1 h-1 rounded-full bg-outline-variant"></div>
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[14px] text-primary" style="">verified_user</span>
            <span class="text-[11px] font-medium text-on-surface-variant uppercase tracking-wider" style="">Secure
              Access</span>
          </div>
        </div>
      </div>
      <!-- Supporting Text -->
      <p class="mt-8 text-center text-xs text-on-surface-variant leading-relaxed px-6" style="">By accessing the portal,
        you agree to our clinical data privacy standards. Need Help? Please visit the
        Information Staff at ABTC.</p>
    </div>
  </main>
  @include('partials.patient-qr-modal')
  <!-- Footer Execution -->
  <footer class="w-full border-t border-slate-200/10 bg-slate-50 dark:bg-slate-950">
    <div class="flex flex-col md:flex-row justify-between items-center px-6 md:px-12 py-8 gap-4 max-w-7xl mx-auto text-center">
      <p class="text-xs font-medium uppercase tracking-widest font-['Inter'] text-slate-500 dark:text-slate-500"
        style="">
        © 2026 Cebu City Health Department</p>
      <div class="flex flex-wrap justify-center gap-x-6 gap-y-2">
        <a class="text-xs font-medium uppercase tracking-widest font-['Inter'] text-slate-500 dark:text-slate-500 hover:text-blue-500 transition-colors"
          href="#" style="">Privacy Policy</a>
        <a class="text-xs font-medium uppercase tracking-widest font-['Inter'] text-slate-500 dark:text-slate-500 hover:text-blue-500 transition-colors"
          href="#" style="">Terms of Service</a>
        <a class="text-xs font-medium uppercase tracking-widest font-['Inter'] text-slate-500 dark:text-slate-500 hover:text-blue-500 transition-colors"
          href="#" style="">Accessibility</a>
      </div>
    </div>
  </footer>
  <!-- Image Data Attributions -->
  <div class="hidden">
    <img class="" data-alt="Soft ethereal blue gradient background representing medical precision"
      src="https://lh3.googleusercontent.com/aida-public/AB6AXuBaTOCLKXIgEDfAA4belsx5lVLmZpxCA5Nup7hMHU6mHxzG_hkqlq-s3BWZVny9hQeevGB8XXDzLEcXGf7FI6UkgcA5tKVCzBxs0UiexpJ5QBAlDknOjNJM-_XKMs_YbjYvhjKYRYO1_a0_hmZqr5SATXbzh1fAdWcZRR-P5F5n1hy_6SapthrbjCExcXGz21IZ9kSORpcM2BsR2OLbdRee6kC8tZD4uo9F-AzpdZnJQkGqvm6XIaE-Q7WSpEesCQPk2UZkkYpGwfto"
      style="" />
    <img class="" data-alt="Minimalist clinical healthcare system logo for RAR-System"
      src="https://lh3.googleusercontent.com/aida-public/AB6AXuCPV5Ewc6XTghkI4hFS5k7etBTyAR2YUdKV2G4iVKovRNg57B2k_774GMJjOOZyC4AtQMzrqxthC9TxBpcMDwEBKOKOpBsyVyWKxMy3r40YcKFDyXdfBJj2sxOENpz8hzH_HW_F0xsvtdyigxXIP6QZAoX_72RGLD8xfiqKGqjz0eIz6E5b3tlA6mdPndOyHJE9Jillgtt3BG7Q6G34niYAuMp_UnJklfNRykt69lgNAd_ZPfofdQja50atY1Wk6CCz_AUk_YiCMWDa"
      style="" />
  </div>

  <script>
    const $ = (id) => document.getElementById(id);

    $('dob').max = (() => { const n = new Date(); return n.getFullYear() + '-' + String(n.getMonth() + 1).padStart(2, '0') + '-' + String(n.getDate()).padStart(2, '0'); })();

    // ---- scan / upload the Patient ID QR code: fills the Tracking ID (the birth date is still needed)
    PatientQr.init({
      openButton: 'scanQrBtn',
      onCode: function (id) {
        $('tracking-id').value = id;
        hideError();
        $('dob').focus();
      },
    });

    function showError(msg) { const e = $('trackError'); e.textContent = msg; e.classList.remove('hidden'); }
    function hideError() { $('trackError').classList.add('hidden'); }

    // ---- look up the status
    $('trackForm').addEventListener('submit', async function (e) {
      e.preventDefault();
      hideError();
      const id = $('tracking-id').value.trim().toUpperCase();
      const dob = $('dob').value;
      if (!id) return showError('Please enter your Tracking ID, or scan your QR code.');
      if (!PatientQr.PATIENT_ID_RE.test(id)) return showError('That Tracking ID is not valid. It looks like CEB-20261120-19840910-001.');
      if (!dob) return showError('Please enter your date of birth.');

      const btn = $('trackBtn');
      let leaving = false;
      btn.disabled = true; $('trackBtnText').textContent = 'Checking...';
      try {
        const res = await fetch(@json(route('patient.tracking.lookup')), {
          method: 'POST',
          headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('#trackForm input[name=_token]').value },
          body: JSON.stringify({ tracking_id: id, dob: dob }),
        });
        let data = {};
        try { data = await res.json(); } catch (err) { /* not JSON */ }
        if (res.status === 419) return showError('Your session expired. Please reload the page and try again.');
        if (res.status === 429 && !data.message) return showError('Too many searches. Please wait a minute and try again.');
        if (!data.found) return showError(data.message || 'No record matches that Tracking ID and date of birth. Please check them and try again.');
        leaving = true;   // the result opens on its own page; the button stays on "Checking..." until it does
        window.location.href = data.redirect;
      } catch (err) {
        showError('Something went wrong. Please try again.');
      } finally {
        if (!leaving) { btn.disabled = false; $('trackBtnText').textContent = 'Track Status'; }
      }
    });
    // coming back with the Back button: the form is ready again
    window.addEventListener('pageshow', function (e) {
      if (e.persisted) { $('trackBtn').disabled = false; $('trackBtnText').textContent = 'Track Status'; }
    });
  </script>
</body>

</html>