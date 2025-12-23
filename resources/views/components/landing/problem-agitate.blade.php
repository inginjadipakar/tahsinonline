@props(['data'])

@php
// Phosphor Icons mapping for different problem types
$iconSvg = [
    'time' => '<svg class="w-8 h-8 text-red-500" viewBox="0 0 256 256" fill="currentColor"><path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm64-88a8,8,0,0,1-8,8H128a8,8,0,0,1-8-8V72a8,8,0,0,1,16,0v48h48A8,8,0,0,1,192,128Z"/></svg>',
    'shy' => '<svg class="w-8 h-8 text-red-500" viewBox="0 0 256 256" fill="currentColor"><path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216ZM80,108a12,12,0,1,1,12,12A12,12,0,0,1,80,108Zm72,0a12,12,0,1,1,12,12A12,12,0,0,1,152,108Zm24,68a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h80A8,8,0,0,1,176,176Z"/></svg>',
    'location' => '<svg class="w-8 h-8 text-red-500" viewBox="0 0 256 256" fill="currentColor"><path d="M128,16a88.1,88.1,0,0,0-88,88c0,75.3,80,132.17,83.41,134.55a8,8,0,0,0,9.18,0C136,236.17,216,179.3,216,104A88.1,88.1,0,0,0,128,16Zm0,56a32,32,0,1,1-32,32A32,32,0,0,1,128,72Z"/></svg>',
    'confused' => '<svg class="w-8 h-8 text-red-500" viewBox="0 0 256 256" fill="currentColor"><path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216ZM80,108a12,12,0,1,1,12,12A12,12,0,0,1,80,108Zm72,0a12,12,0,1,1,12,12A12,12,0,0,1,152,108Zm24,76a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h80A8,8,0,0,1,176,184ZM140,140a8,8,0,0,1,0,16H116a8,8,0,0,1,0-16Z"/></svg>',
];

// Map emoji to icon key
$emojiToKey = [
    '🕰️' => 'time',
    '😳' => 'shy', 
    '🚗' => 'location',
    '😕' => 'confused',
];
@endphp

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
                <div class="w-16 h-16 bg-red-50 dark:bg-red-900/20 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                    @php
                        $iconKey = $emojiToKey[$item['icon']] ?? 'time';
                    @endphp
                    {!! $iconSvg[$iconKey] !!}
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
