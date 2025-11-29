<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">
                    {{ $tahsinClass->name }}
                </h2>
                <p class="text-gray-400 text-sm mt-1">{{ $tahsinClass->description }}</p>
            </div>
            <a href="{{ route('student.classes.index') }}" class="text-sm text-gray-400 hover:text-white flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Kelas
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Progress Overview -->
            @php
                $totalLessons = $tahsinClass->lessons->count();
                $completedLessons = $userProgress->where('is_completed', true)->count();
                $progressPercent = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
            @endphp

            <div class="glass-card mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-white">Progress Pembelajaran</h3>
                    <span class="text-islamic-gold font-bold">{{ $completedLessons }}/{{ $totalLessons }} Materi</span>
                </div>
                
                <div class="w-full bg-islamic-navy-light rounded-full h-3 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-islamic-emerald to-islamic-gold rounded-full transition-all duration-500" 
                         style="width: {{ $progressPercent }}%;">
                    </div>
                </div>
                <p class="text-gray-400 text-sm mt-2">{{ $progressPercent }}% selesai</p>
            </div>

            <!-- Lessons List -->
            <div class="space-y-4">
                @forelse($tahsinClass->lessons->sortBy('order') as $lesson)
                    @php
                        $progress = $userProgress->get($lesson->id);
                        $isCompleted = $progress && $progress->is_completed;
                    @endphp
                    
                    <div class="glass-card hover:scale-[1.01] transition-all duration-300 {{ $isCompleted ? 'border-l-4 border-l-islamic-emerald' : 'border-l-4 border-l-transparent' }}">
                        <div class="flex items-start gap-4">
                            <!-- Lesson Number Circle -->
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full {{ $isCompleted ? 'bg-islamic-emerald' : 'bg-islamic-navy-light' }} flex items-center justify-center border-2 {{ $isCompleted ? 'border-islamic-emerald' : 'border-white/10' }}">
                                    @if($isCompleted)
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @else
                                        <span class="text-lg font-bold text-white">{{ $lesson->order }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Lesson Content -->
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-xs text-gray-500 uppercase">Materi {{ $lesson->order }}</span>
                                            @if($isCompleted)
                                                <span class="inline-flex items-center gap-1 bg-islamic-emerald/20 text-islamic-emerald text-xs font-semibold px-2 py-0.5 rounded-full">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Selesai
                                                </span>
                                            @endif
                                        </div>
                                        <h4 class="text-lg font-bold text-white mb-1">{{ $lesson->title }}</h4>
                                        <p class="text-gray-400 text-sm">{{ Str::limit($lesson->description, 120) }}</p>
                                    </div>
                                </div>

                                <!-- Lesson Meta Info -->
                                <div class="flex items-center gap-4 mt-3 text-sm text-gray-400">
                                    @if($lesson->video_url)
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-islamic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>Video</span>
                                        </div>
                                    @endif
                                    @if($lesson->content)
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-islamic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span>Materi Teks</span>
                                        </div>
                                    @endif
                                    @if($isCompleted && $progress->completed_at)
                                        <div class="flex items-center gap-1 text-islamic-emerald">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ $progress->completed_at->diffForHumans() }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Button -->
                                <div class="mt-4">
                                    <a href="{{ route('student.lessons.show', $lesson) }}" class="inline-flex items-center gap-2 glass-btn text-sm group">
                                        @if($isCompleted)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Review Materi
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Mulai Belajar
                                        @endif
                                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="glass-card text-center py-12">
                        <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <p class="text-gray-400 text-lg">Belum ada materi untuk kelas ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
