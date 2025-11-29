<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                📚 {{ __('Kelas Saya') }}
            </h2>
            <p class="text-sm text-gray-600 mt-1">{{ $enrolledClass->name }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Class Header Card --}}
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-lg p-8 mb-8 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="bg-white/20 rounded-full p-3">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold">{{ $enrolledClass->name }}</h3>
                                <p class="text-blue-100 text-sm">{{ $enrolledClass->description }}</p>
                            </div>
                        </div>
                        
                        {{-- Progress Bar --}}
                        <div class="bg-white/10 rounded-full h-3 overflow-hidden mb-2">
                            <div class="bg-white h-full rounded-full transition-all" style="width: {{ $progress }}%"></div>
                        </div>
                        <p class="text-sm text-blue-100">{{ $progress }}% Selesai ({{ $completedCount }}/{{ $totalLessons }} Materi)</p>
                    </div>
                    
                    <div class="flex flex-col gap-3">
                        @if($classActive)
                            <span class="inline-flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded-lg font-semibold">
                                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                Kelas Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 bg-yellow-500 text-white px-4 py-2 rounded-lg font-semibold">
                                ⏸️ Kelas Belum Dibuka
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Class Schedules --}}
            @if($activeSchedules->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        Jadwal Pertemuan
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($activeSchedules as $schedule)
                            <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-xl p-4 border-2 border-blue-100">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="font-bold text-gray-900">{{ $schedule->day_indonesian }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-700">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ date('H:i', strtotime($schedule->time_start)) }} - {{ date('H:i', strtotime($schedule->time_end)) }} WIB</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Lessons Section --}}
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                    </svg>
                    Materi Pembelajaran
                </h4>

                <div class="space-y-4">
                    @foreach($lessons as $lessonData)
                        @php
                            $lesson = $lessonData['lesson'];
                            $status = $lessonData['status'];
                            $isCompleted = $lessonData['isCompleted'];
                            $isCurrent = $lessonData['isCurrent'];
                            $isLocked = $lessonData['isLocked'];
                        @endphp

                        <div class="bg-gradient-to-r {{ $isCompleted ? 'from-green-50 to-emerald-50 border-green-200' : ($isCurrent ? 'from-blue-50 to-indigo-50 border-blue-200' : 'from-gray-50 to-slate-50 border-gray-200') }} border-2 rounded-xl p-5 transition-all hover:shadow-md {{ !$isLocked ? 'cursor-pointer' : 'opacity-60' }}" 
                             onclick="{{ !$isLocked ? "window.location='" . route('student.lessons.show', $lesson) . "'" : '' }}">
                            
                            <div class="flex items-start gap-4">
                                {{-- Status Icon --}}
                                <div class="flex-shrink-0">
                                    @if($isCompleted)
                                        <div class="bg-green-500 rounded-full p-3">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @elseif($isCurrent)
                                        <div class="bg-blue-500 rounded-full p-3">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="bg-gray-300 rounded-full p-3">
                                            <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Lesson Info --}}
                                <div class="flex-1">
                                    <div class="flex items-start justify-between gap-4 mb-2">
                                        <div>
                                            <span class="text-xs font-semibold {{ $isCompleted ? 'text-green-700' : ($isCurrent ? 'text-blue-700' : 'text-gray-500') }} uppercase">
                                                Materi {{ $lesson->order }}
                                            </span>
                                            <h5 class="text-lg font-bold {{ $isCompleted ? 'text-green-900' : ($isCurrent ? 'text-blue-900' : 'text-gray-700') }}">
                                                {{ $lesson->title }}
                                            </h5>
                                        </div>
                                        
                                        @if($isCompleted)
                                            <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap">✓ Selesai</span>
                                        @elseif($isCurrent)
                                            <span class="bg-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap animate-pulse">● Sedang Aktif</span>
                                        @else
                                            <span class="bg-gray-400 text-white text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap">🔒 Terkunci</span>
                                        @endif
                                    </div>
                                    
                                    <p class="text-sm {{ $isLocked ? 'text-gray-500' : 'text-gray-700' }} mb-3">
                                        {{ Str::limit($lesson->description, 100) }}
                                    </p>

                                    @if(!$isLocked)
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('student.lessons.show', $lesson) }}" class="inline-flex items-center gap-2 bg-gradient-to-r {{ $isCompleted ? 'from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700' : 'from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700' }} text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-all">
                                                @if($isCompleted)
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                    </svg>
                                                    Ulangi Materi
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ $isCurrent ? 'Lanjutkan' : 'Mulai Belajar' }}
                                                @endif
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500 italic">
                                            🔒 Selesaikan materi sebelumnya untuk membuka
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
