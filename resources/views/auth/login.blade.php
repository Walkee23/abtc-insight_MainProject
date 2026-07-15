<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Staff Portal Login | ABTC-Insight</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-tertiary-container": "#ffd7c0",
                        "on-secondary": "#ffffff",
                        "surface-bright": "#f7f9fb",
                        "on-primary-fixed-variant": "#00468c",
                        "primary-container": "#0b61bb",
                        "outline-variant": "#c1c7d3",
                        "surface-container-high": "#e6e8ea",
                        "surface-container-low": "#f2f4f6",
                        "on-error": "#ffffff",
                        "surface-tint": "#005db6",
                        "secondary": "#49607f",
                        "on-tertiary": "#ffffff",
                        "on-surface": "#191c1e",
                        "tertiary-fixed": "#ffdbc8",
                        "surface-container": "#eceef0",
                        "secondary-container": "#c1d9fd",
                        "tertiary-container": "#9e4b00",
                        "tertiary-fixed-dim": "#ffb689",
                        "inverse-surface": "#2d3133",
                        "background": "#f7f9fb",
                        "surface-container-lowest": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-tertiary-fixed-variant": "#743500",
                        "inverse-primary": "#a9c7ff",
                        "on-secondary-container": "#485f7e",
                        "on-background": "#191c1e",
                        "on-secondary-fixed-variant": "#314866",
                        "tertiary": "#7a3800",
                        "primary": "#004a93",
                        "secondary-fixed": "#d3e4ff",
                        "on-tertiary-fixed": "#311300",
                        "on-primary-fixed": "#001b3d",
                        "on-secondary-fixed": "#011c38",
                        "surface-dim": "#d8dadc",
                        "primary-fixed": "#d6e3ff",
                        "primary-fixed-dim": "#a9c7ff",
                        "secondary-fixed-dim": "#b1c8ec",
                        "on-primary": "#ffffff",
                        "surface-container-highest": "#e0e3e5",
                        "outline": "#717782",
                        "error": "#ba1a1a",
                        "surface": "#f7f9fb",
                        "on-surface-variant": "#414751",
                        "inverse-on-surface": "#eff1f3"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.5rem",
                        "lg": "1rem",
                        "xl": "1.25rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Inter", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                        "label": ["Inter", "sans-serif"]
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

        .clinical-gradient {
            background: linear-gradient(135deg, #004a93 0%, #0b61bb 100%);
        }
    </style>
</head>

<body class="bg-surface text-on-surface min-h-screen flex flex-col antialiased">
    <!-- TopNavBar (Updated to match Patient Portal style) -->
    <nav class="fixed top-0 w-full z-50 bg-slate-50/85 backdrop-blur-md shadow-sm shadow-blue-900/5 transition-all duration-300 ease-in-out font-sans antialiased tracking-tight">
        <div class="flex justify-between items-center px-8 py-4 max-w-full mx-auto">
            <!-- Brand -->
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 clinical-gradient rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">health_metrics</span>
                </div>
                <span class="text-xl font-bold tracking-tighter text-blue-900">ABTC-Insight</span>
            </div>
            <!-- Links & Actions -->
            <div class="flex items-center gap-8">
                <div class="hidden md:flex items-center gap-8">
                    <a class="text-slate-600 hover:text-blue-600 transition-colors text-sm font-medium" href="#">Patient Registration</a>
                    <a class="text-slate-600 hover:text-blue-600 transition-colors text-sm font-medium" href="#">Tracking Portal</a>
                </div>
                <button class="px-5 py-2 clinical-gradient text-white text-sm font-semibold rounded-lg shadow-md shadow-primary/10 hover:shadow-lg transition-all active:scale-95">
                    Login
                </button>
            </div>
        </div>
    </nav>
    <!-- Main Content: Login Portal -->
    <main class="flex-grow flex items-center justify-center pt-24 pb-12 px-4 bg-surface">
        <!-- Background Decoration -->
        <div class="fixed top-1/4 -left-20 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="fixed bottom-1/4 -right-20 w-96 h-96 bg-secondary/5 rounded-full blur-3xl pointer-events-none"></div>
        <!-- Login Card -->
        <div class="w-full max-w-[480px] z-10">
            <div class="bg-surface-container-lowest rounded-xl p-8 md:p-12 shadow-[0_24px_48px_rgba(25,28,30,0.04)] border border-outline-variant/10">
                <!-- Header -->
                <div class="text-center mb-10">
                    <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-on-surface mb-2">ABTC-Insight Portal Login</h1>
                    <p class="text-on-surface-variant text-sm md:text-base">Access the clinical system for ABTC Staff, Health Workers, and Administrators.</p>
                </div>
                <!-- Form -->
                <form method="POST" action="{{ route('login.submit') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant/80 ml-1" for="username">Username</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-outline">
                                <span class="material-symbols-outlined text-[20px]">person</span>
                            </div>
                            <input class="block w-full pl-11 pr-4 py-4 bg-surface-container-highest border-none rounded-lg text-on-surface focus:ring-1 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all duration-200 outline-none" id="username" name="username" placeholder="Enter your username" type="text" required />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant/80 ml-1" for="password">Password</label>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-outline">
                                <span class="material-symbols-outlined text-[20px]">lock</span>
                            </div>
                            <input class="block w-full pl-11 pr-12 py-4 bg-surface-container-highest border-none rounded-lg text-on-surface focus:ring-1 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all duration-200 outline-none" id="password" name="password" placeholder="••••••••" type="password" required />
                            <button class="absolute inset-y-0 right-0 pr-4 flex items-center text-outline hover:text-primary transition-colors" type="button">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </div>
                    </div>

                    @if($errors->any())
                    <div class="text-red-500 text-sm font-semibold px-2">
                        {{ $errors->first() }}
                    </div>
                    @endif

                    <div class="flex items-center gap-3 p-3 rounded-lg bg-surface-container-low border border-outline-variant/15">
                        <span class="material-symbols-outlined text-primary text-[18px]">verified_user</span>
                        <p class="text-[11px] text-on-surface-variant leading-tight">Secure session managed by Cebu City Health Security Protocols. Authorized personnel access only.</p>
                    </div>

                    <div class="pt-2">
                        <button class="w-full py-4 px-6 clinical-gradient text-white font-semibold rounded-lg shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 transition-all duration-300 transform active:scale-[0.98] flex items-center justify-center gap-2" type="submit">
                            <span>Login</span>
                            <span class="material-symbols-outlined text-sm">login</span>
                        </button>
                    </div>

                    <div class="text-center pt-2">
                        <a class="text-sm font-medium text-primary hover:text-primary-container transition-colors inline-flex items-center gap-1 group" href="#">
                            Forgot Password?
                            <span class="material-symbols-outlined text-[16px] group-hover:translate-x-0.5 transition-transform">chevron_right</span>
                        </a>
                    </div>
                </form>
            </div>
            <!-- Contextual Help / Login Support -->
            <div class="mt-8 flex justify-center gap-6">
                <div class="flex items-center gap-2 text-[12px] text-on-surface-variant/70">
                    <span class="material-symbols-outlined text-[14px]">support_agent</span>
                    <span>IT Support: (032) 231-1000</span>
                </div>
                <div class="flex items-center gap-2 text-[12px] text-on-surface-variant/70">
                    <span class="material-symbols-outlined text-[14px]">language</span>
                    <span>Region VII Hub</span>
                </div>
            </div>
        </div>
    </main>
    <!-- Standardized Footer -->
    <footer class="bg-surface-container-low border-t border-outline-variant/10 py-8 px-8">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-sm font-medium text-on-surface-variant">
                © 2026 CEBU CITY HEALTH DEPARTMENT
            </div>
            <div class="flex flex-wrap justify-center gap-6 md:gap-8">
                <a class="text-xs font-bold uppercase tracking-widest text-on-surface-variant hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <a class="text-xs font-bold uppercase tracking-widest text-on-surface-variant hover:text-primary transition-colors" href="#">Terms of Service</a>
                <a class="text-xs font-bold uppercase tracking-widest text-on-surface-variant hover:text-primary transition-colors" href="#">Accessibility</a>
            </div>
        </div>
    </footer>
</body>

</html>