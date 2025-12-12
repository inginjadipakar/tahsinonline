@props(['data'])

<section class="py-24 bg-white dark:bg-islamic-navy bg-arabic-calligraphy relative overflow-hidden">
    <!-- Decorative Blob -->
    <div class="absolute top-0 right-0 w-1/3 h-full bg-islamic-emerald/5 skew-x-12 transform translate-x-20"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <span class="text-islamic-emerald dark:text-islamic-gold font-bold tracking-wider uppercase text-sm mb-2 block animate-on-scroll">Solusi Kami</span>
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4 animate-on-scroll delay-100">
                {{ $data['title'] }}
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 animate-on-scroll delay-200">
                {{ $data['subtitle'] }}
            </p>
        </div>

        <div class="space-y-24">
            @foreach($data['features'] as $index => $feature)
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20 {{ $index % 2 == 1 ? 'lg:flex-row-reverse' : '' }}">
                <!-- Image Side -->
                <div class="w-full lg:w-1/2 animate-on-scroll slide-in-{{ $index % 2 == 1 ? 'right' : 'left' }}">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl group">
                        <div class="absolute inset-0 bg-islamic-navy/20 group-hover:bg-transparent transition-colors duration-500 z-10"></div>
                        <img src="{{ asset($feature['image']) }}" alt="{{ $feature['title'] }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                    </div>
                </div>

                <!-- Text Side -->
                <div class="w-full lg:w-1/2 animate-on-scroll">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="flex items-center justify-center w-12 h-12 rounded-full bg-islamic-emerald text-white font-bold text-xl shadow-lg shadow-islamic-emerald/30">
                            {{ $index + 1 }}
                        </span>
                        <div class="h-px flex-1 bg-gray-200 dark:bg-gray-700"></div>
                    </div>
                    
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
                        {{ $feature['title'] }}
                    </h3>
                    <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed mb-8">
                        {{ $feature['description'] }}
                    </p>
                    
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-islamic-emerald dark:text-islamic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Teruji efektif
                        </li>
                        <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-islamic-emerald dark:text-islamic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Bimbingan intensif
                        </li>
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
