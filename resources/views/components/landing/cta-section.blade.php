@props(['data'])

<section class="py-24 relative overflow-hidden">
    <!-- Background with Overlay -->
    <div class="absolute inset-0 bg-islamic-emerald-dark">
        <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-islamic-emerald-dark to-islamic-emerald/90"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-5xl font-bold text-white mb-6 animate-on-scroll">
            {{ $data['title'] }}
        </h2>
        <p class="text-xl text-islamic-emerald-light mb-10 animate-on-scroll delay-100">
            {{ $data['description'] }}
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-on-scroll delay-200">
            <a href="#pricing" class="w-full sm:w-auto px-10 py-5 bg-islamic-gold hover:bg-yellow-400 text-islamic-navy text-lg font-bold rounded-xl shadow-xl shadow-islamic-gold/20 transition-all transform hover:-translate-y-1">
                {{ $data['button_text'] }}
            </a>
        </div>
        
        <p class="mt-8 text-sm text-white/60 flex items-center justify-center gap-2 animate-on-scroll delay-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $data['guarantee'] }}
        </p>
    </div>
</section>
