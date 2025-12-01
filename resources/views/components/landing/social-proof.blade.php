@props(['data'])

<section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4 animate-on-scroll">
                {{ $data['title'] }}
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 animate-on-scroll delay-100">
                {{ $data['subtitle'] }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($data['testimonials'] as $index => $testimonial)
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 relative animate-on-scroll" style="transition-delay: {{ $index * 100 }}ms">
                <!-- Quote Icon -->
                <div class="absolute -top-4 -left-4 w-10 h-10 bg-islamic-gold text-islamic-navy flex items-center justify-center rounded-full text-2xl shadow-md">
                    ❝
                </div>

                <p class="text-gray-600 dark:text-gray-300 mb-8 italic leading-relaxed">
                    "{{ $testimonial['content'] }}"
                </p>

                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                        <!-- Placeholder Avatar -->
                        <div class="w-full h-full flex items-center justify-center text-xl">👤</div>
                        <!-- <img src="{{ asset($testimonial['avatar']) }}" alt="{{ $testimonial['name'] }}" class="w-full h-full object-cover"> -->
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white">{{ $testimonial['name'] }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $testimonial['role'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
