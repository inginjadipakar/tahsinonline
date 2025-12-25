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
        }
        
        @media (max-width: 768px) {
            .mobile-bottom-nav {
                display: flex !important;
            }
            
            .page-content {
                margin-bottom: 80px;
            }
        }
        
        @media (min-width: 769px) {
            .mobile-bottom-nav {
                display: none !important;
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="flex h-screen overflow-hidden bg-[#F5F7FB]">
        {{-- Sidebar --}}
        <div class="hidden md:flex w-64 flex-col bg-white h-full border-r border-gray-100">
            {{-- Logo --}}
            <div class="p-8 flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Tahsinku Logo" class="h-9 w-auto">
                <span class="text-2xl font-bold text-gray-900">Tahsin<span class="text-green-600">ku</span></span>
            </div>

            {{-- Menu --}}
            <div class="flex-1 overflow-y-auto px-6 space-y-6">
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 px-4">Menu Guru</h3>
                    <div class="space-y-1">
                        <a href="{{ route('teacher.dashboard') }}"
                            class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('teacher.dashboard') ? 'text-green-600 font-bold bg-green-50' : 'text-gray-500 hover:text-gray-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('teacher.lessons.index') }}"
                            class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('teacher.lessons.*') ? 'text-green-600 font-bold bg-green-50' : 'text-gray-500 hover:text-gray-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Materi & Tugas</span>
                        </a>

                        <a href="{{ route('teacher.students.index') }}"
                            class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('teacher.students.*') ? 'text-green-600 font-bold bg-green-50' : 'text-gray-500 hover:text-gray-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>Siswa Saya</span>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 px-4">Umum</h3>
                    <div class="space-y-1">
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-4 px-4 py-3 rounded-xl text-gray-500 hover:text-gray-900 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Pengaturan</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-4 px-4 py-3 rounded-xl text-gray-500 hover:text-red-600 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- User Profile --}}
            <div class="p-4 border-t border-gray-100">
                <div class="relative overflow-hidden bg-gradient-to-br from-islamic-emerald to-teal-600 rounded-2xl p-4 text-white shadow-lg">
                    {{-- Decorative --}}
                    <div class="absolute top-0 right-0 -mr-4 -mt-4 w-16 h-16 bg-white/10 rounded-full blur-lg"></div>
                    
                    <div class="flex items-center gap-3 relative z-10">
                        <div class="w-10 h-10 rounded-full bg-white/20 border-2 border-white/30 flex items-center justify-center text-white font-bold flex-shrink-0">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" class="w-full h-full rounded-full object-cover">
                            @else
                                {{ substr(auth()->user()->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold truncate text-white">{{ auth()->user()->name }}</p>
                            <div class="flex items-center gap-2">
                                <p class="text-[10px] text-emerald-100 uppercase tracking-wide font-medium">Guru</p>
                                <a href="{{ route('profile.edit') }}" class="text-[10px] text-white/80 hover:text-white underline decoration-white/30 hover:decoration-white transition-colors">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="flex-1 overflow-y-auto p-4 md:p-6">
            <div class="max-w-7xl mx-auto">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}
            </div>
        </div>
    </div>

    {{-- Mobile Bottom Navigation --}}
    <div class="mobile-bottom-nav hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50">
        <div class="grid grid-cols-4 items-center h-14">
            <a href="{{ route('teacher.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('teacher.dashboard') ? 'text-green-600' : 'text-gray-600' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-[10px] mt-0.5">Beranda</span>
            </a>
            
            <a href="{{ route('teacher.lessons.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('teacher.lessons.*') ? 'text-green-600' : 'text-gray-600' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span class="text-[10px] mt-0.5">Materi</span>
            </a>
            
            <a href="{{ route('teacher.students.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('teacher.students.*') ? 'text-green-600' : 'text-gray-600' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span class="text-[10px] mt-0.5">Siswa</span>
            </a>
            
            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('profile.*') ? 'text-green-600' : 'text-gray-600' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="text-[10px] mt-0.5">Profil</span>
            </a>
        </div>
    </div>
</body>

</html>
