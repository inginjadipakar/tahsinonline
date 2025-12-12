@props(['data'])

<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-islamic-green-dark mb-4">
                {{ $data['title'] }}
            </h2>
            <div class="w-24 h-1 bg-islamic-lime mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($data['images'] as $index => $image)
            <div class="relative group overflow-hidden rounded-2xl {{ $index === 0 || $index === 3 ? 'md:col-span-2 md:row-span-2' : '' }} h-64 md:h-auto min-h-[250px]">
                <img src="{{ asset($image) }}" alt="Gallery {{ $index + 1 }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-300"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>
