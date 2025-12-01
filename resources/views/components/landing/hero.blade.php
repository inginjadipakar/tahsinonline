@props(['data'])

<div class="relative bg-islamic-emerald-dark overflow-hidden min-h-screen flex items-center">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-islamic-emerald-dark via-islamic-emerald to-islamic-emerald/90"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 flex flex-col lg:flex-row items-start gap-12">
        <!-- Text Content -->
        <div class="w-full lg:w-1/2 text-center lg:text-left z-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 text-white text-sm font-medium mb-8 backdrop-blur-sm animate-fade-in-up">
                <span class="w-2 h-2 rounded-full bg-islamic-gold animate-pulse"></span>
                {{ $data['badge'] }}
            </div>
            
            <h1 class="text-4xl lg:text-6xl font-bold text-white leading-tight mb-6 animate-fade-in-up delay-100">
                {!! $data['title'] !!}
            </h1>
            
            <p class="text-lg text-islamic-emerald-light mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed animate-fade-in-up delay-200">
                {{ $data['description'] }}
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 animate-fade-in-up delay-300">
                <a href="#pricing" class="w-full sm:w-auto px-8 py-4 bg-islamic-gold hover:bg-yellow-400 text-islamic-navy font-bold rounded-xl shadow-lg shadow-islamic-gold/20 transition-all transform hover:-translate-y-1">
                    {{ $data['cta_primary'] }}
                </a>
                <a href="#schedule" class="w-full sm:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl backdrop-blur-sm border border-white/10 transition-all">
                    {{ $data['cta_secondary'] }}
                </a>
            </div>

            <!-- Stats -->
            @if(!empty($data['stats']))
            <div class="mt-12 grid grid-cols-3 gap-6 border-t border-white/10 pt-8 animate-fade-in-up delay-500">
                @foreach($data['stats'] as $stat)
                <div>
                    <div class="text-2xl lg:text-3xl font-bold text-white">{{ $stat['value'] }}</div>
                    <div class="text-xs lg:text-sm text-islamic-emerald-light">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Hero Image -->
        <div class="w-full lg:w-1/2 relative z-10 animate-fade-in-left delay-500">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white/10 group">
                <div class="absolute inset-0 bg-gradient-to-t from-islamic-navy/50 to-transparent z-10"></div>
                <img src="{{ asset($data['image']) }}" alt="Belajar Mengaji" class="w-full h-auto max-h-80 object-contain transform group-hover:scale-105 transition-transform duration-700">
                
                <!-- Floating Card -->
                <div class="absolute bottom-6 left-6 right-6 bg-white/95 backdrop-blur-md p-4 rounded-xl shadow-lg z-20 transform translate-y-2 group-hover:translate-y-0 transition-transform">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-islamic-emerald/10 flex items-center justify-center text-2xl">
                            🧕
                        </div>
                        <div>
                            <div class="text-sm font-bold text-gray-900">Ustadzah Himmah</div>
                            <div class="text-xs text-gray-500">Pengajar Bersanad</div>
                        </div>
                        <div class="ml-auto text-islamic-gold">
                            ★★★★★
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Decorative Elements -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-islamic-gold/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-islamic-emerald/30 rounded-full blur-3xl"></div>
        </div>
    </div>
</div>
