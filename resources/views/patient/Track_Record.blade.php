<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>ABTC-Insight | My Treatment Record</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <!-- Shared Components JSON Execution: Using tailwind-config from the Design System -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-fixed": "#d6e3ff",
                        "surface-bright": "#f7f9fb",
                        "primary-container": "#0b61bb",
                        "surface-container-highest": "#e0e3e5",
                        "on-primary": "#ffffff",
                        "secondary-fixed-dim": "#b1c8ec",
                        "on-tertiary-fixed": "#311300",
                        "inverse-primary": "#a9c7ff",
                        "error-container": "#ffdad6",
                        "on-tertiary-container": "#ffd7c0",
                        "on-secondary-fixed": "#011c38",
                        "on-surface": "#191c1e",
                        "on-surface-variant": "#414751",
                        "on-secondary-fixed-variant": "#314866",
                        "outline": "#717782",
                        "inverse-on-surface": "#eff1f3",
                        "surface": "#f7f9fb",
                        "tertiary-fixed-dim": "#ffb689",
                        "on-secondary-container": "#485f7e",
                        "on-primary-fixed": "#001b3d",
                        "inverse-surface": "#2d3133",
                        "surface-dim": "#d8dadc",
                        "on-secondary": "#ffffff",
                        "surface-container-high": "#e6e8ea",
                        "secondary-fixed": "#d3e4ff",
                        "on-background": "#191c1e",
                        "error": "#ba1a1a",
                        "on-tertiary": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "secondary-container": "#c1d9fd",
                        "secondary": "#49607f",
                        "tertiary-fixed": "#ffdbc8",
                        "on-tertiary-fixed-variant": "#743500",
                        "surface-tint": "#005db6",
                        "surface-container": "#eceef0",
                        "surface-variant": "#e0e3e5",
                        "on-primary-fixed-variant": "#00468c",
                        "primary": "#004a93",
                        "outline-variant": "#c1c7d3",
                        "tertiary": "#7a3800",
                        "primary-fixed-dim": "#a9c7ff",
                        "on-primary-container": "#d0dfff",
                        "surface-container-low": "#f2f4f6",
                        "on-error-container": "#93000a",
                        "tertiary-container": "#9e4b00",
                        "on-error": "#ffffff",
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
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        .clinical-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
        }

        html { scroll-behavior: smooth; }
        .no-scrollbar { scrollbar-width: none; }
        .no-scrollbar::-webkit-scrollbar { display: none; }

        /* FAQ: no default marker, the chevron turns when an item is open */
        details.faq > summary { list-style: none; cursor: pointer; }
        details.faq > summary::-webkit-details-marker { display: none; }
        details.faq[open] .faq-chevron { transform: rotate(180deg); }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    <script src="{{ asset('js/mobile-nav.js') }}" defer></script>
</head>

