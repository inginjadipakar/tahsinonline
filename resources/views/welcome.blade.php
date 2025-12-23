<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark" x-data="{ darkMode: localStorage.getItem('darkMode') === 'false' ? false : true }" :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts - Inter (Premium font used by Notion, Linear, Vercel) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] { display: none !important; }
            .animate-on-scroll { opacity: 0; transform: translateY(20px); transition: all 0.6s ease-out; }
            .animate-on-scroll.is-visible { opacity: 1; transform: translateY(0); }
        </style>
    </head>
    <body class="antialiased font-sans text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-islamic-navy transition-colors duration-300">
        
        <!-- Navigation -->
        <nav x-data="{ mobileMenuOpen: false }" class="fixed w-full z-50 transition-all duration-300" :class="{ 'bg-white/80 dark:bg-islamic-navy/90 backdrop-blur-md shadow-sm': true }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <!-- Logo -->
                    <a href="#" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Tahsinku Logo" class="h-9 w-auto">
                        <span class="text-xl font-bold text-gray-800 dark:text-white tracking-wide leading-none mt-1">Tahsin<span class="text-islamic-emerald dark:text-islamic-gold">ku</span></span>
                    </a>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center gap-8">
                        <a href="#about" class="text-gray-600 dark:text-gray-300 hover:text-islamic-emerald dark:hover:text-islamic-gold transition-colors">Tentang</a>
                        <a href="#pricing" class="text-gray-600 dark:text-gray-300 hover:text-islamic-emerald dark:hover:text-islamic-gold transition-colors">Program</a>
                        <a href="#faq" class="text-gray-600 dark:text-gray-300 hover:text-islamic-emerald dark:hover:text-islamic-gold transition-colors">FAQ</a>
                        
                        <!-- Dark Mode Toggle -->
                        <button @click="darkMode = !darkMode" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <svg x-show="darkMode" class="w-5 h-5 text-islamic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <svg x-show="!darkMode" class="w-5 h-5 text-islamic-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        </button>

                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-islamic-emerald hover:bg-islamic-emerald-dark text-white font-semibold rounded-xl transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-islamic-emerald dark:hover:text-islamic-gold font-medium transition-colors">
                                Masuk
                            </a>
                            <a href="#pricing" class="px-5 py-2.5 bg-islamic-emerald hover:bg-islamic-emerald-dark text-white font-semibold rounded-xl transition-colors shadow-lg shadow-islamic-emerald/20">
                                Daftar Sekarang
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="flex md:hidden items-center gap-4">
                        <!-- Dark Mode Toggle (Mobile) -->
                        <button @click="darkMode = !darkMode" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <svg x-show="darkMode" class="w-5 h-5 text-islamic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <svg x-show="!darkMode" class="w-5 h-5 text-islamic-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        </button>

                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 dark:text-gray-300 hover:text-islamic-emerald dark:hover:text-islamic-gold focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="md:hidden absolute top-20 left-0 w-full bg-white dark:bg-islamic-navy border-t border-gray-100 dark:border-gray-800 shadow-lg"
                 x-cloak>
                <div class="flex flex-col px-4 py-6 space-y-4">
                    <a href="#about" @click="mobileMenuOpen = false" class="text-lg font-medium text-gray-600 dark:text-gray-300 hover:text-islamic-emerald dark:hover:text-islamic-gold transition-colors">Tentang</a>
                    <a href="#pricing" @click="mobileMenuOpen = false" class="text-lg font-medium text-gray-600 dark:text-gray-300 hover:text-islamic-emerald dark:hover:text-islamic-gold transition-colors">Program</a>
                    <a href="#faq" @click="mobileMenuOpen = false" class="text-lg font-medium text-gray-600 dark:text-gray-300 hover:text-islamic-emerald dark:hover:text-islamic-gold transition-colors">FAQ</a>
                    
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex flex-col gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="w-full text-center px-5 py-3 bg-islamic-emerald hover:bg-islamic-emerald-dark text-white font-semibold rounded-xl transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="w-full text-center px-5 py-3 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:text-islamic-emerald dark:hover:text-islamic-gold font-medium rounded-xl transition-colors">
                                Masuk
                            </a>
                            <a href="#pricing" @click="mobileMenuOpen = false" class="w-full text-center px-5 py-3 bg-islamic-emerald hover:bg-islamic-emerald-dark text-white font-semibold rounded-xl transition-colors shadow-lg shadow-islamic-emerald/20">
                                Daftar Sekarang
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            <x-landing.carousel :data="config('landing.carousel')" />
            
            <x-landing.hero :data="config('landing.hero')" />
            
            <div id="about" class="bg-white bg-arabic-calligraphy">
                <x-landing.problem-agitate :data="config('landing.problem')" />
            </div>

            <x-landing.solution-features :data="config('landing.solution')" />
            
            <div id="pricing" class="py-20 bg-gray-50 dark:bg-gray-900 bg-arabic-calligraphy">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">Pilih Paket Belajar</h2>
                        <p class="text-gray-600 dark:text-gray-400">Investasi terbaik untuk masa depan akhirat Anda.</p>
                    </div>
                    
                    <!-- Existing Pricing Grid (Kept for functionality) -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach($classes as $index => $class)
                        <div class="relative bg-white dark:bg-gray-800 bg-arabic-calligraphy rounded-3xl shadow-xl overflow-hidden flex flex-col transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl group {{ $index === 2 ? 'ring-4 ring-islamic-gold scale-105 z-30' : '' }}">
                            @if($index === 2)
                            <div class="absolute top-0 inset-x-0 h-2 bg-islamic-gold"></div>
                            <div class="absolute top-2 right-0 bg-islamic-gold text-islamic-navy text-xs font-bold px-3 py-1 rounded-l-full shadow-sm">
                                POPULER
                            </div>
                            @endif

                            <div class="p-8 flex-1">
                                <div class="w-20 h-20 rounded-2xl {{ $index === 2 ? 'bg-yellow-100' : 'bg-blue-50' }} flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 transition-transform p-2">
                                    <img src="{{ asset('images/icons/' . ($index === 0 ? 'toddler.png' : ($index === 1 ? 'kid.png' : ($index === 2 ? 'family.png' : 'woman.png')))) }}" 
                                         alt="{{ $class->name }}" 
                                         class="w-full h-full object-contain drop-shadow-md">
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $class->name }}</h3>
                                <div class="flex items-baseline mb-4">
                                    <span class="text-4xl font-extrabold text-gray-900 dark:text-white">Rp {{ number_format($class->price / 1000, 0) }}rb</span>
                                    <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">/bln</span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-8 leading-relaxed min-h-[40px]">{{ $class->description }}</p>
                                
                                <ul role="list" class="space-y-4 mb-8">
                                    @php
                                        $curriculums = [
                                            'Tahsin Anak Reguler' => ['Pengenalan Huruf Hijaiyah', 'Makharijul Huruf Dasar', 'Hafalan Surat Pendek', 'Adab & Doa Harian'],
                                            'Tahsin Anak Privat' => ['Pengenalan Huruf Hijaiyah', 'Makharijul Huruf Dasar', 'Hafalan Surat Pendek', 'Fokus One-on-One'],
                                            'Tahsin Reguler (Dewasa)' => ['Pengenalan Huruf Hijaiyah', 'Makharijul Huruf', 'Hukum Tajwid Dasar', 'Praktik Bacaan'],
                                            'Tahsin Privat (Dewasa)' => ['Pengenalan Huruf Hijaiyah', 'Makharijul Huruf', 'Hukum Tajwid Lengkap', 'Praktik Bacaan Intensif'],
                                        ];
                                        $currentCurriculum = $curriculums[$class->name] ?? ['Makharijul Huruf', 'Sifat Huruf', 'Hukum Tajwid', 'Praktik Bacaan'];
                                    @endphp

                                    @foreach($currentCurriculum as $item)
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-islamic-emerald flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span class="ml-3 text-sm text-gray-600 dark:text-gray-300">{{ $item }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            <div class="p-6 pt-0 mt-auto">
                                <a href="{{ route('guest.select-program', ['class_id' => $class->id]) }}" class="w-full flex items-center justify-center px-6 py-3.5 border border-transparent text-sm font-bold rounded-xl text-white {{ $index === 2 ? 'bg-islamic-emerald hover:bg-islamic-emerald-dark shadow-lg shadow-islamic-emerald/30' : 'bg-gray-900 hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600' }} transition-all hover:-translate-y-0.5">
                                    Daftar Sekarang
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <x-landing.social-proof :data="config('landing.social_proof')" />
            
            <div id="faq">
                <x-landing.faq :data="config('landing.faq')" />
            </div>

            <x-landing.cta-section :data="config('landing.cta')" />
        </main>

        <footer class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    <!-- Branding -->
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <img src="{{ asset('images/logo.png') }}" alt="Tahsinku Logo" class="h-8 w-auto">
                            <span class="text-xl font-bold text-gray-800 dark:text-white">Tahsin<span class="text-islamic-emerald dark:text-islamic-gold">ku</span></span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Platform Belajar Al-Qur'an #1 di Indonesia
                        </p>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-3">Alamat</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Pelem II, Pelem,<br>
                            Kec. Ngawi, Kabupaten Ngawi,<br>
                            Jawa Timur
                        </p>
                    </div>

                    <!-- Social Media -->
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-3">Ikuti Kami</h3>
                        <a href="https://www.instagram.com/masjidjamisosrohadisewoyo?igsh=anNsMWhweGl3bW9h" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 hover:text-islamic-emerald dark:hover:text-islamic-gold transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                            @masjidjamisosrohadisewoyo
                        </a>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        &copy; {{ date('Y') }} Tahsinku. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>

        <script>
            // Intersection Observer for Scroll Animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.animate-on-scroll').forEach((el) => observer.observe(el));
        </script>

        <!-- Floating WhatsApp Button -->
        <x-landing.whatsapp-float />
    </body>
</html>
