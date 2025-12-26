@props(['lesson'])

@php
    // Get students in this class
    $classStudents = \App\Models\User::where('role', 'student')
        ->whereHas('subscriptions', function($q) use ($lesson) {
            $q->where('tahsin_class_id', $lesson->tahsin_class_id)
              ->where('status', 'active');
        })
        ->orderBy('name')
        ->get();
@endphp

<div class="bg-gradient-to-br from-emerald-50 to-blue-50 rounded-2xl shadow-lg border-2 border-emerald-200 overflow-hidden mb-6">
    <div class="bg-emerald-600 px-6 py-4">
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            📋 ABSENSI MENGAJAR
        </h2>
        <p class="text-emerald-100 text-sm mt-1">Isi absensi setelah selesai mengajar</p>
    </div>

    <form action="{{ route('teacher.attendance.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
        @csrf

        <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">

        {{-- Auto-filled Info --}}
        <div class="bg-white/80 rounded-lg p-4 border border-emerald-200">
            <h3 class="font-semibold text-gray-700 mb-3">Informasi Otomatis</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                <div>
                    <span class="text-gray-600">📅 Tanggal:</span>
                    <span class="font-semibold text-gray-900">{{ now()->format('d M Y') }}</span>
                    <input type="hidden" name="attendance_date" value="{{ now()->format('Y-m-d') }}">
                </div>
                <div>
                    <span class="text-gray-600">📚 Pertemuan:</span>
                    <span class="font-semibold text-gray-900">{{ $lesson->order }} - {{ $lesson->title }}</span>
                </div>
                <div>
                    <span class="text-gray-600">📱 WhatsApp:</span>
                    <span class="font-semibold text-gray-900">{{ auth()->user()->phone }}</span>
                </div>
                <div>
                    <span class="text-gray-600">🏫 Kelas:</span>
                    <span class="font-semibold text-gray-900">{{ $lesson->tahsinClass->name }}</span>
                </div>
            </div>
        </div>

        {{-- Time Input --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">⏰ Jam Mulai *</label>
                <input type="time" name="start_time" id="start_time" required value="{{ old('start_time') }}"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                @error('start_time')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">⏰ Jam Selesai *</label>
                <input type="time" name="end_time" id="end_time" required value="{{ old('end_time') }}"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                @error('end_time')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
        </div>

        {{-- Students Selection --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">👨‍🎓 Murid yang Diajar *</label>
            <div class="bg-white rounded-lg border border-gray-300 p-3 max-h-48 overflow-y-auto">
                @forelse($classStudents as $student)
                    <label class="flex items-center gap-2 p-2 hover:bg-gray-50 rounded cursor-pointer">
                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                            {{ in_array($student->id, old('student_ids', [])) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="text-sm text-gray-900">{{ $student->name }} ({{ $student->phone }})</span>
                    </label>
                @empty
                    <p class="text-sm text-gray-500 text-center py-2">Tidak ada murid terdaftar di kelas ini</p>
                @endforelse
            </div>
            @error('student_ids')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>

        {{-- Activity Notes --}}
        <div>
            <label for="activity_notes" class="block text-sm font-medium text-gray-700 mb-1">📝 Catatan Aktivitas Pembelajaran *</label>
            <textarea name="activity_notes" id="activity_notes" rows="4" required
                placeholder="Contoh: Pengenalan makharijul huruf, praktik huruf halqi, latihan membaca Al-Fatihah..."
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('activity_notes') }}</textarea>
            @error('activity_notes')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>

        {{-- Student Notes --}}
        <div>
            <label for="student_notes" class="block text-sm font-medium text-gray-700 mb-1">📝 Catatan Murid (Opsional)</label>
            <textarea name="student_notes" id="student_notes" rows="3"
                placeholder="Contoh: Ahmad dan Fatimah sudah cukup baik, Umar perlu latihan lagi..."
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('student_notes') }}</textarea>
            @error('student_notes')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>

        {{-- Screenshot Upload --}}
        <div>
            <label for="screenshot" class="block text-sm font-medium text-gray-700 mb-1">📸 Upload Screenshot Pembelajaran *</label>
            <input type="file" name="screenshot" id="screenshot" required accept="image/jpeg,image/png,image/jpg"
                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
            <p class="text-xs text-gray-500 mt-1">Max 5MB. Format: JPG, PNG</p>
            @error('screenshot')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>

        {{-- Submit Button --}}
        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl transition-colors shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Kirim Absensi
            </button>
            <button type="reset" class="inline-flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                Reset
            </button>
        </div>

        <p class="text-xs text-gray-500 italic">* Field wajib diisi. Absensi akan diverifikasi oleh admin.</p>
    </form>
</div>
