<!DOCTYPE html>

<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap"
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
          "colors": {
            "tertiary-fixed-dim": "#ffb689",
            "secondary-fixed": "#d3e4ff",
            "error": "#ba1a1a",
            "surface-container-low": "#f2f4f6",
            "primary-fixed": "#d6e3ff",
            "inverse-primary": "#a9c7ff",
            "surface-container-lowest": "#ffffff",
            "on-primary": "#ffffff",
            "on-error-container": "#93000a",
            "primary-container": "#0b61bb",
            "on-surface": "#191c1e",
            "surface-container-high": "#e6e8ea",
            "outline-variant": "#c1c7d3",
            "outline": "#717782",
            "tertiary-container": "#9e4b00",
            "primary-fixed-dim": "#a9c7ff",
            "tertiary-fixed": "#ffdbc8",
            "on-secondary-fixed": "#011c38",
            "background": "#f7f9fb",
            "secondary-container": "#c1d9fd",
            "inverse-on-surface": "#eff1f3",
            "on-secondary-container": "#485f7e",
            "surface-tint": "#005db6",
            "on-tertiary-fixed-variant": "#743500",
            "on-tertiary-fixed": "#311300",
            "tertiary": "#7a3800",
            "inverse-surface": "#2d3133",
            "on-surface-variant": "#414751",
            "surface-dim": "#d8dadc",
            "surface-container-highest": "#e0e3e5",
            "on-tertiary": "#ffffff",
            "on-secondary": "#ffffff",
            "surface": "#f7f9fb",
            "on-primary-fixed-variant": "#00468c",
            "error-container": "#ffdad6",
            "on-tertiary-container": "#ffd7c0",
            "secondary": "#49607f",
            "on-background": "#191c1e",
            "on-primary-container": "#d0dfff",
            "surface-container": "#eceef0",
            "surface-bright": "#f7f9fb",
            "on-secondary-fixed-variant": "#314866",
            "on-error": "#ffffff",
            "surface-variant": "#e0e3e5",
            "secondary-fixed-dim": "#b1c8ec",
            "primary": "#004a93",
            "on-primary-fixed": "#001b3d"
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
    }

    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }

    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }

    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>
</head>

<body class="bg-surface text-on-surface antialiased">
  <!-- TopAppBar Navigation Shell -->
  <header
    class="ml-64 sticky top-0 z-40 bg-slate-50/85 dark:bg-slate-900/85 backdrop-blur-md flex items-center justify-between px-8 py-4 shadow-sm">
    <div class="flex items-center gap-8">
      <div class="relative group">
        <span
          class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
        <input
          class="pl-10 pr-4 py-2 bg-surface-container-highest/50 border-none rounded-full text-sm w-64 focus:ring-2 focus:ring-primary/20 transition-all outline-none"
          placeholder="Search records..." type="text" />
      </div>
    </div>
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
          class="w-9 h-9 rounded-full object-cover ring-2 ring-primary/10 group:ring-primary/30 transition-all"
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
  </header>
  <div class="flex min-h-screen">
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
    <!-- Main Content Canvas -->
    <main class="ml-64 min-h-screen flex flex-col relative bg-surface p-8">
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
  </div>
</body>

</html>