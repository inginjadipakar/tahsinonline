<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-lg text-gray-900">KELOLA KELAS TAHSIN</h2>
                <p class="text-[10px] text-gray-500">Kelola kelas-kelas pembelajaran Tahsin Al-Qur'an</p>
            </div>
            <a href="{{ route('admin.tahsin-classes.create') }}" class="bg-emerald-700 hover:bg-emerald-800 border border-emerald-900 text-white text-xs font-bold py-1.5 px-3 uppercase">
                + Tambah Kelas
            </a>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto px-4">
            
            {{-- Stats - Compact --}}
            <div class="grid grid-cols-4 gap-2 mb-3">
                <div class="bg-white border border-gray-300 p-2">
                    <div class="flex items-center gap-2">
                        <div class="text-xl font-bold text-gray-900">{{ $classes->count() }}</div>
                        <p class="text-[9px] text-gray-600 uppercase font-semibold">Total Kelas</p>
                    </div>
                </div>
                <div class="bg-white border border-gray-300 p-2">
                    <div class="flex items-center gap-2">
                        <div class="text-xl font-bold text-green-700">{{ $classes->where('is_active', true)->count() }}</div>
                        <p class="text-[9px] text-gray-600 uppercase font-semibold">Kelas Aktif</p>
                    </div>
                </div>
                <div class="bg-white border border-gray-300 p-2">
                    <div class="flex items-center gap-2">
                        <div class="text-xl font-bold text-gray-900">{{ $classes->sum('lessons_count') }}</div>
                        <p class="text-[9px] text-gray-600 uppercase font-semibold">Total Materi</p>
                    </div>
                </div>
                <div class="bg-white border border-gray-300 p-2">
                    <div class="flex items-center gap-2">
                        <div class="text-xl font-bold text-gray-900">{{ number_format($classes->avg('price') / 1000 ?? 0, 0) }}k</div>
                        <p class="text-[9px] text-gray-600 uppercase font-semibold">Rata-rata Harga</p>
                    </div>
                </div>
            </div>

            {{-- Flash Message - Compact --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-300 p-2 mb-2 text-[10px] text-green-800 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Table - Compact --}}
            <div class="bg-white border border-gray-300">
                <div class="px-3 py-1 border-b border-gray-300 bg-gray-50">
                    <h3 class="text-[10px] font-bold text-gray-900 uppercase">Daftar Kelas</h3>
                </div>
                
                @if($classes->count() > 0)
                <table class="w-full text-[10px]" style="font-family: 'Courier New', monospace;">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="border-r border-gray-700 px-2 py-1 text-left uppercase">Kelas</th>
                            <th class="border-r border-gray-700 px-2 py-1 text-right uppercase">Harga</th>
                            <th class="border-r border-gray-700 px-2 py-1 text-center uppercase">Materi</th>
                            <th class="border-r border-gray-700 px-2 py-1 text-center uppercase">Peserta</th>
                            <th class="border-r border-gray-700 px-2 py-1 text-center uppercase">Status</th>
                            <th class="px-2 py-1 text-right uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classes as $class)
                        <tr class="border-t border-gray-300 hover:bg-gray-50">
                            <td class="border-r border-gray-300 px-2 py-1">
                                <div class="flex items-center gap-1">
                                    <div class="w-4 h-4 {{ $class->is_active ? 'bg-emerald-700' : 'bg-gray-400' }} flex items-center justify-center flex-shrink-0">
                                        <span class="text-white text-[8px]">K</span>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.tahsin-classes.show', $class) }}" class="font-bold text-gray-900 hover:text-emerald-700">{{ $class->name }}</a>
                                        <p class="text-[9px] text-gray-500">{{ Str::limit($class->description, 40) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="border-r border-gray-300 px-2 py-1 text-right">
                                <span class="font-bold">Rp {{ number_format($class->price / 1000, 0) }}k</span>
                                <span class="text-[9px] text-gray-500">/bln</span>
                            </td>
                            <td class="border-r border-gray-300 px-2 py-1 text-center">
                                <a href="{{ route('admin.lessons.index', ['tahsin_class_id' => $class->id]) }}" class="px-2 py-0.5 bg-blue-100 text-blue-900 font-bold hover:bg-blue-200">
                                    {{ $class->lessons_count }}
                                </a>
                            </td>
                            <td class="border-r border-gray-300 px-2 py-1 text-center">
                                <a href="{{ route('admin.subscriptions.index', ['tahsin_class_id' => $class->id]) }}" class="px-2 py-0.5 bg-purple-100 text-purple-900 font-bold hover:bg-purple-200">
                                    {{ $class->subscriptions_count ?? 0 }}
                                </a>
                            </td>
                            <td class="border-r border-gray-300 px-2 py-1 text-center">
                                @if($class->is_active)
                                    <span class="px-2 py-0.5 bg-green-200 text-green-900 font-bold uppercase">Aktif</span>
                                @else
                                    <span class="px-2 py-0.5 bg-gray-200 text-gray-700 font-bold uppercase">Off</span>
                                @endif
                            </td>
                            <td class="px-2 py-1">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.tahsin-classes.show', $class) }}" class="text-blue-700 hover:text-blue-900 font-bold" title="Lihat">👁</a>
                                    <a href="{{ route('admin.tahsin-classes.edit', $class) }}" class="text-indigo-700 hover:text-indigo-900 font-bold" title="Edit">✎</a>
                                    <form action="{{ route('admin.tahsin-classes.destroy', $class) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus {{ $class->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-700 hover:text-red-900 font-bold" title="Hapus">✕</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <div class="p-8 text-center">
                        <div class="w-12 h-12 bg-gray-100 flex items-center justify-center mx-auto mb-2">
                            <span class="text-2xl">📚</span>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Belum ada kelas tahsin</h3>
                        <p class="text-xs text-gray-600 mb-3">Mulai dengan menambahkan kelas pertama</p>
                        <a href="{{ route('admin.tahsin-classes.create') }}" class="inline-block bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold px-4 py-2 border border-emerald-900 uppercase">
                            + Tambah Kelas Baru
                        </a>
                    </div>
                @endif

                {{-- Pagination --}}
                @if($classes->hasPages())
                    <div class="px-3 py-2 border-t border-gray-300 bg-gray-50 text-xs">
                        {{ $classes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
