<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                🎯 {{ __('Admin Dashboard') }}
            </h2>
            <p class="text-sm text-gray-600 mt-1">Selamat datang di panel administrasi Tahsin Online</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Welcome Banner --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 rounded-2xl shadow-lg p-8 mb-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
                        <p class="text-teal-100 text-lg">Kelola sistem pembelajaran Tahsin Online dengan mudah</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="bg-white/20 rounded-2xl p-6">
                            <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions Grid - Hixme Style --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                {{-- Payments Card --}}
                <a href="{{ route('payments.index') }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-lg p-6 transition-all duration-300 border border-gray-100 hover:border-teal-200">
                    <div class="flex items-start gap-4">
                        <div class="bg-teal-50 rounded-xl p-4 group-hover:bg-teal-100 transition-colors">
                            <svg class="w-8 h-8 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Payments</h3>
                            <p class="text-gray-500 text-sm">Kelola bukti pembayaran dari siswa</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-teal-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                {{-- Subscriptions Card --}}
                <a href="{{ route('admin.subscriptions.index') }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-lg p-6 transition-all duration-300 border border-gray-100 hover:border-teal-200">
                    <div class="flex items-start gap-4">
                        <div class="bg-blue-50 rounded-xl p-4 group-hover:bg-blue-100 transition-colors">
                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Subscriptions</h3>
                            <p class="text-gray-500 text-sm">Kelola langganan siswa secara manual</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-teal-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                {{-- Kelas Tahsin Card --}}
                <a href="{{ route('admin.tahsin-classes.index') }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-lg p-6 transition-all duration-300 border border-gray-100 hover:border-teal-200">
                    <div class="flex items-start gap-4">
                        <div class="bg-green-50 rounded-xl p-4 group-hover:bg-green-100 transition-colors">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Kelas Tahsin</h3>
                            <p class="text-gray-500 text-sm">Kelola kelas pembelajaran tahsin</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-teal-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                {{-- Lessons Card --}}
                <a href="{{ route('admin.lessons.index') }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-lg p-6 transition-all duration-300 border border-gray-100 hover:border-teal-200">
                    <div class="flex items-start gap-4">
                        <div class="bg-purple-50 rounded-xl p-4 group-hover:bg-purple-100 transition-colors">
                            <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Lessons</h3>
                            <p class="text-gray-500 text-sm">Kelola materi pembelajaran per kelas</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-teal-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                {{-- Jadwal Kelas Card --}}
                <a href="{{ route('admin.schedules.index') }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-lg p-6 transition-all duration-300 border border-gray-100 hover:border-teal-200">
                    <div class="flex items-start gap-4">
                        <div class="bg-orange-50 rounded-xl p-4 group-hover:bg-orange-100 transition-colors">
                            <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Jadwal Kelas</h3>
                            <p class="text-gray-500 text-sm">Atur jadwal pertemuan kelas</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-teal-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                {{-- Kelola Users Card --}}
                <a href="#" class="group bg-white rounded-2xl shadow-sm hover:shadow-lg p-6 transition-all duration-300 border border-gray-100 hover:border-teal-200">
                    <div class="flex items-start gap-4">
                        <div class="bg-pink-50 rounded-xl p-4 group-hover:bg-pink-100 transition-colors">
                            <svg class="w-8 h-8 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Kelola Users</h3>
                            <p class="text-gray-500 text-sm">Manajemen akun siswa dan guru</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-teal-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            </div>

            {{-- Statistics Section --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Statistik Ringkas</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="bg-teal-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::where('role', 'student')->count() }}</p>
                        <p class="text-sm text-gray-500">Total Siswa</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\TahsinClass::count() }}</p>
                        <p class="text-sm text-gray-500">Kelas Tersedia</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="bg-purple-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Lesson::count() }}</p>
                        <p class="text-sm text-gray-500">Total Materi</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\ClassSchedule::where('is_active', true)->count() }}</p>
                        <p class="text-sm text-gray-500">Jadwal Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
