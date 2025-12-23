<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts - Inter (Premium font used by Notion, Linear, Vercel) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
            
            /* Fix all text colors - REMOVED to allow Tailwind utilities to work */
            /* 
               The previous !important overrides were preventing text-white and other color utilities 
               from working in the dashboard and other pages. 
            */
            /* Mobile: hide sidebar, show bottom nav */
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
            
            /* Desktop: show sidebar, hide bottom nav */
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
            {{-- Desktop Sidebar (Full Width with Text) --}}
            <div class="hidden md:flex w-64 flex-col bg-white h-full border-r border-gray-100">
                {{-- Logo --}}
                <div class="p-8 flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Tahsinku Logo" class="h-9 w-auto">
                    <span class="text-2xl font-bold text-gray-900 tracking-tight leading-none mt-1">Tahsin<span class="text-islamic-emerald">ku</span></span>
                </div>
                
                {{-- Menu --}}
                <div class="flex-1 overflow-y-auto px-6 space-y-8">
                    {{-- Section: Menu --}}
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 px-4">Menu Utama</h3>
                        <div class="space-y-1">
                            {{-- Dashboard / Beranda --}}
                            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" 
                               class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'text-red-600 font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'text-red-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                <span>Beranda</span>
                                @if(request()->routeIs('dashboard'))
                                    <div class="ml-auto w-1.5 h-1.5 rounded-full bg-red-600"></div>
                                @endif
                            </a>

                            @if(auth()->user()->role === 'student')
                                {{-- Kelas Saya --}}
                                <a href="{{ route('student.my-class') }}" 
                                   class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('student.my-class') ? 'text-red-600 font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900' }}">
                                    <svg class="w-5 h-5 {{ request()->routeIs('student.my-class') ? 'text-red-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/></svg>
                                    <span>Kelas Saya</span>
                                </a>
                                
                                {{-- Classes / Kursus Lainnya --}}
                                <a href="{{ route('student.classes.index') }}" 
                                   class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('student.classes.*') ? 'text-red-600 font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900' }}">
                                    <svg class="w-5 h-5 {{ request()->routeIs('student.classes.*') ? 'text-red-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    <span>Kursus Lainnya</span>
                                </a>
                                
                                {{-- Subscription / Langganan --}}
                                <a href="{{ route('student.subscription.index') }}" 
                                   class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('student.subscription.*') ? 'text-red-600 font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900' }}">
                                    <svg class="w-5 h-5 {{ request()->routeIs('student.subscription.*') ? 'text-red-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>Langganan</span>
                                </a>
                            @else
                                {{-- Admin Links --}}
                                <a href="{{ route('admin.tahsin-classes.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-gray-500 hover:text-gray-900">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    <span>Kelola Kelas</span>
                                </a>
                                
                                <a href="{{ route('admin.schedules.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->routeIs('admin.schedules.*') ? 'text-red-600 font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900' }} transition-all">
                                    <svg class="w-5 h-5 {{ request()->routeIs('admin.schedules.*') ? 'text-red-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>Jadwal Kelas</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Section: Social --}}
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 px-4">Sosial</h3>
                        <div class="space-y-1">
                            <a href="{{ route('student.infak.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->routeIs('student.infak.*') ? 'text-red-600 font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900' }} transition-all">
                                <svg class="w-5 h-5 {{ request()->routeIs('student.infak.*') ? 'text-red-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Infak</span>
                            </a>
                            <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl text-gray-500 hover:text-gray-900 transition-all">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <span>Materi</span>
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
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">Level 12</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content Area --}}
            <div class="flex-1 overflow-y-auto p-4 md:p-6">
                <div class="max-w-7xl mx-auto">
                    @isset($header)
                        <div class="mb-4 md:mb-6">
                            <h1 class="text-2xl md:text-3xl font-bold text-white">{{ $header }}</h1>
                        </div>
                    @endisset

                    <div class="page-content p-4 md:p-6">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile Bottom Navigation (Hidden on Desktop) --}}
        <div class="mobile-bottom-nav hidden fixed bottom-0 left-0 right-0 bottom-nav z-50">
            <div class="grid grid-cols-8 items-center h-14">
                @if(auth()->user()->role === 'student')
                    {{-- Beranda --}}
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('dashboard') ? 'text-red-600' : 'text-gray-600' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span class="text-[10px] mt-0.5">Beranda</span>
                    </a>
                    
                    {{-- Kelas --}}
                    <a href="{{ route('student.my-class') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('student.my-class') ? 'text-red-600' : 'text-gray-600' }}">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                        </svg>
                        <span class="text-[10px] mt-0.5">Kelas</span>
                    </a>
                    
                    {{-- Kursus --}}
                    <a href="{{ route('student.classes.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('student.classes.*') || request()->routeIs('student.lessons.*') ? 'text-red-600' : 'text-gray-600' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="text-[10px] mt-0.5">Kursus</span>
                    </a>
                    
                    {{-- Langganan --}}
                    <a href="{{ route('student.subscription.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('student.subscription.*') ? 'text-red-600' : 'text-gray-600' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-[10px] mt-0.5">Langganan</span>
                    </a>

                    {{-- Materi --}}
                    <a href="#" class="flex flex-col items-center justify-center w-full h-full text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="text-[10px] mt-0.5">Materi</span>
                    </a>

                    {{-- Infak --}}
                    <a href="{{ route('student.infak.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('student.infak.*') ? 'text-red-600' : 'text-gray-600' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-[10px] mt-0.5">Infak</span>
                    </a>

                    {{-- Profil --}}
                    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('profile.*') ? 'text-red-600' : 'text-gray-600' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="text-[10px] mt-0.5">Profil</span>
                    </a>

                    {{-- Keluar --}}
                    <form method="POST" action="{{ route('logout') }}" class="w-full h-full">
                        @csrf
                        <button type="submit" class="flex flex-col items-center justify-center w-full h-full text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="text-[10px] mt-0.5">Keluar</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-600' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="text-xs mt-1">Home</span>
                    </a>
                    
                    <a href="{{ route('admin.tahsin-classes.index') }}" class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('admin.tahsin-classes.*') ? 'text-blue-600' : 'text-gray-600' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span class="text-xs mt-1">Kelas</span>
                    </a>
                    
                    <a href="{{ route('admin.lessons.index') }}" class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('admin.lessons.*') ? 'text-blue-600' : 'text-gray-600' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-xs mt-1">Materi</span>
                    </a>
                    
                    <a href="{{ route('admin.subscriptions.index') }}" class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('admin.subscriptions.*') ? 'text-blue-600' : 'text-gray-600' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xs mt-1">Paket</span>
                    </a>
                    
                    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('profile.*') ? 'text-blue-600' : 'text-gray-600' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="text-xs mt-1">Profil</span>
                    </a>
                @endif
            </div>
        </div>
    </body>
</html>
