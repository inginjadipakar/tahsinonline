<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $tahsinClass->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-2">{{ $tahsinClass->name }}</h3>
                    <p class="text-gray-600">{{ $tahsinClass->description }}</p>
                    <div class="mt-4">
                        <span class="text-sm text-gray-500">Urutan: {{ $tahsinClass->order }}</span>
                        <span class="ml-4 px-2 py-1 text-xs rounded {{ $tahsinClass->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $tahsinClass->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-semibold mb-4">Lessons ({{ $tahsinClass->lessons->count() }})</h4>
                    
                    <div class="space-y-3">
                        @forelse($tahsinClass->lessons as $lesson)
                            <div class="border rounded p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Lesson {{ $lesson->order }}</span>
                                        <h5 class="text-lg font-semibold mt-2">{{ $lesson->title }}</h5>
                                        <p class="text-gray-600 text-sm">{{ Str::limit($lesson->description, 100) }}</p>
                                    </div>
                                    <a href="{{ route('admin.lessons.edit', $lesson) }}" class="text-indigo-600 hover:underline text-sm">Edit</a>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada lessons.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
