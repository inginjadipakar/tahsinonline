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
    <body class="font-sans antialiased text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-islamic-navy bg-islamic-pattern bg-blend-multiply dark:bg-blend-overlay transition-colors duration-300">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-6">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-islamic-emerald to-islamic-emerald-dark dark:from-islamic-gold dark:to-islamic-gold-light flex items-center justify-center shadow-lg shadow-islamic-emerald/20 dark:shadow-islamic-gold/20">
                        <svg class="w-7 h-7 text-white dark:text-islamic-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-gray-800 dark:text-white tracking-wide">Tahsin<span class="text-islamic-emerald dark:text-islamic-gold">ku</span></span>
                </a>
            </div>

            <div class="w-full {{ $maxWidth ?? 'sm:max-w-md' }} mt-6 {{ $padding ?? 'px-6 py-8' }} bg-white/80 dark:bg-islamic-navy-light/60 backdrop-blur-md border border-islamic-emerald/20 dark:border-white/10 shadow-xl sm:rounded-2xl transition-colors duration-300 overflow-hidden">
                {{ $slot }}
            </div>

            <!-- Dark Mode Toggle -->
            <div class="mt-8">
                <button @click="darkMode = !darkMode" class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/50 dark:bg-islamic-navy-light/50 border border-islamic-emerald/20 dark:border-white/10 text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-islamic-navy-light transition-all shadow-sm">
                    <svg x-show="darkMode" class="w-5 h-5 text-islamic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg x-show="!darkMode" class="w-5 h-5 text-islamic-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <span x-text="darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'" class="text-xs font-bold"></span>
                </button>
            </div>
        </div>
    </body>
</html>
