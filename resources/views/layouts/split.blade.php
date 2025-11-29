<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark" x-data="{ darkMode: localStorage.getItem('darkMode') === 'false' ? false : true }" :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 z-0 opacity-30 dark:opacity-10">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%2310b981\' fill-opacity=\'0.1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            </div>

            <!-- Floating Card -->
            <div class="relative z-10 w-full max-w-6xl bg-white dark:bg-islamic-navy rounded-3xl shadow-2xl overflow-hidden flex flex-col lg:flex-row max-h-[90vh]">
                
                <!-- Left Side: Content -->
                <div class="w-full lg:w-1/2 xl:w-5/12 flex flex-col overflow-y-auto custom-scrollbar relative">
                    <div class="p-8 sm:p-12 lg:p-16">
                        <div class="flex items-center justify-between mb-10">
                            <a href="/" class="flex items-center gap-2">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-islamic-emerald to-islamic-emerald-dark dark:from-islamic-gold dark:to-islamic-gold-light flex items-center justify-center shadow-lg shadow-islamic-emerald/20 dark:shadow-islamic-gold/20">
                                    <svg class="w-6 h-6 text-white dark:text-islamic-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <span class="text-2xl font-bold text-gray-800 dark:text-white tracking-wide">Tahsin<span class="text-islamic-emerald dark:text-islamic-gold">ku</span></span>
                            </a>
                            
                            <!-- Dark Mode Toggle (Top Right) -->
                            <button @click="darkMode = !darkMode" class="flex items-center gap-2 text-sm font-medium text-islamic-emerald dark:text-islamic-gold hover:text-islamic-emerald-dark dark:hover:text-white transition-colors">
                                <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                                <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                            </button>
                        </div>

                        {{ $slot }}
                    </div>
                </div>

                <!-- Right Side: Image -->
                <div class="hidden lg:block lg:w-1/2 xl:w-7/12 relative bg-islamic-emerald/5 dark:bg-islamic-navy-light/50">
                    <div class="absolute inset-0 bg-gradient-to-br from-islamic-emerald/10 to-islamic-gold/10"></div>
                    <img class="absolute inset-0 h-full w-full object-cover" src="{{ asset('images/quran-study.png') }}" alt="Belajar Mengaji">
                    <div class="absolute inset-0 bg-gradient-to-t from-islamic-navy/90 via-islamic-navy/20 to-transparent flex flex-col justify-end p-16 text-white">
                        <h2 class="text-4xl font-bold mb-6">Mari Mulai Perjalanan Hijrahmu</h2>
                        <p class="text-xl text-gray-200 max-w-md leading-relaxed">
                            Bergabunglah dengan ribuan santri lainnya dan rasakan kemudahan belajar Al-Qur'an secara online dengan kurikulum terbaik.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 6px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgba(156, 163, 175, 0.5); border-radius: 20px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: rgba(156, 163, 175, 0.8); }
        </style>
    </body>
</html>
