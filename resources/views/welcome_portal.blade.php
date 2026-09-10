<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary": "#7a3800",
                        "error": "#ba1a1a",
                        "surface-bright": "#f7f9fb",
                        "on-tertiary-container": "#ffd7c0",
                        "on-secondary-container": "#485f7e",
                        "primary-container": "#0b61bb",
                        "on-tertiary-fixed": "#311300",
                        "on-secondary-fixed-variant": "#314866",
                        "inverse-on-surface": "#eff1f3",
                        "surface-container-low": "#f2f4f6",
                        "surface-container-highest": "#e0e3e5",
                        "outline": "#717782",
                        "on-secondary-fixed": "#011c38",
                        "on-primary-fixed": "#001b3d",
                        "on-error-container": "#93000a",
                        "tertiary-container": "#9e4b00",
                        "surface-variant": "#e0e3e5",
                        "surface": "#f7f9fb",
                        "surface-container-high": "#e6e8ea",
                        "primary-fixed-dim": "#a9c7ff",
                        "surface-container-lowest": "#ffffff",
                        "on-primary": "#ffffff",
                        "on-surface": "#191c1e",
                        "primary-fixed": "#d6e3ff",
                        "surface-tint": "#005db6",
                        "error-container": "#ffdad6",
                        "secondary-container": "#c1d9fd",
                        "tertiary-fixed-dim": "#ffb689",
                        "tertiary-fixed": "#ffdbc8",
                        "on-primary-container": "#d0dfff",
                        "on-primary-fixed-variant": "#00468c",
                        "secondary-fixed-dim": "#b1c8ec",
                        "surface-dim": "#d8dadc",
                        "on-tertiary": "#ffffff",
                        "inverse-primary": "#a9c7ff",
                        "surface-container": "#eceef0",
                        "secondary-fixed": "#d3e4ff",
                        "background": "#f7f9fb",
                        "primary": "#004a93",
                        "on-tertiary-fixed-variant": "#743500",
                        "outline-variant": "#c1c7d3",
                        "on-surface-variant": "#414751",
                        "secondary": "#49607f",
                        "inverse-surface": "#2d3133",
                        "on-error": "#ffffff",
                        "on-secondary": "#ffffff",
                        "on-background": "#191c1e"
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
            background-color: #f7f9fb;
            color: #191c1e;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .glass-nav {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .soft-shadow {
            shadow: 0 24px 48px -12px rgba(25, 28, 30, 0.04);
        }
    </style>
</head>

