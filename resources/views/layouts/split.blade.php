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
        <div class="min-h-screen flex items-center justify-center lg:p-8 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 z-0 opacity-30 dark:opacity-10">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%2310b981\' fill-opacity=\'0.1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            </div>

            <!-- Floating Card (Full Screen on Mobile) -->
            <div class="relative z-10 w-full max-w-6xl bg-white dark:bg-islamic-navy lg:rounded-3xl shadow-2xl overflow-hidden flex flex-col lg:flex-row min-h-screen lg:min-h-0 lg:max-h-[90vh]">
                
                <!-- Mobile Header -->
                <div class="lg:hidden absolute top-0 left-0 right-0 z-30 p-4 flex items-center justify-between bg-gradient-to-b from-black/50 to-transparent">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Tahsinku Logo" class="h-8 w-auto">
                        <span class="text-xl font-bold text-white tracking-wide">Tahsin<span class="text-islamic-gold">ku</span></span>
                    </div>
                    <button @click="darkMode = !darkMode" class="text-white hover:text-islamic-gold transition-colors">
                        <svg x-show="darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </button>
                </div>

                <!-- Right Side: Image (Top on Mobile) -->
                <div class="w-full lg:w-1/2 xl:w-7/12 relative bg-islamic-emerald/5 dark:bg-islamic-navy-light/50 h-72 lg:h-auto order-first lg:order-last shrink-0">
                    <div class="absolute inset-0 bg-gradient-to-br from-islamic-emerald/10 to-islamic-gold/10 z-10"></div>
                    <img class="absolute inset-0 h-full w-full object-cover z-0" src="{{ asset($image ?? 'images/quran-study-cinematic.png') }}" alt="Belajar Mengaji">
                    <div class="absolute inset-0 bg-gradient-to-t from-islamic-navy/90 via-islamic-navy/40 to-transparent flex flex-col justify-end p-6 lg:p-16 text-white z-20">
                        <h2 class="text-2xl lg:text-4xl font-bold mb-2 lg:mb-6">Mari Mulai Perjalanan Hijrahmu</h2>
                        <p class="text-sm lg:text-xl text-gray-200 max-w-md leading-relaxed hidden sm:block">
                            Bergabunglah dengan ribuan santri lainnya dan rasakan kemudahan belajar Al-Qur'an secara online dengan kurikulum terbaik.
                        </p>
                        <p class="text-sm text-gray-200 leading-relaxed sm:hidden">
                            Belajar Al-Qur'an online dengan kurikulum terbaik.
                        </p>
                    </div>
                </div>

                <!-- Left Side: Content (Bottom on Mobile) -->
                <div class="w-full lg:w-1/2 xl:w-5/12 flex flex-col overflow-y-auto custom-scrollbar relative bg-white dark:bg-islamic-navy -mt-6 rounded-t-3xl lg:mt-0 lg:rounded-none z-20 flex-1">
                    <div class="p-6 sm:p-12 lg:p-16">
                        <!-- Desktop Header -->
                        <div class="hidden lg:flex items-center justify-between mb-10">
                            <a href="/" class="flex items-center gap-2">
                                <img src="{{ asset('images/logo.png') }}" alt="Tahsinku Logo" class="h-10 w-auto">
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
