<x-teacher-layout>
    @php
        $classLessons = $lesson->tahsinClass->lessons->sortBy('order');
        $currentLessonIndex = $classLessons->search(function($l) use ($lesson) {
            return $l->id === $lesson->id;
        });
        $prevLesson = $currentLessonIndex > 0 ? $classLessons[$currentLessonIndex - 1] : null;
        $nextLesson = $currentLessonIndex < $classLessons->count() - 1 ? $classLessons[$currentLessonIndex + 1] : null;
    @endphp

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6">
                <a href="{{ route('teacher.lessons.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-3">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Daftar Materi
                </a>
                <h1 class="text-3xl font-bold text-gray-900">{{ $lesson->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">Materi Ke-{{ $lesson->order }} - {{ $lesson->tahsinClass->name }}</p>
            </div>

            {{-- Teacher Actions --}}
            <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-emerald-900 mb-3">📝 Aksi Guru</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('teacher.lessons.edit', $lesson) }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Materi
                    </a>
                    
                    @if($lesson->quiz)
                        <a href="{{ route('teacher.quiz.edit', $lesson->quiz) }}" class="inline-flex items-center gap-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Quiz
                        </a>
                    @else
                        <a href="{{ route('teacher.quiz.create', ['lesson_id' => $lesson->id]) }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Buat Quiz
                        </a>
                    @endif
                </div>
            </div>

            {{-- Content Area dengan semua LMS Features --}}
            <div class="space-y-6">
                {{-- Video Player Component --}}
                <x-lesson.video-player :lesson="$lesson" />

                {{-- PDF Viewer Component --}}
                <x-lesson.pdf-viewer :lesson="$lesson" />

                {{-- Zoom Link Component --}}
                <x-lesson.zoom-link :lesson="$lesson" />

                {{-- Text Content --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 md:p-8 space-y-6">
                        @if($lesson->description)
                            <div class="bg-blue-50/50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                                <p class="text-gray-700 leading-relaxed">{{ $lesson->description }}</p>
                            </div>
                        @endif

                        @if($lesson->content)
                            <div class="prose prose-lg prose-emerald max-w-none text-gray-600">
                                {!! nl2br(e($lesson->content)) !!}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Quiz Section with Stats --}}
                @if($lesson->quiz)
                    <div class="bg-gradient-to-r from-emerald-50 to-blue-50 rounded-2xl shadow-sm border border-emerald-100 overflow-hidden">
                        <div class="p-6 md:p-8">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">📝 {{ $lesson->quiz->title }}</h3>
                                    @if($lesson->quiz->description)
                                        <p class="text-gray-600 mb-4">{{ $lesson->quiz->description }}</p>
                                    @endif
                                </div>
                                <a href="{{ route('teacher.quiz.edit', $lesson->quiz) }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
                                    Edit Quiz
                                </a>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div class="bg-white/80 rounded-lg p-4">
                                    <p class="text-sm text-gray-500 mb-1">Total Pertanyaan</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $lesson->quiz->questions->count() }}</p>
                                </div>
                                <div class="bg-white/80 rounded-lg p-4">
                                    <p class="text-sm text-gray-500 mb-1">Passing Score</p>
                                    <p class="text-2xl font-bold text-emerald-600">{{ $lesson->quiz->passing_score }}%</p>
                                </div>
                                <div class="bg-white/80 rounded-lg p-4">
                                    <p class="text-sm text-gray-500 mb-1">Total Attempts</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ $lesson->quiz->attempts->count() }}</p>
                                </div>
                            </div>

                            <a href="{{ route('quiz.show', $lesson->quiz) }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl transition-colors shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Preview Quiz
                            </a>
                        </div>
                    </div>
                @else
                    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl shadow-sm border border-yellow-200 overflow-hidden">
                        <div class="p-8 md:p-12 text-center">
                            <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Quiz Belum Dibuat</h3>
                            <p class="text-sm text-gray-500 max-w-md mx-auto mb-4">
                                Buat quiz untuk menguji pemahaman siswa terhadap materi ini.
                            </p>
                            <a href="{{ route('teacher.quiz.create', ['lesson_id' => $lesson->id]) }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl transition-colors shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Buat Quiz Sekarang
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Comments Section --}}
                <x-lesson.comments :lesson="$lesson" />
            </div>

            {{-- Navigation --}}
            <div class="mt-8 border-t border-gray-200 pt-8 flex items-center justify-between">
                @if($prevLesson)
                    <a href="{{ route('teacher.lessons.show', $prevLesson) }}" class="flex items-center text-gray-500 hover:text-gray-900">
                        <div class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide font-semibold">Sebelumnya</p>
                            <p class="font-medium">{{ $prevLesson->title }}</p>
                        </div>
                    </a>
                @else
                    <div></div>
                @endif

                @if($nextLesson)
                    <a href="{{ route('teacher.lessons.show', $nextLesson) }}" class="flex items-center text-gray-500 hover:text-gray-900 text-right">
                        <div>
                            <p class="text-xs uppercase tracking-wide font-semibold">Selanjutnya</p>
                            <p class="font-medium">{{ $nextLesson->title }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center ml-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-teacher-layout>
