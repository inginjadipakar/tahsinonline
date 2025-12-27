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

<div class="border-2 border-gray-800 mb-6" style="font-family: 'Courier New', monospace;">
    {{-- Header - Government Style --}}
    <div class="bg-blue-900 text-white px-4 py-3 border-b-4 border-gray-800">
        <div class="font-bold text-sm uppercase">FORMULIR ABSENSI MENGAJAR</div>
        <div class="text-xs mt-0.5">Sistem Informasi Manajemen Pembelajaran - TAHSIN ONLINE</div>
    </div>

    <form action="{{ route('teacher.attendance.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">

        {{-- Section 1: Data Pembelajaran --}}
        <div class="border-b-2 border-gray-800">
            <div class="bg-gray-200 px-4 py-2 border-b border-gray-600">
                <strong class="text-xs uppercase">I. DATA PEMBELAJARAN</strong>
            </div>
            <table class="w-full text-xs border-collapse">
                <tr class="border-b border-gray-400">
                    <td class="px-4 py-2 font-semibold bg-gray-100 border-r border-gray-400" width="200">TANGGAL</td>
                    <td class="px-4 py-2">{{ now()->format('d/m/Y') }}</td>
                    <input type="hidden" name="attendance_date" value="{{ now()->format('Y-m-d') }}">
                </tr>
                <tr class="border-b border-gray-400">
                    <td class="px-4 py-2 font-semibold bg-gray-100 border-r border-gray-400">PERTEMUAN KE</td>
                    <td class="px-4 py-2">{{ $lesson->order }} - {{ $lesson->title }}</td>
                </tr>
                <tr class="border-b border-gray-400">
                    <td class="px-4 py-2 font-semibold bg-gray-100 border-r border-gray-400">KELAS</td>
                    <td class="px-4 py-2">{{ $lesson->tahsinClass->name }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold bg-gray-100 border-r border-gray-400">PENGAJAR</td>
                    <td class="px-4 py-2">{{ auth()->user()->name }} ({{ auth()->user()->phone }})</td>
                </tr>
            </table>
        </div>

        {{-- Section 2: Waktu Pelaksanaan --}}
        <div class="border-b-2 border-gray-800">
            <div class="bg-gray-200 px-4 py-2 border-b border-gray-600">
                <strong class="text-xs uppercase">II. WAKTU PELAKSANAAN PEMBELAJARAN</strong>
            </div>
            <table class="w-full text-xs border-collapse">
                <tr class="border-b border-gray-400">
                    <td class="px-4 py-2 font-semibold bg-gray-100 border-r border-gray-400" width="200">JAM MULAI <span class="text-red-700">*</span></td>
                    <td class="px-4 py-2">
                        <input type="time" name="start_time" id="start_time" required value="{{ old('start_time') }}"
                            class="border-2 border-gray-600 px-2 py-1 w-48 focus:border-blue-900 focus:outline-none">
                        @error('start_time')<div class="text-red-700 text-xs mt-1">{{ $message }}</div>@enderror
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold bg-gray-100 border-r border-gray-400">JAM SELESAI <span class="text-red-700">*</span></td>
                    <td class="px-4 py-2">
                        <input type="time" name="end_time" id="end_time" required value="{{ old('end_time') }}"
                            class="border-2 border-gray-600 px-2 py-1 w-48 focus:border-blue-900 focus:outline-none">
                        @error('end_time')<div class="text-red-700 text-xs mt-1">{{ $message }}</div>@enderror
                    </td>
                </tr>
            </table>
        </div>

        {{-- Section 3: Daftar Peserta --}}
        <div class="border-b-2 border-gray-800">
            <div class="bg-gray-200 px-4 py-2 border-b border-gray-600">
                <strong class="text-xs uppercase">III. DAFTAR PESERTA YANG HADIR <span class="text-red-700">*</span></strong>
            </div>
            <div class="px-4 py-3">
                <table class="w-full border-2 border-gray-800 text-xs">
                    <thead>
                        <tr class="bg-blue-900 text-white">
                            <th class="border border-gray-800 px-3 py-2 text-left" width="50">
                                <input type="checkbox" id="select-all" class="border-gray-800">
                            </th>
                            <th class="border border-gray-800 px-3 py-2 text-left" width="60">NO.</th>
                            <th class="border border-gray-800 px-3 py-2 text-left">NAMA PESERTA</th>
                            <th class="border border-gray-800 px-3 py-2 text-left" width="150">NO. TELEPON</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classStudents as $index => $student)
                            <tr class="hover:bg-gray-100">
                                <td class="border border-gray-600 px-3 py-2 text-center">
                                    <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                        {{ in_array($student->id, old('student_ids', [])) ? 'checked' : '' }}
                                        class="student-checkbox border-gray-800">
                                </td>
                                <td class="border border-gray-600 px-3 py-2 text-center">{{ $index + 1 }}</td>
                                <td class="border border-gray-600 px-3 py-2 font-semibold">{{ strtoupper($student->name) }}</td>
                                <td class="border border-gray-600 px-3 py-2">{{ $student->phone }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="border border-gray-600 px-3 py-4 text-center text-gray-600">
                                    TIDAK ADA DATA PESERTA
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @error('student_ids')<div class="text-red-700 text-xs mt-2">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Section 4: Catatan Pembelajaran --}}
        <div class="border-b-2 border-gray-800">
            <div class="bg-gray-200 px-4 py-2 border-b border-gray-600">
                <strong class="text-xs uppercase">IV. CATATAN AKTIVITAS PEMBELAJARAN <span class="text-red-700">*</span></strong>
            </div>
            <div class="px-4 py-3">
                <textarea name="activity_notes" id="activity_notes" rows="5" required
                    placeholder="Tuliskan aktivitas pembelajaran yang telah dilaksanakan..."
                    class="w-full border-2 border-gray-600 px-3 py-2 text-xs focus:border-blue-900 focus:outline-none" style="font-family: 'Courier New', monospace;">{{ old('activity_notes') }}</textarea>
                @error('activity_notes')<div class="text-red-700 text-xs mt-1">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Section 5: Catatan Peserta --}}
        <div class="border-b-2 border-gray-800">
            <div class="bg-gray-200 px-4 py-2 border-b border-gray-600">
                <strong class="text-xs uppercase">V. CATATAN PENILAIAN PESERTA (Opsional)</strong>
            </div>
            <div class="px-4 py-3">
                <textarea name="student_notes" id="student_notes" rows="4"
                    placeholder="Tuliskan catatan penilaian atau evaluasi terhadap peserta..."
                    class="w-full border-2 border-gray-600 px-3 py-2 text-xs focus:border-blue-900 focus:outline-none" style="font-family: 'Courier New', monospace;">{{ old('student_notes') }}</textarea>
                @error('student_notes')<div class="text-red-700 text-xs mt-1">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Section 6: Dokumentasi --}}
        <div class="border-b-2 border-gray-800">
            <div class="bg-gray-200 px-4 py-2 border-b border-gray-600">
                <strong class="text-xs uppercase">VI. DOKUMENTASI PEMBELAJARAN <span class="text-red-700">*</span></strong>
            </div>
            <div class="px-4 py-3">
                <table class="w-full text-xs border-collapse">
                    <tr>
                        <td class="py-1 font-semibold" width="200">UPLOAD FILE SCREENSHOT</td>
                        <td class="py-1">
                            <input type="file" name="screenshot" id="screenshot" required accept="image/jpeg,image/png,image/jpg"
                                class="border-2 border-gray-600 px-2 py-1 text-xs w-full bg-white">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="py-1 text-xs text-gray-600">
                            Format: JPG/PNG, Maksimal: 5 MB
                            @error('screenshot')<div class="text-red-700 mt-1">{{ $message }}</div>@enderror
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Footer Section --}}
        <div class="bg-gray-100 px-4 py-3 border-t-2 border-gray-800">
            <div class="flex items-center justify-between">
                <div class="text-xs text-gray-700">
                    <span class="text-red-700 font-bold">*</span> = WAJIB DIISI<br>
                    Data akan diverifikasi oleh Administrator
                </div>
                <div class="flex gap-2">
                    <button type="reset" class="border-2 border-gray-700 bg-white hover:bg-gray-200 text-gray-900 px-6 py-2 text-xs font-bold uppercase">
                        BATAL
                    </button>
                    <button type="submit" class="border-2 border-blue-900 bg-blue-900 hover:bg-blue-800 text-white px-6 py-2 text-xs font-bold uppercase">
                        KIRIM DATA
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Select all checkbox
document.getElementById('select-all')?.addEventListener('change', function() {
    document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = this.checked);
});
</script>
