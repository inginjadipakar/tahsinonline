@props(['data'])

@if($data['enabled'])
<div x-data="{ 
        activeSlide: 0,
        slides: {{ json_encode(array_map(function($slide) {
            $slide['image'] = Str::startsWith($slide['image'], ['http://', 'https://']) ? $slide['image'] : asset($slide['image']);
            return $slide;
        }, $data['slides'])) }},
        autoSlide() {
            setInterval(() => {
                this.activeSlide = (this.activeSlide + 1) % this.slides.length;
            }, 5000);
        }
    }" 
    x-init="autoSlide()"
    class="relative w-full h-[600px] overflow-hidden bg-gray-900">

    <!-- Slides -->
    <template x-for="(slide, index) in slides" :key="index">
        <div x-show="activeSlide === index"
             x-transition:enter="transition transform duration-1000 ease-out"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition transform duration-1000 ease-in"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="absolute inset-0 w-full h-full">
            
            <!-- Background Image -->
            <div class="absolute inset-0 bg-cover bg-center" :style="`background-image: url('${slide.image}');`"></div>
            
            <!-- Overlay (Only if there is text) -->
            <template x-if="slide.title">
                <div class="absolute inset-0 bg-black/50 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            </template>

            <!-- Content -->
            <template x-if="slide.title">
                <div class="absolute inset-0 flex items-center justify-center text-center px-4">
                    <div class="max-w-4xl mx-auto">
                        <h2 x-text="slide.title" 
                            class="text-4xl md:text-6xl font-bold text-white mb-6 drop-shadow-lg animate-fade-in-up">
                        </h2>
                        <p x-text="slide.subtitle" 
                           class="text-xl md:text-2xl text-gray-200 mb-10 drop-shadow-md animate-fade-in-up delay-200">
                        </p>
                        <template x-if="slide.cta_text">
                            <a :href="slide.cta_link" 
                               x-text="slide.cta_text"
                               class="inline-block px-8 py-4 bg-islamic-gold hover:bg-yellow-400 text-islamic-navy font-bold rounded-full shadow-lg shadow-islamic-gold/20 transition-all transform hover:-translate-y-1 animate-fade-in-up delay-300">
                            </a>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </template>

    <!-- Navigation Arrows -->
    <button @click="activeSlide = (activeSlide - 1 + slides.length) % slides.length" 
            class="absolute left-4 top-1/2 -translate-y-1/2 p-3 rounded-full bg-white/10 hover:bg-white/20 text-white backdrop-blur-sm transition-colors z-10">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button @click="activeSlide = (activeSlide + 1) % slides.length" 
            class="absolute right-4 top-1/2 -translate-y-1/2 p-3 rounded-full bg-white/10 hover:bg-white/20 text-white backdrop-blur-sm transition-colors z-10">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>

    <!-- Indicators -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-3 z-10">
        <template x-for="(slide, index) in slides" :key="index">
            <button @click="activeSlide = index" 
                    class="w-3 h-3 rounded-full transition-all duration-300"
                    :class="activeSlide === index ? 'bg-islamic-gold w-8' : 'bg-white/50 hover:bg-white'">
            </button>
        </template>
    </div>
</div>
@endif
