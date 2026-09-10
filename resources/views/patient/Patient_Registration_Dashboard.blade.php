<!DOCTYPE html>

<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Patient Registration - ABTC-Insight</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap"
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
            "surface-dim": "#d8dadc",
            "primary-container": "#0b61bb",
            "on-tertiary": "#ffffff",
            "primary": "#004a93",
            "tertiary-container": "#9e4b00",
            "on-surface": "#191c1e",
            "background": "#f7f9fb",
            "surface-bright": "#f7f9fb",
            "on-primary-fixed": "#001b3d",
            "error-container": "#ffdad6",
            "surface-container-high": "#e6e8ea",
            "on-error": "#ffffff",
            "tertiary-fixed-dim": "#ffb689",
            "secondary-fixed-dim": "#b1c8ec",
            "outline": "#717782",
            "on-tertiary-fixed": "#311300",
            "surface": "#f7f9fb",
            "inverse-surface": "#2d3133",
            "tertiary-fixed": "#ffdbc8",
            "inverse-on-surface": "#eff1f3",
            "on-secondary-fixed-variant": "#314866",
            "on-error-container": "#93000a",
            "secondary-container": "#c1d9fd",
            "on-tertiary-fixed-variant": "#743500",
            "surface-container-lowest": "#ffffff",
            "on-secondary-container": "#485f7e",
            "surface-variant": "#e0e3e5",
            "on-primary": "#ffffff",
            "secondary": "#49607f",
            "on-surface-variant": "#414751",
            "on-secondary-fixed": "#011c38",
            "surface-container-low": "#f2f4f6",
            "on-primary-container": "#d0dfff",
            "error": "#ba1a1a",
            "on-secondary": "#ffffff",
            "on-tertiary-container": "#ffd7c0",
            "outline-variant": "#c1c7d3",
            "primary-fixed": "#d6e3ff",
            "inverse-primary": "#a9c7ff",
            "surface-tint": "#005db6",
            "surface-container": "#eceef0",
            "primary-fixed-dim": "#a9c7ff",
            "on-primary-fixed-variant": "#00468c",
            "surface-container-highest": "#e0e3e5",
            "secondary-fixed": "#d3e4ff",
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
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }

    .glass-effect {
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
    }

    .soft-shadow {
      shadow-color: rgba(25, 28, 30, 0.04);
      box-shadow: 0 24px 48px -12px rgba(25, 28, 30, 0.04);
    }

    .clinical-gradient {
      background: linear-gradient(135deg, #004a93 0%, #0b61bb 100%);
    }
  </style>
</head>

<body class="bg-surface font-body text-on-surface antialiased">
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
  <main class="min-h-screen pt-24 pb-12 px-6 flex flex-col items-center justify-center relative overflow-hidden">
    <!-- Background decorative elements -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full pointer-events-none opacity-20">
      <div class="absolute top-20 left-10 w-96 h-96 bg-primary-fixed rounded-full blur-[120px]"></div>
      <div class="absolute bottom-20 right-10 w-96 h-96 bg-secondary-container rounded-full blur-[120px]"></div>
    </div>
    <!-- Hero Section -->
    <div class="w-full max-w-4xl text-center mb-16 relative z-10">
      <span
        class="inline-block px-4 py-1.5 mb-6 text-xs font-bold tracking-widest uppercase rounded-full bg-secondary-container text-on-secondary-container">
        Cebu City Health Department
      </span>
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-on-surface mb-6 leading-tight">
        Animal Bite Treatment <br /><span class="text-primary">Care &amp; Registration</span>
      </h1>
      <p class="text-lg text-on-surface-variant max-w-2xl mx-auto font-medium">
        Welcome to the digital portal for ABTC services. Please select your status below to begin your consultation
        process.
      </p>
    </div>
    <!-- Registration Cards Bento Grid -->
    <div class="grid md:grid-cols-2 gap-8 w-full max-w-5xl relative z-10">
      <!-- New Patient Card -->
      <div
        class="group bg-surface-container-lowest p-10 rounded-xl soft-shadow transition-all duration-500 hover:bg-surface-bright flex flex-col items-start text-left border border-transparent hover:border-outline-variant/10">
        <div
          class="mb-8 p-4 rounded-2xl bg-primary-fixed text-primary group-hover:scale-110 transition-transform duration-500">
          <span class="material-symbols-outlined text-4xl" data-icon="person_add">person_add</span>
        </div>
        <h2 class="text-2xl font-bold tracking-tight text-on-surface mb-4">New Patient</h2>
        <p class="text-on-surface-variant leading-relaxed mb-10">
          I have never been vaccinated at CCHD-ABTC before. Select this option to create a new health record and
          schedule your first consultation.
        </p>
        <div class="mt-auto w-full">
          <a href="{{ route('patient.new-patient') }}"
            class="w-full py-4 px-6 rounded-xl bg-primary text-on-primary font-bold tracking-tight shadow-md hover:bg-primary-container hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 group/btn">
            Register as New Patient
            <span class="material-symbols-outlined text-lg group-hover/btn:translate-x-1 transition-transform"
              data-icon="arrow_forward">arrow_forward</span>
          </a>
        </div>
      </div>
      <!-- Returning Patient Card -->
      <div
        class="group bg-surface-container-lowest p-10 rounded-xl soft-shadow transition-all duration-500 hover:bg-surface-bright flex flex-col items-start text-left border border-transparent hover:border-outline-variant/10">
        <div
          class="mb-8 p-4 rounded-2xl bg-tertiary-fixed text-tertiary group-hover:scale-110 transition-transform duration-500">
          <span class="material-symbols-outlined text-4xl" data-icon="history">history</span>
        </div>
        <h2 class="text-2xl font-bold tracking-tight text-on-surface mb-4">Returning Patient</h2>

        <!-- Updated Description -->
        <p class="text-on-surface-variant leading-relaxed mb-10">
          I already have a record at CCHD-ABTC. Use this portal if you need to report a new animal bite incident, or if
          you are returning to get your follow up doses (such as dose 2, 3, 4, or 5).
        </p>

        <div class="mt-auto w-full">
          <!-- Changed to an anchor tag with the returning-patient route -->
          <a href="{{ route('patient.returning-patient') }}"
            class="w-full py-4 px-6 rounded-xl bg-surface-container-high text-on-surface font-bold tracking-tight hover:bg-surface-variant transition-all duration-300 flex items-center justify-center gap-2 border border-outline-variant/20">
            Log in as Returning Patient
            <span class="material-symbols-outlined text-lg" data-icon="login">login</span>
          </a>
        </div>
      </div>
    </div>
    <!-- Information Triage System -->
    <div class="mt-16 w-full max-w-5xl flex flex-wrap gap-4 justify-center">
      <div
        class="flex items-center gap-3 px-5 py-2.5 rounded-full bg-error-container text-on-error-container text-sm font-semibold">
        <span class="material-symbols-outlined text-lg" data-icon="emergency_home">emergency_home</span>
        Emergency bite case? Visit clinical center immediately.
      </div>
      <div
        class="flex items-center gap-3 px-5 py-2.5 rounded-full bg-secondary-container text-on-secondary-container text-sm font-semibold">
        <span class="material-symbols-outlined text-lg" data-icon="verified_user">verified_user</span>
        Secure HIPAA compliant registration
      </div>
    </div>
  </main>
  <!-- Visual Anchor Section (Asymmetric) -->
  <section class="max-w-7xl mx-auto px-6 py-20">
    <div class="grid lg:grid-cols-2 gap-16 items-center">
      <div class="order-2 lg:order-1">
        <div class="relative rounded-xl overflow-hidden shadow-2xl">
          <img alt="Medical Facility" class="w-full h-[400px] object-cover"
            data-alt="Modern medical facility interior with clean glass walls, soft blue lighting, and professional medical staff in a minimalist hallway"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuC0fFEvRiiSqCgM4R6WVxQn1JVnaJQiDvjYVSg8RdYCYWY0yv8fJeMifaKshlJk64Heo9QiTF0dOYVd7c1oCQkcDd6pVkPAk1I0z4qTAtIwKQ_Ehu2CPTOW1yySCQXUjT2-SR1j2A2XiCy_7IE-Z0rYdB_FWMq1nZZ1aOeO24fd2NE9Kp-GuDhQBn5bviDNNNvVrjqr5QlB-oUjkMqpWMkKmsgAw331ihhRg6e2D6UjqsAjyts42THLeQLgr3hs-P8feH03yoFzVknT" />
          <div class="absolute inset-0 bg-gradient-to-t from-primary/40 to-transparent"></div>
        </div>
      </div>
      <div class="order-1 lg:order-2 space-y-6">
        <h3 class="text-3xl font-bold tracking-tight text-on-surface">Integrated Health Monitoring</h3>
        <p class="text-on-surface-variant text-lg font-medium leading-relaxed">
          ABTC-Insight provides real-time tracking for your vaccination schedule. Our clinical portal ensures you never
          miss a critical dose, providing peace of mind through automated reminders and digital certifications.
        </p>
        <div class="grid grid-cols-2 gap-4">
          <div class="bg-surface-container-low p-4 rounded-lg">
            <p class="text-2xl font-bold text-primary mb-1">24/7</p>
            <p class="text-xs uppercase font-bold tracking-widest text-on-surface-variant">Portal Access</p>
          </div>
          <div class="bg-surface-container-low p-4 rounded-lg">
            <p class="text-2xl font-bold text-primary mb-1">0%</p>
            <p class="text-xs uppercase font-bold tracking-widest text-on-surface-variant">Lost Records</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Footer: Updated to match SCREEN_40 style -->
  <footer class="bg-surface-container-low border-t border-outline-variant/10 py-8 px-8">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
      <div class="text-sm font-medium text-on-surface-variant">
        © 2026 CEBU CITY HEALTH DEPARTMENT
      </div>
      <div class="flex flex-wrap justify-center gap-6 md:gap-8">
        <a class="text-xs font-bold uppercase tracking-widest text-on-surface-variant hover:text-primary transition-colors"
          href="#">Privacy Policy</a>
        <a class="text-xs font-bold uppercase tracking-widest text-on-surface-variant hover:text-primary transition-colors"
          href="#">Terms of Service</a>
        <a class="text-xs font-bold uppercase tracking-widest text-on-surface-variant hover:text-primary transition-colors"
          href="#">Accessibility</a>
      </div>
    </div>
  </footer>
</body>

</html>