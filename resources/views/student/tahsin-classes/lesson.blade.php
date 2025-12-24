<x-app-layout>
    @php
        $classLessons = $lesson->tahsinClass->lessons->sortBy('order');
        $currentLessonIndex = $classLessons->search(function($l) use ($lesson) {
            return $l->id === $lesson->id;
        });
        $prevLesson = $currentLessonIndex > 0 ? $classLessons[$currentLessonIndex - 1] : null;
        $nextLesson = $currentLessonIndex < $classLessons->count() - 1 ? $classLessons[$currentLessonIndex + 1] : null;
        
        // Progress Calc
        // Note: We need user progress for ALL lessons to show in sidebar.
        // The current controller only passes single lesson progress.
        // We can lazy load it or just trust the view composer if available? 
        // For now, simpler: we won't show checkmarks in sidebar unless we fetch them.
        // Optimal: Load all progress in controller. But for now, let's just highlight current one.
    @endphp

    <div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
        {{-- Mobile Header Bar --}}
        <div class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-30 h-16 flex items-center justify-between px-4 md:hidden">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <span class="font-bold text-gray-900 truncate max-w-[200px]">{{ $lesson->tahsinClass->name }}</span>
            <a href="{{ route('student.classes.show', $lesson->tahsinClass) }}" class="text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </a>
        </div>

        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-40 w-80 bg-white border-r border-gray-200 transform transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:block pt-16 md:pt-0"
               :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
            
            <div class="h-full flex flex-col">
                {{-- Sidebar Header --}}
                <div class="p-6 border-b border-gray-100 hidden md:block">
                    <a href="{{ route('student.classes.show', $lesson->tahsinClass) }}" class="flex items-center text-sm text-gray-500 hover:text-emerald-600 mb-4 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Course
                    </a>
                    <h2 class="font-bold text-xl text-gray-900 leading-tight">{{ $lesson->tahsinClass->name }}</h2>
                    <p class="text-xs text-gray-400 mt-1">{{ $classLessons->count() }} Materi Pembelajaran</p>
                </div>

                {{-- Lesson List --}}
                <div class="flex-1 overflow-y-auto p-4 space-y-2">
                    @foreach($classLessons as $l)
                        <a href="{{ route('student.lessons.show', $l) }}" 
                           class="flex items-start gap-3 p-3 rounded-lg transition-colors {{ $l->id === $lesson->id ? 'bg-emerald-50 border border-emerald-100' : 'hover:bg-gray-50' }}">
                            <div class="flex-shrink-0 mt-0.5">
                                @php
                                    // Check if this lesson is completed by the user (loaded via controller)
                                    $isLessonCompleted = $l->userProgress->where('is_completed', true)->isNotEmpty();
                                @endphp

                                @if($l->id === $lesson->id)
                                    <div class="w-6 h-6 rounded-full bg-emerald-600 flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
                                    </div>
                                @elseif($isLessonCompleted)
                                    <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center border border-emerald-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                @else
                                    <div class="w-6 h-6 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-xs font-semibold">
                                        {{ $l->order }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium {{ $l->id === $lesson->id ? 'text-emerald-900' : 'text-gray-600' }}">
                                    {{ $l->title }}
                                </p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] uppercase font-bold text-gray-400">
                                        {{ $l->video_url ? 'Video' : 'Teks' }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

        {{-- Backdrop for Mobile --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 md:hidden glass-blur"></div>

        {{-- Main Content --}}
        <main class="flex-1 min-w-0 md:pl-0 pt-16 md:pt-0">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
                {{-- Alert Success --}}
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-6 flex items-center shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Header --}}
                <div class="mb-8">
                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                        <span>Materi Ke-{{ $lesson->order }}</span>
                        @if($progress && $progress->is_completed)
                            <span class="bg-emerald-100 text-emerald-700 text-xs px-2 py-0.5 rounded-full font-bold flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Selesai
                            </span>
                        @endif
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">{{ $lesson->title }}</h1>
                </div>

                {{-- Content Area --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    {{-- Video --}}
                    @if($lesson->video_url)
                        <div class="aspect-w-16 aspect-h-9 bg-black">
                            <iframe src="{{ $lesson->video_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full"></iframe>
                        </div>
                    @endif

                    {{-- Text Content --}}
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

                {{-- Navigation & Action --}}
                <div class="mt-8 border-t border-gray-200 pt-8 flex flex-col md:flex-row items-center justify-between gap-6">
                    {{-- Previous Button --}}
                    @if($prevLesson)
                        <a href="{{ route('student.lessons.show', $prevLesson) }}" class="flex items-center text-gray-500 hover:text-gray-900 transition-colors w-full md:w-auto">
                            <div class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center mr-3 shadow-sm group-hover:border-emerald-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-xs uppercase tracking-wide font-semibold text-gray-400">Sebelumnya</p>
                                <p class="font-medium truncate max-w-[150px]">{{ $prevLesson->title }}</p>
                            </div>
                        </a>
                    @else
                        <div class="hidden md:block w-1/3"></div>
                    @endif

                    {{-- Complete Button --}}
                    @if(!$progress || !$progress->is_completed)
                        <form action="{{ route('student.lessons.complete', $lesson) }}" method="POST" class="w-full md:w-auto">
                            @csrf
                            <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all transform hover:scale-105">
                                <span class="mr-2">Selesai & Lanjut</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </button>
                        </form>
                    @else
                        <div class="text-center md:text-left">
                            <p class="text-emerald-600 font-bold mb-1">Materi Telah Selesai</p>
                            <p class="text-xs text-gray-400">{{ $progress->completed_at->format('d M Y, H:i') }}</p>
                        </div>
                    @endif

                    {{-- Next Button --}}
                    @if($nextLesson)
                        <a href="{{ route('student.lessons.show', $nextLesson) }}" class="flex items-center justify-end text-gray-500 hover:text-gray-900 transition-colors w-full md:w-auto text-right">
                            <div class="text-right">
                                <p class="text-xs uppercase tracking-wide font-semibold text-gray-400">Selanjutnya</p>
                                <p class="font-medium truncate max-w-[150px]">{{ $nextLesson->title }}</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center ml-3 shadow-sm group-hover:border-emerald-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </a>
                    @else
                        <div class="hidden md:block w-1/3"></div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
