@props(['data'])

<section class="py-24 bg-white relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-islamic-cream rounded-full blur-3xl opacity-50 translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-islamic-lime/10 rounded-full blur-3xl opacity-50 -translate-x-1/2 translate-y-1/2"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-islamic-green-dark mb-4">{{ $data['title'] }}</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">{{ $data['subtitle'] }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($data['items'] as $item)
            <div class="bg-white rounded-2xl p-8 shadow-lg shadow-gray-100 border border-gray-50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl mb-6 {{ $item['color'] }} transition-transform duration-300 group-hover:scale-110">
                    {{ $item['icon'] }}
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-islamic-emerald transition-colors">
                    {{ $item['title'] }}
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ $item['description'] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>
