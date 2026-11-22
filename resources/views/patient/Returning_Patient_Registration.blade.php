<!DOCTYPE html>

<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Returning Patient Registration | ABTC-Insight</title>
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

    /* the dose the patient picked: same layout as a given dose (Day / date / status), in the primary blue */
    .dose-chip.is-selected {
      background-color: #d6e3ff;
      border-color: #004a93;
      color: #004a93;
      box-shadow: 0 0 0 3px rgba(0, 74, 147, 0.15);
    }
    .dose-chip.is-selected .dose-status { color: #004a93; font-size: 10px; font-weight: 700; }

    .clinical-gradient {
      background: linear-gradient(135deg, #004a93 0%, #0b61bb 100%);
    }
  </style>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script src="{{ asset('js/custom-select.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    <script src="{{ asset('js/mobile-nav.js') }}" defer></script>
</head>

<body class="bg-surface text-on-surface min-h-screen flex flex-col">
  <!-- TopNavBar (Updated to match Patient Portal style) -->
  <nav class="fixed top-0 w-full z-50 bg-slate-50/85 backdrop-blur-md shadow-sm shadow-blue-900/5 transition-all duration-300 ease-in-out font-sans antialiased tracking-tight">
    <div class="flex justify-between items-center px-8 py-4 max-w-full mx-auto">
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
          <a class="text-slate-600 hover:text-blue-600 transition-colors text-sm font-medium" href="{{ route('patient.register') }}">Patient Registration</a>
          <a class="text-slate-600 hover:text-blue-600 transition-colors text-sm font-medium" href="{{ route('patient.tracking.portal') }}">Tracking Portal</a>
        </div>
      </div>
    </div>
  </nav>
  <main class="min-h-screen flex flex-col items-center px-4 pt-24 pb-12">
    <!-- Breadcrumb -->
    <div class="w-full max-w-[680px] mb-6 flex items-center gap-2 group cursor-pointer"
      onclick="window.location.href='{{ route('patient.register') }}'">
      <span class="material-symbols-outlined text-on-surface-variant text-sm">arrow_back</span>
      <span class="text-on-surface-variant text-sm font-medium group-hover:text-primary transition-colors">Back to
        selection</span>
    </div>
    <!-- Main Form Card -->
    <div class="w-full max-w-[680px] bg-surface-container-lowest rounded-xl shadow-[0_8px_32px_rgba(0,0,0,0.04)] overflow-hidden">
      <div class="p-5 sm:p-8 md:p-12">
        <!-- Header -->
        <div class="flex flex-wrap justify-between items-start gap-3 mb-10">
          <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-on-surface">Returning Patient</h1>
            <p class="text-on-surface-variant mt-2 text-lg">Check in for your next anti-rabies vaccine dose</p>
          </div>
          <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-[12px] font-bold tracking-wide uppercase whitespace-nowrap shrink-0">Existing Record</span>
        </div>
        <!-- Step Indicator -->
        <div class="flex items-center mb-12">
          <!-- Step 1 -->
          <div class="flex flex-col items-center gap-2 shrink-0">
            <div class="w-10 h-10 rounded-full step-active flex items-center justify-center shadow-lg ring-4 ring-primary-container/20" id="returningStepCircle-1">
              <span class="font-bold">1</span>
            </div>
            <span class="text-xs font-bold text-primary uppercase tracking-wider" id="returningStepLabel-1">Find Record</span>
          </div>
          <div class="flex-1 h-[2px] bg-surface-container-high mx-1 -mt-6 transition-colors" id="returningStepLine-1"></div>
          <!-- Step 2 -->
          <div class="flex flex-col items-center gap-2 shrink-0">
            <div class="w-10 h-10 rounded-full step-inactive flex items-center justify-center" id="returningStepCircle-2">
              <span class="font-bold">2</span>
            </div>
            <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider" id="returningStepLabel-2">Choose Dose</span>
          </div>
          <div class="flex-1 h-[2px] bg-surface-container-high mx-1 -mt-6 transition-colors" id="returningStepLine-2"></div>
          <!-- Step 3 -->
          <div class="flex flex-col items-center gap-2 shrink-0">
            <div class="w-10 h-10 rounded-full step-inactive flex items-center justify-center" id="returningStepCircle-3">
              <span class="font-bold">3</span>
            </div>
            <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider" id="returningStepLabel-3">Confirm</span>
          </div>
        </div>

        @if($errors->any())
        <div class="bg-red-50 text-red-700 px-6 py-4 rounded-lg text-sm font-medium mb-6">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('patient.submit.returning') }}" method="POST" id="returningForm">
          @csrf
          <input type="hidden" name="token" id="tokenInput" value="">
          <input type="hidden" name="bite_case_id" id="caseInput" value="">
          <input type="hidden" name="dose_day" id="doseInput" value="">

          <!-- Section 1: Find the record with the unique Patient ID (CEB-...); full name + date of birth is the fallback -->
          <div class="mb-10" id="lookupSection">
            <div id="idLookup" class="mb-4">
              <div class="space-y-1.5">
                <label class="text-xs font-bold text-on-surface-variant uppercase ml-1" for="searchPatientId">Patient ID</label>
                <div class="flex flex-wrap gap-2">
                  <input type="text" id="searchPatientId" autocomplete="off" spellcheck="false" placeholder="CEB-20261120-19840910-001" class="w-full basis-full sm:basis-0 sm:flex-1 min-w-0 bg-surface-container-highest border-0 focus:ring-2 focus:ring-primary/20 rounded-lg px-4 py-3.5 font-medium uppercase tracking-wide" />
                  <button type="button" id="scanQrBtn" title="Scan your Patient ID QR code"
                    class="w-full sm:w-auto justify-center bg-secondary-container text-on-secondary-container px-5 py-3.5 rounded-lg text-sm font-bold hover:opacity-90 active:scale-95 transition-all flex items-center gap-1.5 whitespace-nowrap">
                    <span class="material-symbols-outlined text-[18px]">qr_code_scanner</span>
                    <span>Scan QR</span>
                  </button>
                </div>
                <p class="text-xs text-on-surface-variant ml-1">The ID you were given at your first visit. It starts with CEB. You can also scan or upload the QR code from your last visit.</p>
              </div>
            </div>
            <button type="button" id="toggleLookup" class="text-sm font-bold text-primary hover:underline mb-4">I don't have my Patient ID</button>
            <div id="nameLookup" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div class="space-y-1.5">
                <label class="text-xs font-bold text-on-surface-variant uppercase ml-1" for="searchName">Full Name</label>
                <input type="text" id="searchName" autocomplete="off" placeholder="e.g. Juan Dela Cruz" class="w-full bg-surface-container-highest border-0 focus:ring-2 focus:ring-primary/20 rounded-lg px-4 py-3.5 font-medium" />
              </div>
              <div class="space-y-1.5">
                <label class="text-xs font-bold text-on-surface-variant uppercase ml-1" for="searchDob">Date of Birth</label>
                <input type="date" id="searchDob" class="w-full bg-surface-container-highest border-0 focus:ring-2 focus:ring-primary/20 rounded-lg px-4 py-3.5 font-medium" />
              </div>
            </div>
            <button type="button" id="searchBtn" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3.5 rounded-lg transition-all">Find My Record</button>
            <div id="notFoundMsg" class="hidden mt-4 bg-red-50 text-red-700 px-6 py-4 rounded-lg text-sm font-medium">
              No matching record found. Please check your Patient ID, or approach the registration desk.
            </div>
            <div id="recordFoundBox" class="hidden mt-4 bg-emerald-600 text-white px-6 py-4 rounded-lg items-center gap-3 shadow-md">
              <span class="material-symbols-outlined">person_check</span>
              <div class="text-sm"><span class="font-bold">Record found:</span> <span id="foundName"></span></div>
            </div>
          </div>

          <!-- Section 2: Choose the dose. Shown once a record has been found -->
          <div id="detailsSection" class="hidden">
            <div class="flex items-center gap-3 mb-6">
              <h2 class="text-xs font-black tracking-[0.15em] text-on-surface-variant uppercase">Your doses: tap the one you are here for</h2>
              <div class="h-px flex-grow bg-outline-variant opacity-20"></div>
            </div>

            <div id="noCaseMsg" class="hidden bg-amber-50 border border-amber-200 text-amber-800 px-6 py-4 rounded-lg text-sm font-medium">
              You have no ongoing vaccine course to check in for. If you were bitten again, please register as a new patient with a new BHW referral, or approach the registration desk.
            </div>

            <div id="casesList" class="space-y-5"></div>

            <div id="confirmArea" class="hidden mt-8 space-y-6">
              <div class="space-y-1.5">
                <label class="text-xs font-bold text-emerald-700 uppercase ml-1" for="returningContactNumberInput">Contact Number (update if changed)</label>
                <input name="contact_num" id="returningContactNumberInput" class="w-full bg-emerald-50/30 border-0 border-b-2 border-emerald-500/30 focus:border-emerald-500 focus:ring-0 text-on-surface font-medium px-4 py-3.5 rounded-t-lg transition-all" type="text" placeholder="09XX XXX XXXX" />
              </div>
              <div class="pt-6 border-t border-outline-variant/15 flex flex-col md:flex-row items-center justify-between gap-4">
                <button type="button" id="clearBtn" class="text-on-surface-variant font-bold text-sm px-6 py-3 rounded-lg hover:bg-surface-container-low transition-colors">Start Over</button>
                <button type="submit" id="submitBtn" disabled class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 disabled:opacity-40 disabled:cursor-not-allowed text-white font-bold px-8 py-4 rounded-xl shadow-lg shadow-emerald-600/20 flex items-center justify-center gap-3 transition-transform active:scale-[0.98]">
                  Confirm Check-in
                  <span class="material-symbols-outlined">arrow_forward</span>
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </main>
  <!-- Scan / upload the Patient ID QR code -->
  <div id="qrScannerModal" role="dialog" aria-modal="true" aria-labelledby="qrModalTitle" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm items-center justify-center p-4">
    <div class="bg-surface-container-lowest rounded-2xl max-w-md w-full p-6 shadow-2xl border border-outline-variant/30 space-y-4 max-h-[92vh] overflow-y-auto">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-primary">qr_code_scanner</span>
          <h3 id="qrModalTitle" class="font-bold text-base text-on-surface">Scan or Upload Patient QR</h3>
        </div>
        <button type="button" id="closeQrModalBtn" aria-label="Close" class="p-1 text-on-surface-variant hover:text-on-surface rounded-lg">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>

      <div class="grid grid-cols-2 gap-2 p-1 bg-surface-container rounded-xl">
        <button type="button" id="tabCameraBtn" class="py-2 px-3 rounded-lg text-xs font-bold bg-white text-primary shadow-sm transition-all flex items-center justify-center gap-1.5">
          <span class="material-symbols-outlined text-[16px]">photo_camera</span>
          Use Camera
        </button>
        <button type="button" id="tabUploadBtn" class="py-2 px-3 rounded-lg text-xs font-bold text-on-surface-variant hover:text-on-surface transition-all flex items-center justify-center gap-1.5">
          <span class="material-symbols-outlined text-[16px]">upload_file</span>
          Upload QR Photo
        </button>
      </div>

      <div id="cameraPanel" class="space-y-3">
        <div id="qrReader" class="w-full rounded-xl overflow-hidden bg-black min-h-[240px]"></div>
        <p class="text-xs text-on-surface-variant text-center">Point your camera at the QR code you received at your last visit.</p>
      </div>

      <div id="uploadPanel" class="hidden space-y-3">
        <input type="file" id="qrFileInput" accept="image/png,image/jpeg,.png,.jpg,.jpeg" class="hidden" />
        <div id="qrFileDropzone" role="button" tabindex="0" class="border-2 border-dashed border-outline-variant/60 hover:border-primary rounded-xl p-8 text-center cursor-pointer transition-colors bg-surface-container-low/50">
          <span class="material-symbols-outlined text-4xl text-primary mb-2">qr_code_2</span>
          <p class="text-sm font-bold text-on-surface">Choose your QR code image</p>
          <p class="text-[11px] text-on-surface-variant mt-1">Only a PNG or JPG photo of your Patient ID QR code (up to 5 MB). Any other kind of file is rejected.</p>
        </div>
        <div id="qrFileReader" class="hidden"></div>
      </div>

      <p id="qrModalError" role="alert" class="hidden text-xs text-error font-semibold text-center bg-error-container/50 py-2 px-3 rounded-lg"></p>
    </div>
  </div>

  <!-- Footer -->
  <footer class="flex flex-col md:flex-row justify-between items-center gap-4 px-6 md:px-8 py-6 w-full border-t border-[#c1c7d3]/15 bg-[#f2f4f6] dark:bg-slate-950 font-['Inter'] text-sm text-center md:text-left">
    <div class="flex flex-col md:flex-row items-center gap-1 md:gap-4">
      <span class="font-bold text-[#004a93]">ABTC-Insight</span>
      <span class="text-[#414751] dark:text-slate-500 text-xs md:text-sm">© 2024 Cebu City Health Center. Clinical Precision System.</span>
    </div>
    <div class="flex flex-wrap justify-center gap-x-6 gap-y-2">
      <a class="text-[#414751] dark:text-slate-500 hover:text-[#004a93] dark:hover:text-blue-300 transition-colors duration-200" href="#">Privacy Policy</a>
      <a class="text-[#414751] dark:text-slate-500 hover:text-[#004a93] dark:hover:text-blue-300 transition-colors duration-200" href="#">Contact Support</a>
      <a class="text-[#414751] dark:text-slate-500 hover:text-[#004a93] dark:hover:text-blue-300 transition-colors duration-200" href="#">Terms of Service</a>
    </div>
  </footer>
 
  <script>
    // Helper to update the 3-step progress indicator
    function markReturningStep(stepNum, state) {
      const circle = document.getElementById(`returningStepCircle-${stepNum}`);
      const label = document.getElementById(`returningStepLabel-${stepNum}`);
      const line = document.getElementById(`returningStepLine-${stepNum}`);

      circle.classList.remove('step-active', 'step-complete', 'step-inactive', 'shadow-lg', 'ring-4', 'ring-primary-container/20', 'shadow-md');

      if (state === 'done') {
        circle.classList.add('step-complete', 'shadow-md');
        circle.innerHTML = '<span class="material-symbols-outlined text-xl">check</span>';
        label.classList.remove('text-primary', 'text-on-surface-variant');
        label.classList.add('text-emerald-600');
        if (line) line.className = 'flex-1 h-[2px] bg-primary/40 mx-1 -mt-6 transition-colors';
      } else if (state === 'active') {
        circle.classList.add('step-active', 'shadow-lg', 'ring-4', 'ring-primary-container/20');
        circle.innerHTML = `<span class="font-bold">${stepNum}</span>`;
        label.classList.remove('text-emerald-600', 'text-on-surface-variant');
        label.classList.add('text-primary');
        if (line) line.className = 'flex-1 h-[2px] bg-surface-container-high mx-1 -mt-6 transition-colors';
      } else {
        circle.classList.add('step-inactive');
        circle.innerHTML = `<span class="font-bold">${stepNum}</span>`;
        label.classList.remove('text-emerald-600', 'text-primary');
        label.classList.add('text-on-surface-variant');
        if (line) line.className = 'flex-1 h-[2px] bg-surface-container-high mx-1 -mt-6 transition-colors';
      }
    }

    const $ = (id) => document.getElementById(id);
    const MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    function fmtDate(iso) {
      if (!iso) return null;
      const [y, m, d] = String(iso).slice(0, 10).split('-').map(Number);
      return `${MONTHS[m - 1]} ${d}, ${y}`;
    }

    // today in the patient's own timezone (toISOString would give the UTC date, a day behind in the early morning)
    function localToday() {
      const n = new Date();
      return `${n.getFullYear()}-${String(n.getMonth() + 1).padStart(2, '0')}-${String(n.getDate()).padStart(2, '0')}`;
    }

    // ----- Scan / upload the Patient ID QR code -------------------------------------------------------------------
    // Only a real Patient ID QR code is accepted (CEB-YYYYMMDD-YYYYMMDD-NNN). The image is read in the browser and
    // never uploaded; the lookup itself is still checked by the server.
    const PATIENT_ID_RE = /^CEB-\d{8}-\d{8}-\d{1,6}$/;
    const QR_MAX_BYTES = 5 * 1024 * 1024;
    const qrModal = $('qrScannerModal');
    const qrError = $('qrModalError');
    let qrCamera = null;
    let lastBadScan = '';
    const qrFileScanner = new Html5Qrcode('qrFileReader');

    function showQrError(msg) { qrError.textContent = msg; qrError.classList.remove('hidden'); }
    function clearQrError() { qrError.textContent = ''; qrError.classList.add('hidden'); }

    // The real file type is read from the first bytes of the file, not from its name or the type the browser reports
    async function isRealPngOrJpeg(file) {
      const b = new Uint8Array(await file.slice(0, 12).arrayBuffer());
      const png = b.length >= 8 && [0x89, 0x50, 0x4E, 0x47, 0x0D, 0x0A, 0x1A, 0x0A].every((v, i) => b[i] === v);
      const jpeg = b.length >= 3 && b[0] === 0xFF && b[1] === 0xD8 && b[2] === 0xFF;
      return png || jpeg;
    }

    // true once a valid Patient ID QR code has been used
    function useScannedPatientId(rawText) {
      const id = String(rawText || '').trim().toUpperCase();
      if (!PATIENT_ID_RE.test(id)) {
        if (id !== lastBadScan) {   // the camera sees the same wrong code many times a second: say it once
          lastBadScan = id;
          showQrError('Invalid QR code. Only the Patient ID QR code from your visit (CEB-XXXXXXXX-XXXXXXXX-XXX) is accepted.');
        }
        return false;
      }
      clearQrError();
      closeQrModal();
      if (byName) $('toggleLookup').click();   // back to the Patient ID box
      $('searchPatientId').value = id;
      $('searchBtn').click();
      return true;
    }

    function stopQrCamera() {
      if (qrCamera && qrCamera.isScanning) return qrCamera.stop().catch(() => {});
      return Promise.resolve();
    }
    function startQrCamera() {
      clearQrError(); lastBadScan = '';
      if (!qrCamera) qrCamera = new Html5Qrcode('qrReader');
      if (qrCamera.isScanning) return;
      qrCamera.start({ facingMode: 'environment' }, { fps: 10, qrbox: { width: 240, height: 240 } },
        (text) => { useScannedPatientId(text); }, () => {})
        .catch(() => { showQrError('Camera unavailable or permission denied. Switch to "Upload QR Photo" above.'); });
    }

    const TAB_ON = 'py-2 px-3 rounded-lg text-xs font-bold bg-white text-primary shadow-sm transition-all flex items-center justify-center gap-1.5';
    const TAB_OFF = 'py-2 px-3 rounded-lg text-xs font-bold text-on-surface-variant hover:text-on-surface transition-all flex items-center justify-center gap-1.5';
    function qrTab(camera) {
      clearQrError(); lastBadScan = '';
      $('tabCameraBtn').className = camera ? TAB_ON : TAB_OFF;
      $('tabUploadBtn').className = camera ? TAB_OFF : TAB_ON;
      $('cameraPanel').classList.toggle('hidden', !camera);
      $('uploadPanel').classList.toggle('hidden', camera);
      if (camera) startQrCamera(); else stopQrCamera();
    }
    function openQrModal() {
      qrModal.classList.remove('hidden');
      qrModal.classList.add('flex');
      qrTab(true);
    }
    function closeQrModal() {
      stopQrCamera();
      qrModal.classList.add('hidden');
      qrModal.classList.remove('flex');
      $('qrFileInput').value = '';
      clearQrError();
    }

    $('scanQrBtn').addEventListener('click', openQrModal);
    $('closeQrModalBtn').addEventListener('click', closeQrModal);
    $('tabCameraBtn').addEventListener('click', () => qrTab(true));
    $('tabUploadBtn').addEventListener('click', () => qrTab(false));
    qrModal.addEventListener('click', (e) => { if (e.target === qrModal) closeQrModal(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !qrModal.classList.contains('hidden')) closeQrModal(); });

    const pickQrFile = () => { $('qrFileInput').value = ''; $('qrFileInput').click(); };
    $('qrFileDropzone').addEventListener('click', pickQrFile);
    $('qrFileDropzone').addEventListener('keydown', (e) => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); pickQrFile(); } });

    $('qrFileInput').addEventListener('change', async function (e) {
      const file = e.target.files[0];
      if (!file) return;
      clearQrError(); lastBadScan = '';
      const reject = (msg) => { showQrError(msg); $('qrFileInput').value = ''; };

      // 1. name, reported type and size
      if (!/\.(png|jpe?g)$/i.test(file.name) || !['image/png', 'image/jpeg'].includes(file.type)) {
        return reject('Invalid file. Only a PNG or JPG image of your QR code can be uploaded.');
      }
      if (file.size === 0) {
        return reject('This image is empty. Please choose your QR code photo.');
      }
      if (file.size > QR_MAX_BYTES) {
        return reject('The image must be smaller than 5 MB.');
      }
      // 2. what the file really is (a renamed PDF, script or other file is turned away here)
      if (!(await isRealPngOrJpeg(file))) {
        return reject('Invalid file. This is not a real PNG or JPG image.');
      }
      // 3. it must contain a Patient ID QR code
      qrFileScanner.scanFile(file, false)
        .then((text) => { useScannedPatientId(text); })
        .catch(() => { showQrError('No QR code detected in this image. Please upload a clear photo of your Patient ID QR code.'); })
        .finally(() => { $('qrFileInput').value = ''; });
    });

    $('searchDob').max =new Date().toISOString().slice(0, 10);

    // Pick a dose: highlight it, remember it, and let the patient confirm
    function chooseDose(caseId, day) {
      $('caseInput').value = caseId;
      $('doseInput').value = day;
      // The chosen dose is filled in like a given one (Day, date, status), in the primary colour, so it is clear which visit is sent
      document.querySelectorAll('button.dose-chip').forEach((chip) => {
        const on = chip.dataset.case === String(caseId) && chip.dataset.day === String(day);
        chip.classList.toggle('is-selected', on);
        chip.querySelector('.dose-date').classList.toggle('hidden', !on);
        chip.querySelector('.dose-status').textContent = on ? 'Selected' : (chip.dataset.checked === '1' ? 'Already checked in' : 'Tap to select');
      });
      $('submitBtn').disabled = false;
      markReturningStep(2, 'done');
      markReturningStep(3, 'active');
    }

    // One card per ongoing case. Doses are taken in order: D0 and the doses already given are filled in from the record,
    // ONLY the next dose can be chosen, and the ones after it stay locked until it has been given.
    function renderCases(cases) {
      const list = $('casesList');
      list.innerHTML = cases.map((c) => {
        const cells = [0, ...c.days].map((day) => {
          const date = c.dates[day];
          const given = !!date;
          const base = 'dose-chip rounded-xl border-2 px-1.5 py-3 text-center transition-all ';
          if (day === 0 || given) {
            return `<div class="${base} border-emerald-200 bg-emerald-50 text-emerald-800">
              <div class="text-[11px] font-black uppercase tracking-wide">Day ${day}</div>
              <div class="text-[11px] font-semibold mt-1">${esc(fmtDate(date) ?? 'Given')}</div>
              <div class="text-[10px] font-bold text-emerald-600 mt-0.5">Given</div></div>`;
          }
          if (day === c.next_day) {
            return `<button type="button" class="${base} border-primary/50 hover:border-primary bg-white text-on-surface ring-2 ring-primary/10"
              data-case="${c.bite_case_id}" data-day="${day}" data-checked="${c.checked_in_for === day ? 1 : 0}">
              <div class="text-[11px] font-black uppercase tracking-wide">Day ${day}</div>
              <div class="dose-date hidden text-[11px] font-semibold mt-1">${esc(fmtDate(localToday()))}</div>
              <div class="dose-status text-[11px] font-semibold mt-1 text-primary">${c.checked_in_for === day ? 'Already checked in' : 'Tap to select'}</div></button>`;
          }
          return `<div class="${base} border-dashed border-surface-container-high bg-surface-container-low text-on-surface-variant cursor-not-allowed" aria-disabled="true"
              title="Available after Day ${c.next_day ?? ''}">
              <div class="text-[11px] font-black uppercase tracking-wide">Day ${day}</div>
              <div class="text-[11px] font-semibold mt-1">Queued</div>
              <div class="text-[10px] font-semibold text-on-surface-variant/70 mt-0.5">after Day ${c.next_day ?? ''}</div></div>`;
        }).join('');
        const note = c.complete
          ? '<p class="mt-4 text-sm font-semibold text-emerald-700">All doses of this case are recorded. Your course is complete.</p>'
          : `<p class="mt-4 text-xs text-on-surface-variant">Doses still queued for you: <span class="font-bold text-on-surface">${c.days.filter((d) => !c.dates[d]).map((d) => 'Day ' + d).join(', ')}</span>. Tap your next dose, <span class="font-bold text-on-surface">Day ${c.next_day}</span>, then confirm the check-in. The doses are taken in order.</p>`;
        return `<div class="border border-outline-variant/30 rounded-xl p-5">
          <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-bold text-on-surface">Bite case #${esc(c.case_number)} · ${esc(c.dose_type)} course</p>
            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-surface-container-high text-on-surface-variant">Category ${esc(c.category)}</span>
          </div>
          <div class="grid grid-cols-3 sm:grid-cols-5 gap-3">${cells}</div>${note}</div>`;
      }).join('');

      list.querySelectorAll('button.dose-chip').forEach((chip) => {
        chip.addEventListener('click', () => chooseDose(chip.dataset.case, Number(chip.dataset.day)));
      });
    }

    function resetAll() {
      $('detailsSection').classList.add('hidden');
      $('notFoundMsg').classList.add('hidden');
      $('recordFoundBox').classList.add('hidden');
      $('recordFoundBox').classList.remove('flex');
      $('noCaseMsg').classList.add('hidden');
      $('confirmArea').classList.add('hidden');
      $('casesList').innerHTML = '';
      ['tokenInput', 'caseInput', 'doseInput', 'searchPatientId', 'searchName', 'searchDob', 'returningContactNumberInput'].forEach((id) => { $(id).value = ''; });
      $('submitBtn').disabled = true;
      markReturningStep(1, 'active');
      markReturningStep(2, 'inactive');
      markReturningStep(3, 'inactive');
    }

    $('clearBtn').addEventListener('click', resetAll);

    // "I don't have my Patient ID": switch to full name + date of birth (and back)
    let byName = false;
    $('toggleLookup').addEventListener('click', () => {
      byName = !byName;
      $('idLookup').classList.toggle('hidden', byName);
      $('nameLookup').classList.toggle('hidden', !byName);
      $('toggleLookup').textContent = byName ? 'I have my Patient ID' : "I don't have my Patient ID";
      $('notFoundMsg').classList.add('hidden');
    });

    $('searchBtn').addEventListener('click', async function () {
      const notFoundMsg = $('notFoundMsg');
      let query;
      if (byName) {
        const name = $('searchName').value.trim();
        const dob = $('searchDob').value;
        if (!name || !dob) {
          notFoundMsg.textContent = 'Please enter your full name and date of birth.';
          notFoundMsg.classList.remove('hidden');
          return;
        }
        query = `name=${encodeURIComponent(name)}&dob=${encodeURIComponent(dob)}`;
      } else {
        const patientId = $('searchPatientId').value.trim();
        if (!patientId) {
          notFoundMsg.textContent = 'Please enter your Patient ID.';
          notFoundMsg.classList.remove('hidden');
          return;
        }
        query = `patient_id=${encodeURIComponent(patientId)}`;
      }

      try {
        const response = await fetch(`/patient/search?${query}`, { headers: { Accept: 'application/json' } });
        if (response.status === 429) {
          notFoundMsg.textContent = 'Too many searches. Please wait a minute and try again.';
          notFoundMsg.classList.remove('hidden');
          return;
        }
        const data = await response.json();

        if (!data.found) {
          notFoundMsg.textContent = byName
            ? 'No matching record found. Please check your full name and date of birth, or approach the registration desk.'
            : 'No matching record found. Please check your Patient ID, or approach the registration desk.';
          notFoundMsg.classList.remove('hidden');
          $('recordFoundBox').classList.add('hidden');
          $('recordFoundBox').classList.remove('flex');
          $('detailsSection').classList.add('hidden');
          return;
        }

        notFoundMsg.classList.add('hidden');
        $('recordFoundBox').classList.remove('hidden');
        $('recordFoundBox').classList.add('flex');
        $('foundName').textContent = data.patient.patient_name;
        $('tokenInput').value = data.token;
        $('returningContactNumberInput').value = data.patient.contact_num || '';
        $('caseInput').value = '';
        $('doseInput').value = '';
        $('submitBtn').disabled = true;

        $('detailsSection').classList.remove('hidden');
        const hasCases = data.cases.length > 0;
        const canCheckIn = data.cases.some((c) => c.next_day !== null);
        $('noCaseMsg').classList.toggle('hidden', hasCases);
        $('confirmArea').classList.toggle('hidden', !canCheckIn);
        renderCases(data.cases);

        markReturningStep(1, 'done');
        markReturningStep(2, canCheckIn ? 'active' : 'inactive');
        markReturningStep(3, 'inactive');
      } catch (error) {
        console.error('Search failed:', error);
        notFoundMsg.textContent = 'Something went wrong. Please try again.';
        notFoundMsg.classList.remove('hidden');
      }
    });
  </script>
</body>

</html>