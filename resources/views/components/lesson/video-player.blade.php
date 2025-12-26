@props(['lesson'])

@if($lesson->hasVideo())
    <div class="lesson-video-container mb-6">
        <div class="relative w-full bg-slate-900 rounded-lg overflow-hidden shadow-lg" style="padding-bottom: 56.25%;">
            <iframe 
                class="absolute top-0 left-0 w-full h-full"
                src="{{ $lesson->getEmbedUrl() }}"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen
                loading="lazy">
            </iframe>
        </div>
        <div class="mt-2 flex items-center justify-between text-sm text-slate-600">
            <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                </svg>
                {{ ucfirst($lesson->video_platform) }} Video
            </span>
        </div>
    </div>
@endif
