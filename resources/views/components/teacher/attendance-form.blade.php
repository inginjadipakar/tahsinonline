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

<div class="bg-white border border-gray-200 shadow-sm mb-6">
    {{-- Header --}}
    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
        <h2 class="text-lg font-semibold text-gray-900">Formulir Absensi Mengajar</h2>
        <p class="text-sm text-gray-600 mt-1">Isi absensi setelah selesai mengajar</p>
    </div>

    <form action="{{ route('teacher.attendance.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">

        {{-- Auto-filled Info --}}
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Informasi Pembelajaran</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 text-sm bg-gray-50 p-4 border border-gray-200">
                <div class="flex justify-between">
                    <span class="text-gray-600">Tanggal</span>
                    <span class="font-medium text-gray-900">{{ now()->format('d M Y') }}</span>
                    <input type="hidden" name="attendance_date" value="{{ now()->format('Y-m-d') }}">
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Pertemuan</span>
                    <span class="font-medium text-gray-900">{{ $lesson->order }} - {{ $lesson->title }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">WhatsApp</span>
                    <span class="font-medium text-gray-900">{{ auth()->user()->phone }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Kelas</span>
                    <span class="font-medium text-gray-900">{{ $lesson->tahsinClass->name }}</span>
                </div>
            </div>
        </div>

        {{-- Time Input --}}
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Waktu Mengajar</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1.5">Jam Mulai <span class="text-red-500">*</span></label>
                    <input type="time" name="start_time" id="start_time" required value="{{ old('start_time') }}"
                        class="w-full px-3 py-2 border border-gray-300 focus:border-gray-500 focus:ring-1 focus:ring-gray-500">
                    @error('start_time')<span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1.5">Jam Selesai <span class="text-red-500">*</span></label>
                    <input type="time" name="end_time" id="end_time" required value="{{ old('end_time') }}"
                        class="w-full px-3 py-2 border border-gray-300 focus:border-gray-500 focus:ring-1 focus:ring-gray-500">
                    @error('end_time')<span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        {{-- Students Selection --}}
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Murid yang Diajar <span class="text-red-500">*</span></h3>
            <div class="border border-gray-200 bg-white max-h-56 overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th class="w-12 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                <input type="checkbox" id="select-all" class="border-gray-300">
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Murid</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">WhatsApp</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($classStudents as $student)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                        {{ in_array($student->id, old('student_ids', [])) ? 'checked' : '' }}
                                        class="student-checkbox border-gray-300">
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-900">{{ $student->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $student->phone }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-4 py-4 text-sm text-gray-500 text-center">Tidak ada murid terdaftar</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @error('student_ids')<span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>@enderror
        </div>

        {{-- Activity Notes --}}
        <div class="mb-6">
            <label for="activity_notes" class="block text-sm font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">Catatan Aktivitas Pembelajaran <span class="text-red-500">*</span></label>
            <textarea name="activity_notes" id="activity_notes" rows="4" required
                placeholder="Contoh: Pengenalan makharijul huruf, praktik huruf halqi, latihan membaca Al-Fatihah..."
                class="w-full px-3 py-2 border border-gray-300 focus:border-gray-500 focus:ring-1 focus:ring-gray-500">{{ old('activity_notes') }}</textarea>
            @error('activity_notes')<span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>@enderror
        </div>

        {{-- Student Notes --}}
        <div class="mb-6">
            <label for="student_notes" class="block text-sm font-medium text-gray-700 mb-1.5">Catatan Murid (Opsional)</label>
            <textarea name="student_notes" id="student_notes" rows="3"
                placeholder="Contoh: Ahmad dan Fatimah sudah cukup baik, Umar perlu latihan lagi..."
                class="w-full px-3 py-2 border border-gray-300 focus:border-gray-500 focus:ring-1 focus:ring-gray-500">{{ old('student_notes') }}</textarea>
            @error('student_notes')<span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>@enderror
        </div>

        {{-- Screenshot Upload --}}
        <div class="mb-6">
            <label for="screenshot" class="block text-sm font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">Upload Screenshot Pembelajaran <span class="text-red-500">*</span></label>
            <input type="file" name="screenshot" id="screenshot" required accept="image/jpeg,image/png,image/jpg"
                class="w-full px-3 py-2 border border-gray-300 text-sm file:mr-3 file:py-1 file:px-3 file:border-0 file:bg-gray-100 file:text-gray-700 file:font-medium hover:file:bg-gray-200">
            <p class="text-xs text-gray-500 mt-1">Maksimal 5MB. Format: JPG, PNG</p>
            @error('screenshot')<span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>@enderror
        </div>

        {{-- Submit Button --}}
        <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
            <button type="submit" class="px-6 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium transition-colors">
                Kirim Absensi
            </button>
            <button type="reset" class="px-6 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium transition-colors">
                Reset
            </button>
            <span class="text-xs text-gray-500 ml-auto">* Wajib diisi</span>
        </div>
    </form>
</div>

<script>
// Select all checkbox functionality
document.getElementById('select-all')?.addEventListener('change', function() {
    document.querySelectorAll('.student-checkbox').forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>
