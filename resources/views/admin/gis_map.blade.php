<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Spatial Distribution Map | ABTC-Insight</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#004a93",
                        "on-surface": "#191c1e",
                        "surface": "#f7f9fb",
                        "outline-variant": "#c1c7d3",
                        "surface-container-lowest": "#ffffff"
                    },
                    fontFamily: {
                        "body": ["Inter"]
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
        }
    </style>
    <script src="{{ asset('js/sidebar-toggle.js') }}"></script>
    <script src="{{ asset('js/custom-select.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    <script src="{{ asset('js/mobile-nav.js') }}" defer></script>
</head>

<body class="bg-surface text-on-surface">
    <!-- Sidebar -->
    <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-50 dark:bg-slate-900 flex flex-col border-r border-slate-200/50 dark:border-slate-800/50 z-50">
        <div class="px-6 py-8">
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-primary rounded-[1rem] flex items-center justify-center">
                    <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                </div>
                <div>
                    <h1 class="font-black uppercase text-primary dark:text-blue-100 text-sm tracking-wider leading-none">ABTC-Insight</h1>
                </div>
            </div>
            <nav class="space-y-1">
                <a class="flex items-center gap-3 px-4 py-3 rounded-[1rem] text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.dashboard') }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="font-['Inter'] text-sm tracking-wide">Main Overview</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-[1rem] text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.analytics') }}">
                    <span class="material-symbols-outlined">analytics</span>
                    <span class="font-['Inter'] text-sm tracking-wide">Analytics</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-[1rem] text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.compliance') }}">
                    <span class="material-symbols-outlined">security</span>
                    <span class="font-['Inter'] text-sm tracking-wide">PEP Compliance & SMS Logs</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-[1rem] text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.forecasting') }}">
                    <span class="material-symbols-outlined">query_stats</span>
                    <span class="font-['Inter'] text-sm tracking-wide">Forecasting & Outbreak Detection</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-[1rem] text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.usm') }}">
                    <span class="material-symbols-outlined">manage_accounts</span>
                    <span class="font-['Inter'] text-sm tracking-wide">User & System Management</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-[1rem] text-blue-700 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600 translate-x-1 duration-150" href="{{ route('admin.gis_map') }}">
                    <span class="material-symbols-outlined">map</span>
                    <span class="font-['Inter'] text-sm tracking-wide">Spatial Map</span>
                </a>
            </nav>
        </div>
    </aside>


    <!-- Main Content -->
    <main class="ml-64 flex-1 flex flex-col min-w-0">
        <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md px-8 py-3 flex justify-between items-center border-b border-slate-100">
            <div class="flex-1"></div>
            <div class="flex items-center gap-2">
                
                <!-- User Profile Section with Dropdown -->
                <div class="relative group cursor-pointer pl-4 border-l border-slate-200">
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-900">{{ Auth::user()->full_name ?? 'Dr. Maria Santos' }}</p>
                            <p class="text-[10px] text-slate-500 font-medium">{{ Auth::user()->role ?? 'Health Administrator' }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-full overflow-hidden ring-2 ring-slate-100 border border-slate-200">
                            <img alt="Admin Avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAWLozmctqDvlYpuogkSKhuQXYqgyRVKTkvnu27_vfksbBi0fRp_28CpvFMkWokTvJIwFCvycusJ03sd70MxGv-IN-9EoSewtoGCMoJCboWhZiyXr9Zka7bBUMXl7Htj8b_rELNobmm3tu5deKHeXDYC1OZQpXtFhCTDycSm3-mjAqV-0zADcM6iNlwgsTmbuHbbvihLUWj2DhK1AdlgzJR_geD3xRe39h4TMEC10LJqKK5azvYdpi-szDRrOG0jL1N9x6qJeeLjIj9" />
                        </div>
                    </div>

                    <!-- Hover Dropdown Menu -->
                    <div class="absolute right-0 top-full pt-2 w-48 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="bg-white rounded-xl shadow-lg border border-slate-100">
                        <div class="p-2">
                            <button type="button" onclick="openProfileModal()" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary rounded-lg transition-colors text-left cursor-pointer">
                                <span class="material-symbols-outlined text-[18px]">person</span>
                                My Profile
                            </button>

                            <div class="h-px bg-slate-100 my-1"></div>

                            <!-- Secure Logout Form -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors text-left">
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
        <div class="p-8">
        <div class="max-w-[1600px] mx-auto space-y-5">
            <div class="flex items-end justify-between flex-wrap gap-2">
                <div>
                    <h2 class="mn-page-title text-2xl font-extrabold tracking-tight text-on-surface">Barangay Spatial Distribution</h2>
                    <p class="text-sm text-slate-500">Confirmed bite cases per barangay, Cebu City. Bubble size = number of cases.</p>
                </div>
                <span id="status" class="text-xs text-slate-500"></span>
            </div>

            <!-- Filters -->
            <form id="filters" class="bg-white rounded-xl border border-outline-variant/30 p-4 text-sm" onsubmit="return false">
                <input type="hidden" name="from"><input type="hidden" name="to">
                <div class="grid gap-3 grid-cols-2 md:grid-cols-4 items-end">
                    <label class="block">Category
                        <select name="category" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                            <option value="">All</option><option>I</option><option>II</option><option>III</option>
                        </select></label>
                    <label class="block">Animal
                        <select name="animal" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                            <option value="">All</option><option value="dog">Dogs</option><option value="cat">Cats</option><option value="others">Others</option>
                        </select></label>
                    <label class="block md:col-span-2">Find barangay
                        <select id="brgySelect" class="mt-1 w-full rounded-lg border-slate-300 text-sm"><option value="">Whole city</option></select></label>
                </div>

                <div class="mt-4">
                    <p class="mb-1">Period</p>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" data-period="all" class="period px-3 py-1 rounded-full text-xs font-semibold">All time</button>
                        <button type="button" data-period="daily" class="period px-3 py-1 rounded-full text-xs font-semibold">Daily</button>
                        <button type="button" data-period="weekly" class="period px-3 py-1 rounded-full text-xs font-semibold">Weekly</button>
                        <button type="button" data-period="monthly" class="period px-3 py-1 rounded-full text-xs font-semibold">Monthly</button>
                        <button type="button" data-period="yearly" class="period px-3 py-1 rounded-full text-xs font-semibold">Yearly</button>
                        <button type="button" id="resetBtn" class="px-3 py-1 rounded-full text-xs font-semibold text-primary hover:bg-blue-50">Reset filters</button>
                    </div>

                    <div id="panel-daily" class="panel hidden mt-3 flex flex-wrap gap-3 items-end">
                        <label>From date<input type="date" id="dFrom" class="mt-1 block rounded-lg border-slate-300 text-sm"></label>
                        <label>To date<input type="date" id="dTo" class="mt-1 block rounded-lg border-slate-300 text-sm"></label>
                    </div>
                    <div id="panel-weekly" class="panel hidden mt-3 flex flex-wrap gap-3 items-end">
                        <label>From week<input type="week" id="wFrom" class="mt-1 block rounded-lg border-slate-300 text-sm"></label>
                        <label>To week<input type="week" id="wTo" class="mt-1 block rounded-lg border-slate-300 text-sm"></label>
                    </div>
                    <div id="panel-monthly" class="panel hidden mt-3 flex flex-wrap gap-3 items-end">
                        <label>From month<input type="month" id="mFrom" class="mt-1 block rounded-lg border-slate-300 text-sm"></label>
                        <label>To month<input type="month" id="mTo" class="mt-1 block rounded-lg border-slate-300 text-sm"></label>
                    </div>
                    <div id="panel-yearly" class="panel hidden mt-3 flex flex-wrap gap-3 items-end">
                        <label>Year<input type="number" id="yFrom" min="2000" max="2100" placeholder="2026" class="mt-1 block w-28 rounded-lg border-slate-300 text-sm"></label>
                        <label>To year (optional)<input type="number" id="yTo" min="2000" max="2100" placeholder="2026" class="mt-1 block w-28 rounded-lg border-slate-300 text-sm"></label>
                    </div>
                    <p id="rangeNote" class="mt-2 text-xs text-slate-500">Showing all dates. Fill only the first box to see a single day, week, month or year.</p>
                </div>
            </form>

            <!-- Summary -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl border border-outline-variant/30 p-4"><p class="text-xs uppercase text-slate-500">Cases</p><p id="sTotal" class="text-2xl font-extrabold text-primary">0</p></div>
                <div class="bg-white rounded-xl border border-outline-variant/30 p-4"><p class="text-xs uppercase text-slate-500">Barangays affected</p><p id="sBrgy" class="text-2xl font-extrabold">0</p></div>
                <div class="bg-white rounded-xl border border-outline-variant/30 p-4"><p class="text-xs uppercase text-slate-500">Highest</p><p id="sTop" class="text-lg font-extrabold truncate">-</p></div>
                <div class="bg-white rounded-xl border border-outline-variant/30 p-4"><p class="text-xs uppercase text-slate-500">Category III</p><p id="sCat3" class="text-2xl font-extrabold text-red-700">0</p></div>
            </div>

            <div id="unmapped" class="hidden rounded-lg bg-amber-50 border border-amber-200 text-amber-900 px-4 py-3 text-sm"></div>
            <div id="outside" class="hidden rounded-lg bg-slate-50 border border-slate-200 text-slate-600 px-4 py-3 text-sm"></div>

            <div class="grid lg:grid-cols-[1fr_300px] gap-5">
                <div class="bg-surface-container-lowest rounded-xl shadow-lg border border-outline-variant/10 p-4">
                    <div id="gisMap" class="w-full h-[640px] rounded-lg z-10 border border-outline-variant/20"></div>
                </div>
                <div class="bg-white rounded-xl border border-outline-variant/30 p-4 h-fit">
                    <h3 class="font-bold mb-2">Top barangays</h3>
                    <ol id="topList" class="text-sm space-y-1"></ol>
                </div>
            </div>
        </div>
    </div>
    </main>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const DATA_URL = "{{ route('admin.gis_map.data') }}";
        const GEO_URL  = "{{ asset('geojson/cebu_city_barangays.geojson') }}";
        const COLORS   = ['#fbbf24', '#f97316', '#ef4444', '#991b1b'];
        const $ = id => document.getElementById(id);
        const esc = s => String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
        // "Lahug (Pob.)" and "Lahug" both become "LAHUG", so small spelling differences still match
        const norm = s => (s || '').toUpperCase().replace(/\(.*?\)/g, ' ').replace(/\bPOB\b\.?/g, ' ').replace(/[^A-Z0-9]+/g, ' ').trim();
        // The cases use the project's barangay names (config/barangays.php); the boundary file uses the government (PSA) names.
        // Where the two spell the same barangay differently, this maps the cleaned-up case name to the cleaned-up boundary name.
        const ALIASES = {
            'QUIOT': 'QUIOT PARDO',
            'KAMPUTHAW': 'CAMPUTHAW',
            'BO LUZ': 'LUZ',
            'KINASANG AN': 'KINASANG AN PARDO',
            'HIPODROMO': 'HIPPODROMO',
            'BUDLAAN': 'BUDLA AN',
            'CAPITOL': 'CAPITOL SITE',
            'SAN NICOLAS PROPER': 'SAN NICOLAS CENTRAL',
            'SAN NICOLAS PAHINA': 'PAHINA SAN NICOLAS',
            'TOONG': 'TO ONG PARDO',
            'PUNG OL': 'PUNG OL SIBUGAY',
            'BOUT TAUP': 'BUOT TAUP PARDO',
            'BUOT TAOP': 'BUOT TAUP PARDO',        // typo found in the imported data
            'STA CRUZ': 'SANTA CRUZ',
            'STO NI O': 'CENTRAL',                 // Sto. Niño (Poblacion) is the "Central (Pob.)" polygon of the boundary file
        };
        const key = s => { const k = norm(s); return ALIASES[k] || k; };
        // cases from outside Cebu City are recorded as "Others: Mandaue", "Other City (Bohol)", ... - they have no barangay on this map
        const isOutside = s => /^\s*other/i.test(s || '');
        const iso  = d => new Date(d.getTime() - d.getTimezoneOffset() * 6e4).toISOString().slice(0, 10);

        const map = L.map('gisMap').setView([10.3157, 123.8854], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors' }).addTo(map);
        const bubbles = L.layerGroup().addTo(map);
        const layers = {};   // normalized name -> { name, layer }
        let timer, lastAgg = {};

        const legend = L.control({ position: 'bottomright' });
        legend.onAdd = () => { const d = L.DomUtil.create('div', 'bg-white/90 rounded-lg shadow p-3 text-xs'); d.id = 'legend'; return d; };
        legend.addTo(map);

        fetch(GEO_URL).then(r => r.json()).then(geo => {
            L.geoJSON(geo, {
                style: { color: '#0b61bb', weight: 1, fillOpacity: 0.03 },
                onEachFeature: (f, layer) => { const n = f.properties.BGY_NAME || 'Unknown'; layers[norm(n)] = { name: n, layer }; }
            }).addTo(map);
            Object.values(layers).map(l => l.name).sort().forEach(n => $('brgySelect').add(new Option(n, norm(n))));
            load();
        }).catch(() => { $('status').textContent = 'Could not load the barangay boundaries file (public/geojson/cebu_city_barangays.geojson).'; });

        async function load() {
            if (!Object.keys(layers).length) return; // boundaries not loaded yet; they call load() when ready
            $('status').textContent = 'Loading...';
            const p = new URLSearchParams(new FormData($('filters')));
            [...p.keys()].forEach(k => { if (!p.get(k)) p.delete(k); });
            try {
                const r = await fetch(DATA_URL + '?' + p, { headers: { 'Accept': 'application/json' } });
                if (!r.ok) throw new Error(r.status);
                render(await r.json());
                $('status').textContent = 'Updated ' + new Date().toLocaleTimeString();
            } catch (e) { $('status').textContent = 'Could not load data (' + e.message + ').'; }
        }

        function popup(name, a) {
            if (!a) return '<b>' + esc(name) + '</b><br>No cases for the current filters.';
            const list = o => Object.entries(o).sort((x, y) => y[1] - x[1]).map(([k, v]) => esc(k) + ': ' + v).join('<br>');
            return '<b>' + esc(name) + '</b><br>Cases: <b>' + a.total + '</b><hr class="my-1">Category<br>' + list(a.cat) + '<hr class="my-1">Animal<br>' + list(a.animal);
        }

        function focusBrgy(key) {
            const l = layers[key]; if (!l) return;
            map.fitBounds(l.layer.getBounds().pad(0.6));
            l.layer.openPopup();
        }

        function render(rows) {
            const agg = {}, unmapped = {};
            let outside = 0;
            rows.forEach(r => {
                const k = key(r.barangay), n = +r.n;
                if (!layers[k]) {
                    if (isOutside(r.barangay)) outside += n;                                 // outside Cebu City: expected, not an error
                    else unmapped[r.barangay] = (unmapped[r.barangay] || 0) + n;             // a name nobody recognises
                    return;
                }
                const a = agg[k] || (agg[k] = { total: 0, cat: {}, animal: {} });
                a.total += n;
                a.cat[r.category] = (a.cat[r.category] || 0) + n;
                a.animal[r.animal] = (a.animal[r.animal] || 0) + n;
            });
            lastAgg = agg;

            const max = Math.max(1, ...Object.values(agg).map(a => a.total));
            const tier = n => { const q = n / max; return q > 0.75 ? 3 : q > 0.5 ? 2 : q > 0.25 ? 1 : 0; };
            bubbles.clearLayers();

            Object.entries(layers).forEach(([k, { name, layer }]) => {
                const a = agg[k];
                layer.setStyle(a ? { fillColor: COLORS[tier(a.total)], fillOpacity: 0.2 } : { fillOpacity: 0.03 });
                layer.bindPopup(popup(name, a));
                if (!a) return;
                L.circleMarker(layer.getBounds().getCenter(), {
                    radius: 6 + 26 * Math.sqrt(a.total / max),   // area grows with case count
                    fillColor: COLORS[tier(a.total)], color: '#7f1d1d', weight: 1, fillOpacity: 0.65
                }).addTo(bubbles).bindTooltip(esc(name) + ': ' + a.total).bindPopup(popup(name, a));
            });

            // Summary cards
            const sorted = Object.entries(agg).sort((x, y) => y[1].total - x[1].total);
            const total = sorted.reduce((s, [, a]) => s + a.total, 0);
            const cat3 = sorted.reduce((s, [, a]) => s + (a.cat['III'] || 0), 0);
            $('sTotal').textContent = total + outside + Object.values(unmapped).reduce((s, n) => s + n, 0);
            $('sBrgy').textContent = sorted.length;
            $('sTop').textContent = sorted.length ? layers[sorted[0][0]].name + ' (' + sorted[0][1].total + ')' : '-';
            $('sCat3').textContent = cat3;

            $('topList').innerHTML = sorted.slice(0, 10).map(([k, a], i) =>
                '<li><button data-k="' + esc(k) + '" class="w-full flex justify-between hover:bg-slate-50 rounded px-1 py-0.5 text-left"><span>' + (i + 1) + '. ' + esc(layers[k].name) + '</span><b>' + a.total + '</b></button></li>'
            ).join('') || '<li class="text-slate-500">No cases for these filters.</li>';

            const u = Object.entries(unmapped);
            $('unmapped').classList.toggle('hidden', !u.length);
            $('unmapped').innerHTML = u.length ? '<b>' + u.reduce((s, [, n]) => s + n, 0) + ' case(s) are not on the map</b> because the barangay name was not found in the boundary file: ' + u.sort((x, y) => y[1] - x[1]).map(([n, c]) => esc(n) + ' (' + c + ')').join(', ') + '. Fix the spelling in the data, or add the name to ALIASES in this page.' : '';
            $('outside').classList.toggle('hidden', !outside);
            $('outside').innerHTML = outside ? '<b>' + outside + ' case(s)</b> are from outside Cebu City (recorded as "Others" / "Other City"), so they are counted in the total but not shown on the map.' : '';

            const step = f => Math.max(1, Math.ceil(max * f));
            $('legend').innerHTML = '<b>Cases per barangay</b>' + [0.25, 0.5, 0.75, 1].map((f, i) =>
                '<div class="flex items-center gap-2 mt-1"><span style="background:' + COLORS[i] + '" class="inline-block w-3 h-3 rounded-full"></span>' + (i ? step([0.25, 0.5, 0.75][i - 1]) + 1 : 1) + ' - ' + step(f) + '</div>').join('');
        }

        $('topList').addEventListener('click', e => { const b = e.target.closest('button[data-k]'); if (b) focusBrgy(b.dataset.k); });
        $('brgySelect').addEventListener('change', e => e.target.value ? focusBrgy(e.target.value) : map.setView([10.3157, 123.8854], 12));
        // ---- Period filter: Daily / Weekly / Monthly / Yearly turn into a from-to date range ----
        let period = 'all';
        const utc = d => d.toISOString().slice(0, 10);
        const weekStart = v => { const [y, w] = v.split('-W').map(Number); const j = new Date(Date.UTC(y, 0, 4)); const dow = j.getUTCDay() || 7; return new Date(Date.UTC(y, 0, 4 - dow + 1 + (w - 1) * 7)); };
        const addDays = (d, n) => new Date(d.getTime() + n * 864e5);
        const monthEnd = v => { const [y, m] = v.split('-').map(Number); return new Date(Date.UTC(y, m, 0)); };

        function updateRange() {
            let from = '', to = '';
            const v = id => $(id).value;
            if (period === 'daily') { from = v('dFrom'); to = v('dTo') || from; if (!from) from = to; }
            if (period === 'weekly') {
                const a = v('wFrom') || v('wTo'), b = v('wTo') || v('wFrom');
                if (a) { from = utc(weekStart(a)); to = utc(addDays(weekStart(b), 6)); }
            }
            if (period === 'monthly') {
                const a = v('mFrom') || v('mTo'), b = v('mTo') || v('mFrom');
                if (a) { from = a + '-01'; to = utc(monthEnd(b)); }
            }
            if (period === 'yearly') {
                const a = v('yFrom') || v('yTo'), b = v('yTo') || v('yFrom');
                if (a) { from = a + '-01-01'; to = b + '-12-31'; }
            }
            if (from && to && from > to) [from, to] = [to, from];
            $('filters').from.value = from; $('filters').to.value = to;
            $('rangeNote').textContent = from ? 'Showing ' + from + ' to ' + to + '.' : 'Showing all dates. Fill only the first box to see a single day, week, month or year.';
        }

        function setPeriod(p) {
            period = p;
            document.querySelectorAll('.period').forEach(b => {
                const on = b.dataset.period === p;
                b.className = 'period px-3 py-1 rounded-full text-xs font-semibold ' + (on ? 'bg-primary text-white' : 'bg-slate-100 hover:bg-slate-200');
            });
            document.querySelectorAll('.panel').forEach(el => el.classList.toggle('hidden', el.id !== 'panel-' + p));
            updateRange(); load();
        }

        document.querySelectorAll('.period').forEach(b => b.addEventListener('click', () => setPeriod(b.dataset.period)));
        $('filters').addEventListener('change', () => { updateRange(); clearTimeout(timer); timer = setTimeout(load, 250); });
        $('resetBtn').addEventListener('click', () => { $('filters').reset(); setPeriod('all'); });
        setPeriod('all'); // marks "All time" as selected (the first data load happens once the boundary file is ready)
    });
    </script>

                @php
            $user = Auth::user();

            // Job description per role (edit these)
            $roleDescriptions = [
                'Admin'         => 'Manages user accounts and system settings, oversees records and reports, monitors activity logs, and makes sure the system runs smoothly for all users.',
                'Staff'         => 'Handles administrative and clerical tasks, manages records and documents, assists clients, and supports the daily operations of the center.',
                'Health Worker' => 'Provides frontline health services, records and updates patient information, conducts health monitoring, and supports community health programs.',
                'BHW'           => 'Serves as the barangay-level health worker, refers patients to the center, and helps monitor the health of residents in the community.',
                'IT'            => 'Maintains the system and its database, manages technical issues and backups, and provides technical support to all users.',
            ];

            // Optional: custom description for a specific person, keyed by username
            $userDescriptions = [
                'thelmaeleccion' => 'Attending physician. Examines and treats patients, oversees health programs, and guides the health workers on patient care.',
                // 'adminusername' => 'Custom description here.',
            ];

            $jobDescription = $userDescriptions[$user->username]
                ?? $roleDescriptions[$user->role]
                ?? 'No job description available.';

            // Badge color per role
            $badgeClasses = match ($user->role) {
                'Admin'         => 'bg-violet-50 text-violet-700 ring-violet-200',
                'Staff'         => 'bg-sky-50 text-sky-700 ring-sky-200',
                'Health Worker' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                'BHW'           => 'bg-amber-50 text-amber-700 ring-amber-200',
                'IT'            => 'bg-slate-100 text-slate-700 ring-slate-300',
                default         => 'bg-slate-100 text-slate-700 ring-slate-300',
            };
        @endphp

        <div id="profileModal"
            class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 opacity-0 transition-opacity duration-200"
            onclick="if(event.target === this) closeProfileModal()">

            <div id="profileCard"
                class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden scale-95 translate-y-2 transition-all duration-200">

                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800">My Profile</h3>
                    <button type="button" onclick="closeProfileModal()"
                            class="w-8 h-8 flex items-center justify-center rounded-full text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors cursor-pointer">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <!-- Details -->
                <div class="p-6 space-y-3">

                    <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="w-10 h-10 shrink-0 rounded-lg bg-white shadow-sm flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[22px]">person</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Account Name</p>
                            <p class="text-sm font-semibold text-slate-800 break-words">{{ $user->full_name }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="w-10 h-10 shrink-0 rounded-lg bg-white shadow-sm flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[22px]">admin_panel_settings</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Role in the System</p>
                            <span class="mt-1 inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold ring-1 {{ $badgeClasses }}">
                                {{ $user->role }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="w-10 h-10 shrink-0 rounded-lg bg-white shadow-sm flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[22px]">work</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Job Description</p>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ $jobDescription }}</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                    <button type="button" onclick="closeProfileModal()"
                            class="px-5 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:opacity-90 transition-opacity cursor-pointer">
                        Close
                    </button>
                </div>
            </div>
        </div>

        <script>
            function openProfileModal() {
                const modal = document.getElementById('profileModal');
                const card = document.getElementById('profileCard');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                requestAnimationFrame(() => {
                    modal.classList.remove('opacity-0');
                    card.classList.remove('scale-95', 'translate-y-2');
                });
            }

            function closeProfileModal() {
                const modal = document.getElementById('profileModal');
                const card = document.getElementById('profileCard');
                modal.classList.add('opacity-0');
                card.classList.add('scale-95', 'translate-y-2');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 200);
            }

            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') closeProfileModal();
            });
        </script>

        @include('partials.idle-timeout')

    </body>

</html>