<body class="bg-surface selection:bg-primary-container selection:text-on-primary-container">
    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 w-full z-50 bg-slate-50/85 backdrop-blur-md shadow-sm">
        <div class="flex justify-between items-center px-6 py-4 max-w-7xl mx-auto font-sans antialiased text-sm font-medium tracking-tight">
            <!-- Left Side: Brand Logo -->
            <div class="text-xl font-bold tracking-tighter text-blue-900">
                ABTC-Insight
            </div>
            <!-- Right Side: Navigation Links & Login -->
            <div class="flex items-center gap-8">
                <div class="flex items-center gap-6">
                    <a class="text-slate-600 hover:text-blue-600 transition-colors" href="{{ route('patient.register') }}">Patient Registration</a>
                    <a class="text-slate-600 hover:text-blue-600 transition-colors" href="{{ route('patient.tracking.portal') }}">Tracking Portal</a>
                </div>
                <button type="button" class="bg-primary text-on-primary px-5 py-2 rounded-full font-semibold active:scale-95 transition-transform" onclick="window.location.href=`{{ route('login') }}`;">
                    Login
                </button>
            </div>
        </div>
        <!-- Separation Line -->
        <div class="bg-slate-200/50 h-[1px] w-full absolute bottom-0"></div>
    </nav>
    <main class="pt-20">
        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-surface py-20 lg:py-32">
            <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
                <div class="z-10">
                    <h1 class="text-4xl lg:text-6xl font-extrabold tracking-tight text-on-surface mb-6 leading-[1.1]">
                        Welcome to Cebu City Health Department's <br />
                        <span class="bg-gradient-to-r from-primary to-primary-container bg-clip-text text-transparent">Animal Bite Treatment Center Portal.</span>
                    </h1>
                    <p class="text-lg text-on-surface-variant mb-10 max-w-xl leading-relaxed">
                        Cebu City's dedicated portal for Animal Bite Treatment &amp; Control. Streamlining patient recovery through advanced tracking and real-time clinical insights.
                    </p>
                </div>
                <div class="relative lg:h-[600px] flex items-center justify-center">
                    <!-- High-end decorative background -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary/5 to-transparent rounded-[3rem] -rotate-3"></div>
                    <div class="relative w-full h-full rounded-[2rem] overflow-hidden shadow-2xl">
                        <img alt="Medical professional using tablet" class="w-full h-full object-cover" data-alt="Professional clinical setting showing a vaccination procedure being administered safely" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAnhIybYKyKeuPQkT1Yhnw-ujuH-TLEDeshEQc4tFhwteZQFJOSKhzXLQn2gIOL9SfO_jpP_phhZTeNY6w1244a7zJAGCvpHDU1m0h1_SWnfB8LhA56VQi0pprxcwFkf9oBEbCiNgaUj1a-c9BMMDZgBz1cGOrVN5RJYvbqkU25PEg3qQtNKE_TMXgA5SEERJ92OnluVy3GSkDB8UYtP2VFRu6ts9R2BZlRWLgBGF2G1CDs18Oiq7BjrYjJJwXzjVlHf0JVXX70qijX" />
                    </div>
                </div>
            </div>
        </section>
        <!-- Educational Section: Understanding Rabies -->
        <section class="py-32 bg-surface">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-20">
                    <h2 class="text-4xl font-black tracking-tight mb-4">Understanding Rabies &amp; The Importance of PEP</h2>
                    <p class="text-on-surface-variant max-w-2xl mx-auto">Essential clinical guidelines and critical safety information based on the World Health Organization (WHO) standards.</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Fatal Nature Card -->
                    <div class="bg-surface-container-lowest p-10 rounded-xl hover:shadow-xl transition-all border border-outline-variant/10">
                        <div class="w-12 h-12 rounded-full bg-error-container flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-on-error-container" data-icon="warning">warning</span>
                        </div>
                        <h4 class="text-xl font-bold mb-4">Virtually 100% Fatal</h4>
                        <p class="text-on-surface-variant leading-relaxed text-sm">
                            Rabies is a vaccine-preventable viral disease, but once clinical symptoms appear, it is virtually 100% fatal for those infected.
                        </p>
                    </div>
                    <!-- PEP Card -->
                    <div class="bg-surface-container-lowest p-10 rounded-xl hover:shadow-xl transition-all border border-outline-variant/10 md:scale-105 shadow-lg shadow-on-surface/5">
                        <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-primary" data-icon="medical_services">medical_services</span>
                        </div>
                        <h4 class="text-xl font-bold mb-4">Immediate PEP</h4>
                        <p class="text-on-surface-variant leading-relaxed text-sm">
                            Post-exposure prophylaxis (PEP) consists of immediate wound cleaning, a full course of rabies vaccine, and rabies immunoglobulin.
                        </p>
                    </div>
                    <!-- Timing Card -->
                    <div class="bg-surface-container-lowest p-10 rounded-xl hover:shadow-xl transition-all border border-outline-variant/10">
                        <div class="w-12 h-12 rounded-full bg-tertiary-fixed flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-on-tertiary-fixed-variant" data-icon="schedule">schedule</span>
                        </div>
                        <h4 class="text-xl font-bold mb-4">Timely Intervention</h4>
                        <p class="text-on-surface-variant leading-relaxed text-sm">
                            Timely PEP is crucial for preventing rabies deaths after a potential exposure. Every minute counts in clinical intervention.
                        </p>
                    </div>
                </div>
                <!-- Call to Action Card -->
                <div class="mt-20 p-12 bg-surface-container-low rounded-[2rem] flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex-1">
                        <h3 class="text-3xl font-bold mb-2">Have you been exposed?</h3>
                        <p class="text-on-surface-variant">Don't wait. Proceed to the <strong>Cebu City Health Department Animal Bite Treatment Center (CCHD ABTC)</strong> immediately for professional medical care.</p>
                    </div>
                    <p class="text-primary font-bold text-lg">Please visit the clinic immediately for urgent medical attention.</p>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer class="bg-slate-100 w-full py-12 px-8 mt-20">
        <div class="flex flex-col md:flex-row justify-between items-center gap-8 max-w-7xl mx-auto">
            <div class="text-lg font-black text-slate-900">
                ABTC-Insight
            </div>
            <div class="flex flex-wrap justify-center gap-8 font-sans text-xs uppercase tracking-widest font-semibold">
                <a class="text-slate-500 hover:text-blue-500 transition-colors" href="#">Privacy Policy</a>
                <a class="text-slate-500 hover:text-blue-500 transition-colors" href="#">Terms of Service</a>
                <a class="text-slate-500 hover:text-blue-500 transition-colors" href="#">Emergency Contacts</a>
                <a class="text-slate-500 hover:text-blue-500 transition-colors" href="#">Department of Health</a>
            </div>
            <div class="text-slate-500 text-[10px] uppercase tracking-widest font-bold opacity-60">
                © 2024 Cebu City Health Center. All rights reserved.
            </div>
        </div>
    </footer>
</body>

</html>