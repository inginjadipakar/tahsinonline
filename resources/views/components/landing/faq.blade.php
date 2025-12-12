@props(['data'])

<section class="py-20 bg-white dark:bg-gray-800 bg-arabic-calligraphy">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4 animate-on-scroll">
                {{ $data['title'] }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 animate-on-scroll delay-100">
                {{ $data['subtitle'] }}
            </p>
        </div>

        <div class="space-y-4" x-data="{ active: null }">
            @foreach($data['items'] as $index => $item)
            <div class="border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden animate-on-scroll" style="transition-delay: {{ $index * 100 }}ms">
                <button @click="active = active === {{ $index }} ? null : {{ $index }}" 
                        class="w-full flex items-center justify-between p-6 text-left bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <span class="font-bold text-gray-900 dark:text-white">{{ $item['question'] }}</span>
                    <span class="transform transition-transform duration-300" :class="{ 'rotate-180': active === {{ $index }} }">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </span>
                </button>
                <div x-show="active === {{ $index }}" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="p-6 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 leading-relaxed">
                    {{ $item['answer'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
