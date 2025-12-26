<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Absensi Mengajar') }}
            </h2>
            <a href="{{ route('admin.attendances.index') }}" class="inline-flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Header Info --}}
            <div class="bg-white rounded-lg shadow-sm mb-6 p-6 border-l-4 border-blue-500">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">TAHSIN ONLINE - DETAIL ABSENSI MENGAJAR</h3>
                <p class="text-sm text-gray-600">No. Absensi: <span class="font-semibold text-blue-600">{{ $attendance->attendanceNumber }}</span></p>
            </div>

            {{-- Teacher Info --}}
            <div class="bg-white rounded-lg shadow-sm mb-6 p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">INFORMASI PENGAJAR</h4>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Nama</dt>
                        <dd class="text-base font-semibold text-gray-900">{{ $attendance->teacher->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">No. WhatsApp</dt>
                        <dd class="text-base font-semibold text-gray-900">{{ $attendance->teacher->phone }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Email</dt>
                        <dd class="text-base font-semibold text-gray-900">{{ $attendance->teacher->email ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Lesson Detail --}}
            <div class="bg-white rounded-lg shadow-sm mb-6 p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">DETAIL PEMBELAJARAN</h4>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Tanggal</dt>
                        <dd class="text-base font-semibold text-gray-900">{{ $attendance->attendance_date->format('d F Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Kelas</dt>
                        <dd class="text-base font-semibold text-gray-900">{{ $attendance->lesson->tahsinClass->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Pertemuan</dt>
                        <dd class="text-base font-semibold text-gray-900">{{ $attendance->lesson->order }} - {{ $attendance->lesson->title }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Jam Mulai</dt>
                        <dd class="text-base font-semibold text-gray-900">{{ \Carbon\Carbon::parse($attendance->start_time)->format('H:i') }} WIB</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Jam Selesai</dt>
                        <dd class="text-base font-semibold text-gray-900">{{ \Carbon\Carbon::parse($attendance->end_time)->format('H:i') }} WIB</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Durasi</dt>
                        <dd class="text-base font-semibold text-emerald-600">{{ $attendance->duration }} jam</dd>
                    </div>
                </dl>
            </div>

            {{-- Students List --}}
            <div class="bg-white rounded-lg shadow-sm mb-6 p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">DAFTAR MURID HADIR ({{ $attendance->students->count() }} orang)</h4>
                <ol class="list-decimal list-inside space-y-2">
                    @foreach($attendance->students as $student)
                        <li class="text-base text-gray-900">
                            <span class="font-semibold">{{ $student->name }}</span>
                            <span class="text-sm text-gray-600">({{ $student->phone }})</span>
                        </li>
                    @endforeach
                </ol>
            </div>

            {{-- Activity Notes --}}
            <div class="bg-white rounded-lg shadow-sm mb-6 p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">CATATAN AKTIVITAS</h4>
                <div class="prose max-w-none">
                    <p class="text-gray-700 whitespace-pre-line">{{ $attendance->activity_notes }}</p>
                </div>
            </div>

            {{-- Student Notes --}}
            @if($attendance->student_notes)
                <div class="bg-white rounded-lg shadow-sm mb-6 p-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">CATATAN MURID</h4>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-line">{{ $attendance->student_notes }}</p>
                    </div>
                </div>
            @endif

            {{-- Screenshot --}}
            <div class="bg-white rounded-lg shadow-sm mb-6 p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">DOKUMENTASI PEMBELAJARAN</h4>
                <div class="space-y-4">
                    <img src="{{ Storage::url($attendance->screenshot_path) }}" alt="Screenshot" class="w-full rounded-lg border border-gray-200 shadow-md">
                    <a href="{{ Storage::url($attendance->screenshot_path) }}" download class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Download Full Resolution
                    </a>
                </div>
            </div>

            {{-- Status & Actions --}}
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">STATUS & AKSI</h4>
                
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Status Saat Ini:</p>
                    @if($attendance->status === 'pending')
                        <span class="px-4 py-2 inline-flex text-base font-semibold rounded-lg bg-yellow-100 text-yellow-800">
                            🟡 PENDING - Menunggu Persetujuan
                        </span>
                    @elseif($attendance->status === 'approved')
                        <span class="px-4 py-2 inline-flex text-base font-semibold rounded-lg bg-green-100 text-green-800">
                            ✅ APPROVED - Disetujui
                        </span>
                    @else
                        <span class="px-4 py-2 inline-flex text-base font-semibold rounded-lg bg-red-100 text-red-800">
                            ❌ REJECTED - Ditolak
                        </span>
                    @endif
                </div>

                @if($attendance->admin_notes)
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm font-semibold text-red-900 mb-1">Alasan Penolakan:</p>
                        <p class="text-sm text-red-700">{{ $attendance->admin_notes }}</p>
                    </div>
                @endif

                @if($attendance->status === 'pending')
                    <div class="flex gap-3">
                        <form action="{{ route('admin.attendances.approve', $attendance) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition shadow-lg" onclick="return confirm('Setujui absensi ini?')">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Setujui Absensi
                            </button>
                        </form>

                        <button type="button" onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Tolak Absensi
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Tolak Absensi</h3>
                <form action="{{ route('admin.attendances.reject', $attendance) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan *</label>
                        <textarea name="admin_notes" id="admin_notes" rows="4" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Jelaskan alasan penolakan..."></textarea>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition">
                            Tolak
                        </button>
                        <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
