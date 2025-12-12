@props(['stats', 'partners'])

<section class="py-16 bg-islamic-cream border-y border-islamic-emerald/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-16">
            @foreach($stats as $stat)
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-extrabold text-islamic-green-dark mb-2">
                    {{ $stat['value'] }}
                </div>
                <div class="text-sm md:text-base font-medium text-islamic-emerald uppercase tracking-wider">
                    {{ $stat['label'] }}
                </div>
            </div>
            @endforeach
        </div>

        <!-- Partners -->
        <div class="text-center">
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-widest mb-8">Didukung Oleh</p>
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
                @foreach($partners as $partner)
                <img src="{{ asset($partner) }}" alt="Partner" class="h-12 w-auto object-contain hover:scale-110 transition-transform">
                @endforeach
            </div>
        </div>
    </div>
</section>
