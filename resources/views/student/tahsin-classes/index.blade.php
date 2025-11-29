<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Kursus Lainnya
        </h2>
        <p class="text-gray-400 text-sm mt-1">Lanjutkan pembelajaran tahsin Al-Quran Anda</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="bg-red-500/20 border border-red-500 text-red-100 px-4 py-3 rounded-xl mb-6 backdrop-blur-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Course Overview Header -->
            <div class="glass-card mb-8">
                <h3 class="text-xl font-semibold text-white mb-4">Ikhtisar Kelas</h3>
                
                <!-- Filters -->
                <div class="flex flex-wrap gap-4 mb-6">
                    <select class="glass-btn text-sm">
                        <option>Semua</option>
                        <option>Anak</option>
                        <option>Dewasa</option>
                    </select>
                    
                    <input type="text" placeholder="Cari kelas..." class="flex-1 min-w-[200px] bg-islamic-navy-light border border-white/10 rounded-xl px-4 py-2 text-white placeholder-gray-500 focus:ring-islamic-gold focus:border-islamic-gold">
                    
                    <select class="glass-btn text-sm">
                        <option>Urutkan berdasarkan nama</option>
                        <option>Progress tertinggi</option>
                        <option>Progress terendah</option>
                    </select>
                </div>
            </div>

            <!-- Course Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $colors = ['#3B82F6', '#10B981', '#F59E0B', '#8B5CF6']; // Blue, Green, Orange, Purple
                    $user = auth()->user();
                @endphp
                
                @forelse($classes as $index => $class)
                    @php
                        $color = $colors[$index % 4];
                        $totalLessons = $class->lessons_count;
                        $completedLessons = \App\Models\UserProgress::whereIn('lesson_id', 
                            $class->lessons()->pluck('id'))
                            ->where('user_id', $user->id)
                            ->where('is_completed', true)
                            ->count();
                        $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
                    @endphp
                    
                    <div class="glass-card group hover:scale-[1.02] transition-all duration-300 cursor-pointer" onclick="window.location='{{ route('student.classes.show', $class) }}'">
                        <!-- Course Badge -->
                        <div class="mb-4">
                            <span class="inline-block bg-islamic-emerald text-white text-xs font-bold px-3 py-1 rounded-full">
                                Tahsin
                            </span>
                        </div>

                        <!-- Course Thumbnail -->
                        <div class="relative mb-4 h-40 rounded-xl overflow-hidden" style="background: linear-gradient(135deg, {{ $color }}dd 0%, {{ $color }}66 100%);">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="w-20 h-20 text-white opacity-20" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/>
                                </svg>
                            </div>
                            <!-- Islamic Pattern Overlay -->
                            <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/arabesque.png');"></div>
                        </div>

                        <!-- Course Title -->
                        <h3 class="text-lg font-bold text-white mb-3 group-hover:text-islamic-gold transition-colors">
                            {{ $class->name }}
                        </h3>

                        <!-- Progress Section -->
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-400">{{ $progress }}% selesai</span>
                                <button class="text-islamic-gold hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="w-full bg-islamic-navy-light rounded-full h-2 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500" 
                                     style="width: {{ $progress }}%; background: {{ $color }};">
                                </div>
                            </div>
                        </div>

                        <!-- Lessons Count -->
                        <div class="flex items-center text-gray-400 text-sm">
                            <svg class="w-4 h-4 mr-2 text-islamic-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            {{ $completedLessons }}/{{ $totalLessons }} Materi
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 glass rounded-2xl">
                        <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <p class="text-gray-400 text-lg">Belum ada kelas tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Show entries dropdown -->
            <div class="mt-8 flex justify-between items-center">
                <div class="flex items-center gap-2 text-gray-400 text-sm">
                    <span>Tampilkan</span>
                    <select class="bg-islamic-navy-light border border-white/10 rounded-lg px-3 py-1 text-white text-sm focus:ring-islamic-gold focus:border-islamic-gold">
                        <option>4</option>
                        <option>8</option>
                        <option>12</option>
                    </select>
                    <span>kelas</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
