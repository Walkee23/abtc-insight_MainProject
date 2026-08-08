<!DOCTYPE html>

<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Patient Database - ABTC-Insight</title>
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
            "surface-container-low": "#f2f4f6",
            "tertiary": "#7a3800",
            "surface-variant": "#e0e3e5",
            "primary-container": "#0b61bb",
            "on-secondary-container": "#485f7e",
            "error": "#ba1a1a",
            "primary-fixed": "#d6e3ff",
            "tertiary-fixed": "#ffdbc8",
            "surface": "#f7f9fb",
            "on-surface-variant": "#414751",
            "surface-container-highest": "#e0e3e5",
            "secondary-fixed": "#d3e4ff",
            "primary-fixed-dim": "#a9c7ff",
            "inverse-primary": "#a9c7ff",
            "on-tertiary": "#ffffff",
            "on-tertiary-container": "#ffd7c0",
            "on-error-container": "#93000a",
            "on-tertiary-fixed": "#311300",
            "on-secondary-fixed-variant": "#314866",
            "tertiary-fixed-dim": "#ffb689",
            "secondary-fixed-dim": "#b1c8ec",
            "secondary": "#49607f",
            "error-container": "#ffdad6",
            "on-primary-fixed-variant": "#00468c",
            "on-primary-fixed": "#001b3d",
            "tertiary-container": "#9e4b00",
            "on-surface": "#191c1e",
            "on-secondary-fixed": "#011c38",
            "surface-tint": "#005db6",
            "secondary-container": "#c1d9fd",
            "on-background": "#191c1e",
            "inverse-on-surface": "#eff1f3",
            "primary": "#004a93",
            "surface-container": "#eceef0",
            "on-tertiary-fixed-variant": "#743500",
            "on-primary": "#ffffff",
            "surface-bright": "#f7f9fb",
            "on-secondary": "#ffffff",
            "on-error": "#ffffff",
            "outline-variant": "#c1c7d3",
            "outline": "#717782",
            "on-primary-container": "#d0dfff",
            "surface-dim": "#d8dadc",
            "inverse-surface": "#2d3133",
            "surface-container-lowest": "#ffffff",
            "surface-container-high": "#e6e8ea",
            "background": "#f7f9fb"
          },
          "borderRadius": {
            "DEFAULT": "0.25rem",
            "lg": "1rem",
            "xl": "1.25rem",
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
      -webkit-font-smoothing: antialiased;
    }

    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }

    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }
  </style>
</head>

