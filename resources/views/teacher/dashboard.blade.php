<x-layouts.teacher>
    <div class="space-y-8">
        @if(!$hasClass)
            {{-- No Class Assigned - Notion Style Alert --}}
            <div class="bg-amber-50/50 border border-amber-100 rounded-xl p-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-amber-600" viewBox="0 0 256 256" fill="currentColor">
                            <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm-8-80V80a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,172Z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-amber-900 text-base">Belum Ada Kelas yang Ditugaskan</h3>
                        <p class="text-sm text-amber-700 mt-1 leading-relaxed">{{ $message }}</p>
                    </div>
                </div>
            </div>
        @else
            {{-- Welcome Header - Notion Style --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Selamat datang kembali,</p>
                    <h1 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h1>
                </div>
                
                {{-- Class Switcher - Notion Style Dropdown --}}
                @if(isset($teacherClasses) && $teacherClasses->count() > 1)
                    <form action="{{ route('teacher.switch-class') }}" method="POST">
                        @csrf
                        <select name="class_id" id="class_id" onchange="this.form.submit()"
                            class="px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-gray-300 focus:border-gray-400 focus:ring-0 transition-colors cursor-pointer min-w-[200px]">
                            @foreach($teacherClasses as $class)
                                <option value="{{ $class->id }}" {{ $class->id == $assignedClass->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </div>

            {{-- Current Class Card - Notion Style --}}
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 text-emerald-100 text-sm mb-2">
                        <svg class="w-4 h-4" viewBox="0 0 256 256" fill="currentColor">
                            <path d="M251.76,88.94l-120-64a8,8,0,0,0-7.52,0l-120,64a8,8,0,0,0,0,14.12L32,117.87v48.42a15.91,15.91,0,0,0,4.06,10.65C49.16,191.53,78.51,216,128,216a130,130,0,0,0,48-8.76V240a8,8,0,0,0,16,0V199.51a115.63,115.63,0,0,0,27.94-22.57A15.91,15.91,0,0,0,224,166.29V117.87l27.76-14.81a8,8,0,0,0,0-14.12Z"/>
                        </svg>
                        <span class="font-medium">Kelas yang Anda Ajar</span>
                    </div>
                    <h2 class="text-3xl font-bold">{{ $assignedClass->name }}</h2>
                </div>
            </div>

            {{-- Statistics Grid - Notion Style Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Total Students --}}
                <div class="group bg-white rounded-xl p-6 border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalStudents }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-50 group-hover:bg-blue-100 rounded-xl flex items-center justify-center transition-colors">
                            <svg class="w-6 h-6 text-blue-600" viewBox="0 0 256 256" fill="currentColor">
                                <path d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total Materials --}}
                <div class="group bg-white rounded-xl p-6 border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Materi</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalMaterials }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-50 group-hover:bg-purple-100 rounded-xl flex items-center justify-center transition-colors">
                            <svg class="w-6 h-6 text-purple-600" viewBox="0 0 256 256" fill="currentColor">
                                <path d="M232,48H160a40,40,0,0,0-32,16A40,40,0,0,0,96,48H24a8,8,0,0,0-8,8V200a8,8,0,0,0,8,8H96a24,24,0,0,1,24,24,8,8,0,0,0,16,0,24,24,0,0,1,24-24h72a8,8,0,0,0,8-8V56A8,8,0,0,0,232,48ZM96,192H32V64H96a24,24,0,0,1,24,24V200A39.81,39.81,0,0,0,96,192Zm128,0H160a39.81,39.81,0,0,0-24,8V88a24,24,0,0,1,24-24h64Z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Completion Rate --}}
                <div class="group bg-white rounded-xl p-6 border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Rata-rata Progress</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $avgCompletionRate }}%</p>
                        </div>
                        <div class="w-12 h-12 bg-emerald-50 group-hover:bg-emerald-100 rounded-xl flex items-center justify-center transition-colors">
                            <svg class="w-6 h-6 text-emerald-600" viewBox="0 0 256 256" fill="currentColor">
                                <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm45.66,85.66-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35a8,8,0,0,1,11.32,11.32Z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions - Notion Style --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <a href="{{ route('teacher.lessons.create') }}"
                        class="group flex items-center gap-4 p-4 bg-white rounded-xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/50 transition-all duration-200">
                        <div class="w-10 h-10 bg-emerald-100 group-hover:bg-emerald-200 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5 text-emerald-600" viewBox="0 0 256 256" fill="currentColor">
                                <path d="M228,128a12,12,0,0,1-12,12H140v76a12,12,0,0,1-24,0V140H40a12,12,0,0,1,0-24h76V40a12,12,0,0,1,24,0v76h76A12,12,0,0,1,228,128Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 group-hover:text-emerald-700 transition-colors">Upload Materi</p>
                            <p class="text-xs text-gray-500">Tambah materi baru</p>
                        </div>
                    </a>

                    <a href="{{ route('teacher.students.index') }}"
                        class="group flex items-center gap-4 p-4 bg-white rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all duration-200">
                        <div class="w-10 h-10 bg-blue-100 group-hover:bg-blue-200 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5 text-blue-600" viewBox="0 0 256 256" fill="currentColor">
                                <path d="M232,208a8,8,0,0,1-8,8H32a8,8,0,0,1-8-8V48a8,8,0,0,1,16,0v94.37L90.73,98a8,8,0,0,1,10.07-.38l58.81,44.11L218.73,90a8,8,0,1,1,10.54,12.06l-64,56a8,8,0,0,1-10.07.38L96.39,114.29,40,163.63V200H224A8,8,0,0,1,232,208Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 group-hover:text-blue-700 transition-colors">Lihat Progress</p>
                            <p class="text-xs text-gray-500">Progress siswa</p>
                        </div>
                    </a>

                    <a href="{{ route('teacher.lessons.index') }}"
                        class="group flex items-center gap-4 p-4 bg-white rounded-xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50/50 transition-all duration-200">
                        <div class="w-10 h-10 bg-purple-100 group-hover:bg-purple-200 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5 text-purple-600" viewBox="0 0 256 256" fill="currentColor">
                                <path d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 group-hover:text-purple-700 transition-colors">Kelola Materi</p>
                            <p class="text-xs text-gray-500">Lihat semua materi</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Two Column Layout for Lists --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Recent Materials - Notion Style --}}
                @if($recentMaterials->count() > 0)
                    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-900">Materi Terbaru</h3>
                        </div>
                        <div class="divide-y divide-gray-50">
                            @foreach($recentMaterials as $material)
                                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/50 transition-colors">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-9 h-9 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-emerald-600" viewBox="0 0 256 256" fill="currentColor">
                                                <path d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z"/>
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-medium text-gray-900 truncate">{{ $material->title }}</p>
                                            <p class="text-xs text-gray-500">{{ $material->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('teacher.lessons.edit', $material) }}"
                                        class="text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors flex-shrink-0 ml-4">
                                        Edit
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Recent Activities - Notion Style --}}
                @if($recentActivities->count() > 0)
                    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-900">Aktivitas Siswa Terbaru</h3>
                        </div>
                        <div class="divide-y divide-gray-50">
                            @foreach($recentActivities as $activity)
                                <div class="px-6 py-4 flex items-center gap-3 hover:bg-gray-50/50 transition-colors">
                                    <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                        {{ strtoupper(substr($activity->user->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm text-gray-900">
                                            <span class="font-medium">{{ $activity->user->name }}</span>
                                            <span class="text-gray-500">menyelesaikan</span>
                                            <span class="font-medium">{{ Str::limit($activity->lesson->title, 30) }}</span>
                                        </p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $activity->updated_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-layouts.teacher>