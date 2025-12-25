<nav x-data="{ open: false }" class="glass border-b border-white/10 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Tahsinku Logo" class="h-9 w-auto">
                        <span class="text-2xl font-bold text-islamic-gold font-serif leading-none mt-1">Tahsin<span class="text-islamic-emerald">ku</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-300 hover:text-islamic-gold transition-colors duration-300">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @if(auth()->user()->role === 'student')
                        <x-nav-link :href="route('student.my-class')" :active="request()->routeIs('student.my-class')" class="text-gray-300 hover:text-islamic-gold transition-colors duration-300">
                            {{ __('Kelas Saya') }}
                        </x-nav-link>
                        <x-nav-link :href="route('student.classes.index')" :active="request()->routeIs('student.classes.*')" class="text-gray-300 hover:text-islamic-gold transition-colors duration-300">
                            {{ __('Kelas Tahsin') }}
                        </x-nav-link>
                        <x-nav-link :href="route('student.subscription.index')" :active="request()->routeIs('student.subscription.*')" class="text-gray-300 hover:text-islamic-gold transition-colors duration-300">
                            {{ __('Langganan') }}
                        </x-nav-link>
                    @endif
                    @if(auth()->user()->role === 'admin')
                        <x-nav-link :href="route('admin.tahsin-classes.index')" :active="request()->routeIs('admin.tahsin-classes.*')" class="text-gray-300 hover:text-islamic-gold transition-colors duration-300">
                            {{ __('Kelola Kelas') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.lessons.index')" :active="request()->routeIs('admin.lessons.*')" class="text-gray-300 hover:text-islamic-gold transition-colors duration-300">
                            {{ __('Kelola Lessons') }}
                        </x-nav-link>
                        <x-nav-link :href="route('payments.index')" :active="request()->routeIs('payments.*')" class="text-gray-300 hover:text-islamic-gold transition-colors duration-300">
                            <span class="flex items-center gap-2">
                                {{ __('Pembayaran') }}
                                @php
                                    $pendingPayments = \App\Models\Payment::where('status', 'pending')->count();
                                @endphp
                                @if($pendingPayments > 0)
                                    <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full animate-pulse">
                                        {{ $pendingPayments }}
                                    </span>
                                @endif
                            </span>
                        </x-nav-link>
                        <x-nav-link :href="route('admin.subscriptions.index')" :active="request()->routeIs('admin.subscriptions.*')" class="text-gray-300 hover:text-islamic-gold transition-colors duration-300">
                            {{ __('Langganan') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48" contentClasses="py-0 bg-white dark:bg-gray-800 overflow-hidden rounded-md shadow-xl border border-white/10">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-islamic-gold bg-islamic-navy-light/50 hover:bg-islamic-navy-light focus:outline-none transition ease-in-out duration-150 shadow-inner gap-2">
                            @if (Auth::user()->profile_photo_path)
                                <img class="h-8 w-8 rounded-full object-cover border border-white/20" src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" />
                            @endif
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- Profile Header --}}
                        <div class="bg-gradient-to-br from-islamic-emerald to-teal-600 px-4 py-5 text-center relative overflow-hidden">
                            {{-- Edit Profile Link --}}
                            <div class="absolute top-3 left-4">
                                <a href="{{ route('profile.edit') }}" class="text-[10px] font-medium text-white/80 hover:text-white flex items-center gap-1 transition-colors">
                                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                    Edit profile
                                </a>
                            </div>

                            {{-- Decorative Circles --}}
                            <div class="absolute top-0 right-0 -mr-6 -mt-6 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
                            <div class="absolute bottom-0 left-0 -ml-6 -mb-6 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>

                            {{-- Avatar --}}
                            <div class="relative mx-auto mt-2 mb-3 w-16 h-16">
                                @if (Auth::user()->profile_photo_path)
                                    <img class="w-full h-full rounded-full object-cover border-2 border-white/50 shadow-md" src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" />
                                @else
                                    <div class="w-full h-full rounded-full bg-white/20 border-2 border-white/50 flex items-center justify-center text-white text-xl font-bold shadow-md">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            {{-- User Details --}}
                            <h3 class="text-white font-bold text-sm truncate px-2">{{ Auth::user()->name }}</h3>
                            
                            {{-- Role Badge --}}
                            <div class="mt-2 flex justify-center">
                                <span class="px-3 py-0.5 rounded-full bg-white/20 border border-white/30 text-white text-[10px] font-bold uppercase tracking-wider backdrop-blur-sm">
                                    {{ Auth::user()->role === 'admin' ? 'Administrator' : ucfirst(Auth::user()->role) }}
                                </span>
                            </div>
                        </div>

                        <div class="py-1">
                            <x-dropdown-link :href="route('dashboard')" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-islamic-emerald group flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-islamic-emerald transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                {{ __('Dashboard') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-islamic-emerald group flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-islamic-emerald transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                {{ __('Settings') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')" class="text-gray-600 dark:text-gray-300 hover:bg-red-50 hover:text-red-600 group flex items-center gap-2"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden glass border-t border-white/10">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-300 hover:text-islamic-gold">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if(auth()->user()->role === 'student')
                <x-responsive-nav-link :href="route('student.my-class')" :active="request()->routeIs('student.my-class')" class="text-gray-300 hover:text-islamic-gold">
                    {{ __('Kelas Saya') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('student.classes.index')" :active="request()->routeIs('student.classes.*')" class="text-gray-300 hover:text-islamic-gold">
                    {{ __('Kelas Tahsin') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('student.subscription.index')" :active="request()->routeIs('student.subscription.*')" class="text-gray-300 hover:text-islamic-gold">
                    {{ __('Langganan') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/10">
            <div class="px-4 flex items-center gap-3">
                @if (Auth::user()->profile_photo_path)
                    <div class="shrink-0">
                        <img class="h-10 w-10 rounded-full object-cover border border-white/20" src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif
                <div>
                    <div class="font-medium text-base text-islamic-gold">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->phone }}</div>
            </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-300 hover:text-islamic-gold">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" class="text-gray-300 hover:text-islamic-gold"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
