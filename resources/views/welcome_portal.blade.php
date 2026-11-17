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
            </div>
        </div>
        <!-- Separation Line -->
        <div class="bg-slate-200/50 h-[1px] w-full absolute bottom-0"></div>
    </nav>

    <main class="pt-20">
        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-surface py-16 lg:py-24">
            <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Text Column -->
                <div class="z-10 lg:col-span-7">
                    <h1 class="text-4xl lg:text-6xl font-extrabold tracking-tight text-on-surface mb-6 leading-[1.1]">
                        Welcome to Cebu City Health Department's <br />
                        <span class="bg-gradient-to-r from-primary to-primary-container bg-clip-text text-transparent">Animal Bite Treatment Center Portal.</span>
                    </h1>
                    <p class="text-lg text-on-surface-variant mb-10 max-w-xl leading-relaxed">
                        Cebu City's dedicated portal for Animal Bite Treatment &amp; Control. Streamlining patient recovery through advanced tracking and real-time clinical insights.
                    </p>
                </div>

                <!-- Right Carousel Column -->
                <div class="relative w-full lg:col-span-5 flex flex-col items-center justify-center">
                    <div class="relative w-full max-w-md bg-surface-container-lowest p-8 rounded-[2rem] shadow-xl border border-outline-variant/10 min-h-[320px] flex flex-col justify-between">
                        
                        <!-- Carousel Slides Wrapper -->
                        <div id="carouselSlides" class="relative overflow-hidden flex-1 flex items-center min-h-[190px]">
                            
                            <!-- Slide 1: Fatal Nature -->
                            <div class="carousel-slide w-full transition-all duration-500 opacity-100 absolute inset-0 flex flex-col justify-center" data-index="0">
                                <div class="w-12 h-12 rounded-full bg-error-container flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-on-error-container text-2xl" data-icon="warning">warning</span>
                                </div>
                                <h4 class="text-xl font-extrabold mb-2 text-on-surface">Virtually 100% Fatal</h4>
                                <p class="text-on-surface-variant leading-relaxed text-sm">
                                    Rabies is a vaccine-preventable viral disease, but once clinical symptoms appear, it is virtually 100% fatal for those infected.
                                </p>
                            </div>

                            <!-- Slide 2: Immediate PEP -->
                            <div class="carousel-slide w-full transition-all duration-500 opacity-0 absolute inset-0 flex flex-col justify-center pointer-events-none" data-index="1">
                                <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-primary text-2xl" data-icon="medical_services">medical_services</span>
                                </div>
                                <h4 class="text-xl font-extrabold mb-2 text-on-surface">Immediate PEP</h4>
                                <p class="text-on-surface-variant leading-relaxed text-sm">
                                    Post-exposure prophylaxis (PEP) consists of immediate wound cleaning, a full course of rabies vaccine, and rabies immunoglobulin.
                                </p>
                            </div>

                            <!-- Slide 3: Timely Intervention -->
                            <div class="carousel-slide w-full transition-all duration-500 opacity-0 absolute inset-0 flex flex-col justify-center pointer-events-none" data-index="2">
                                <div class="w-12 h-12 rounded-full bg-tertiary-fixed flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-on-tertiary-fixed-variant text-2xl" data-icon="schedule">schedule</span>
                                </div>
                                <h4 class="text-xl font-extrabold mb-2 text-on-surface">Timely Intervention</h4>
                                <p class="text-on-surface-variant leading-relaxed text-sm">
                                    Timely PEP is crucial for preventing rabies deaths after a potential exposure. Every minute counts in clinical intervention.
                                </p>
                            </div>

                            <!-- Slide 4: 15 Min Wound Washing -->
                            <div class="carousel-slide w-full transition-all duration-500 opacity-0 absolute inset-0 flex flex-col justify-center pointer-events-none" data-index="3">
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-blue-700 text-2xl" data-icon="water_drop">water_drop</span>
                                </div>
                                <h4 class="text-xl font-extrabold mb-2 text-on-surface">15 Min Wound Washing</h4>
                                <p class="text-on-surface-variant leading-relaxed text-sm">
                                    Wash the wound thoroughly immediately with soap and water under running water for at least 15 minutes to effectively neutralize the virus.
                                </p>
                            </div>

                        </div>

                        <!-- Carousel Controls & Indicators -->
                        <div class="flex items-center justify-between mt-6 pt-4 border-t border-outline-variant/10 z-20">
                            <!-- Dot Indicators -->
                            <div class="flex gap-1.5" id="carouselDots">
                                <button onclick="currentSlide(0)" class="w-6 h-2 rounded-full bg-primary transition-all dot-indicator" aria-label="Slide 1"></button>
                                <button onclick="currentSlide(1)" class="w-2 h-2 rounded-full bg-slate-300 transition-all dot-indicator" aria-label="Slide 2"></button>
                                <button onclick="currentSlide(2)" class="w-2 h-2 rounded-full bg-slate-300 transition-all dot-indicator" aria-label="Slide 3"></button>
                                <button onclick="currentSlide(3)" class="w-2 h-2 rounded-full bg-slate-300 transition-all dot-indicator" aria-label="Slide 4"></button>
                            </div>

                            <!-- Next/Prev Buttons -->
                            <div class="flex gap-2">
                                <button onclick="prevSlide()" class="w-8 h-8 rounded-full bg-surface-container hover:bg-surface-container-high flex items-center justify-center text-slate-700 transition-colors shadow-sm">
                                    <span class="material-symbols-outlined text-sm">chevron_left</span>
                                </button>
                                <button onclick="nextSlide()" class="w-8 h-8 rounded-full bg-surface-container hover:bg-surface-container-high flex items-center justify-center text-slate-700 transition-colors shadow-sm">
                                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <!-- GIS MAP -->

        <!-- Call to Action Card Section -->
        <section class="py-12 bg-surface">
            <div class="max-w-7xl mx-auto px-6">
                <div class="p-10 bg-surface-container-low rounded-[2rem] flex flex-col md:flex-row items-center justify-between gap-8 shadow-sm">
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold mb-2">Have you been exposed?</h3>
                        <p class="text-on-surface-variant text-sm md:text-base">Don't wait. Proceed to the <strong>Cebu City Health Department Animal Bite Treatment Center (CCHD ABTC)</strong> immediately for professional medical care.</p>
                    </div>
                    <p class="text-primary font-bold text-base text-right">Please visit the clinic immediately for urgent medical attention.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-100 w-full py-12 px-8 mt-12">
        <div class="flex flex-col md:flex-row justify-between items-center gap-8 max-w-7xl mx-auto">
            <div class="flex flex-wrap justify-center gap-8 font-sans text-xs uppercase tracking-widest font-semibold">
            <a class="text-slate-500 hover:text-blue-500 transition-colors" href="https://cebucitytour.com/cebu-city-emergecy-hotline/" target="_blank" rel="noopener noreferrer">Emergency Contacts</a>
            <a class="text-slate-500 hover:text-blue-500 transition-colors" href="https://doh.gov.ph/" target="_blank" rel="noopener noreferrer">Department of Health</a>
        </div>
            <div class="text-slate-500 text-[10px] uppercase tracking-widest font-bold opacity-60">
                © 2026 Cebu City Health Center. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Carousel Script -->
    <script>
        let slideIndex = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.dot-indicator');
        let autoSlideTimer;

        function showSlide(n) {
            slideIndex = (n + slides.length) % slides.length;
            
            slides.forEach((slide, i) => {
                if (i === slideIndex) {
                    slide.classList.remove('opacity-0', 'pointer-events-none');
                    slide.classList.add('opacity-100');
                } else {
                    slide.classList.remove('opacity-100');
                    slide.classList.add('opacity-0', 'pointer-events-none');
                }
            });

            dots.forEach((dot, i) => {
                if (i === slideIndex) {
                    dot.classList.remove('w-2', 'bg-slate-300');
                    dot.classList.add('w-6', 'bg-primary');
                } else {
                    dot.classList.remove('w-6', 'bg-primary');
                    dot.classList.add('w-2', 'bg-slate-300');
                }
            });
        }

        function nextSlide() {
            showSlide(slideIndex + 1);
            resetTimer();
        }

        function prevSlide() {
            showSlide(slideIndex - 1);
            resetTimer();
        }

        function currentSlide(n) {
            showSlide(n);
            resetTimer();
        }

        function resetTimer() {
            clearInterval(autoSlideTimer);
            autoSlideTimer = setInterval(() => {
                showSlide(slideIndex + 1);
            }, 6000); // Rotates every 6 seconds automatically
        }

        // Initialize auto rotation
        autoSlideTimer = setInterval(() => {
            showSlide(slideIndex + 1);
        }, 6000);
    </script>
</body>

</html>