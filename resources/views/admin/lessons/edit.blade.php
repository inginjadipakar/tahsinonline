<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Lesson') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.lessons.update', $lesson) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="tahsin_class_id" class="block text-sm font-medium text-gray-700">Kelas Tahsin</label>
                            <select name="tahsin_class_id" id="tahsin_class_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($tahsinClasses as $class)
                                    <option value="{{ $class->id }}" {{ old('tahsin_class_id', $lesson->tahsin_class_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tahsin_class_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul Lesson</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $lesson->title) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            @error('title')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                            <textarea name="description" id="description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $lesson->description) }}</textarea>
                            @error('description')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Konten Materi</label>
                            <textarea name="content" id="content" rows="8" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('content', $lesson->content) }}</textarea>
                            @error('content')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <!-- Video Section -->
                        <div class="mb-6 p-4 bg-slate-50 rounded-lg border border-slate-200">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">📹 Media Video</h3>
                            
                            <div class="mb-4">
                                <label for="video_platform" class="block text-sm font-medium text-gray-700">Platform Video</label>
                                <select name="video_platform" id="video_platform" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="none" {{ old('video_platform', $lesson->video_platform ?? 'none') == 'none' ? 'selected' : '' }}>Tidak Ada Video</option>
                                    <option value="youtube" {{ old('video_platform', $lesson->video_platform) == 'youtube' ? 'selected' : '' }}>YouTube</option>
                                    <option value="vimeo" {{ old('video_platform', $lesson->video_platform) == 'vimeo' ? 'selected' : '' }}>Vimeo</option>
                                </select>
                                @error('video_platform')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-4">
                                <label for="video_url" class="block text-sm font-medium text-gray-700">Video URL</label>
                                <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $lesson->video_url) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="https://www.youtube.com/watch?v=... atau https://vimeo.com/..." />
                                <p class="mt-1 text-xs text-gray-500">Paste link dari YouTube atau Vimeo</p>
                                @error('video_url')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- PDF Section -->
                        <div class="mb-6 p-4 bg-slate-50 rounded-lg border border-slate-200">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">📄 Dokumen PDF</h3>
                            
                            @if($lesson->pdf_file)
                                <div class="mb-3 p-2 bg-blue-50 border border-blue-200 rounded">
                                    <p class="text-sm text-blue-800">✅ PDF saat ini: <a href="{{ Storage::url($lesson->pdf_file) }}" target="_blank" class="underline">Lihat PDF</a></p>
                                </div>
                            @endif

                            <div class="mb-4">
                                <label for="pdf_file" class="block text-sm font-medium text-gray-700">Upload PDF Baru (Opsional)</label>
                                <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                <p class="mt-1 text-xs text-gray-500">Max 10MB. Upload file baru akan mengganti yang lama.</p>
                                @error('pdf_file')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="order" class="block text-sm font-medium text-gray-700">Urutan</label>
                            <input type="number" name="order" id="order" value="{{ old('order', $lesson->order) }}" required min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            @error('order')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Update
                            </button>
                            <a href="{{ route('admin.lessons.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
