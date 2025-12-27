<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-lg text-gray-800">
                {{ __('LAPORAN ABSENSI MENGAJAR') }}
            </h2>
            <a href="{{ route('admin.attendances.export', request()->query()) }}" 
               class="inline-flex items-center gap-1 bg-green-700 hover:bg-green-800 text-white text-xs font-bold py-1.5 px-3 border border-green-900">
                Export Excel
            </a>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto px-4">
            
            {{-- Statistics Cards - Compact --}}
            <div class="grid grid-cols-5 gap-2 mb-3">
                <div class="bg-white border-l-2 border-blue-700 p-2">
                    <p class="text-[10px] text-gray-600 uppercase font-semibold">Total</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white border-l-2 border-yellow-600 p-2">
                    <p class="text-[10px] text-gray-600 uppercase font-semibold">Pending</p>
                    <p class="text-xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                </div>
                <div class="bg-white border-l-2 border-green-700 p-2">
                    <p class="text-[10px] text-gray-600 uppercase font-semibold">Approved</p>
                    <p class="text-xl font-bold text-green-700">{{ $stats['approved'] }}</p>
                </div>
                <div class="bg-white border-l-2 border-red-700 p-2">
                    <p class="text-[10px] text-gray-600 uppercase font-semibold">Rejected</p>
                    <p class="text-xl font-bold text-red-700">{{ $stats['rejected'] }}</p>
                </div>
                <div class="bg-white border-l-2 border-emerald-700 p-2">
                    <p class="text-[10px] text-gray-600 uppercase font-semibold">Total Jam</p>
                    <p class="text-xl font-bold text-emerald-700">{{ number_format($stats['total_hours'], 1) }}</p>
                </div>
            </div>

            {{-- Filters - Compact --}}
            <div class="bg-white border border-gray-300 mb-3 p-3">
                <form method="GET" action="{{ route('admin.attendances.index') }}">
                    <div class="grid grid-cols-5 gap-2 mb-2">
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-700 mb-0.5 uppercase">Pengajar</label>
                            <select name="teacher_id" class="w-full border-gray-400 text-xs py-1 px-2">
                                <option value="">Semua Pengajar</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-semibold text-gray-700 mb-0.5 uppercase">Kelas</label>
                            <select name="class_id" class="w-full border-gray-400 text-xs py-1 px-2">
                                <option value="">Semua Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-semibold text-gray-700 mb-0.5 uppercase">Status</label>
                            <select name="status" class="w-full border-gray-400 text-xs py-1 px-2">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-semibold text-gray-700 mb-0.5 uppercase">Dari Tanggal</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border-gray-400 text-xs py-1 px-2">
                        </div>

                        <div>
                            <label class="block text-[10px] font-semibold text-gray-700 mb-0.5 uppercase">Sampai Tanggal</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border-gray-400 text-xs py-1 px-2">
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white text-xs font-bold py-1 px-3 border border-blue-900 uppercase">
                            Filter
                        </button>
                        <a href="{{ route('admin.attendances.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white text-xs font-bold py-1 px-3 border border-gray-800 uppercase">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Table - Compact --}}
            <div class="bg-white border border-gray-300 overflow-hidden">
                @if($attendances->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-[10px]" style="font-family: 'Courier New', monospace;">
                            <thead class="bg-blue-900 text-white">
                                <tr>
                                    <th class="border-r border-gray-700 px-2 py-1 text-left uppercase">Tanggal</th>
                                    <th class="border-r border-gray-700 px-2 py-1 text-left uppercase">Pengajar</th>
                                    <th class="border-r border-gray-700 px-2 py-1 text-left uppercase">Kelas</th>
                                    <th class="border-r border-gray-700 px-2 py-1 text-left uppercase">P</th>
                                    <th class="border-r border-gray-700 px-2 py-1 text-left uppercase">Murid</th>
                                    <th class="border-r border-gray-700 px-2 py-1 text-left uppercase">Jam</th>
                                    <th class="border-r border-gray-700 px-2 py-1 text-left uppercase">Status</th>
                                    <th class="px-2 py-1 text-right uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                    <tr class="border-t border-gray-300 hover:bg-gray-50">
                                        <td class="border-r border-gray-300 px-2 py-1 whitespace-nowrap">
                                            {{ $attendance->attendance_date->format('d/m/Y') }}
                                        </td>
                                        <td class="border-r border-gray-300 px-2 py-1 font-semibold">
                                            {{ $attendance->teacher->name }}
                                        </td>
                                        <td class="border-r border-gray-300 px-2 py-1">
                                            {{ $attendance->lesson->tahsinClass->name }}
                                        </td>
                                        <td class="border-r border-gray-300 px-2 py-1 text-center">
                                            {{ $attendance->lesson->order }}
                                        </td>
                                        <td class="border-r border-gray-300 px-2 py-1 text-center">
                                            {{ $attendance->students->count() }}
                                        </td>
                                        <td class="border-r border-gray-300 px-2 py-1 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($attendance->start_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($attendance->end_time)->format('H:i') }}
                                            <span class="text-[9px] text-gray-500">({{ $attendance->duration }}h)</span>
                                        </td>
                                        <td class="border-r border-gray-300 px-2 py-1">
                                            @if($attendance->status === 'pending')
                                                <span class="px-1.5 py-0.5 text-[9px] font-bold bg-yellow-200 text-yellow-900 uppercase">Pending</span>
                                            @elseif($attendance->status === 'approved')
                                                <span class="px-1.5 py-0.5 text-[9px] font-bold bg-green-200 text-green-900 uppercase">Approved</span>
                                            @else
                                                <span class="px-1.5 py-0.5 text-[9px] font-bold bg-red-200 text-red-900 uppercase">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="px-2 py-1 text-right whitespace-nowrap">
                                            <a href="{{ route('admin.attendances.show', $attendance) }}" class="text-blue-700 hover:text-blue-900 font-bold mr-2">Detail</a>
                                            @if($attendance->status === 'pending')
                                                <form action="{{ route('admin.attendances.approve', $attendance) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-700 hover:text-green-900 font-bold" onclick="return confirm('Setujui absensi ini?')">
                                                        Approve
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-3 py-2 bg-gray-50 border-t border-gray-300 text-xs">
                        {{ $attendances->links() }}
                    </div>
                @else
                    <div class="p-8 text-center">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Tidak Ada Data</h3>
                        <p class="text-xs text-gray-600">Belum ada absensi mengajar yang tercatat.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
