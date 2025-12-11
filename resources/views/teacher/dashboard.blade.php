<x-layouts.teacher>
    <div class="space-y-6">
        @if(!$hasClass)
            {{-- No Class Assigned --}}
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <h3 class="font-bold text-yellow-900">Belum Ada Kelas</h3>
                        <p class="text-sm text-yellow-700">{{ $message }}</p>
                    </div>
                </div>
            </div>
        @else
            {{-- Class Switcher --}}
            @if(isset($teacherClasses) && $teacherClasses->count() > 1)
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-6">
                    <form action="{{ route('teacher.switch-class') }}" method="POST" class="flex items-center gap-4">
                        @csrf
                        <label for="class_id" class="font-medium text-gray-700">Pilih Kelas:</label>
                        <select name="class_id" id="class_id" onchange="this.form.submit()"
                            class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 py-2">
                            @foreach($teacherClasses as $class)
                                <option value="{{ $class->id }}" {{ $class->id == $assignedClass->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            @endif

            {{-- Class Info --}}
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">Kelas yang Anda Ajar</p>
                        <h2 class="text-2xl font-bold mt-1">{{ $assignedClass->name }}</h2>
                    </div>
                    <svg class="w-16 h-16 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                    </svg>
                </div>
            </div>

            {{-- Statistics --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Siswa</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalStudents }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Materi</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalMaterials }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Avg Completion</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $avgCompletionRate }}%</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('teacher.lessons.create') }}"
                        class="flex items-center gap-3 p-4 border-2 border-green-200 rounded-xl hover:bg-green-50 transition-colors">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Upload Materi</p>
                            <p class="text-xs text-gray-600">Tambah materi baru</p>
                        </div>
                    </a>

                    <a href="{{ route('teacher.students.index') }}"
                        class="flex items-center gap-3 p-4 border-2 border-blue-200 rounded-xl hover:bg-blue-50 transition-colors">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Lihat Progress</p>
                            <p class="text-xs text-gray-600">Progress siswa</p>
                        </div>
                    </a>

                    <a href="{{ route('teacher.lessons.index') }}"
                        class="flex items-center gap-3 p-4 border-2 border-purple-200 rounded-xl hover:bg-purple-50 transition-colors">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Kelola Materi</p>
                            <p class="text-xs text-gray-600">Lihat semua materi</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Recent Materials --}}
            @if($recentMaterials->count() > 0)
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Materi Terbaru</h3>
                    <div class="space-y-3">
                        @foreach($recentMaterials as $material)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        @if($material->hasFile())
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $material->title }}</p>
                                        <p class="text-sm text-gray-600">{{ $material->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('teacher.lessons.edit', $material) }}"
                                    class="text-green-600 hover:text-green-700 text-sm font-medium">Edit</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Recent Activities --}}
            @if($recentActivities->count() > 0)
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Aktivitas Siswa Terbaru</h3>
                    <div class="space-y-3">
                        @foreach($recentActivities as $activity)
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                <div
                                    class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm">
                                    {{ substr($activity->user->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900">
                                        <span class="font-semibold">{{ $activity->user->name }}</span> menyelesaikan
                                        <span class="font-semibold">"{{ $activity->lesson->title }}"</span>
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $activity->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>
</x-layouts.teacher>