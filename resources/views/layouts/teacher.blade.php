<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Guru</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                background: #F5F7FB !important;
                background-image: none !important;
            }
            
            .icon-sidebar {
                background: white;
                border-right: 1px solid #f3f4f6;
            }
            
            .bottom-nav {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);
            }
            
            .main-card,
            .page-content {
                background: white !important;
                border-radius: 24px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            }
            
            @media (max-width: 768px) {
                .icon-sidebar {
                    display: none !important;
                }
                
                .mobile-bottom-nav {
                    display: flex !important;
                }
                
                .page-content {
                    margin-bottom: 80px;
                }
            }
            
            @media (min-width: 769px) {
                .icon-sidebar {
                    display: flex !important;
                }
                
                .mobile-bottom-nav {
                    display: none !important;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="flex h-screen overflow-hidden bg-[#F5F7FB]">
            {{-- Desktop Sidebar --}}
            <div class="hidden md:flex w-64 flex-col bg-white h-full border-r border-gray-100">
                {{-- Logo --}}
                <div class="p-8 flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Tahsinku Logo" class="h-9 w-auto">
                    <span class="text-2xl font-bold text-gray-900 tracking-tight leading-none mt-1">Tahsin<span class="text-islamic-emerald">ku</span></span>
                </div>
                
                {{-- Menu --}}
                <div class="flex-1 overflow-y-auto px-6 space-y-8">
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 px-4">Menu Guru</h3>
                        <div class="space-y-1">
                            {{-- Dashboard --}}
                            <a href="{{ route('teacher.dashboard') }}" 
                               class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('teacher.dashboard') ? 'text-islamic-emerald font-bold bg-emerald-50' : 'text-gray-500 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 {{ request()->routeIs('teacher.dashboard') ? 'text-islamic-emerald' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                <span>Dashboard</span>
                            </a>

                            {{-- Materi (Lessons) --}}
                            <a href="#" 
                               class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('teacher.lessons.*') ? 'text-islamic-emerald font-bold bg-emerald-50' : 'text-gray-500 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 {{ request()->routeIs('teacher.lessons.*') ? 'text-islamic-emerald' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                <span>Kelola Materi</span>
                            </a>
                            
                            {{-- Siswa (Students) --}}
                            <a href="#" 
                               class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('teacher.students.*') ? 'text-islamic-emerald font-bold bg-emerald-50' : 'text-gray-500 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 {{ request()->routeIs('teacher.students.*') ? 'text-islamic-emerald' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                <span>Progress Siswa</span>
                            </a>
                        </div>
                    </div>

                    {{-- Section: General --}}
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 px-4">Umum</h3>
                        <div class="space-y-1">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-gray-500 hover:text-gray-900 transition-all">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Pengaturan</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-4 px-4 py-3 rounded-xl text-gray-500 hover:text-red-600 transition-all">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                {{-- User Profile --}}
                <div class="p-6 border-t border-gray-100">
                    <div class="flex items-center gap-3 p-3 rounded-2xl bg-gray-50">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-islamic-emerald font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">Guru Tahsin</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content Area --}}
            <div class="flex-1 overflow-y-auto p-4 md:p-6">
                <div class="max-w-7xl mx-auto">
                    @isset($header)
                        <div class="mb-4 md:mb-6">
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $header }}</h1>
                        </div>
                    @endisset

                    <div class="page-content p-4 md:p-6">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile Bottom Navigation --}}
        <div class="mobile-bottom-nav hidden fixed bottom-0 left-0 right-0 bottom-nav z-50">
            <div class="grid grid-cols-4 items-center h-14">
                <a href="{{ route('teacher.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('teacher.dashboard') ? 'text-islamic-emerald' : 'text-gray-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span class="text-[10px] mt-0.5">Beranda</span>
                </a>
                
                <a href="#" class="flex flex-col items-center justify-center w-full h-full text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span class="text-[10px] mt-0.5">Materi</span>
                </a>
                
                <a href="#" class="flex flex-col items-center justify-center w-full h-full text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span class="text-[10px] mt-0.5">Siswa</span>
                </a>
                
                <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('profile.*') ? 'text-islamic-emerald' : 'text-gray-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span class="text-[10px] mt-0.5">Profil</span>
                </a>
            </div>
        </div>
    </body>
</html>
