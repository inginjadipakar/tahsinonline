@php
    // Shared data - Single Source of Truth
    $user = auth()->user();
    $subscription = $user->subscription;
    $hasActiveSubscription = $subscription && $subscription->status === 'active';
    $daysLeft = $hasActiveSubscription ? now()->diffInDays($subscription->end_date, false) : 0;
    $isExpiringSoon = $hasActiveSubscription && $daysLeft > 0 && $daysLeft <= 7;
    $isExpired = $subscription && $daysLeft <= 0;
@endphp

<x-app-layout>
    <div class="bg-gray-50 min-h-screen pb-24 md:pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            

            {{-- Pending Subscription Logic (Payment Prompt) --}}
            @if($subscription && $subscription->status === 'pending')
                <div class="max-w-4xl mx-auto text-center py-10">
                    <div class="mb-8">
                        <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                            <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Menunggu Pembayaran</h2>
                        <p class="text-lg text-gray-600 mb-8">
                            Terima kasih telah mendaftar. Silakan selesaikan pembayaran untuk mengaktifkan paket 
                            <span class="font-bold text-gray-900">Program {{ ucfirst($subscription->program_type) }}</span> Anda.
                        </p>
                        
                        <a href="{{ route('payments.create') }}" class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-xl text-white bg-orange-500 hover:bg-orange-600 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Lakukan Pembayaran Sekarang
                        </a>
                    </div>
                </div>
            @elseif($hasActiveSubscription && is_null($subscription->program_type))
                <div class="max-w-4xl mx-auto text-center py-10">
                    <div class="mb-8">
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Pilih Program Belajar Anda</h2>
                        <p class="text-lg text-gray-600">Silakan pilih program yang sesuai dengan kebutuhan Anda untuk melanjutkan ke tes penempatan.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Iqra Option --}}
                        <form action="{{ route('student.program-selection.store') }}" method="POST" class="h-full">
                            @csrf
                            <input type="hidden" name="program_type" value="iqra">
                            <button type="submit" class="w-full h-full bg-white rounded-2xl p-8 shadow-lg border-2 border-transparent hover:border-green-500 hover:shadow-xl transition-all group text-left">
                                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8 text-green-600" viewBox="0 0 256 256" fill="currentColor">
                                        <path d="M232,48H160a40,40,0,0,0-32,16A40,40,0,0,0,96,48H24a8,8,0,0,0-8,8V200a8,8,0,0,0,8,8H96a24,24,0,0,1,24,24,8,8,0,0,0,16,0,24,24,0,0,1,24-24h72a8,8,0,0,0,8-8V56A8,8,0,0,0,232,48ZM96,192H32V64H96a24,24,0,0,1,24,24V200A39.81,39.81,0,0,0,96,192Zm128,0H160a39.81,39.81,0,0,0-24,8V88a24,24,0,0,1,24-24h64Z"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Program Iqra</h3>
                                <p class="text-gray-600 mb-6">Cocok untuk pemula yang ingin belajar membaca Al-Qur'an dari nol (pengenalan huruf).</p>
                                <div class="flex items-center text-green-600 font-bold">
                                    Pilih Program Ini <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </div>
                            </button>
                        </form>

                        {{-- Tahsin Option --}}
                        <form action="{{ route('student.program-selection.store') }}" method="POST" class="h-full">
                            @csrf
                            <input type="hidden" name="program_type" value="tahsin">
                            <button type="submit" class="w-full h-full bg-white rounded-2xl p-8 shadow-lg border-2 border-transparent hover:border-blue-500 hover:shadow-xl transition-all group text-left">
                                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8 text-blue-600" viewBox="0 0 256 256" fill="currentColor">
                                        <path d="M223.85,47.12a16,16,0,0,0-15-15c-12.58-.75-44.73.4-71.41,27.07L132.69,64H74.36A15.91,15.91,0,0,0,63,68.68L28.7,103a16,16,0,0,0,9.07,27.16l38.47,5.37,44.21,44.21,5.37,38.49a15.94,15.94,0,0,0,10.78,12.92,16.11,16.11,0,0,0,5.1.83A15.91,15.91,0,0,0,153,227.3L187.32,193A15.91,15.91,0,0,0,192,181.64V123.31l4.77-4.77C223.45,91.86,224.6,59.71,223.85,47.12ZM74.36,80h42.33L77.16,119.52,40,114.34Zm74.41-9.45a76.65,76.65,0,0,1,59.11-22.47,76.46,76.46,0,0,1-22.42,59.16L128,164.68,91.32,128ZM176,181.64,141.67,216l-5.19-37.17L176,139.31Zm-74.16,9.5C97.34,201,82.29,224,40,224a8,8,0,0,1-8-8c0-42.29,23-57.34,32.86-61.85a8,8,0,0,1,6.64,14.56c-6.43,2.93-20.62,12.36-23.12,38.91,26.55-2.5,36-16.69,38.91-23.12a8,8,0,1,1,14.56,6.64Z"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Program Tahsin</h3>
                                <p class="text-gray-600 mb-6">Untuk Anda yang sudah bisa membaca namun ingin memperbaiki bacaan (makhraj & tajwid).</p>
                                <div class="flex items-center text-blue-600 font-bold">
                                    Pilih Program Ini <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            @else
            {{-- Hero Section --}}
            <div class="relative rounded-2xl overflow-hidden shadow-xl h-[340px] md:h-[500px] mb-6 group">
                {{-- Background Image --}}
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105" 
                     style="background-image: url('https://images.unsplash.com/photo-1609599006353-e629aaabfeae?q=60&w=800&auto=format&fit=crop');">
                </div>
                
                {{-- Dark Overlay for Readability --}}
                {{-- Dark Overlay for Readability --}}
                <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 to-gray-900/60"></div>

                {{-- Subscription Status Badge (Overlay) --}}
                @if(!$hasActiveSubscription || $isExpired)
                    <div class="absolute top-4 right-4 z-20">
                        <a href="{{ route('student.subscription.index') }}" class="flex items-center gap-2 bg-red-500/90 backdrop-blur-sm text-white px-3 py-1.5 rounded-full shadow-lg hover:bg-red-600 transition-all border border-white/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span class="text-xs font-bold">{{ $isExpired ? 'Langganan Berakhir' : 'Belum Berlangganan' }}</span>
                        </a>
                    </div>
                @elseif($isExpiringSoon)
                    <div class="absolute top-4 right-4 z-20">
                        <a href="{{ route('student.subscription.index') }}" class="flex items-center gap-2 bg-orange-500/90 backdrop-blur-sm text-white px-3 py-1.5 rounded-full shadow-lg hover:bg-orange-600 transition-all border border-white/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-xs font-bold">Berakhir {{ $daysLeft }} Hari Lagi</span>
                        </a>
                    </div>
                @elseif($hasActiveSubscription)
                    <div class="absolute top-4 right-4 z-20">
                        <div class="flex items-center gap-2 bg-green-500/90 backdrop-blur-sm text-white px-3 py-1.5 rounded-full shadow-lg border border-white/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-xs font-bold">Langganan Aktif</span>
                        </div>
                    </div>
                @endif
                
                {{-- Content --}}
                <div class="absolute inset-0 p-6 md:p-12 flex flex-col justify-end z-30">
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-2 mb-3">
                            <span class="bg-red-500 text-white text-xs font-extrabold px-2.5 py-1 rounded-md shadow-lg">NEW</span>
                            <span class="text-sm font-semibold text-white">Tahsin Online</span>
                        </div>
                        
                        <h2 class="text-2xl md:text-5xl font-extrabold mb-2 md:mb-4 leading-tight text-white">
                            Tahsin Al-Qur'an:<br>Belajar Huruf Hijaiyah
                        </h2>
                        <p class="text-sm md:text-xl font-medium mb-2 md:mb-4 text-white">Level 1 - Dasar</p>
                        
                        <div class="text-3xl md:text-4xl font-extrabold mb-4 md:mb-6 text-white">Rp 99.000</div>
                        
                        <a href="{{ $hasActiveSubscription ? route('student.my-class') : route('student.subscription.index') }}" class="inline-block bg-red-500 text-white px-6 md:px-8 py-3 rounded-xl font-bold text-center shadow-lg hover:bg-red-600 transition-all">
                            {{ $hasActiveSubscription ? 'Lanjutkan Belajar' : 'Mulai Berlangganan' }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- Lessons Section --}}
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg md:text-2xl font-bold text-gray-900">Tahsin Reguler (Dewasa)</h3>
                        <p class="text-sm text-gray-600">{{ $lessons->count() }} Pelajaran</p>
                    </div>
                    <a href="{{ route('student.classes.index') }}" class="text-red-500 text-sm font-semibold hover:text-red-600 transition-colors">
                        Lihat Semua →
                    </a>
                </div>
                
                {{-- Desktop: Grid Layout --}}
                <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($lessons->take(6) as $lessonData)
                        @php
                            $lesson = $lessonData['lesson'];
                            $isLocked = $lessonData['isLocked'];
                            $isCompleted = $lessonData['isCompleted'];
                            $isCurrent = $lessonData['isCurrent'];
                        @endphp
                        
                        <div class="bg-white rounded-2xl overflow-hidden shadow-md border border-gray-100 hover:shadow-lg transition-all {{ !$isLocked ? 'cursor-pointer' : 'opacity-75' }}"
                             onclick="{{ !$isLocked ? "window.location='" . route('student.lessons.show', $lesson) . "'" : '' }}">
                            <div class="h-40 bg-gradient-to-br {{ $isCompleted ? 'from-green-400 to-emerald-500' : ($isCurrent ? 'from-purple-400 to-blue-500' : 'from-gray-300 to-gray-400') }} flex items-center justify-center relative">
                                <svg class="w-16 h-16 text-white/30" fill="currentColor" viewBox="0 0 20 20">
                                    @if($isCompleted)
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    @elseif($isCurrent)
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                                    @else
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                    @endif
                                </svg>
                                <span class="absolute top-3 right-3 {{ $isCompleted ? 'bg-green-500' : ($isCurrent ? 'bg-purple-500' : 'bg-gray-500') }} text-white text-xs font-bold px-3 py-1 rounded-full">
                                    {{ $isCompleted ? '✓ SELESAI' : ($isCurrent ? '● AKTIF' : '🔒 TERKUNCI') }}
                                </span>
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-base mb-2">{{ $lesson->title }}</h4>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $lesson->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Mobile: Compact Horizontal Cards --}}
                <div class="space-y-3 md:hidden">
                    @foreach($lessons->take(3) as $lessonData)
                        @php
                            $lesson = $lessonData['lesson'];
                            $isLocked = $lessonData['isLocked'];
                            $isCompleted = $lessonData['isCompleted'];
                            $isCurrent = $lessonData['isCurrent'];
                        @endphp
                        
                        <div class="bg-white rounded-2xl overflow-hidden shadow-md border border-gray-100"
                             onclick="{{ !$isLocked ? "window.location='" . route('student.lessons.show', $lesson) . "'" : '' }}">
                            <div class="flex items-center gap-4 p-4">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 rounded-xl flex items-center justify-center {{ $isCompleted ? 'bg-green-100' : ($isCurrent ? 'bg-purple-100' : 'bg-gray-100') }}">
                                        <svg class="w-8 h-8 {{ $isCompleted ? 'text-green-600' : ($isCurrent ? 'text-purple-600' : 'text-gray-400') }}" fill="currentColor" viewBox="0 0 20 20">
                                            @if($isCompleted)
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            @elseif($isCurrent)
                                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                                            @else
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                            @endif
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-base text-gray-900 mb-1 truncate">{{ $lesson->title }}</h4>
                                    <p class="text-sm text-gray-600 line-clamp-1">{{ $lesson->description }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="text-xs font-bold px-3 py-1.5 rounded-lg whitespace-nowrap {{ $isCompleted ? 'bg-green-100 text-green-700' : ($isCurrent ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600') }}">
                                        {{ $isCompleted ? 'SELESAI' : ($isCurrent ? 'AKTIF' : 'TERKUNCI') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        </div>
    </div>
</x-app-layout>
