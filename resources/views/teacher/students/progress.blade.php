<x-layouts.teacher>
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <a href="{{ route('teacher.students.index') }}"
                class="text-green-600 hover:text-green-700 text-sm font-medium mb-2 inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <div class="mt-2 flex items-center gap-4">
                <div
                    class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-2xl">
                    {{ substr($student->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $student->name }}</h1>
                    <p class="text-gray-600">{{ $student->phone }}</p>
                </div>
            </div>
        </div>

        {{-- Progress Summary --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Progress</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Materi</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalLessons }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Materi Selesai</p>
                    <p class="text-3xl font-bold text-green-600">{{ $completedCount }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Persentase</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $completionPercentage }}%</p>
                </div>
            </div>

            {{-- Progress Bar --}}
            <div class="mt-6">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-gray-700 font-medium">Progress Keseluruhan</span>
                    <span class="text-gray-900 font-bold">{{ $completionPercentage }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full transition-all"
                        style="width: {{ $completionPercentage }}%"></div>
                </div>
            </div>
        </div>

        {{-- Lessons Progress --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Detail Progress per Materi</h3>
            </div>

            <div class="divide-y divide-gray-200">
                @foreach($lessons as $lessonData)
                    <div
                        class="p-6 flex items-center justify-between {{ $lessonData['is_completed'] ? 'bg-green-50' : 'bg-white' }}">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full flex items-center justify-center {{ $lessonData['is_completed'] ? 'bg-green-600' : 'bg-gray-300' }}">
                                @if($lessonData['is_completed'])
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    <span class="text-white font-bold text-sm">{{ $lessonData['lesson']->order }}</span>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $lessonData['lesson']->title }}</h4>
                                @if($lessonData['lesson']->description)
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ Str::limit($lessonData['lesson']->description, 80) }}</p>
                                @endif
                            </div>
                        </div>
                        <div>
                            @if($lessonData['is_completed'])
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Selesai
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                                    Belum Selesai
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.teacher>