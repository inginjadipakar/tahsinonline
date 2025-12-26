@props(['lesson'])

@if($lesson->hasVideo() && $lesson->getEmbedUrl())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="aspect-w-16 aspect-h-9 bg-black">
            <iframe 
                src="{{ $lesson->getEmbedUrl() }}" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen 
                class="w-full h-full">
            </iframe>
        </div>
    </div>
@else
    {{-- Empty State --}}
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-8 md:p-12 text-center">
            <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Video Belum Tersedia</h3>
            <p class="text-sm text-gray-500 max-w-md mx-auto">
                Video pembelajaran untuk materi ini sedang dalam proses persiapan. 
                Silakan pelajari materi teks terlebih dahulu.
            </p>
        </div>
    </div>
@endif
