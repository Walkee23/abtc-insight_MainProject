<!DOCTYPE html>

<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>ABTC-Insight Patient Portal | Your Treatment Status</title>
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

  <main class="flex-grow px-4 pt-24 pb-12">
    <div class="w-full max-w-[760px] mx-auto space-y-5">
      <a href="{{ route('patient.tracking.portal') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors text-sm font-medium">
        <span class="material-symbols-outlined text-sm">arrow_back</span>
        Back to Tracking Portal
      </a>

      <div class="bg-surface-container-lowest rounded-xl p-6 md:p-8 shadow-[0_24px_48px_-12px_rgba(25,28,30,0.04)] ring-1 ring-outline-variant/10">
        <div class="flex flex-wrap items-start justify-between gap-3">
          <div class="min-w-0">
            <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Treatment status for</p>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-on-surface break-words">{{ $patient->patient_name }}</h1>
            <p class="mt-1 text-xs text-on-surface-variant">Tracking ID: <span class="font-mono font-bold text-primary break-all">{{ $patient->patient_id }}</span></p>
          </div>
          <a href="{{ route('patient.tracking.portal') }}" class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-bold text-primary bg-primary/10 hover:bg-primary/15 active:scale-95 transition-all">
            <span class="material-symbols-outlined text-[16px]">search</span>
            Look up another
          </a>
        </div>
      </div>

      @php
        $statusText = [
          'ongoing'    => ['Treatment ongoing',        'bg-primary-fixed text-primary'],
          'checked_in' => ['Checked in at the clinic', 'bg-amber-100 text-amber-800'],
          'completed'  => ['Treatment complete',       'bg-emerald-100 text-emerald-800'],
          'registered' => ['Registered',               'bg-surface-container-high text-on-surface-variant'],
          'discharged' => ['No vaccine needed',        'bg-emerald-100 text-emerald-800'],
          'past'       => ['Past record',              'bg-surface-container-high text-on-surface-variant'],
        ];
        $fmt = fn ($iso) => $iso ? \Carbon\Carbon::parse($iso)->format('M j, Y') : '';
        $long = fn ($iso) => \Carbon\Carbon::parse($iso)->format('l, F j, Y');
      @endphp

      @forelse($cases as $c)
      @php
        [$label, $labelClass] = $statusText[$c->status] ?? $statusText['registered'];
        $next = collect($c->doses)->firstWhere('state', 'next');

        // the instruction under the schedule
        if ($c->status === 'checked_in') {
            $tone = 'info'; $msg = 'You are checked in for your Day ' . $c->checked_in_for . ' dose. Please wait at the Health Worker station to be called.';
        } elseif ($c->status === 'completed') {
            $tone = 'ok'; $msg = 'You have received every dose of your course. Keep your vaccination card safe.';
        } elseif ($c->status === 'discharged') {
            $tone = 'ok'; $msg = 'This was a Category I exposure. No vaccine was needed.';
        } elseif ($c->status === 'past') {
            $tone = 'muted'; $msg = 'This is a past record that was not completed at the center.';
        } elseif ($c->status === 'registered') {
            $tone = 'info'; $msg = 'Your visit is registered. Please wait to be called by the Health Worker for your first dose.';
        } elseif ($next && $next->overdue) {
            $tone = 'warn'; $msg = 'Your Day ' . $next->day . ' dose was due on ' . $long($next->due) . '. Please visit the clinic as soon as possible and bring your vaccination card.';
        } elseif ($next && $next->due) {
            $tone = 'info'; $msg = 'Please visit the clinic ' . ($next->due === $today ? 'today' : 'on ' . $long($next->due)) . ' for your Day ' . $next->day . ' dose. Bring your vaccination card.';
        } else {
            $tone = 'info'; $msg = 'Please follow the schedule above and visit the clinic for your next dose.';
        }
        $tones = [
          'info'  => ['info',     'bg-primary/5 text-primary'],
          'ok'    => ['verified', 'bg-emerald-50 text-emerald-800'],
          'warn'  => ['schedule', 'bg-amber-50 text-amber-900'],
          'muted' => ['history',  'bg-surface-container-low text-on-surface-variant'],
        ];
        [$icon, $toneClass] = $tones[$tone];
        $meta = collect([
          $c->reported ? 'Reported ' . $fmt($c->reported) : null,
          $c->animal ? $c->animal . ' bite' : null,
          $c->dose_type === 'Booster' ? 'Booster course' : null,
        ])->filter()->implode(' · ');
        $cols = count($c->doses) >= 4 ? 'sm:grid-cols-4' : 'sm:grid-cols-2';
      @endphp
      <article class="bg-surface-container-lowest rounded-xl p-6 md:p-8 shadow-[0_24px_48px_-12px_rgba(25,28,30,0.04)] ring-1 ring-outline-variant/10">
        <div class="flex flex-wrap items-start justify-between gap-3">
          <div class="min-w-0">
            <h2 class="text-lg font-bold tracking-tight text-on-surface">Case #{{ $c->case_number }}</h2>
            <p class="text-xs text-on-surface-variant mt-0.5">{{ $meta }}</p>
          </div>
          <div class="flex flex-wrap gap-2">
            @if($c->category)
            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full bg-surface-container-high text-on-surface-variant">Category {{ $c->category }}</span>
            @endif
            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $labelClass }}">{{ $label }}</span>
          </div>
        </div>

        @if(count($c->doses))
        <h3 class="mt-5 mb-3 text-[11px] font-bold uppercase tracking-widest text-on-surface-variant">Immunization schedule</h3>
        <div class="grid grid-cols-2 {{ $cols }} gap-3">
          @foreach($c->doses as $d)
            @if($d->state === 'done')
            <div class="rounded-xl border-2 px-2 py-3 text-center min-w-0 border-emerald-200 bg-emerald-50 text-emerald-800">
              <div class="text-[11px] font-black uppercase tracking-wide">Day {{ $d->day }}</div>
              <div class="text-[11px] font-semibold mt-1">{{ $fmt($d->date) }}</div>
              <div class="text-[10px] font-bold text-emerald-600 mt-0.5">Given</div>
              @if($d->brand)<div class="text-[9px] text-emerald-700/80 mt-1 break-words">{{ $d->brand }}</div>@endif
            </div>
            @elseif($d->state === 'next')
            <div class="rounded-xl border-2 px-2 py-3 text-center min-w-0 ring-2 {{ $d->overdue ? 'border-amber-300 bg-amber-50 text-amber-900 ring-amber-200' : 'border-primary bg-primary-fixed/40 text-primary ring-primary/15' }}">
              <div class="text-[11px] font-black uppercase tracking-wide">Day {{ $d->day }}</div>
              <div class="text-[11px] font-semibold mt-1">{{ $d->due ? $fmt($d->due) : 'At your visit' }}</div>
              <div class="text-[10px] font-bold mt-0.5">{{ $d->overdue ? 'Overdue' : 'Next dose' }}</div>
            </div>
            @else
            <div class="rounded-xl border-2 px-2 py-3 text-center min-w-0 border-dashed border-surface-container-high bg-surface-container-low text-on-surface-variant">
              <div class="text-[11px] font-black uppercase tracking-wide">Day {{ $d->day }}</div>
              <div class="text-[11px] font-semibold mt-1">{{ $d->due ? $fmt($d->due) : '-' }}</div>
              <div class="text-[10px] font-semibold mt-0.5 text-on-surface-variant/70">Upcoming</div>
            </div>
            @endif
          @endforeach
        </div>
        @endif

        <div class="mt-5 rounded-xl p-4 flex items-start gap-3 {{ $toneClass }}">
          <span class="material-symbols-outlined text-[20px] shrink-0">{{ $icon }}</span>
          <p class="text-sm leading-relaxed">{{ $msg }}</p>
        </div>
      </article>
      @empty
      <p class="text-center text-sm text-on-surface-variant bg-surface-container-lowest rounded-xl p-6 ring-1 ring-outline-variant/10">No bite case is on record for this patient yet.</p>
      @endforelse

      <p class="text-center text-xs text-on-surface-variant leading-relaxed px-6">For your privacy this page closes after 20 minutes. Need help? Please visit the Information Staff at the ABTC.</p>
    </div>
  </main>

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
</body>

</html>
