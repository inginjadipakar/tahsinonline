<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark" x-data="{ darkMode: localStorage.getItem('darkMode') === 'false' ? false : true }" :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-islamic-navy bg-islamic-pattern bg-blend-multiply dark:bg-blend-overlay transition-colors duration-300">
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-islamic-gold selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="flex items-center justify-between py-6 sm:py-10">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-br from-islamic-emerald to-islamic-emerald-dark dark:from-islamic-gold dark:to-islamic-gold-light flex items-center justify-center shadow-lg shadow-islamic-emerald/20 dark:shadow-islamic-gold/20">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white dark:text-islamic-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <span class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white tracking-wide">Tahsin<span class="text-islamic-emerald dark:text-islamic-gold">ku</span></span>
                    </div>
                    <nav class="-mx-3 flex flex-1 justify-end items-center gap-4">
                        {{-- Desktop Dark Mode Toggle --}}
                        <button @click="darkMode = !darkMode" class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            <svg x-show="darkMode" class="w-5 h-5 text-islamic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <svg x-show="!darkMode" class="w-5 h-5 text-islamic-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                            <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'" class="text-sm font-bold"></span>
                        </button>

                        @if (Route::has('login'))
                            @auth
                                <a
                                    href="{{ url('/dashboard') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Dashboard
                                </a>
                            @else
                                <a
                                    href="{{ route('login') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a
                                        href="#pricing"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Register
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </nav>
                </header>

                {{-- Mobile Dark Mode Toggle (Centered) --}}
                <div class="flex sm:hidden justify-center mb-8">
                    <button @click="darkMode = !darkMode" class="flex items-center gap-2 px-4 py-2 rounded-full bg-white dark:bg-islamic-navy-light border border-gray-200 dark:border-gray-700 shadow-sm text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all transform hover:scale-105">
                        <svg x-show="darkMode" class="w-5 h-5 text-islamic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <svg x-show="!darkMode" class="w-5 h-5 text-islamic-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'" class="text-sm font-bold"></span>
                    </button>
                </div>

                        {{-- Emerald Background Section for Overlap --}}
                        <div id="pricing" class="relative bg-gradient-to-b from-islamic-emerald to-islamic-emerald-dark dark:from-islamic-navy dark:to-islamic-navy-dark rounded-3xl mx-4 sm:mx-8 mt-8 pt-20 pb-48 overflow-hidden shadow-2xl">
                            {{-- Decorative Elements --}}
                            <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
                                <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white blur-3xl"></div>
                                <div class="absolute top-1/2 right-0 w-64 h-64 rounded-full bg-yellow-400 blur-3xl"></div>
                                <div class="absolute bottom-0 left-1/2 w-full h-32 bg-gradient-to-t from-black/20 to-transparent"></div>
                            </div>

                            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
                                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl md:text-6xl mb-6">
                                    <span class="block">Belajar Al-Qur'an</span>
                                    <span class="block mt-2 text-yellow-400">Mudah & Terjangkau</span>
                                </h1>
                                
                                <p class="text-lg text-green-50 max-w-2xl mx-auto leading-relaxed mb-8">
                                    Platform pembelajaran Tahsin online interaktif dengan kurikulum terstruktur dan bimbingan ustadz berpengalaman.
                                </p>

                                <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md rounded-full px-6 py-2 border border-white/20 shadow-lg">
                                    <span class="flex h-3 w-3 relative">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
                                    </span>
                                    <span class="text-white font-bold tracking-wide">Pilih Kelas Belajar</span>
                                </div>
                            </div>
                        </div>

                        {{-- Cards Grid (Overlapping) --}}
                        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-32 z-20 mb-24">
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                                @foreach($classes as $index => $class)
                                <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden flex flex-col transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl group {{ $index === 2 ? 'ring-4 ring-yellow-400 scale-105 z-30' : '' }}">
                                    
                                    @if($index === 2)
                                    <div class="absolute top-0 inset-x-0 h-2 bg-yellow-400"></div>
                                    <div class="absolute top-2 right-0 bg-yellow-400 text-blue-900 text-xs font-bold px-3 py-1 rounded-l-full shadow-sm">
                                        POPULER
                                    </div>
                                    @endif

                                    <div class="p-8 flex-1">
                                        <div class="w-20 h-20 rounded-2xl {{ $index === 2 ? 'bg-yellow-100' : 'bg-blue-50' }} flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 transition-transform p-2">
                                        <img src="{{ asset('images/icons/' . ($index === 0 ? 'toddler.png' : ($index === 1 ? 'kid.png' : ($index === 2 ? 'family.png' : 'woman.png')))) }}" 
                                             alt="{{ $class->name }}" 
                                             class="w-full h-full object-contain drop-shadow-md">
                                    </div>
                                        
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $class->name }}</h3>
                                        <div class="flex items-baseline mb-4">
                                            <span class="text-4xl font-extrabold text-gray-900 dark:text-white">Rp {{ number_format($class->price / 1000, 0) }}rb</span>
                                            <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">/bln</span>
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-8 leading-relaxed min-h-[40px]">{{ $class->description }}</p>
                                        
                                        <ul role="list" class="space-y-4 mb-8">
                                            <li class="flex items-start">
                                                <div class="flex-shrink-0 w-5 h-5 rounded-full bg-green-100 flex items-center justify-center mt-0.5">
                                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                </div>
                                                <span class="ml-3 text-sm text-gray-600 dark:text-gray-300">Kurikulum Terstruktur</span>
                                            </li>
                                            <li class="flex items-start">
                                                <div class="flex-shrink-0 w-5 h-5 rounded-full bg-green-100 flex items-center justify-center mt-0.5">
                                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                </div>
                                                <span class="ml-3 text-sm text-gray-600 dark:text-gray-300">Bimbingan Ustadz</span>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    <div class="p-6 pt-0 mt-auto">
                                        <a href="{{ route('guest.select-program', ['class_id' => $class->id]) }}" class="w-full flex items-center justify-center px-6 py-3.5 border border-transparent text-sm font-bold rounded-xl text-white {{ $index === 2 ? 'bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/30' : 'bg-gray-900 hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600' }} transition-all hover:-translate-y-0.5">
                                            Daftar Sekarang
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                        {{-- FAQ Section --}}
                        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-24 mb-24">
                            <h2 class="text-3xl font-extrabold text-center text-gray-900 dark:text-white mb-12">
                                Pertanyaan yang <span class="text-islamic-emerald dark:text-islamic-gold">Sering Diajukan</span>
                            </h2>
                            
                            <div class="space-y-4">
                                {{-- FAQ Item 1 --}}
                                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden p-6">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Apa itu Tahsinku?</h3>
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                        Tahsinku adalah platform pembelajaran Al-Qur'an intensif secara online yang dirancang untuk membantu Anda memperbaiki bacaan Al-Qur'an sesuai kaidah tajwid, dibimbing langsung oleh ustadz/ustadzah bersertifikat.
                                    </p>
                                </div>

                                {{-- FAQ Item 2 --}}
                                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden p-6">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Bagaimana sistem belajarnya?</h3>
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                        Pembelajaran dilakukan secara interaktif melalui video conference (Zoom/Google Meet). Anda bisa memilih kelas privat (1-on-1) atau reguler (kelompok kecil) dengan jadwal yang fleksibel sesuai kesepakatan.
                                    </p>
                                </div>

                                {{-- FAQ Item 3 --}}
                                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden p-6">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Apakah cocok untuk pemula?</h3>
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                        Sangat cocok! Kami menyediakan program Iqra untuk pemula yang baru belajar membaca huruf hijaiyah, hingga program Tahsin lanjutan untuk yang ingin memperlancar dan memfasihkan bacaan.
                                    </p>
                                </div>

                                {{-- FAQ Item 4 --}}
                                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden p-6">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Berapa lama durasi belajarnya?</h3>
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                        Durasi belajar bervariasi tergantung paket yang Anda ambil (Bulanan, Semester, atau Tahunan). Setiap sesi pertemuan berlangsung selama 60-90 menit dengan materi yang terstruktur.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-12 text-center">
                                <a href="#pricing" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-full text-white bg-islamic-emerald hover:bg-islamic-emerald-dark transition-colors shadow-lg shadow-islamic-emerald/30">
                                    Mulai Belajar Sekarang
                                </a>
                            </div>
                        </div>

                        {{-- Testimonials Section --}}
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-32">
                            <h2 class="text-3xl font-extrabold text-center text-gray-900 dark:text-white mb-12">
                                Apa Kata Mereka <span class="text-islamic-emerald dark:text-islamic-gold">Tentang Kami</span>
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                {{-- Testimonial 1 --}}
                                <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 relative">
                                    <div class="flex items-center gap-4 mb-6">
                                        <div class="w-14 h-14 rounded-full bg-gray-200 overflow-hidden">
                                            <img src="https://ui-avatars.com/api/?name=Ahmad+Fauzi&background=10B981&color=fff" alt="User" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-white">Ahmad Fauzi</h4>
                                            <div class="flex text-yellow-400 text-sm">
                                                ★★★★★
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed italic">
                                        "Alhamdulillah, setelah 3 bulan belajar di Tahsinku, bacaan Al-Qur'an saya jauh lebih baik. Ustadznya sangat sabar membimbing dari nol sampai lancar."
                                    </p>
                                </div>

                                {{-- Testimonial 2 --}}
                                <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 relative">
                                    <div class="flex items-center gap-4 mb-6">
                                        <div class="w-14 h-14 rounded-full bg-gray-200 overflow-hidden">
                                            <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=D4AF37&color=fff" alt="User" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-white">Siti Aminah</h4>
                                            <div class="flex text-yellow-400 text-sm">
                                                ★★★★★
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed italic">
                                        "Sangat terbantu dengan jadwal yang fleksibel. Sebagai ibu rumah tangga, saya tetap bisa belajar mengaji tanpa mengganggu urusan rumah. Materinya juga mudah dipahami."
                                    </p>
                                </div>

                                {{-- Testimonial 3 --}}
                                <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 relative">
                                    <div class="flex items-center gap-4 mb-6">
                                        <div class="w-14 h-14 rounded-full bg-gray-200 overflow-hidden">
                                            <img src="https://ui-avatars.com/api/?name=Rudi+Hermawan&background=0F172A&color=fff" alt="User" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-white">Rudi Hermawan</h4>
                                            <div class="flex text-yellow-400 text-sm">
                                                ★★★★★
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed italic">
                                        "Kelas privatnya sangat efektif. Koreksi bacaan detail banget, jadi tau salahnya dimana. Recommended buat yang mau serius perbaiki bacaan."
                                    </p>
                                </div>

                                {{-- Testimonial 4 --}}
                                <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 relative">
                                    <div class="flex items-center gap-4 mb-6">
                                        <div class="w-14 h-14 rounded-full bg-gray-200 overflow-hidden">
                                            <img src="https://ui-avatars.com/api/?name=Dewi+Sartika&background=10B981&color=fff" alt="User" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-white">Dewi Sartika</h4>
                                            <div class="flex text-yellow-400 text-sm">
                                                ★★★★★
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed italic">
                                        "Anak saya jadi semangat belajar ngaji karena metodenya menyenangkan. Tampilannya juga bagus dan mudah digunakan. Terima kasih Tahsinku!"
                                    </p>
                                </div>
                            </div>
                        </div>
                </main>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    &copy; {{ date('Y') }} Tahsinku. All rights reserved.
                    
                    <!-- Dark Mode Toggle -->

                </footer>
            </div>
        </div>
    </body>
</html>