<body class="bg-surface text-on-surface antialiased">
  <!-- TopAppBar Navigation Shell -->
  <!-- SideNavBar Navigation Shell -->
  <aside
    class="h-screen w-64 fixed left-0 top-0 bg-slate-50 dark:bg-slate-900 flex flex-col border-r border-slate-200/50 dark:border-slate-800/50 py-6 font-['Inter'] tracking-tight z-50">
    <div class="px-6 mb-10 flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-on-primary">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
      </div>
      <div>
        <h1 class="text-lg font-bold text-blue-900 dark:text-blue-100 leading-none">ABTC-Insight</h1>
      </div>
    </div>
    <nav class="flex-1 space-y-1 px-3">
      <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all"
        href="{{ route('healthworker.dashboard') }}">
        <span class="material-symbols-outlined">dashboard</span>
        <span class="text-sm">Dashboard</span>
      </a>
      <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all"
        href="{{ route('healthworker.clinical-encoding') }}">
        <span class="material-symbols-outlined">medical_services</span>
        <span class="text-sm">Clinical Encoding</span>
      </a>
      <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all"
        href="{{ route('healthworker.treatment-tracker') }}">
        <span class="material-symbols-outlined">monitor_heart</span>
        <span class="text-sm">Treatment Tracker</span>
      </a>
      <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-blue-700 text-blue-700 bg-blue-50 dark:bg-blue-900/20 font-semibold transition-all"
        href="{{ route('healthworker.patient-database') }}">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">database</span>
        <span class="text-sm">Patient Database</span>
      </a>
      <a class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all"
        href="{{ route('healthworker.compliance') }}">
        <span class="material-symbols-outlined">verified_user</span>
        <span class="text-sm">Compliance</span>
      </a>
    </nav>
  </aside>
  <header
    class="fixed top-0 w-full h-16 bg-slate-50/85 dark:bg-slate-900/85 backdrop-blur-md shadow-sm shadow-blue-900/5 z-40">
    <div class="flex justify-between items-center px-8 h-16 w-full">
      <!-- Logo on the far left -->
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white shadow-md">
          <span class="material-symbols-outlined text-[18px]"
            style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
        </div>
        <h1 class="text-blue-900 dark:text-blue-50 font-bold text-sm tracking-tight leading-none">ABTC-Insight</h1>
      </div>
      <!-- Search Bar -->
      <div class="flex items-center flex-1 max-w-md ml-12">
        <div class="relative w-full group">
          <span
            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm group-focus-within:text-blue-700 transition-colors">search</span>
          <input
            class="w-full bg-slate-100 dark:bg-slate-800/50 border-none rounded-full py-2 pl-9 pr-4 text-xs focus:ring-2 focus:ring-blue-700/20 placeholder:text-slate-400 font-['Inter']"
            placeholder="Search records..." type="text" />
        </div>
      </div>
      <!-- Right Side Actions (Notifications, Help, Vertical Divider, Profile) -->
      <div class="flex items-center gap-4">
        <button
          class="relative w-9 h-9 flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all rounded-full">
          <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
          <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-slate-50"></span>
        </button>
        <button
          class="w-9 h-9 flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all rounded-full">
          <span class="material-symbols-outlined" data-icon="help">help</span>
        </button>
        <div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-800 mx-2"></div>
        <div class="flex items-center gap-3 cursor-pointer group relative">
          <div class="text-right hidden lg:block">
            <p class="text-xs font-bold text-on-surface leading-tight font-['Inter']">Dr. Elena Santos</p>
            <p class="text-[10px] text-on-surface-variant font-['Inter']">Senior Health Worker</p>
          </div>
          <img alt="Health Worker Profile"
            class="w-9 h-9 rounded-full object-cover ring-2 ring-primary/10 group-hover:ring-primary/30 transition-all"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAzuEzGuKhuDJKI44bu6U1YzFdI7z5disX1FjUVLwgq07xpkF1vi2q1RQg1lWnbbzx-97qaEaUE0wHwrsBEDnQdIf8whoLOPKyx4AYqvvB-lfqq-SS3OBugICvjWAE_JcAHe0Vi0CwgldGbMzdKqqq-JDxrvKkK7FcZlxsnNKgOhrLZQUJ0ev2rjCkC13g53yP7Tgqv7JJmgsQFbx1nOvxapzia3kkgWKs_FBVNJ7u5msUyUkju3OqnpM2i3ofnQDyojEEc-LEA3xlD" />
          <div
            class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
            <div class="p-2">
              <a href="#"
                class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary rounded-lg transition-colors">
                <span class="material-symbols-outlined text-[18px]">person</span>
                My Profile
              </a>
              <div class="h-px bg-slate-100 my-1"></div>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                  class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors text-left">
                  <span class="material-symbols-outlined text-[18px]">logout</span>
                  Log Out
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Main Content Canvas -->
  <main class="ml-64 pt-24 min-h-screen flex flex-col relative bg-surface px-8 pb-8">
    <div class="max-w-6xl mx-auto">
      <!-- Header Section -->
      <div class="mb-10">
        <h1 class="text-3xl font-extrabold tracking-tight text-on-surface mb-2">Patient Lookup &amp; Records</h1>
        <p class="text-on-surface-variant text-sm max-w-2xl leading-relaxed">Access and manage comprehensive patient
          health records, rabies treatment progress, and clinical history within the Cebu City Health Center network.
        </p>
      </div>
      <!-- Search Bento Area -->
      <!-- Table Container with Tonal Depth -->
      <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-surface-container-low/50">
                <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-on-surface-variant">PATIENT
                  NAME</th>
                <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-on-surface-variant">PATIENT
                  ID</th>
                <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-on-surface-variant">AGE/SEX
                </th>
                <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-on-surface-variant">BARANGAY
                </th>
                <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-on-surface-variant">LAST
                  VISIT</th>
                <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-on-surface-variant">ACTIVE
                  PEP</th>
                <th
                  class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-on-surface-variant text-right">
                  ACTION</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-high">
              <!-- Row 1 -->
              <tr class="hover:bg-surface-container-low transition-colors group">
                <td class="px-6 py-5">
                  <div class="flex items-center gap-3">
                    <div
                      class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                      JD</div>
                    <span class="font-semibold text-on-surface">Juan Dela Cruz</span>
                  </div>
                </td>
                <td class="px-6 py-5 text-sm text-on-surface-variant font-mono">P-2024-0891</td>
                <td class="px-6 py-5 text-sm text-on-surface-variant">42 / M</td>
                <td class="px-6 py-5 text-sm text-on-surface-variant">Guadalupe</td>
                <td class="px-6 py-5 text-sm text-on-surface-variant">Oct 24, 2024</td>
                <td class="px-6 py-5">
                  <span
                    class="px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-wider">In
                    Progress</span>
                </td>
                <td class="px-6 py-5 text-right">
                  <button class="text-primary font-bold text-xs hover:underline decoration-2 underline-offset-4">View
                    Record</button>
                </td>
              </tr>
              <!-- Row 2 -->
              <tr class="hover:bg-surface-container-low transition-colors group">
                <td class="px-6 py-5">
                  <div class="flex items-center gap-3">
                    <div
                      class="w-8 h-8 rounded-full bg-secondary/10 flex items-center justify-center text-secondary font-bold text-xs">
                      MC</div>
                    <span class="font-semibold text-on-surface">Maria Clara</span>
                  </div>
                </td>
                <td class="px-6 py-5 text-sm text-on-surface-variant font-mono">P-2024-1102</td>
                <td class="px-6 py-5 text-sm text-on-surface-variant">28 / F</td>
                <td class="px-6 py-5 text-sm text-on-surface-variant">Lahug</td>
                <td class="px-6 py-5 text-sm text-on-surface-variant">Nov 02, 2024</td>
                <td class="px-6 py-5">
                  <span
                    class="px-3 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed-variant text-[10px] font-bold uppercase tracking-wider">Observation</span>
                </td>
                <td class="px-6 py-5 text-right">
                  <button class="text-primary font-bold text-xs hover:underline decoration-2 underline-offset-4">View
                    Record</button>
                </td>
              </tr>
              <!-- Row 3 -->
              <tr class="hover:bg-surface-container-low transition-colors group">
                <td class="px-6 py-5">
                  <div class="flex items-center gap-3">
                    <div
                      class="w-8 h-8 rounded-full bg-error-container flex items-center justify-center text-on-error-container font-bold text-xs">
                      PR</div>
                    <span class="font-semibold text-on-surface">Pedro Rizal</span>
                  </div>
                </td>
                <td class="px-6 py-5 text-sm text-on-surface-variant font-mono">P-2024-0045</td>
                <td class="px-6 py-5 text-sm text-on-surface-variant">55 / M</td>
                <td class="px-6 py-5 text-sm text-on-surface-variant">Mabolo</td>
                <td class="px-6 py-5 text-sm text-on-surface-variant">Oct 12, 2024</td>
                <td class="px-6 py-5">
                  <span
                    class="px-3 py-1 rounded-full bg-surface-container-high text-on-surface-variant text-[10px] font-bold uppercase tracking-wider">Completed</span>
                </td>
                <td class="px-6 py-5 text-right">
                  <button class="text-primary font-bold text-xs hover:underline decoration-2 underline-offset-4">View
                    Record</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Pagination -->
        <div
          class="px-6 py-5 flex items-center justify-between border-t border-surface-container-high bg-surface-container-lowest/50">
          <p class="text-xs text-on-surface-variant">Showing <span class="font-bold text-on-surface">1</span> to <span
              class="font-bold text-on-surface">3</span> of <span class="font-bold text-on-surface">1,240</span>
            patients</p>
          <div class="flex gap-2">
            <button
              class="p-2 rounded-lg bg-surface-container-low text-outline hover:bg-surface-container-high transition-colors">
              <span class="material-symbols-outlined text-sm" data-icon="chevron_left">chevron_left</span>
            </button>
            <div class="flex gap-1">
              <button class="w-8 h-8 rounded-lg bg-primary text-on-primary text-xs font-bold shadow-sm">1</button>
              <button
                class="w-8 h-8 rounded-lg text-on-surface-variant text-xs font-medium hover:bg-surface-container-low transition-colors">2</button>
              <button
                class="w-8 h-8 rounded-lg text-on-surface-variant text-xs font-medium hover:bg-surface-container-low transition-colors">3</button>
              <span
                class="w-8 h-8 flex items-center justify-center text-on-surface-variant text-xs font-medium">...</span>
              <button
                class="w-8 h-8 rounded-lg text-on-surface-variant text-xs font-medium hover:bg-surface-container-low transition-colors">414</button>
            </div>
            <button
              class="p-2 rounded-lg bg-surface-container-low text-outline hover:bg-surface-container-high transition-colors">
              <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
            </button>
          </div>
        </div>
      </div>
      <!-- Contextual Hint -->
      <div class="mt-8 p-4 bg-primary/5 rounded-xl border border-primary/10 flex gap-4 items-start">
        <span class="material-symbols-outlined text-primary" data-icon="info">info</span>
        <div>
          <p class="text-xs font-bold text-primary uppercase tracking-wider mb-1">Quick Tip</p>
          <p class="text-sm text-on-secondary-container leading-snug">Use the Unique Patient Identifier (UPI) for the
            most accurate results. All data is synchronized in real-time with the central Cebu City Health Health
            Information System.</p>
        </div>
      </div>
    </div>
  </main>
</body>

</html>