<body class="bg-surface text-on-surface selection:bg-primary-fixed">
    @php
        $fmt = fn ($iso) => $iso ? \Carbon\Carbon::parse($iso)->format('M j, Y') : '';
        $short = fn ($iso) => $iso ? \Carbon\Carbon::parse($iso)->format('M j') : '';
        $long = fn ($iso) => \Carbon\Carbon::parse($iso)->format('l, F j, Y');
        $initials = strtoupper(mb_substr(preg_replace('/[^A-Za-z ]/', '', $firstName) ?: 'P', 0, 1));
        $active = fn ($c) => in_array($c->status, ['ongoing', 'checked_in', 'registered'], true);

        // the badge on a case card
        $badge = fn ($c) => match ($c->status) {
            'completed'  => ['Completed', 'text-emerald-700 bg-emerald-100'],
            'discharged' => ['No vaccine needed', 'text-emerald-700 bg-emerald-100'],
            'past'       => ['Past record', 'text-on-surface-variant bg-surface-container-highest'],
            'checked_in' => ['Checked in', 'text-amber-800 bg-amber-100'],
            default      => ['Active', 'text-primary bg-primary-fixed'],
        };

        // the soonest dose still to come, for the greeting card
        $soonest = collect($cases)->filter($active)
            ->map(fn ($c) => ['case' => $c, 'dose' => collect($c->doses)->firstWhere('state', 'next')])
            ->filter(fn ($x) => $x['dose'] && $x['dose']->due)
            ->sortBy(fn ($x) => $x['dose']->due)->first();
        $inProgress = collect($cases)->filter($active)->count();

        // "In 2 days" / "Today" / "Overdue by 3 days"
        $away = function ($iso) use ($today) {
            $n = (int) \Carbon\Carbon::parse($today)->startOfDay()->diffInDays(\Carbon\Carbon::parse($iso)->startOfDay(), false);
            return $n === 0 ? 'Today' : ($n === 1 ? 'Tomorrow' : ($n > 1 ? 'In ' . $n . ' days' : 'Overdue by ' . abs($n) . ' day' . (abs($n) === 1 ? '' : 's')));
        };
        // doses given / doses in the course
        $progress = function ($c) {
            $total = count($c->doses);
            $given = collect($c->doses)->where('state', 'done')->count();
            return [$given, $total, $total ? (int) round($given / $total * 100) : 0];
        };
    @endphp

    <!-- Top bar -->
    <nav class="print:hidden fixed top-0 inset-x-0 z-50 flex justify-between items-center gap-3 px-4 sm:px-6 h-16 bg-slate-50/85 backdrop-blur-xl shadow-sm">
        <div class="flex items-center gap-8 min-w-0">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 hover:opacity-80 transition-opacity min-w-0">
                <div class="w-9 h-9 bg-primary rounded-lg flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-white text-[20px]" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                </div>
                <span class="text-lg sm:text-xl font-bold tracking-tighter text-blue-800 truncate">ABTC-Insight</span>
            </a>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('patient.tracking.portal') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold text-primary bg-primary/10 hover:bg-primary/15 active:scale-95 transition-all">
                <span class="material-symbols-outlined text-[16px]">logout</span>
                <span class="hidden sm:inline">Exit</span>
            </a>
            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-sm font-bold" title="{{ $patient->patient_name }}">{{ $initials }}</div>
        </div>
    </nav>

    <main class="pt-24 print:pt-4 pb-28 md:pb-14 px-4 sm:px-6 max-w-4xl mx-auto">
        <div>
            <!-- MAIN CONTENT -->
            <div class="space-y-6 lg:space-y-8 min-w-0">

                <!-- Greeting + next dose -->
                <section class="print:hidden relative overflow-hidden rounded-2xl bg-primary-container text-on-primary">
                    <div class="relative z-10 p-6 sm:p-8 grid gap-6 md:grid-cols-[1fr_auto] md:items-center">
                        <div class="min-w-0">
                            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-2 break-words">Welcome back, {{ $firstName }}!</h1>
                            <p class="text-on-primary-container/90 text-sm sm:text-base max-w-md">Here is your treatment record: your cases, the doses you have received and what comes next.</p>
                            <span class="mt-5 inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1.5 text-[11px] font-semibold max-w-full">
                                <span class="material-symbols-outlined text-[15px]">fingerprint</span>
                                <span class="font-mono break-all">{{ $patient->patient_id }}</span>
                            </span>
                        </div>

                        @if($soonest)
                        @php $sd = $soonest['dose']; @endphp
                        <div class="rounded-2xl bg-white text-on-surface p-5 md:w-60 shadow-xl shadow-black/10">
                            <p class="text-[10px] font-extrabold uppercase tracking-widest {{ $sd->overdue ? 'text-amber-700' : 'text-on-surface-variant' }}">{{ $sd->overdue ? 'Dose overdue' : 'Next dose' }}</p>
                            <p class="mt-1 text-4xl font-black tracking-tight {{ $sd->overdue ? 'text-amber-700' : 'text-primary' }}">Day {{ $sd->day }}</p>
                            <p class="mt-0.5 text-sm font-semibold text-on-surface">{{ \Carbon\Carbon::parse($sd->due)->format('D, M j') }}</p>
                            <span class="mt-3 inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-[11px] font-bold {{ $sd->overdue ? 'bg-amber-100 text-amber-800' : 'bg-primary-fixed text-primary' }}">
                                <span class="material-symbols-outlined text-[14px]">{{ $sd->overdue ? 'schedule' : 'event' }}</span>{{ $away($sd->due) }}
                            </span>
                            <p class="mt-3 text-[11px] text-on-surface-variant">Case #{{ $soonest['case']->case_number }}</p>
                        </div>
                        @elseif(count($cases) && !$inProgress)
                        <div class="rounded-2xl bg-white text-on-surface p-5 md:w-60 shadow-xl shadow-black/10">
                            <span class="inline-flex w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 items-center justify-center"><span class="material-symbols-outlined">verified</span></span>
                            <p class="mt-3 text-lg font-extrabold">No doses due</p>
                            <p class="text-xs text-on-surface-variant mt-0.5">Every course on record is finished.</p>
                        </div>
                        @endif
                    </div>
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-primary/20 rounded-full blur-2xl translate-y-1/2 -translate-x-1/4"></div>
                </section>

                <!-- My cases -->
                <section id="cases" class="print:hidden scroll-mt-24">
                    <div class="flex items-end justify-between gap-3 mb-4">
                        <h2 class="text-lg sm:text-xl font-bold tracking-tight text-on-surface">My Treatment Cases</h2>
                        <span class="text-xs font-semibold text-on-surface-variant whitespace-nowrap">{{ count($cases) }} {{ count($cases) === 1 ? 'case' : 'cases' }}@if(count($cases) > 1)<span class="sm:hidden"> · swipe</span>@endif</span>
                    </div>
                    @if(count($cases))
                    <div class="no-scrollbar flex gap-3 overflow-x-auto snap-x snap-mandatory scroll-px-4 -mx-4 px-4 pb-2 sm:mx-0 sm:px-0 sm:pb-0 sm:grid sm:grid-cols-2 sm:gap-4 sm:overflow-visible">
                        @foreach($cases as $c)
                        @php
                            [$badgeText, $badgeClass] = $badge($c);
                            $isSel = $selected && $selected->case_number === $c->case_number;
                            $nextDose = collect($c->doses)->firstWhere('state', 'next');
                            $isActive = $active($c);
                            [$given, $total, $pct] = $progress($c);
                        @endphp
                        <a href="{{ route('patient.tracking.result', ['case' => $c->case_number]) }}#detail"
                            @if($isSel) aria-current="true" @endif
                            class="group snap-start shrink-0 w-[82%] sm:w-auto sm:shrink flex flex-col p-5 rounded-xl border-l-4 shadow-sm transition-all hover:shadow-md {{ $isActive ? 'bg-surface-container-lowest border-primary' : 'bg-surface-container-low border-outline-variant/40' }} {{ $isSel ? 'ring-2 ring-primary/40' : 'ring-1 ring-outline-variant/10' }}">
                            <div class="flex justify-between items-start gap-2 mb-3">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $badgeClass }}">{{ $badgeText }}</span>
                                    @if($isSel)<span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-primary text-white">Viewing</span>@endif
                                </div>
                                <span class="text-on-surface-variant text-xs font-semibold whitespace-nowrap">Case #{{ $c->case_number }}</span>
                            </div>
                            <h3 class="font-bold text-base sm:text-lg leading-snug">{{ $c->animal ? $c->animal . ' Bite Incident' : 'Animal Bite Incident' }}</h3>
                            <p class="text-on-surface-variant text-sm mt-0.5">{{ $c->reported ? 'Reported ' . $fmt($c->reported) : 'Reported date not recorded' }}</p>
                            @if($total && $c->status !== 'discharged')
                            <div class="mt-4">
                                <div class="flex justify-between text-[11px] font-semibold text-on-surface-variant mb-1.5"><span>{{ $given }} of {{ $total }} doses given</span><span>{{ $pct }}%</span></div>
                                <div class="h-1.5 rounded-full bg-surface-container-highest overflow-hidden"><div class="h-full rounded-full {{ $pct === 100 ? 'bg-emerald-500' : 'bg-primary' }}" style="width: {{ $pct }}%"></div></div>
                            </div>
                            @endif
                            <div class="mt-auto pt-4 flex items-center gap-2 text-sm font-semibold {{ $isActive ? ($nextDose && $nextDose->overdue ? 'text-amber-700' : 'text-primary') : 'text-on-surface-variant' }}">
                                @if($c->status === 'checked_in')
                                    <span class="material-symbols-outlined text-[18px]">how_to_reg</span> Checked in for Day {{ $c->checked_in_for }}
                                @elseif($c->status === 'registered')
                                    <span class="material-symbols-outlined text-[18px]">hourglass_top</span> Waiting for your first dose
                                @elseif($isActive && $nextDose && $nextDose->due)
                                    <span class="material-symbols-outlined text-[18px]">{{ $nextDose->overdue ? 'schedule' : 'event' }}</span> {{ $nextDose->overdue ? 'Day ' . $nextDose->day . ' dose overdue' : 'Next dose: ' . $short($nextDose->due) }}
                                @elseif($c->status === 'completed')
                                    <span class="material-symbols-outlined text-[18px]">verified</span> Treatment finished
                                @elseif($c->status === 'discharged')
                                    <span class="material-symbols-outlined text-[18px]">verified</span> Category I: no vaccine needed
                                @else
                                    <span class="material-symbols-outlined text-[18px]">history</span> Not completed at the center
                                @endif
                                <span class="material-symbols-outlined text-[18px] ml-auto opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <p class="text-center text-sm text-on-surface-variant bg-surface-container-lowest rounded-xl p-6 ring-1 ring-outline-variant/10">No bite case is on record for this patient yet.</p>
                    @endif
                </section>

                @if($selected)
                @php
                    $c = $selected;
                    $next = collect($c->doses)->firstWhere('state', 'next');

                    if ($c->status === 'checked_in') {
                        $msg = 'You are checked in for your Day ' . $c->checked_in_for . ' dose. Please wait at the Health Worker station to be called.';
                    } elseif ($c->status === 'completed') {
                        $msg = 'You have received every dose of your course. Keep your vaccination card safe.';
                    } elseif ($c->status === 'discharged') {
                        $msg = 'This was a Category I exposure. No vaccine was needed.';
                    } elseif ($c->status === 'past') {
                        $msg = 'This is a past record that was not completed at the center.';
                    } elseif ($c->status === 'registered') {
                        $msg = 'Your visit is registered. Please wait to be called by the Health Worker for your first dose.';
                    } elseif ($next && $next->overdue) {
                        $msg = 'Your Day ' . $next->day . ' dose was due on ' . $long($next->due) . '. Please visit the clinic as soon as possible and bring your vaccination card.';
                    } elseif ($next && $next->due) {
                        $msg = 'Please visit the clinic ' . ($next->due === $today ? 'today' : 'on ' . $long($next->due)) . ' for your Day ' . $next->day . ' dose. Bring your vaccination card.';
                    } else {
                        $msg = 'Please follow the schedule above and visit the clinic for your next dose.';
                    }
                    $warn = $next && $next->overdue && $c->status === 'ongoing';
                    $cat = ['I' => ['Category I (Minor)', 'bg-surface-container-high text-on-surface-variant', 'info'],
                            'II' => ['Category II (Moderate)', 'bg-tertiary-fixed text-on-tertiary-fixed-variant', 'info'],
                            'III' => ['Category III (Severe)', 'bg-error-container text-on-error-container', 'warning']][$c->category] ?? null;
                    $gridCols = count($c->doses) >= 4 ? 'sm:grid-cols-4' : 'sm:grid-cols-2';
                    [$dGiven, $dTotal, $dPct] = $progress($c);
                @endphp
                <!-- Case detail -->
                <section id="detail" class="bg-surface-container-lowest rounded-2xl p-5 sm:p-8 shadow-sm ring-1 ring-outline-variant/10 scroll-mt-24">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 sm:mb-8 pb-5 sm:pb-6 border-b border-outline-variant/10">
                        <div class="min-w-0">
                            <p class="text-[11px] uppercase font-bold tracking-widest text-on-surface-variant mb-1">Case details</p>
                            <h2 class="text-xl sm:text-2xl font-bold tracking-tight">Case #{{ $c->case_number }}@if($c->reported) <span class="text-on-surface-variant font-semibold">· {{ $fmt($c->reported) }}</span>@endif</h2>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 self-start sm:self-auto shrink-0">
                            @if($cat)
                            <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full {{ $cat[1] }}">
                                <span class="material-symbols-outlined text-[20px]">{{ $cat[2] }}</span>
                                <span class="text-xs sm:text-sm font-bold tracking-tight">{{ $cat[0] }}</span>
                            </div>
                            @endif
                            <button type="button" onclick="window.print()" title="Print or save this record" class="print:hidden inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full text-xs font-bold text-primary bg-primary/10 hover:bg-primary/15 active:scale-95 transition-all">
                                <span class="material-symbols-outlined text-[18px]">print</span>Print
                            </button>
                        </div>
                    </div>

                    {{-- shown on paper only: whose record this is --}}
                    <p class="hidden print:block mb-6 text-sm"><span class="font-bold">{{ $patient->patient_name }}</span> · Tracking ID <span class="font-mono">{{ $patient->patient_id }}</span></p>

                    <!-- Instruction first: what the patient has to do -->
                    <div class="mb-8 rounded-xl p-4 sm:p-5 flex items-start gap-3 sm:gap-4 {{ $warn ? 'bg-amber-50' : 'bg-primary/5' }}">
                        <div class="p-2.5 rounded-lg shrink-0 {{ $warn ? 'bg-amber-100 text-amber-700' : 'bg-primary-container/10 text-primary' }}">
                            <span class="material-symbols-outlined">{{ $warn ? 'schedule' : 'info' }}</span>
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-on-surface mb-0.5">What to do next</h4>
                            <p class="text-sm text-on-surface-variant leading-relaxed">{{ $msg }}</p>
                        </div>
                    </div>

                    @if(count($c->doses))
                    <div>
                        <div class="flex items-center justify-between gap-3 mb-6 sm:mb-8">
                            <h3 class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Immunization timeline</h3>
                            <span class="text-xs font-semibold text-on-surface-variant whitespace-nowrap">{{ $dGiven }} of {{ $dTotal }} doses given</span>
                        </div>
                        <div class="relative">
                            {{-- the line: across on a wide screen, down the side on a phone --}}
                            <div class="hidden sm:block absolute top-5 h-0.5 bg-surface-container-highest {{ count($c->doses) >= 4 ? 'left-[12.5%] right-[12.5%]' : 'left-1/4 right-1/4' }}"></div>
                            <div class="sm:hidden absolute top-5 bottom-5 left-5 -ml-px w-0.5 bg-surface-container-highest"></div>
                            <ol class="relative flex flex-col gap-6 sm:grid {{ $gridCols }} sm:gap-4">
                                @foreach($c->doses as $d)
                                <li class="flex sm:flex-col items-start sm:items-center gap-4 sm:gap-0 min-w-0">
                                    @if($d->state === 'done')
                                    <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-on-primary z-10 shrink-0 shadow-lg shadow-primary/20">
                                        <span class="material-symbols-outlined">check</span>
                                    </div>
                                    <div class="text-left sm:text-center sm:mt-4 min-w-0">
                                        <p class="text-sm font-bold">Day {{ $d->day }}</p>
                                        <p class="text-xs text-on-surface-variant">{{ $short($d->date) }}</p>
                                        <p class="mt-1 text-[10px] font-bold text-primary uppercase tracking-wide">Completed</p>
                                        @if($d->brand)<p class="mt-0.5 text-[10px] text-on-surface-variant break-words">{{ $d->brand }}</p>@endif
                                    </div>
                                    @elseif($d->state === 'next')
                                    <div class="w-10 h-10 rounded-full bg-surface-container-lowest border-4 {{ $d->overdue ? 'border-amber-500' : 'border-primary' }} flex items-center justify-center z-10 shrink-0">
                                        <span class="w-2 h-2 rounded-full {{ $d->overdue ? 'bg-amber-500' : 'bg-primary' }} animate-pulse"></span>
                                    </div>
                                    <div class="text-left sm:text-center sm:mt-4 min-w-0">
                                        <p class="text-sm font-bold">Day {{ $d->day }}</p>
                                        <p class="text-xs text-on-surface-variant">{{ $d->due ? $short($d->due) : 'At your visit' }}</p>
                                        <p class="mt-1 inline-block text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide {{ $d->overdue ? 'text-amber-800 bg-amber-100' : 'text-primary-container bg-primary-fixed' }}">{{ $d->overdue ? 'Overdue' : 'Next' }}</p>
                                    </div>
                                    @else
                                    <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center text-on-surface-variant z-10 shrink-0">
                                        <span class="material-symbols-outlined text-sm">schedule</span>
                                    </div>
                                    <div class="text-left sm:text-center sm:mt-4 min-w-0">
                                        <p class="text-sm font-medium text-on-surface-variant">Day {{ $d->day }}</p>
                                        <p class="text-xs text-on-surface-variant">{{ $d->due ? $short($d->due) : '-' }}</p>
                                        <p class="mt-1 text-[10px] font-bold text-on-surface-variant uppercase tracking-wide">Pending</p>
                                    </div>
                                    @endif
                                </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                    @endif
                </section>
                @endif

                <div class="print:hidden flex items-start gap-3 rounded-xl bg-surface-container-lowest ring-1 ring-outline-variant/10 px-4 py-3.5">
                    <span class="material-symbols-outlined text-primary text-[20px] shrink-0 mt-0.5">lock_clock</span>
                    <p class="text-xs text-on-surface-variant leading-relaxed">For your privacy this page closes after 20 minutes. Need help? Please visit the Information Staff at the ABTC.</p>
                </div>

                <!-- Rabies prevention FAQ -->
            <section id="faq" class="print:hidden scroll-mt-24">
                <div id="faqList" class="rounded-2xl p-2 -m-2 transition-shadow duration-500">
                    <h2 class="text-base sm:text-lg font-bold tracking-tight text-on-surface mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">clinical_notes</span>
                        Rabies Prevention <span class="text-xs font-normal text-on-surface-variant">(WHO)</span>
                    </h2>
                    <div class="grid gap-3 lg:grid-cols-3 lg:items-start">
                    @foreach([
                        ['What is PEP?', 'Post-Exposure Prophylaxis (PEP) is the immediate treatment of a bite victim after rabies exposure. This prevents virus entry into the central nervous system.'],
                        ['Why is time critical?', 'Once symptoms appear, rabies is 99.9% fatal. Immediate PEP after exposure can effectively stop the infection.'],
                        ['Wound washing', 'Immediately wash the wound with soap and water for at least 15 minutes. This is the first critical step in PEP.'],
                    ] as [$q, $a])
                    <details class="faq group rounded-xl bg-surface-container-lowest ring-1 ring-outline-variant/10 shadow-sm" data-faq>
                        <summary class="flex items-center justify-between gap-3 px-4 py-3.5">
                            <span class="font-bold text-sm text-on-surface">{{ $q }}</span>
                            <span class="faq-chevron material-symbols-outlined text-on-surface-variant text-[20px] transition-transform">expand_more</span>
                        </summary>
                        <p class="px-4 pb-4 text-xs text-on-surface-variant leading-relaxed">{{ $a }}</p>
                    </details>
                    @endforeach
                    </div>
                </div>
            </section>
            </div>

        </div>
    </main>

    <!-- Bottom bar (phones only) -->
    <nav class="print:hidden md:hidden fixed bottom-0 inset-x-0 bg-surface-container-lowest/95 backdrop-blur shadow-[0_-4px_20px_rgba(0,0,0,0.05)] px-6 pt-2.5 pb-[max(0.625rem,env(safe-area-inset-bottom))] flex justify-around items-center z-50">
        <a href="#cases" class="flex flex-col items-center gap-0.5 text-primary">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">grid_view</span>
            <span class="text-[10px] font-bold">My cases</span>
        </a>
        <a href="#faq" class="flex flex-col items-center gap-0.5 text-on-surface-variant">
            <span class="material-symbols-outlined">quiz</span>
            <span class="text-[10px] font-medium">FAQs</span>
        </a>
        <a href="{{ route('patient.tracking.portal') }}" class="flex flex-col items-center gap-0.5 text-on-surface-variant">
            <span class="material-symbols-outlined">logout</span>
            <span class="text-[10px] font-medium">Exit</span>
        </a>
    </nav>

    <script>
        (function () {
            var items = document.querySelectorAll('details[data-faq]');
            var ACTIVE = 'text-blue-700 font-semibold border-b-2 border-blue-700 pb-1';
            var IDLE = 'text-slate-600 hover:text-blue-600 transition-colors';

            // FAQ items are open in the side column on a wide screen and folded on a phone
            var wide = window.matchMedia('(min-width: 1024px)').matches;
            items.forEach(function (d) { d.open = wide; });

            function mark(which) {
                document.querySelectorAll('[data-nav]').forEach(function (a) {
                    a.className = a.getAttribute('data-nav') === which ? ACTIVE : IDLE;
                });
            }

            // "Rabies FAQ" / "FAQs": go to the questions, open them, and flash the box so it is clear where they are
            // (on a wide screen they are already beside the page, so the flash is the feedback)
            document.addEventListener('click', function (e) {
                var link = e.target.closest('a[href="#faq"], a[href="#cases"]');
                if (!link) return;
                var faq = link.getAttribute('href') === '#faq';
                mark(faq ? 'faq' : 'cases');
                if (!faq) return;
                items.forEach(function (d) { d.open = true; });
                var box = document.getElementById('faqList');
                box.classList.add('ring-2', 'ring-primary/40', 'bg-primary/5');
                setTimeout(function () { box.classList.remove('ring-2', 'ring-primary/40', 'bg-primary/5'); }, 1600);
            });
        })();
    </script>
</body>

</html>
