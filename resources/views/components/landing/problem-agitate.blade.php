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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($data['items'] as $index => $item)
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700 animate-on-scroll" style="transition-delay: {{ $index * 100 }}ms">
                <div class="w-16 h-16 bg-red-50 dark:bg-red-900/20 rounded-2xl flex items-center justify-center text-4xl mb-6 mx-auto">
                    {{ $item['icon'] }}
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 text-center">
                    {{ $item['title'] }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 text-center leading-relaxed">
                    {{ $item['description'] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>
