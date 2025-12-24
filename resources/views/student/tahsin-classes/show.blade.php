<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        {{-- Course Header / Banner --}}
        <div class="bg-gradient-to-r from-islamic-navy to-islamic-emerald text-white pt-12 pb-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row gap-6 items-start">
                    <div class="flex-1">
                        {{-- Breadcrumb --}}
                        <div class="flex items-center gap-2 text-sm text-emerald-100 mb-4">
                            <a href="{{ route('dashboard') }}" class="hover:text-white">Dashboard</a>
                            <span>/</span>
                            <a href="{{ route('student.classes.index') }}" class="hover:text-white">Kelas Saya</a>
                            <span>/</span>
                            <span class="text-white font-semibold">{{ $tahsinClass->name }}</span>
                        </div>

                        <h1 class="text-3xl md:text-4xl font-bold mb-4 leading-tight">{{ $tahsinClass->name }}</h1>
                        <p class="text-emerald-100 text-lg max-w-3xl leading-relaxed">{{ $tahsinClass->description }}</p>
                        
                        <div class="flex items-center gap-6 mt-8">
                            <div class="flex items-center gap-2">
                                <div class="p-2 bg-white/10 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-emerald-200">Total Materi</p>
                                    <p class="font-bold">{{ $tahsinClass->lessons->count() }} Pelajaran</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="p-2 bg-white/10 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-emerald-200">Level</p>
                                    <p class="font-bold">{{ $tahsinClass->level ?? 'Semua Level' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Progress Card (Floating) --}}
                    @php
                        $totalLessons = $tahsinClass->lessons->count();
                        $completedLessons = $userProgress->where('is_completed', true)->count();
                        $progressPercent = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
                    @endphp
                    <div class="w-full md:w-80 bg-white rounded-2xl p-6 shadow-xl text-gray-900 mt-6 md:mt-0">
                        <h3 class="font-bold text-lg mb-2">Progress Belajar</h3>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                            <div class="bg-emerald-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
                        </div>
                        <div class="flex justify-between text-sm mb-6">
                            <span class="text-gray-500">{{ $progressPercent }}% Selesai</span>
                            <span class="font-bold text-gray-900">{{ $completedLessons }}/{{ $totalLessons }} Materi</span>
                        </div>
                        @if($progressPercent === 100)
                            <button class="w-full py-2 bg-emerald-100 text-emerald-700 font-bold rounded-lg text-sm">
                                🎉 Kelas Selesai!
                            </button>
                        @elseif($totalLessons > 0)
                            <a href="#lesson-list" class="block w-full text-center py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-sm transition-colors">
                                Lanjutkan Belajar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12" id="lesson-list">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                {{-- Module Header --}}
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Materi Pembelajaran</h2>
                        <p class="text-sm text-gray-500">Silakan pelajari materi secara berurutan</p>
                    </div>
                </div>

                {{-- Lesson List --}}
                <div class="divide-y divide-gray-100">
                    @forelse($tahsinClass->lessons->sortBy('order') as $lesson)
                        @php
                            $progress = $userProgress->get($lesson->id);
                            $isCompleted = $progress && $progress->is_completed;
                        @endphp
                        
                        <div class="group hover:bg-gray-50 transition-colors p-4 sm:p-6 flex gap-4 items-start {{ $isCompleted ? 'bg-emerald-50/30' : '' }}">
                            {{-- Icon Type --}}
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $isCompleted ? 'bg-emerald-100 text-emerald-600' : 'bg-blue-100 text-blue-600' }}">
                                    @if($lesson->video_url)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div>
                                        <a href="{{ route('student.lessons.show', $lesson) }}" class="text-base font-bold text-gray-900 hover:text-emerald-600 hover:underline decoration-2 underline-offset-2 block mb-1">
                                            {{ $lesson->title }}
                                        </a>
                                        <p class="text-sm text-gray-500 line-clamp-1">{{ Str::limit($lesson->description, 100) }}</p>
                                        
                                        {{-- Meta Tags --}}
                                        <div class="flex items-center gap-3 mt-2">
                                            <span class="text-xs font-medium text-gray-400 bg-gray-100 px-2 py-0.5 rounded text-uppercase tracking-wide">
                                                {{ $lesson->video_url ? 'VIDEO' : 'TEKS' }}
                                            </span>
                                            @if($lesson->video_url)
                                            {{-- Duration placeholder if we had it --}}
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Action & Status --}}
                                    <div class="flex-shrink-0 flex items-center gap-4">
                                        @if($isCompleted)
                                            <div class="flex items-center gap-2 text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-100">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                                <span class="text-xs font-bold">Selesai</span>
                                            </div>
                                        @else
                                            <a href="{{ route('student.lessons.show', $lesson) }}" class="hidden sm:inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm transition-all whitespace-nowrap">
                                                Mulai Belajar
                                            </a>
                                        @endif
                                        
                                        {{-- Mobile Arrow --}}
                                        <a href="{{ route('student.lessons.show', $lesson) }}" class="sm:hidden text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 px-4">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Belum ada materi</h3>
                            <p class="text-gray-500 mt-1">Materi pembelajaran akan segera ditambahkan oleh pengajar.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
