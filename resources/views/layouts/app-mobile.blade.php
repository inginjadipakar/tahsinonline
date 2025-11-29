<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-white">
        {{-- Mobile Header --}}
        <div class="md:hidden fixed top-0 left-0 right-0 bg-white z-40 shadow-sm">
            <div class="flex items-center justify-between px-4 py-3">
                <div>
                    <span class="text-xl font-bold text-gray-900 tracking-tight">Tahsinku.</span>
                </div>
                
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-2 bg-red-50 rounded-full px-3 py-1.5">
                        <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="text-sm">
                            <div class="font-semibold text-gray-900 text-xs">{{ explode(' ', auth()->user()->name)[0] }}</div>
                            <div class="text-[10px] text-gray-500">Level 12</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="overflow-y-auto h-screen pb-20 pt-16">
            {{ $slot }}
        </div>

        {{-- Bottom Navigation --}}
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 pb-safe md:hidden">
            <div class="flex justify-around items-center h-16 px-2">
                {{-- Home --}}
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                    <span class="text-[10px] mt-0.5 font-medium">Home</span>
                </a>
                
                {{-- Kelas --}}
                <a href="{{ route('student.classes.index') }}" class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('student.classes.*') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                    </svg>
                    <span class="text-[10px] mt-0.5 font-medium">Kelas</span>
                </a>
                
                {{-- Paket --}}
                <a href="{{ route('student.subscription.index') }}" class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('student.subscription.*') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-[10px] mt-0.5 font-medium">Paket</span>
                </a>
                
                {{-- Bayar (Placeholder) --}}
                <a href="#" class="flex flex-col items-center justify-center flex-1 text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <span class="text-[10px] mt-0.5 font-medium">Bayar</span>
                </a>
                
                {{-- Profil --}}
                <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('profile.*') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-[10px] mt-0.5 font-medium">Profil</span>
                </a>
            </div>
        </div>
    </body>
</html>
