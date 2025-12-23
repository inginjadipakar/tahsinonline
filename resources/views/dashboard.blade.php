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
    <div class="min-h-screen pb-24 md:pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            {{-- Pending Subscription --}}
            @if($subscription && $subscription->status === 'pending')
                <div class="max-w-2xl mx-auto text-center py-16">
                    <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-amber-600" viewBox="0 0 256 256" fill="currentColor">
                            <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm64-88a8,8,0,0,1-8,8H128a8,8,0,0,1-8-8V72a8,8,0,0,1,16,0v48h48A8,8,0,0,1,192,128Z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">Menunggu Pembayaran</h2>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Silakan selesaikan pembayaran untuk mengaktifkan 
                        <span class="font-semibold">Program {{ ucfirst($subscription->program_type) }}</span>
                    </p>
                    <a href="{{ route('payments.create') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-xl transition-colors">
                        <svg class="w-5 h-5" viewBox="0 0 256 256" fill="currentColor">
                            <path d="M224,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48Zm0,16V88H32V64Zm0,128H32V104H224v88Zm-16-24a8,8,0,0,1-8,8H168a8,8,0,0,1,0-16h32A8,8,0,0,1,208,168Zm-64,0a8,8,0,0,1-8,8H120a8,8,0,0,1,0-16h16A8,8,0,0,1,144,168Z"/>
                        </svg>
                        Lakukan Pembayaran
                    </a>
                </div>

            {{-- Program Selection --}}
            @elseif($hasActiveSubscription && is_null($subscription->program_type))
                <div class="max-w-3xl mx-auto py-12">
                    <div class="text-center mb-10">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Pilih Program Belajar</h2>
                        <p class="text-gray-600">Silakan pilih program yang sesuai dengan kebutuhan Anda</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Iqra Option --}}
                        <form action="{{ route('student.program-selection.store') }}" method="POST" class="h-full">
                            @csrf
                            <input type="hidden" name="program_type" value="iqra">
                            <button type="submit" class="w-full h-full bg-white rounded-2xl p-8 border border-gray-100 hover:border-emerald-200 hover:shadow-lg transition-all group text-left">
                                <div class="w-14 h-14 bg-emerald-100 group-hover:bg-emerald-200 rounded-xl flex items-center justify-center mb-6 transition-colors">
                                    <svg class="w-7 h-7 text-emerald-600" viewBox="0 0 256 256" fill="currentColor">
                                        <path d="M232,48H160a40,40,0,0,0-32,16A40,40,0,0,0,96,48H24a8,8,0,0,0-8,8V200a8,8,0,0,0,8,8H96a24,24,0,0,1,24,24,8,8,0,0,0,16,0,24,24,0,0,1,24-24h72a8,8,0,0,0,8-8V56A8,8,0,0,0,232,48ZM96,192H32V64H96a24,24,0,0,1,24,24V200A39.81,39.81,0,0,0,96,192Zm128,0H160a39.81,39.81,0,0,0-24,8V88a24,24,0,0,1,24-24h64Z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-700 transition-colors">Program Iqra</h3>
                                <p class="text-gray-600 mb-6 text-sm leading-relaxed">Cocok untuk pemula yang ingin belajar membaca Al-Qur'an dari nol.</p>
                                <div class="flex items-center text-emerald-600 font-medium text-sm">
                                    Pilih Program Ini
                                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" viewBox="0 0 256 256" fill="currentColor">
                                        <path d="M221.66,133.66l-72,72a8,8,0,0,1-11.32-11.32L196.69,136H40a8,8,0,0,1,0-16H196.69L138.34,61.66a8,8,0,0,1,11.32-11.32l72,72A8,8,0,0,1,221.66,133.66Z"/>
                                    </svg>
                                </div>
                            </button>
                        </form>

                        {{-- Tahsin Option --}}
                        <form action="{{ route('student.program-selection.store') }}" method="POST" class="h-full">
                            @csrf
                            <input type="hidden" name="program_type" value="tahsin">
                            <button type="submit" class="w-full h-full bg-white rounded-2xl p-8 border border-gray-100 hover:border-blue-200 hover:shadow-lg transition-all group text-left">
                                <div class="w-14 h-14 bg-blue-100 group-hover:bg-blue-200 rounded-xl flex items-center justify-center mb-6 transition-colors">
                                    <svg class="w-7 h-7 text-blue-600" viewBox="0 0 256 256" fill="currentColor">
                                        <path d="M223.85,47.12a16,16,0,0,0-15-15c-12.58-.75-44.73.4-71.41,27.07L132.69,64H74.36A15.91,15.91,0,0,0,63,68.68L28.7,103a16,16,0,0,0,9.07,27.16l38.47,5.37,44.21,44.21,5.37,38.49a15.94,15.94,0,0,0,10.78,12.92,16.11,16.11,0,0,0,5.1.83A15.91,15.91,0,0,0,153,227.3L187.32,193A15.91,15.91,0,0,0,192,181.64V123.31l4.77-4.77C223.45,91.86,224.6,59.71,223.85,47.12Z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-700 transition-colors">Program Tahsin</h3>
                                <p class="text-gray-600 mb-6 text-sm leading-relaxed">Untuk yang sudah bisa membaca namun ingin memperbaiki bacaan.</p>
                                <div class="flex items-center text-blue-600 font-medium text-sm">
                                    Pilih Program Ini
                                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" viewBox="0 0 256 256" fill="currentColor">
                                        <path d="M221.66,133.66l-72,72a8,8,0,0,1-11.32-11.32L196.69,136H40a8,8,0,0,1,0-16H196.69L138.34,61.66a8,8,0,0,1,11.32-11.32l72,72A8,8,0,0,1,221.66,133.66Z"/>
                                    </svg>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>

            {{-- Main Dashboard --}}
            @else
                <div class="space-y-8">
                    {{-- Welcome Header - Notion Style --}}
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Selamat datang kembali,</p>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                        </div>
                        
                        {{-- Subscription Status Badge --}}
                        @if(!$hasActiveSubscription || $isExpired)
                            <a href="{{ route('student.subscription.index') }}" 
                               class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg border border-red-100 transition-colors">
                                <svg class="w-4 h-4" viewBox="0 0 256 256" fill="currentColor">
                                    <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm-8-80V80a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,172Z"/>
                                </svg>
                                <span class="text-sm font-medium">{{ $isExpired ? 'Langganan Berakhir' : 'Belum Berlangganan' }}</span>
                            </a>
                        @elseif($isExpiringSoon)
                            <a href="{{ route('student.subscription.index') }}" 
                               class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg border border-amber-100 transition-colors">
                                <svg class="w-4 h-4" viewBox="0 0 256 256" fill="currentColor">
                                    <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm64-88a8,8,0,0,1-8,8H128a8,8,0,0,1-8-8V72a8,8,0,0,1,16,0v48h48A8,8,0,0,1,192,128Z"/>
                                </svg>
                                <span class="text-sm font-medium">Berakhir {{ $daysLeft }} Hari Lagi</span>
                            </a>
                        @elseif($hasActiveSubscription)
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-lg border border-emerald-100">
                                <svg class="w-4 h-4" viewBox="0 0 256 256" fill="currentColor">
                                    <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm45.66,85.66-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35a8,8,0,0,1,11.32,11.32Z"/>
                                </svg>
                                <span class="text-sm font-medium">Langganan Aktif</span>
                            </div>
                        @endif
                    </div>

                    {{-- Featured Course Card - Notion Style --}}
                    <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl overflow-hidden relative group">
                        <div class="absolute inset-0 bg-cover bg-center opacity-30 group-hover:opacity-40 transition-opacity duration-500" 
                             style="background-image: url('https://images.unsplash.com/photo-1609599006353-e629aaabfeae?q=60&w=800&auto=format&fit=crop');"></div>
                        <div class="relative z-10 p-8 md:p-12">
                            <div class="inline-flex items-center gap-2 mb-4">
                                <span class="bg-emerald-500 text-white text-xs font-bold px-2.5 py-1 rounded-md">KELAS ANDA</span>
                                @if($subscription && $subscription->program_type)
                                    <span class="text-gray-300 text-sm">Program {{ ucfirst($subscription->program_type) }}</span>
                                @endif
                            </div>
                            
                            <h2 class="text-2xl md:text-4xl font-bold text-white mb-4 leading-tight max-w-xl">
                                Tahsin Al-Qur'an: Belajar dengan Metode Terstruktur
                            </h2>
                            
                            <p class="text-gray-300 mb-6 max-w-lg">
                                Pelajari Al-Qur'an dengan bimbingan personal dari ustadz bersanad. Akses materi kapan saja, di mana saja.
                            </p>
                            
                            <a href="{{ $hasActiveSubscription ? route('student.my-class') : route('student.subscription.index') }}" 
                               class="inline-flex items-center gap-2 px-6 py-3 bg-white hover:bg-gray-100 text-gray-900 font-semibold rounded-xl transition-colors">
                                {{ $hasActiveSubscription ? 'Lanjutkan Belajar' : 'Mulai Berlangganan' }}
                                <svg class="w-4 h-4" viewBox="0 0 256 256" fill="currentColor">
                                    <path d="M221.66,133.66l-72,72a8,8,0,0,1-11.32-11.32L196.69,136H40a8,8,0,0,1,0-16H196.69L138.34,61.66a8,8,0,0,1,11.32-11.32l72,72A8,8,0,0,1,221.66,133.66Z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Lessons Section - Notion Style --}}
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Materi Pelajaran</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $lessons->count() }} pelajaran tersedia</p>
                            </div>
                            <a href="{{ route('student.classes.index') }}" 
                               class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors flex items-center gap-1">
                                Lihat Semua
                                <svg class="w-4 h-4" viewBox="0 0 256 256" fill="currentColor">
                                    <path d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z"/>
                                </svg>
                            </a>
                        </div>
                        
                        {{-- Lessons Grid - Notion Style --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($lessons->take(6) as $lessonData)
                                @php
                                    $lesson = $lessonData['lesson'];
                                    $isLocked = $lessonData['isLocked'];
                                    $isCompleted = $lessonData['isCompleted'];
                                    $isCurrent = $lessonData['isCurrent'];
                                @endphp
                                
                                <div class="group bg-white rounded-xl border border-gray-100 overflow-hidden {{ !$isLocked ? 'hover:border-gray-200 hover:shadow-sm cursor-pointer' : 'opacity-60' }} transition-all duration-200"
                                     onclick="{{ !$isLocked ? "window.location='" . route('student.lessons.show', $lesson) . "'" : '' }}">
                                    
                                    {{-- Status Bar --}}
                                    <div class="h-1 {{ $isCompleted ? 'bg-emerald-500' : ($isCurrent ? 'bg-blue-500' : 'bg-gray-200') }}"></div>
                                    
                                    <div class="p-5">
                                        <div class="flex items-start gap-4">
                                            {{-- Icon --}}
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0
                                                {{ $isCompleted ? 'bg-emerald-100' : ($isCurrent ? 'bg-blue-100' : 'bg-gray-100') }}">
                                                @if($isCompleted)
                                                    <svg class="w-5 h-5 text-emerald-600" viewBox="0 0 256 256" fill="currentColor">
                                                        <path d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z"/>
                                                    </svg>
                                                @elseif($isCurrent)
                                                    <svg class="w-5 h-5 text-blue-600" viewBox="0 0 256 256" fill="currentColor">
                                                        <path d="M232,128A104,104,0,1,0,128,232,104.12,104.12,0,0,0,232,128Zm-152,0a24,24,0,0,1,48,0v44a8,8,0,1,1-16,0V128a8,8,0,0,0-16,0v44a24,24,0,0,1-16-22.62Z"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5 text-gray-400" viewBox="0 0 256 256" fill="currentColor">
                                                        <path d="M208,80H176V56A48,48,0,0,0,80,56V80H48A16,16,0,0,0,32,96V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V96A16,16,0,0,0,208,80Zm-16,128H64V96H192ZM96,80V56a32,32,0,0,1,64,0V80Z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            
                                            {{-- Content --}}
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-xs font-medium px-2 py-0.5 rounded
                                                        {{ $isCompleted ? 'bg-emerald-100 text-emerald-700' : ($isCurrent ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                                                        {{ $isCompleted ? 'Selesai' : ($isCurrent ? 'Aktif' : 'Terkunci') }}
                                                    </span>
                                                </div>
                                                <h4 class="font-semibold text-gray-900 mb-1 group-hover:text-gray-700 transition-colors truncate">
                                                    {{ $lesson->title }}
                                                </h4>
                                                <p class="text-sm text-gray-500 line-clamp-2">{{ $lesson->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Quick Actions - Notion Style --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('student.my-class') }}" 
                           class="group flex flex-col items-center p-6 bg-white rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all text-center">
                            <div class="w-12 h-12 bg-emerald-100 group-hover:bg-emerald-200 rounded-xl flex items-center justify-center mb-3 transition-colors">
                                <svg class="w-6 h-6 text-emerald-600" viewBox="0 0 256 256" fill="currentColor">
                                    <path d="M251.76,88.94l-120-64a8,8,0,0,0-7.52,0l-120,64a8,8,0,0,0,0,14.12L32,117.87v48.42a15.91,15.91,0,0,0,4.06,10.65C49.16,191.53,78.51,216,128,216a130,130,0,0,0,48-8.76V240a8,8,0,0,0,16,0V199.51a115.63,115.63,0,0,0,27.94-22.57A15.91,15.91,0,0,0,224,166.29V117.87l27.76-14.81a8,8,0,0,0,0-14.12Z"/>
                                </svg>
                            </div>
                            <p class="font-medium text-gray-900 text-sm">Kelas Saya</p>
                        </a>
                        
                        <a href="{{ route('student.subscription.index') }}" 
                           class="group flex flex-col items-center p-6 bg-white rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all text-center">
                            <div class="w-12 h-12 bg-blue-100 group-hover:bg-blue-200 rounded-xl flex items-center justify-center mb-3 transition-colors">
                                <svg class="w-6 h-6 text-blue-600" viewBox="0 0 256 256" fill="currentColor">
                                    <path d="M224,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48Zm0,16V88H32V64Zm0,128H32V104H224v88Z"/>
                                </svg>
                            </div>
                            <p class="font-medium text-gray-900 text-sm">Langganan</p>
                        </a>
                        
                        <a href="{{ route('student.payments.index') }}" 
                           class="group flex flex-col items-center p-6 bg-white rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all text-center">
                            <div class="w-12 h-12 bg-purple-100 group-hover:bg-purple-200 rounded-xl flex items-center justify-center mb-3 transition-colors">
                                <svg class="w-6 h-6 text-purple-600" viewBox="0 0 256 256" fill="currentColor">
                                    <path d="M200,168a48.05,48.05,0,0,1-48,48H136v16a8,8,0,0,1-16,0V216H96a48.05,48.05,0,0,1-48-48,8,8,0,0,1,16,0,32,32,0,0,0,32,32h56a32,32,0,0,0,0-64H100a48,48,0,0,1,0-96h20V24a8,8,0,0,1,16,0V40h12a48.05,48.05,0,0,1,48,48,8,8,0,0,1-16,0,32,32,0,0,0-32-32H100a32,32,0,0,0,0,64h52A48.05,48.05,0,0,1,200,168Z"/>
                                </svg>
                            </div>
                            <p class="font-medium text-gray-900 text-sm">Pembayaran</p>
                        </a>
                        
                        <a href="{{ route('student.infak.index') }}" 
                           class="group flex flex-col items-center p-6 bg-white rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all text-center">
                            <div class="w-12 h-12 bg-rose-100 group-hover:bg-rose-200 rounded-xl flex items-center justify-center mb-3 transition-colors">
                                <svg class="w-6 h-6 text-rose-600" viewBox="0 0 256 256" fill="currentColor">
                                    <path d="M178,32c-20.65,0-38.73,8.88-50,23.89C116.73,40.88,98.65,32,78,32A62.07,62.07,0,0,0,16,94c0,70,103.79,126.66,108.21,129a8,8,0,0,0,7.58,0C136.21,220.66,240,164,240,94A62.07,62.07,0,0,0,178,32Z"/>
                                </svg>
                            </div>
                            <p class="font-medium text-gray-900 text-sm">Infak</p>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
