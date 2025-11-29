<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-white leading-tight">
                    {{ $lesson->title }}
                </h2>
                <p class="text-sm text-islamic-gold mt-1">{{ $lesson->tahsinClass->name }} - Lesson {{ $lesson->order }}</p>
            </div>
            <a href="{{ route('student.classes.show', $lesson->tahsinClass) }}" class="text-sm text-gray-400 hover:text-white flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Kelas
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-islamic-emerald/20 border border-islamic-emerald text-islamic-emerald px-4 py-3 rounded-xl mb-6 backdrop-blur-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Lesson Content -->
            <div class="glass-card mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-3xl font-bold text-white">{{ $lesson->title }}</h1>
                    @if($progress && $progress->is_completed)
                        <span class="bg-islamic-emerald/20 text-islamic-emerald border border-islamic-emerald/30 text-xs font-bold px-3 py-1 rounded-full flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Selesai
                        </span>
                    @endif
                </div>
                
                @if($lesson->description)
                    <p class="text-gray-300 mb-8 text-lg leading-relaxed border-l-4 border-islamic-gold pl-4 bg-white/5 py-2 rounded-r">{{ $lesson->description }}</p>
                @endif

                @if($lesson->video_url)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-islamic-gold mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Video Pembelajaran
                        </h3>
                        <div class="aspect-w-16 aspect-h-9 bg-black/50 rounded-xl overflow-hidden border border-white/10 shadow-2xl">
                            <iframe src="{{ $lesson->video_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-96"></iframe>
                        </div>
                    </div>
                @endif

                @if($lesson->content)
                    <div class="prose prose-invert max-w-none">
                        <h3 class="text-lg font-semibold text-islamic-gold mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Materi Bacaan
                        </h3>
                        <div class="text-gray-300 leading-relaxed whitespace-pre-wrap bg-islamic-navy-light/50 p-6 rounded-xl border border-white/5">{{ $lesson->content }}</div>
                    </div>
                @endif
            </div>

            <!-- Mark as Complete -->
            @if(!$progress || !$progress->is_completed)
                <div class="glass-card border-t-4 border-t-islamic-gold">
                    <h3 class="text-lg font-semibold text-white mb-4">Selesaikan Materi Ini</h3>
                    <form action="{{ route('student.lessons.complete', $lesson) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-400 mb-2">Catatan Pembelajaran (Opsional)</label>
                            <textarea id="notes" name="notes" rows="3" class="w-full bg-islamic-navy-light border border-white/10 rounded-xl text-white placeholder-gray-500 focus:ring-islamic-gold focus:border-islamic-gold transition" placeholder="Tulis poin penting yang Anda pelajari..."></textarea>
                        </div>
                        <button type="submit" class="glass-btn w-full md:w-auto flex items-center justify-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Tandai Selesai
                        </button>
                    </form>
                </div>
            @else
                <div class="glass-card bg-islamic-emerald/10 border border-islamic-emerald/30">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-islamic-emerald/20 flex items-center justify-center text-islamic-emerald">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-bold text-white">Alhamdulillah!</h3>
                            <p class="text-sm text-gray-300 mt-1">
                                Anda telah menyelesaikan materi ini pada <span class="text-islamic-gold">{{ $progress->completed_at->format('d M Y, H:i') }}</span>
                            </p>
                            @if($progress->notes)
                                <div class="mt-3 p-3 bg-black/20 rounded-lg border border-white/5">
                                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Catatan Anda:</p>
                                    <p class="text-sm text-gray-200 italic">"{{ $progress->notes }}"</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
