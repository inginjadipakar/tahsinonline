<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Kelola Subscriptions</h1>
                    <p class="mt-1 text-sm text-gray-500">Kelola langganan dan assign guru ke siswa</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('admin.subscriptions.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-emerald-500 hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Tambah Subscription
                    </a>
                </div>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <!-- Total Siswa -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalSiswa }}</p>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Siswa</p>
                    </div>
                </div>

                <!-- Aktif -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-emerald-50 rounded-xl">
                        <svg class="h-6 w-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $activeCount }}</p>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Aktif</p>
                    </div>
                </div>

                <!-- Pending -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-orange-50 rounded-xl">
                        <svg class="h-6 w-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $pendingCount }}</p>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pending</p>
                    </div>
                </div>
            </div>

            {{-- Main Content Card --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h2 class="text-lg font-bold text-gray-900">Daftar Subscription</h2>
                    
                    {{-- Filter --}}
                    <div class="flex items-center gap-2">
                        <label for="filter" class="text-sm font-medium text-gray-500">Filter:</label>
                        <select onchange="window.location.href=this.value" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-xl">
                            <option value="{{ route('admin.subscriptions.index') }}" {{ !request('filter') ? 'selected' : '' }}>Semua</option>
                            <option value="{{ route('admin.subscriptions.index', ['filter' => 'active']) }}" {{ request('filter') === 'active' ? 'selected' : '' }}>Active Only</option>
                            <option value="{{ route('admin.subscriptions.index', ['filter' => 'pending']) }}" {{ request('filter') === 'pending' ? 'selected' : '' }}>Pending Only</option>
                            <option value="{{ route('admin.subscriptions.index', ['filter' => 'no_teacher']) }}" {{ request('filter') === 'no_teacher' ? 'selected' : '' }}>Belum Ada Guru</option>
                        </select>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Siswa</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kelas</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Guru</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Periode</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($subscriptions as $subscription)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full flex-shrink-0 overflow-hidden bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-sm">
                                                @if($subscription->user->profile_photo_path)
                                                    <img src="{{ asset('storage/' . $subscription->user->profile_photo_path) }}" alt="{{ $subscription->user->name }}" class="w-full h-full object-cover">
                                                @else
                                                    {{ substr($subscription->user->name, 0, 1) }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $subscription->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $subscription->user->phone }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">{{ $subscription->tahsinClass?->name ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $subscription->program_type ?? 'Regular' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($subscription->assignedTeacher)
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full flex-shrink-0 overflow-hidden bg-purple-100 flex items-center justify-center text-purple-600 font-bold text-xs ring-2 ring-white">
                                                @if($subscription->assignedTeacher->profile_photo_path)
                                                    <img src="{{ asset('storage/' . $subscription->assignedTeacher->profile_photo_path) }}" alt="{{ $subscription->assignedTeacher->name }}" class="w-full h-full object-cover">
                                                @else
                                                    {{ substr($subscription->assignedTeacher->name, 0, 1) }}
                                                @endif
                                            </div>
                                            <span class="text-sm text-gray-700 font-medium">{{ $subscription->assignedTeacher->name }}</span>
                                        </div>
                                    @else
                                        <button onclick="openAssignModal('{{ $subscription->id }}', '{{ $subscription->user->name }}', '{{ $subscription->tahsinClass?->name ?? 'Kelas' }}')" 
                                                class="inline-flex items-center px-2.5 py-1.5 border border-dashed border-gray-300 text-xs font-medium rounded-lg text-gray-500 hover:text-emerald-600 hover:border-emerald-300 bg-white hover:bg-emerald-50 transition-all">
                                            <svg class="mr-1.5 h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            Assign Guru
                                        </button>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($subscription->start_date)->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">s/d {{ \Carbon\Carbon::parse($subscription->end_date)->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($subscription->status === 'active')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @elseif($subscription->status === 'pending')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ ucfirst($subscription->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.subscriptions.edit', $subscription->id) }}" class="p-2 text-gray-400 hover:text-emerald-500 hover:bg-emerald-50 rounded-lg transition-all" title="Edit">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.subscriptions.destroy', $subscription->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus subscription ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-base font-medium text-gray-900">Belum ada data subscription</p>
                                        <p class="text-sm text-gray-500 mt-1">Silakan tambah subscription baru untuk memulai.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="border-t border-gray-200 px-6 py-4">
                    {{ $subscriptions->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Assign Teacher Modal --}}
    <div x-data="{ open: false, subscriptionId: null, studentName: '', className: '' }"
         @open-assign-modal.window="open = true; subscriptionId = $event.detail.id; studentName = $event.detail.name; className = $event.detail.class"
         class="relative z-50">
        
        {{-- Custom Event Listener Script --}}
        <script>
            function openAssignModal(id, name, className) {
                window.dispatchEvent(new CustomEvent('open-assign-modal', {
                    detail: { id: id, name: name, class: className }
                }));
            }
        </script>

        {{-- Backdrop --}}
        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
             @click="open = false"></div>

        {{-- Modal Panel --}}
        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <form :action="`{{ url('/admin/subscriptions') }}/${subscriptionId}/assign`" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Assign Guru</h3>
                            <p class="text-sm text-gray-500 mb-6">
                                Pilih guru untuk siswa <span class="font-bold text-gray-900" x-text="studentName"></span> 
                                di kelas <span class="font-bold text-gray-900" x-text="className"></span>.
                            </p>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Guru</label>
                                    <select name="assigned_teacher_id" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm h-12" required>
                                        <option value="">-- Pilih Guru --</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->name }} ({{ ucfirst($teacher->gender) }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-emerald-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 sm:ml-3 sm:w-auto transition-colors">
                                Simpan Assignment
                            </button>
                            <button type="button" @click="open = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
