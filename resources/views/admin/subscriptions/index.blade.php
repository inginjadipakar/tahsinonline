<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Kelola Subscriptions
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola langganan dan assign guru ke siswa</p>
            </div>
            <a href="{{ route('admin.subscriptions.create') }}" class="inline-flex items-center gap-2 bg-islamic-emerald hover:bg-islamic-emerald-dark text-white font-medium py-2.5 px-5 rounded-lg shadow-sm hover:shadow transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Subscription
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Stats Overview --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $subscriptions->total() }}</p>
                            <p class="text-xs text-gray-500">Total Siswa</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $subscriptions->where('status', 'active')->count() }}</p>
                            <p class="text-xs text-gray-500">Aktif</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $subscriptions->where('status', 'pending')->count() }}</p>
                            <p class="text-xs text-gray-500">Pending</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $subscriptions->whereNull('assigned_teacher_id')->count() }}</p>
                            <p class="text-xs text-gray-500">Belum Ada Guru</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Subscriptions Table --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">Daftar Subscription</h3>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500">Filter:</span>
                        <select class="text-sm border-gray-200 rounded-lg" onchange="window.location.href=this.value">
                            <option value="{{ route('admin.subscriptions.index') }}" {{ !request('filter') ? 'selected' : '' }}>Semua</option>
                            <option value="{{ route('admin.subscriptions.index', ['filter' => 'no_teacher']) }}" {{ request('filter') === 'no_teacher' ? 'selected' : '' }}>Belum Ada Guru</option>
                            <option value="{{ route('admin.subscriptions.index', ['filter' => 'active']) }}" {{ request('filter') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="{{ route('admin.subscriptions.index', ['filter' => 'pending']) }}" {{ request('filter') === 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                </div>
                
                @if($subscriptions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-3">Siswa</th>
                                <th class="px-6 py-3">Kelas</th>
                                <th class="px-6 py-3">Guru</th>
                                <th class="px-6 py-3">Periode</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($subscriptions as $subscription)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-islamic-emerald/10 flex items-center justify-center text-islamic-emerald font-bold">
                                            {{ strtoupper(substr($subscription->user?->name ?? '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $subscription->user?->name ?? 'User Deleted' }}</p>
                                            <p class="text-xs text-gray-500">{{ $subscription->user?->phone }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-700">{{ $subscription->tahsinClass?->name ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($subscription->assignedTeacher)
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 text-sm font-bold">
                                                {{ strtoupper(substr($subscription->assignedTeacher->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $subscription->assignedTeacher->name }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <button 
                                            type="button"
                                            onclick="openAssignModal({{ $subscription->id }}, '{{ $subscription->user?->name }}', {{ $subscription->tahsin_class_id ?? 'null' }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 text-sm font-medium rounded-lg hover:bg-amber-100 transition-colors"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                            </svg>
                                            Assign Guru
                                        </button>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        <p class="text-gray-700">{{ $subscription->start_date?->format('d M Y') }}</p>
                                        <p class="text-gray-500">s/d {{ $subscription->end_date?->format('d M Y') }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClasses = [
                                            'active' => 'bg-green-50 text-green-700',
                                            'pending' => 'bg-amber-50 text-amber-700',
                                            'expired' => 'bg-gray-100 text-gray-600',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClasses[$subscription->status] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.subscriptions.edit', $subscription) }}" title="Edit" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.subscriptions.destroy', $subscription) }}" method="POST" class="inline" onsubmit="return confirm('Hapus subscription ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="px-6 py-16 text-center">
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-gray-900 font-semibold mb-1">Belum ada subscription</h3>
                        <p class="text-gray-500 text-sm mb-6">Tambahkan subscription baru untuk siswa</p>
                        <a href="{{ route('admin.subscriptions.create') }}" class="inline-flex items-center gap-2 bg-islamic-emerald hover:bg-islamic-emerald-dark text-white font-medium px-5 py-2.5 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Subscription
                        </a>
                    </div>
                @endif

                @if($subscriptions->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $subscriptions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Assign Teacher Modal --}}
    <div id="assignModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900/50 transition-opacity" onclick="closeAssignModal()"></div>
            
            <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6 transform transition-all">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Assign Guru</h3>
                    <button onclick="closeAssignModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form id="assignForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Siswa</label>
                        <p id="studentName" class="text-gray-900 font-semibold">-</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Guru</label>
                        <div id="teacherSuggestions" class="space-y-2 mb-3">
                            <p class="text-sm text-gray-500 italic">Memuat saran guru...</p>
                        </div>
                        <select name="assigned_teacher_id" id="teacherSelect" required class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="button" onclick="closeAssignModal()" class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-islamic-emerald text-white rounded-lg hover:bg-islamic-emerald-dark font-medium transition-colors">
                            Assign Guru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openAssignModal(subscriptionId, studentName, classId) {
            document.getElementById('assignModal').classList.remove('hidden');
            document.getElementById('studentName').textContent = studentName;
            document.getElementById('assignForm').action = `/admin/subscriptions/${subscriptionId}/assign-teacher`;
            
            // Fetch suggested teachers for this class
            fetchSuggestedTeachers(classId);
        }

        function closeAssignModal() {
            document.getElementById('assignModal').classList.add('hidden');
        }

        function fetchSuggestedTeachers(classId) {
            const container = document.getElementById('teacherSuggestions');
            container.innerHTML = '<p class="text-sm text-gray-500 italic">Memuat saran guru...</p>';
            
            // For now, just show quick suggestion text
            // In production, you'd fetch from API
            setTimeout(() => {
                container.innerHTML = `
                    <div class="bg-green-50 rounded-lg p-3 border border-green-200">
                        <p class="text-sm text-green-800 font-medium">💡 Saran: Pilih guru yang sudah mengajar kelas ini</p>
                    </div>
                `;
            }, 300);
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeAssignModal();
        });
    </script>
</x-app-layout>
