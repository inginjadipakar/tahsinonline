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

<div class="border-2 border-gray-800 mb-4" style="font-family: 'Courier New', monospace; font-size: 11px;">
    {{-- Header - Compact --}}
    <div class="bg-blue-900 text-white px-3 py-1.5 border-b-2 border-gray-800">
        <div class="font-bold text-xs uppercase">FORMULIR ABSENSI MENGAJAR</div>
        <div class="text-[10px]">Sistem Informasi Manajemen Pembelajaran - TAHSIN ONLINE</div>
    </div>

    <form action="{{ route('teacher.attendance.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">

        {{-- Section 1: Data Pembelajaran - Compact --}}
        <div class="border-b border-gray-600">
            <div class="bg-gray-200 px-3 py-1 border-b border-gray-500">
                <strong class="text-[10px] uppercase">I. DATA PEMBELAJARAN</strong>
            </div>
            <table class="w-full text-[10px] border-collapse">
                <tr class="border-b border-gray-300">
                    <td class="px-3 py-1 font-semibold bg-gray-100 border-r border-gray-400" width="180">TANGGAL</td>
                    <td class="px-3 py-1">{{ now()->format('d/m/Y') }}</td>
                    <input type="hidden" name="attendance_date" value="{{ now()->format('Y-m-d') }}">
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-3 py-1 font-semibold bg-gray-100 border-r border-gray-400">PERTEMUAN</td>
                    <td class="px-3 py-1">{{ $lesson->order }} - {{ $lesson->title }}</td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-3 py-1 font-semibold bg-gray-100 border-r border-gray-400">KELAS</td>
                    <td class="px-3 py-1">{{ $lesson->tahsinClass->name }}</td>
                </tr>
                <tr>
                    <td class="px-3 py-1 font-semibold bg-gray-100 border-r border-gray-400">PENGAJAR</td>
                    <td class="px-3 py-1">{{ auth()->user()->name }} ({{ auth()->user()->phone }})</td>
                </tr>
            </table>
        </div>

        {{-- Section 2: Waktu - Inline --}}
        <div class="border-b border-gray-600">
            <div class="bg-gray-200 px-3 py-1 border-b border-gray-500">
                <strong class="text-[10px] uppercase">II. WAKTU PEMBELAJARAN</strong>
            </div>
            <div class="px-3 py-1.5 flex gap-6">
                <div class="flex items-center gap-2">
                    <label class="font-semibold text-[10px]">JAM MULAI <span class="text-red-700">*</span></label>
                    <input type="time" name="start_time" required value="{{ old('start_time') }}"
                        class="border border-gray-600 px-2 py-0.5 text-[10px] w-28 focus:border-blue-900 focus:outline-none">
                    @error('start_time')<span class="text-red-700 text-[9px]">{{ $message }}</span>@enderror
                </div>
                <div class="flex items-center gap-2">
                    <label class="font-semibold text-[10px]">JAM SELESAI <span class="text-red-700">*</span></label>
                    <input type="time" name="end_time" required value="{{ old('end_time') }}"
                        class="border border-gray-600 px-2 py-0.5 text-[10px] w-28 focus:border-blue-900 focus:outline-none">
                    @error('end_time')<span class="text-red-700 text-[9px]">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        {{-- Section 3: Daftar Peserta - Compact Table --}}
        <div class="border-b border-gray-600">
            <div class="bg-gray-200 px-3 py-1 border-b border-gray-500">
                <strong class="text-[10px] uppercase">III. DAFTAR PESERTA HADIR <span class="text-red-700">*</span></strong>
            </div>
            <div class="px-2 py-1.5">
                <div class="border border-gray-700 max-h-36 overflow-y-auto">
                    <table class="w-full text-[10px]">
                        <thead class="sticky top-0 bg-blue-900 text-white">
                            <tr>
                                <th class="border-r border-gray-700 px-2 py-1" width="30">
                                    <input type="checkbox" id="select-all" class="w-3 h-3">
                                </th>
                                <th class="border-r border-gray-700 px-2 py-1 text-left" width="35">NO</th>
                                <th class="border-r border-gray-700 px-2 py-1 text-left">NAMA PESERTA</th>
                                <th class="px-2 py-1 text-left" width="110">TELP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classStudents as $index => $student)
                                <tr class="border-t border-gray-400 hover:bg-gray-50">
                                    <td class="border-r border-gray-400 px-2 py-0.5 text-center">
                                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                            {{ in_array($student->id, old('student_ids', [])) ? 'checked' : '' }}
                                            class="student-checkbox w-3 h-3">
                                    </td>
                                    <td class="border-r border-gray-400 px-2 py-0.5 text-center">{{ $index + 1 }}</td>
                                    <td class="border-r border-gray-400 px-2 py-0.5 font-semibold">{{ strtoupper($student->name) }}</td>
                                    <td class="px-2 py-0.5">{{ $student->phone }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-2 py-2 text-center text-gray-600">TIDAK ADA DATA</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @error('student_ids')<div class="text-red-700 text-[9px] mt-1">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Section 4 & 5: Catatan - Side by Side --}}
        <div class="border-b border-gray-600 grid grid-cols-2 gap-0">
            <div class="border-r border-gray-600">
                <div class="bg-gray-200 px-3 py-1 border-b border-gray-500">
                    <strong class="text-[10px] uppercase">IV. CATATAN AKTIVITAS <span class="text-red-700">*</span></strong>
                </div>
                <div class="px-2 py-1.5">
                    <textarea name="activity_notes" required rows="3" placeholder="Aktivitas pembelajaran..."
                        class="w-full border border-gray-600 px-2 py-1 text-[10px] focus:border-blue-900 focus:outline-none resize-none" 
                        style="font-family: 'Courier New', monospace;">{{ old('activity_notes') }}</textarea>
                    @error('activity_notes')<div class="text-red-700 text-[9px]">{{ $message }}</div>@enderror
                </div>
            </div>
            <div>
                <div class="bg-gray-200 px-3 py-1 border-b border-gray-500">
                    <strong class="text-[10px] uppercase">V. CATATAN PENILAIAN (Opsional)</strong>
                </div>
                <div class="px-2 py-1.5">
                    <textarea name="student_notes" rows="3" placeholder="Penilaian peserta..."
                        class="w-full border border-gray-600 px-2 py-1 text-[10px] focus:border-blue-900 focus:outline-none resize-none" 
                        style="font-family: 'Courier New', monospace;">{{ old('student_notes') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Section 6: Upload - Inline --}}
        <div class="border-b border-gray-600">
            <div class="bg-gray-200 px-3 py-1 border-b border-gray-500">
                <strong class="text-[10px] uppercase">VI. DOKUMENTASI <span class="text-red-700">*</span></strong>
            </div>
            <div class="px-3 py-1.5 flex items-center gap-3">
                <label class="font-semibold text-[10px] whitespace-nowrap">UPLOAD SCREENSHOT:</label>
                <input type="file" name="screenshot" required accept="image/jpeg,image/png,image/jpg"
                    class="border border-gray-600 px-2 py-0.5 text-[10px] flex-1 bg-white">
                <span class="text-[9px] text-gray-600 whitespace-nowrap">JPG/PNG, Max 5MB</span>
                @error('screenshot')<span class="text-red-700 text-[9px]">{{ $message }}</span>@enderror
            </div>
        </div>

        {{-- Footer - Compact --}}
        <div class="bg-gray-100 px-3 py-1.5 flex items-center justify-between">
            <div class="text-[9px] text-gray-700">
                <span class="text-red-700 font-bold">*</span> WAJIB DIISI | Data akan diverifikasi Administrator
            </div>
            <div class="flex gap-2">
                <button type="reset" class="border border-gray-700 bg-white hover:bg-gray-200 text-gray-900 px-4 py-1 text-[10px] font-bold uppercase">
                    BATAL
                </button>
                <button type="submit" class="border border-blue-900 bg-blue-900 hover:bg-blue-800 text-white px-4 py-1 text-[10px] font-bold uppercase">
                    KIRIM DATA
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('select-all')?.addEventListener('change', function() {
    document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = this.checked);
});
</script>
