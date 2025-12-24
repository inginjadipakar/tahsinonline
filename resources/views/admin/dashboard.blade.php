<x-app-layout>
    @php
        // Get pending payment count for notification badge
        $pendingPaymentsCount = \App\Models\Payment::where('status', 'pending')->count();
    @endphp
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-900 leading-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ __('Admin Dashboard') }}
            </h2>
            <p class="text-sm text-gray-600 mt-1">Selamat datang di panel administrasi Tahsin Online</p>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Welcome Banner --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 rounded-xl shadow-lg p-5 mb-5 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold mb-1">Welcome back, {{ auth()->user()->name }}!</h1>
                        <p class="text-teal-100 text-sm">Kelola sistem pembelajaran Tahsin Online dengan mudah</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="bg-white/20 rounded-xl p-3">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions Grid - Hixme Style --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-5">
                {{-- Payments Card with Notification Badge --}}
                <a href="{{ route('payments.index') }}" class="group bg-white rounded-xl shadow-sm hover:shadow-md p-4 transition-all duration-300 border border-gray-100 hover:border-teal-200 relative">
                    {{-- Notification Badge --}}
                    @if($pendingPaymentsCount > 0)
                    <div class="absolute -top-1.5 -right-1.5 flex items-center justify-center">
                        <span class="absolute inline-flex h-4 w-4 rounded-full bg-red-400 opacity-75 animate-ping"></span>
                        <span class="relative inline-flex items-center justify-center h-4 w-4 rounded-full bg-red-500 text-white text-[10px] font-bold shadow-sm">
                            {{ $pendingPaymentsCount > 9 ? '9+' : $pendingPaymentsCount }}
                        </span>
                    </div>
                    @endif
                    
                    <div class="flex items-start gap-3">
                        <div class="bg-teal-50 rounded-lg p-2.5 group-hover:bg-teal-100 transition-colors">
                            <svg class="w-6 h-6 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-gray-900 mb-0.5 flex items-center gap-2 truncate">
                                Payments
                                @if($pendingPaymentsCount > 0)
                                <span class="text-[10px] font-bold text-red-600 bg-red-50 px-1.5 py-0.5 rounded-full ring-1 ring-red-100">{{ $pendingPaymentsCount }}</span>
                                @endif
                            </h3>
                            <p class="text-gray-500 text-xs truncate">Kelola bukti bayar</p>
                        </div>
                    </div>
                </a>

                {{-- Subscriptions Card --}}
                <a href="{{ route('admin.subscriptions.index') }}" class="group bg-white rounded-xl shadow-sm hover:shadow-md p-4 transition-all duration-300 border border-gray-100 hover:border-teal-200">
                    <div class="flex items-start gap-3">
                        <div class="bg-blue-50 rounded-lg p-2.5 group-hover:bg-blue-100 transition-colors">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-gray-900 mb-0.5 truncate">Subscriptions</h3>
                            <p class="text-gray-500 text-xs truncate">Kelola langganan</p>
                        </div>
                    </div>
                </a>

                {{-- Kelas Tahsin Card --}}
                <a href="{{ route('admin.tahsin-classes.index') }}" class="group bg-white rounded-xl shadow-sm hover:shadow-md p-4 transition-all duration-300 border border-gray-100 hover:border-teal-200">
                    <div class="flex items-start gap-3">
                        <div class="bg-green-50 rounded-lg p-2.5 group-hover:bg-green-100 transition-colors">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-gray-900 mb-0.5 truncate">Kelas Tahsin</h3>
                            <p class="text-gray-500 text-xs truncate">Kelola kelas</p>
                        </div>
                    </div>
                </a>

                {{-- Lessons Card --}}
                <a href="{{ route('admin.lessons.index') }}" class="group bg-white rounded-xl shadow-sm hover:shadow-md p-4 transition-all duration-300 border border-gray-100 hover:border-teal-200">
                    <div class="flex items-start gap-3">
                        <div class="bg-purple-50 rounded-lg p-2.5 group-hover:bg-purple-100 transition-colors">
                            <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-gray-900 mb-0.5 truncate">Lessons</h3>
                            <p class="text-gray-500 text-xs truncate">Kelola materi</p>
                        </div>
                    </div>
                </a>

                {{-- Jadwal Kelas Card --}}
                <a href="{{ route('admin.schedules.index') }}" class="group bg-white rounded-xl shadow-sm hover:shadow-md p-4 transition-all duration-300 border border-gray-100 hover:border-teal-200">
                    <div class="flex items-start gap-3">
                        <div class="bg-orange-50 rounded-lg p-2.5 group-hover:bg-orange-100 transition-colors">
                            <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-gray-900 mb-0.5 truncate">Jadwal Kelas</h3>
                            <p class="text-gray-500 text-xs truncate">Atur jadwal</p>
                        </div>
                    </div>
                </a>

                {{-- Kelola Users Card --}}
                <a href="#" class="group bg-white rounded-xl shadow-sm hover:shadow-md p-4 transition-all duration-300 border border-gray-100 hover:border-teal-200">
                    <div class="flex items-start gap-3">
                        <div class="bg-pink-50 rounded-lg p-2.5 group-hover:bg-pink-100 transition-colors">
                            <svg class="w-6 h-6 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-gray-900 mb-0.5 truncate">Kelola Users</h3>
                            <p class="text-gray-500 text-xs truncate">Manajemen akun</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Statistics Section --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <h3 class="text-sm font-bold text-gray-900 mb-3">Statistik Ringkas</h3>
                <div class="grid grid-cols-4 gap-4">
                    <div class="text-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <div class="bg-teal-100 rounded-full w-8 h-8 flex items-center justify-center mx-auto mb-2">
                            <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                        </div>
                        <p class="text-lg font-bold text-gray-900 leading-none mb-1">{{ \App\Models\User::where('role', 'student')->count() }}</p>
                        <p class="text-[10px] uppercase tracking-wide text-gray-500 font-bold">Siswa</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <div class="bg-green-100 rounded-full w-8 h-8 flex items-center justify-center mx-auto mb-2">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                            </svg>
                        </div>
                        <p class="text-lg font-bold text-gray-900 leading-none mb-1">{{ \App\Models\TahsinClass::count() }}</p>
                        <p class="text-[10px] uppercase tracking-wide text-gray-500 font-bold">Kelas</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <div class="bg-purple-100 rounded-full w-8 h-8 flex items-center justify-center mx-auto mb-2">
                            <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                            </svg>
                        </div>
                        <p class="text-lg font-bold text-gray-900 leading-none mb-1">{{ \App\Models\Lesson::count() }}</p>
                        <p class="text-[10px] uppercase tracking-wide text-gray-500 font-bold">Materi</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <div class="bg-blue-100 rounded-full w-8 h-8 flex items-center justify-center mx-auto mb-2">
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <p class="text-lg font-bold text-gray-900 leading-none mb-1">{{ \App\Models\ClassSchedule::where('is_active', true)->count() }}</p>
                        <p class="text-[10px] uppercase tracking-wide text-gray-500 font-bold">Jadwal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
