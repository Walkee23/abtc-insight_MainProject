<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Spatial Distribution Map | ABTC-Insight</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
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
</head>

<body class="bg-surface text-on-surface">
    <!-- Sidebar -->
    <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-100 flex flex-col pt-6 pb-4 gap-2 z-50">
        <div class="px-6 mb-8 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white shadow-lg">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
            </div>
            <h1 class="text-blue-900 font-bold text-sm tracking-tight leading-none">ABTC-Insight Admin</h1>
        </div>
        <nav class="space-y-1 px-4">
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm tracking-wide">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.analytics') }}">
                <span class="material-symbols-outlined">analytics</span>
                <span class="text-sm tracking-wide">Analytics</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.compliance') }}">
                <span class="material-symbols-outlined">verified_user</span>
                <span class="text-sm tracking-wide">Compliance</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 hover:text-blue-600 transition-all hover:bg-slate-100" href="{{ route('admin.usm') }}">
                <span class="material-symbols-outlined">settings</span>
                <span class="text-sm tracking-wide">System Management</span>
            </a>
            <!-- Active State for Spatial Map -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-700 font-bold bg-blue-50 border-l-4 border-blue-600 translate-x-1 duration-150" href="{{ route('admin.gis_map') }}">
                <span class="material-symbols-outlined">map</span>
                <span class="text-sm tracking-wide">Spatial Map</span>
            </a>
        </nav>
    </aside>

    <!-- Top Navbar -->
    <header class="fixed top-0 w-full h-16 bg-slate-50/85 backdrop-blur-md shadow-sm z-40 flex items-center px-8 justify-end">
        <div class="flex items-center gap-3">
            <div class="text-right">
                <p class="text-xs font-bold text-on-surface leading-tight">Admin User</p>
                <p class="text-[10px] text-slate-500">System Administrator</p>
            </div>
            <div class="w-9 h-9 rounded-full bg-primary/20 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[20px]">person</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="ml-64 pt-20 p-8 min-h-screen">
        <div class="max-w-[1600px] mx-auto">
            <h2 class="text-2xl font-extrabold tracking-tight text-on-surface mb-6">Barangay Spatial Distribution</h2>

            <div class="bg-surface-container-lowest rounded-xl shadow-lg border border-outline-variant/10 p-6">
                <!-- GIS Map Container -->
                <div id="gisMap" class="w-full h-[650px] rounded-lg z-10 border border-outline-variant/20"></div>
            </div>
        </div>
    </main>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('gisMap').setView([10.3157, 123.8854], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var dbData = @json($barangayData);
            var caseCounts = {};

            dbData.forEach(item => {
                if (item.barangay) {
                    caseCounts[item.barangay.toUpperCase()] = item.total_cases;
                }
            });

            // Make sure cebu_city_barangays.geojson is saved in public/geojson/
            fetch("{{ asset('geojson/cebu_city_barangays.geojson') }}")
                .then(response => response.json())
                .then(data => {
                    L.geoJSON(data, {
                        style: function(feature) {
                            return {
                                color: "#0b61bb",
                                weight: 1,
                                fillOpacity: 0.05
                            };
                        },
                        onEachFeature: function(feature, layer) {
                            // Use the exact key from your GeoJSON file
                            var rawName = feature.properties.BGY_NAME || 'UNKNOWN';

                            var brgyName = rawName.toUpperCase();
                            var cases = caseCounts[brgyName] || 0;

                            // Base boundary popup
                            layer.bindPopup("<b>" + brgyName + "</b><br>Cases: " + cases);

                            // Generate the Bubble Map Markers
                            if (cases > 0) {
                                var center = layer.getBounds().getCenter();
                                var radiusSize = Math.max(8, cases * 1.5);

                                L.circleMarker(center, {
                                    radius: radiusSize,
                                    fillColor: "#ba1a1a",
                                    color: "#93000a",
                                    weight: 1,
                                    opacity: 1,
                                    fillOpacity: 0.6
                                }).addTo(map).bindPopup("<b>" + brgyName + "</b><br>Active Cases: " + cases);
                            }
                        }
                    }).addTo(map);
                })
                .catch(error => console.error('Error loading GeoJSON:', error));
        });
    </script>
</body>

</html>