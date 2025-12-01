<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Header Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-islamic-emerald/10 text-islamic-emerald dark:bg-islamic-emerald/20 dark:text-islamic-emerald-light">
                                    Kelas Aktif
                                </span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    Berakhir: {{ $subscription->end_date->format('d M Y') }}
                                </span>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ $enrolledClass->name }}
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ $enrolledClass->description }}
                            </p>
                        </div>
                        
                        <!-- Progress Card -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5 min-w-[280px] border border-gray-100 dark:border-gray-600">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Progress Belajar</span>
                                <span class="text-2xl font-bold text-islamic-emerald">{{ $progress }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5 mb-2">
                                <div class="bg-islamic-emerald h-2.5 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 flex justify-between">
                                <span>{{ $completedCount }} Selesai</span>
                                <span>{{ $totalLessons }} Total Materi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content: Lessons List -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="text-2xl">📚</span> Daftar Materi
                        </h2>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        @forelse($lessons as $item)
                            <div class="group border-b last:border-0 border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="p-5 flex items-center gap-4">
                                    <!-- Status Icon -->
                                    <div class="flex-shrink-0">
                                        @if($item['status'] === 'completed')
                                            <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            </div>
                                        @elseif($item['status'] === 'current')
                                            <div class="w-10 h-10 rounded-full bg-islamic-gold/20 flex items-center justify-center text-islamic-gold animate-pulse">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </div>
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Pertemuan {{ $loop->iteration }}
                                            </span>
                                            @if($item['status'] === 'current')
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-islamic-gold text-white">SEKARANG</span>
                                            @endif
                                        </div>
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-white truncate group-hover:text-islamic-emerald transition-colors">
                                            {{ $item['lesson']->title }}
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                            {{ $item['lesson']->description }}
                                        </p>
                                    </div>

                                    <!-- Action -->
                                    <div>
                                        @if($item['status'] !== 'locked')
                                            <a href="{{ route('student.lessons.show', $item['lesson']) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </a>
                                        @else
                                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-transparent text-gray-300 dark:text-gray-600 cursor-not-allowed">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                                    📭
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum Ada Materi</h3>
                                <p class="text-gray-500 dark:text-gray-400">Materi pembelajaran akan segera ditambahkan oleh admin.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Sidebar: Schedule & Info -->
                <div class="space-y-6">
                    <!-- Schedule Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <span>📅</span> Jadwal Kelas
                        </h3>
                        
                        @if($activeSchedules->count() > 0)
                            <div class="space-y-4">
                                @foreach($activeSchedules as $schedule)
                                    <div class="flex items-start gap-3 p-3 rounded-lg bg-gray-50 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700">
                                        <div class="w-10 h-10 rounded-lg bg-white dark:bg-gray-800 flex flex-col items-center justify-center shadow-sm border border-gray-100 dark:border-gray-600">
                                            <span class="text-[10px] font-bold text-gray-400 uppercase">{{ substr($schedule->day_of_week, 0, 3) }}</span>
                                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($schedule->start_time)->format('d') }}</span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ ucfirst($schedule->day_of_week) }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-6">
                                <a href="#" class="block w-full py-3 px-4 bg-islamic-navy hover:bg-islamic-navy-light text-white text-center font-medium rounded-xl transition-colors shadow-lg shadow-islamic-navy/20">
                                    Gabung Zoom Meeting
                                </a>
                                <p class="text-xs text-center text-gray-400 mt-2">Link akan aktif 15 menit sebelum kelas dimulai.</p>
                            </div>
                        @else
                            <div class="text-center py-6 text-gray-500 dark:text-gray-400">
                                <p>Jadwal belum ditentukan.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Teacher Info -->
                    <div class="bg-gradient-to-br from-islamic-emerald to-islamic-emerald-dark rounded-xl shadow-lg p-6 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                        
                        <h3 class="text-lg font-bold mb-4 relative z-10">Pengajar Anda</h3>
                        <div class="flex items-center gap-4 relative z-10">
                            <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center text-2xl border-2 border-white/30">
                                👳
                            </div>
                            <div>
                                <div class="font-bold text-lg">Ustadz Ahmad</div>
                                <div class="text-sm text-islamic-emerald-light">Bersanad Hafs 'an 'Ashim</div>
                            </div>
                        </div>
                        
                        <div class="mt-6 pt-6 border-t border-white/10 relative z-10">
                            <a href="#" class="flex items-center justify-between text-sm font-medium hover:text-islamic-gold-light transition-colors">
                                <span>Hubungi Pengajar</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
