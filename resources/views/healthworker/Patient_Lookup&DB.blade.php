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

<aside class="h-screen w-64 fixed left-0 top-0 bg-slate-100 dark:bg-slate-900 flex flex-col pt-6 pb-4 gap-2 z-50">
    <!-- Brand / Header Section -->
    <div class="px-6 mb-8">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white shadow-lg">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
            </div>
            <div>
                <h1 class="text-blue-900 dark:text-blue-50 font-bold text-sm tracking-tight leading-none">ABTC-Insight</h1>
            </div>
        </div>
    </div>

    <!-- Navigation sits right beneath it -->
    <nav class="space-y-1 px-4 dark:bg-slate-900">
        <!-- Dashboard (Inactive) -->
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
           href="{{ route('healthworker.dashboard') }}">
            <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
            <span class="font-['Inter'] text-sm tracking-wide">Dashboard</span>
        </a>

        <!-- Clinical Encoding (Inactive) -->
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
           href="{{ route('healthworker.clinical-encoding') }}">
            <span class="material-symbols-outlined" data-icon="medical_services">medical_services</span>
            <span class="font-['Inter'] text-sm tracking-wide">Clinical Encoding</span>
        </a>

        <!-- Treatment Tracker (Inactive) -->
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
           href="{{ route('healthworker.treatment-tracker') }}">
            <span class="material-symbols-outlined" data-icon="monitor_heart">monitor_heart</span>
            <span class="font-['Inter'] text-sm tracking-wide">Treatment Tracker</span>
        </a>

        <!-- Patient Database (Active - Admin Style) -->
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-700 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600 translate-x-1 duration-150" 
           href="{{ route('healthworker.patient-database') }}">
            <span class="material-symbols-outlined" data-icon="database">database</span>
            <span class="font-['Inter'] text-sm tracking-wide">Patient Database</span>
        </a>

        <!-- Compliance (Inactive) -->
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100 dark:hover:bg-slate-800/50" 
           href="{{ route('healthworker.compliance') }}">
            <span class="material-symbols-outlined" data-icon="verified_user">verified_user</span>
            <span class="font-['Inter'] text-sm tracking-wide">Compliance</span>
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
                <h1 class="text-blue-900 dark:text-blue-50 font-bold text-sm tracking-tight leading-none">ABTC-Insight
                </h1>
            </div>
            <!-- Search Bar -->
            <div class="flex items-center flex-1 max-w-md ml-12">
                <div class="relative w-full group">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm group-focus-within:text-blue-700 transition-colors">search</span>
                    <input
                        class="w-full bg-slate-100 dark:bg-slate-800/50 border-none rounded-full py-2 pl-9 pr-4 text-xs focus:ring-2 focus:ring-blue-700/20 placeholder:text-slate-400 font-['Inter']"
                        placeholder="Search patient by name or ID..." type="text" />
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
                        <p class="text-xs font-bold text-on-surface leading-tight font-['Inter']">{{ Auth::user()->full_name ?? 'Dr. Elena Santos' }}</p>
                        <p class="text-[10px] text-on-surface-variant font-['Inter']">{{ Auth::user()->role ?? 'Senior Health Worker' }}</p>
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
    <div class="max-w-6xl mx-auto w-full">
      <!-- Header Section -->
      <div class="mb-8">
        <h1 class="text-3xl font-extrabold tracking-tight text-on-surface mb-2">Patient Lookup &amp; Records</h1>
        <p class="text-on-surface-variant text-sm max-w-2xl leading-relaxed">Access and manage comprehensive patient
          health records, rabies treatment progress, and clinical history within the Cebu City Health Center network.
        </p>
      </div>
      <!-- Search & Filter -->
      <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <form method="GET" action="{{ route('healthworker.patient-database') }}" class="flex-1 min-w-[260px] max-w-md">
          @if($status !== 'all')
          <input type="hidden" name="status" value="{{ $status }}" />
          @endif
          <div
            class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2.5 border border-outline-variant/20 focus-within:border-primary/40 transition-all">
            <span class="material-symbols-outlined text-outline text-[18px]">search</span>
            <input id="patientSearchInput" name="q" type="text" value="{{ $search }}"
              class="bg-transparent border-none focus:ring-0 text-sm w-full py-0"
              placeholder="Search by name, patient ID or barangay..." />
            @if($search !== '')
            <a href="{{ route('healthworker.patient-database', $status !== 'all' ? ['status' => $status] : []) }}"
              class="material-symbols-outlined text-outline text-[18px] hover:text-on-surface" title="Clear search">close</a>
            @endif
          </div>
        </form>
        <div class="flex gap-2">
          @foreach(['all' => 'All Patients', 'active' => 'Active PEP', 'completed' => 'Completed'] as $key => $label)
          <a href="{{ route('healthworker.patient-database', array_filter(['q' => $search, 'status' => $key === 'all' ? null : $key])) }}"
            class="px-4 py-2 text-sm font-semibold rounded-full transition-colors {{ $status === $key ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-high text-on-surface-variant hover:bg-surface-variant' }}">{{ $label }}</a>
          @endforeach
        </div>
      </div>
      <!-- Table Container with Tonal Depth -->
      <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-surface-container-low/50">
                <th class="px-4 py-4 text-[11px] font-bold uppercase tracking-widest text-on-surface-variant whitespace-nowrap">Patient Name</th>
                <th class="px-4 py-4 text-[11px] font-bold uppercase tracking-widest text-on-surface-variant whitespace-nowrap">Patient ID</th>
                <th class="px-4 py-4 text-[11px] font-bold uppercase tracking-widest text-on-surface-variant whitespace-nowrap">Age/Sex</th>
                <th class="px-4 py-4 text-[11px] font-bold uppercase tracking-widest text-on-surface-variant whitespace-nowrap">Barangay</th>
                <th class="px-4 py-4 text-[11px] font-bold uppercase tracking-widest text-on-surface-variant whitespace-nowrap">Last Visit</th>
                <th class="px-4 py-4 text-[11px] font-bold uppercase tracking-widest text-on-surface-variant whitespace-nowrap">Active PEP</th>
                <th class="px-4 py-4 text-[11px] font-bold uppercase tracking-widest text-on-surface-variant text-right whitespace-nowrap">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-high">
              @forelse($patients as $patient)
              @php
                $pill = [
                  'In Progress' => 'bg-primary/10 text-primary',
                  'Awaiting Encoding' => 'bg-tertiary-fixed text-on-tertiary-fixed-variant',
                  'Completed' => 'bg-surface-container-high text-on-surface-variant',
                  'No Case' => 'bg-surface-container-high text-on-surface-variant',
                ][$patient->pep_status];
              @endphp
              <tr class="hover:bg-surface-container-low transition-colors group">
                <td class="px-4 py-5">
                  <span class="font-semibold text-on-surface whitespace-nowrap">{{ $patient->patient_name }}</span>
                </td>
                <td class="px-4 py-5 text-sm text-on-surface-variant font-mono whitespace-nowrap">{{ $patient->patient_id }}</td>
                <td class="px-4 py-5 text-sm text-on-surface-variant whitespace-nowrap">{{ $patient->age }} / {{ strtoupper(substr($patient->sex, 0, 1)) }}</td>
                <td class="px-4 py-5 text-sm text-on-surface-variant whitespace-nowrap">{{ $patient->barangay ?? '—' }}</td>
                <td class="px-4 py-5 text-sm text-on-surface-variant whitespace-nowrap">{{ $patient->last_visit ? \Carbon\Carbon::parse($patient->last_visit)->format('M d, Y') : '—' }}</td>
                <td class="px-4 py-5">
                  <span
                    class="inline-block whitespace-nowrap px-3 py-1 rounded-full {{ $pill }} text-[10px] font-bold uppercase tracking-wider">{{ $patient->pep_status }}</span>
                </td>
                <td class="px-4 py-5 text-right">
                  <button type="button" data-view-record="{{ $patient->patient_id }}"
                    class="whitespace-nowrap text-primary font-bold text-xs hover:underline decoration-2 underline-offset-4">View
                    Record</button>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="px-6 py-14 text-center text-sm text-on-surface-variant">
                  @if($search !== '' || $status !== 'all')
                  No patients match your search or filter.
                  @else
                  No patients yet. Patients appear here once Staff verifies them.
                  @endif
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <!-- Pagination -->
        <div
          class="px-4 py-5 flex flex-wrap items-center justify-between gap-3 border-t border-surface-container-high bg-surface-container-lowest/50">
          <p class="text-xs text-on-surface-variant">
            @if($patients->total() > 0)
            Showing <span class="font-bold text-on-surface">{{ $patients->firstItem() }}</span> to <span
              class="font-bold text-on-surface">{{ $patients->lastItem() }}</span> of <span
              class="font-bold text-on-surface">{{ number_format($patients->total()) }}</span>
            {{ \Illuminate\Support\Str::plural('patient', $patients->total()) }}
            @else
            No patients to show
            @endif
          </p>
          @if($patients->hasPages())
          @php
            $current = $patients->currentPage();
            $last = $patients->lastPage();
            $window = array_unique(array_filter([1, $current - 1, $current, $current + 1, $last], fn ($n) => $n >= 1 && $n <= $last));
            sort($window);
          @endphp
          <div class="flex gap-2 items-center">
            @if($patients->onFirstPage())
            <span class="p-2 rounded-lg bg-surface-container-low text-outline-variant cursor-not-allowed"><span class="material-symbols-outlined text-sm">chevron_left</span></span>
            @else
            <a href="{{ $patients->previousPageUrl() }}" class="p-2 rounded-lg bg-surface-container-low text-outline hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined text-sm">chevron_left</span></a>
            @endif
            <div class="flex gap-1">
              @php $prev = 0; @endphp
              @foreach($window as $n)
              @if($n - $prev > 1)
              <span class="w-8 h-8 flex items-center justify-center text-on-surface-variant text-xs font-medium">...</span>
              @endif
              <a href="{{ $patients->url($n) }}"
                class="w-8 h-8 flex items-center justify-center rounded-lg text-xs {{ $n === $current ? 'bg-primary text-on-primary font-bold shadow-sm' : 'text-on-surface-variant font-medium hover:bg-surface-container-low transition-colors' }}">{{ $n }}</a>
              @php $prev = $n; @endphp
              @endforeach
            </div>
            @if($patients->hasMorePages())
            <a href="{{ $patients->nextPageUrl() }}" class="p-2 rounded-lg bg-surface-container-low text-outline hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined text-sm">chevron_right</span></a>
            @else
            <span class="p-2 rounded-lg bg-surface-container-low text-outline-variant cursor-not-allowed"><span class="material-symbols-outlined text-sm">chevron_right</span></span>
            @endif
          </div>
          @endif
        </div>
      </div>
      <!-- Contextual Hint -->
      <div class="mt-8 p-4 bg-primary/5 rounded-xl border border-primary/10 flex gap-4 items-start">
        <span class="material-symbols-outlined text-primary" data-icon="info">info</span>
        <div>
          <p class="text-xs font-bold text-primary uppercase tracking-wider mb-1">Quick Tip</p>
          <p class="text-sm text-on-secondary-container leading-snug">Search by patient name, Patient ID or barangay,
            then use <span class="font-semibold">View Record</span> to see a patient's details and every bite case on
            file. Patients appear here once Staff has verified them.</p>
        </div>
      </div>
    </div>
  </main>
  <!-- Patient record modal -->
  <div id="recordModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-6" role="dialog"
    aria-modal="true" aria-labelledby="recordName">
    <div id="recordBackdrop" class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px]"></div>
    <div class="relative bg-surface-container-lowest rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col overflow-hidden">
      <div class="px-8 py-6 bg-surface-container-low border-b border-outline-variant/20 flex items-start justify-between gap-4">
        <div class="min-w-0">
          <p class="text-[10px] font-bold text-primary tracking-widest uppercase mb-1">Patient Record</p>
          <h2 id="recordName" class="text-2xl font-extrabold tracking-tight text-on-surface truncate"></h2>
          <p id="recordId" class="text-xs text-on-surface-variant font-mono mt-1"></p>
        </div>
        <button type="button" id="recordClose" aria-label="Close"
          class="w-9 h-9 shrink-0 flex items-center justify-center rounded-full text-outline hover:bg-surface-container-high transition-colors">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
      <div class="flex-1 overflow-y-auto px-8 py-6 space-y-6">
        <dl id="recordDetails" class="grid grid-cols-2 gap-x-8 gap-y-4"></dl>
        <div>
          <h3 class="text-xs font-extrabold uppercase tracking-widest text-on-surface-variant mb-3">Medical History</h3>
          <div class="grid grid-cols-2 gap-4">
            <div class="bg-surface-container-low rounded-xl p-4">
              <p class="text-[10px] font-bold text-outline uppercase tracking-wider mb-1">Illnesses</p>
              <p id="recordIllness" class="text-sm text-on-surface"></p>
            </div>
            <div class="bg-surface-container-low rounded-xl p-4">
              <p class="text-[10px] font-bold text-outline uppercase tracking-wider mb-1">Allergies</p>
              <p id="recordAllergy" class="text-sm text-on-surface"></p>
            </div>
          </div>
        </div>
        <div>
          <h3 class="text-xs font-extrabold uppercase tracking-widest text-on-surface-variant mb-3">Bite Cases</h3>
          <div id="recordCases" class="space-y-3"></div>
        </div>
      </div>
    </div>
  </div>
  <script type="application/json" id="recordData">@json($records)</script>
  <script>
    (function () {
      const records = JSON.parse(document.getElementById('recordData').textContent);
      const clinicalUrl = @json(route('healthworker.clinical-encoding'));
      const modal = document.getElementById('recordModal');
      const statusStyle = {
        'In Progress': 'bg-primary/10 text-primary',
        'Awaiting Encoding': 'bg-tertiary-fixed text-on-tertiary-fixed-variant',
        'Completed': 'bg-surface-container-high text-on-surface-variant',
      };

      const el = (tag, cls, text) => {
        const node = document.createElement(tag);
        if (cls) node.className = cls;
        if (text !== undefined) node.textContent = text;
        return node;
      };

      function openRecord(id) {
        const r = records[id];
        if (!r) return;
        document.getElementById('recordName').textContent = r.name;
        document.getElementById('recordId').textContent = id;

        const details = document.getElementById('recordDetails');
        details.replaceChildren();
        [['Age / Sex', (r.age ?? '—') + ' / ' + (r.sex ?? '—')], ['Date of Birth', r.dob || '—'],
         ['Civil Status', r.civil_status || '—'], ['Contact No.', r.contact || '—'],
         ['PhilHealth', r.philhealth || '—']].forEach(([label, value]) => {
          const wrap = el('div');
          wrap.append(el('dt', 'text-[10px] font-bold text-outline uppercase tracking-wider mb-1', label),
                      el('dd', 'text-sm font-semibold text-on-surface', value));
          details.append(wrap);
        });

        document.getElementById('recordIllness').textContent = r.illness || 'None reported';
        document.getElementById('recordAllergy').textContent = r.allergy || 'None reported';

        const list = document.getElementById('recordCases');
        list.replaceChildren();
        if (!r.cases.length) {
          list.append(el('p', 'text-sm text-on-surface-variant', 'No bite cases on file yet.'));
        }
        r.cases.forEach((c) => {
          const row = el('div', 'flex items-center justify-between gap-4 bg-surface-container-low rounded-xl px-4 py-3');
          const info = el('div', 'min-w-0');
          info.append(el('p', 'text-sm font-bold text-on-surface', 'Case ' + c.case_number + ' · Cat ' + c.category),
                      el('p', 'text-[11px] text-on-surface-variant', c.date + (c.barangay ? ' · ' + c.barangay : '')));
          const side = el('div', 'flex items-center gap-3 shrink-0');
          side.append(el('span', 'px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider whitespace-nowrap ' + (statusStyle[c.status] || ''), c.status));
          const open = el('a', 'text-primary font-bold text-xs hover:underline decoration-2 underline-offset-4 whitespace-nowrap', 'Open');
          open.href = clinicalUrl + '/' + c.bite_case_id;
          side.append(open);
          row.append(info, side);
          list.append(row);
        });

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
      }

      function closeRecord() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
      }

      document.querySelectorAll('[data-view-record]').forEach((btn) =>
        btn.addEventListener('click', () => openRecord(btn.dataset.viewRecord)));
      document.getElementById('recordClose').addEventListener('click', closeRecord);
      document.getElementById('recordBackdrop').addEventListener('click', closeRecord);
      document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeRecord(); });

      // The header search box searches the patient database too (Enter to search)
      const headerSearch = document.querySelector('header input[type="text"]');
      const pageSearch = document.getElementById('patientSearchInput');
      if (headerSearch && pageSearch) {
        headerSearch.value = pageSearch.value;
        headerSearch.addEventListener('keydown', (e) => {
          if (e.key !== 'Enter') return;
          pageSearch.value = headerSearch.value;
          pageSearch.form.requestSubmit();
        });
      }
    })();
  </script>
</body>

</html>
