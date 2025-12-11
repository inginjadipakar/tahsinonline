<x-layouts.teacher>
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Siswa Saya</h1>
            <p class="text-gray-600 mt-1">Kelas: {{ $assignedClass->name }}</p>
        </div>

        {{-- Students List --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            @if($students->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                    @foreach($students as $student)
                        <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-lg">
                                    {{ substr($student['student']->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $student['student']->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $student['student']->phone }}</p>
                                </div>
                            </div>

                            {{-- Progress --}}
                            <div class="mb-3">
                                <div class="flex items-center justify-between text-sm mb-1">
                                    <span class="text-gray-600">Progress</span>
                                    <span class="font-semibold text-gray-900">{{ $student['completion_percentage'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full transition-all"
                                        style="width: {{ $student['completion_percentage'] }}%"></div>
                                </div>
                            </div>

                            {{-- Stats --}}
                            <div class="text-sm text-gray-600 mb-4">
                                {{ $student['completed_lessons'] }} / {{ $student['total_lessons'] }} materi selesai
                            </div>

                            {{-- Action --}}
                            <a href="{{ route('teacher.students.show', $student['student']) }}"
                                class="block w-full text-center px-4 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors text-sm font-medium">
                                Lihat Detail Progress
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Siswa</h3>
                    <p class="text-gray-600">Belum ada siswa yang terdaftar di kelas ini</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.teacher>