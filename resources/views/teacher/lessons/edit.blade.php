<x-layouts.teacher>
    <div class="max-w-3xl mx-auto space-y-6">
        {{-- Header --}}
        <div>
            <a href="{{ route('teacher.lessons.index') }}"
                class="text-green-600 hover:text-green-700 text-sm font-medium mb-2 inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">Edit Materi</h1>
            <p class="text-gray-600 mt-1">{{ $lesson->title }}</p>
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('teacher.lessons.update', $lesson) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Title --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Materi *</label>
                    <input type="text" name="title" value="{{ old('title', $lesson->title) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    @error('title')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('description', $lesson->description) }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Content --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konten Materi</label>
                    <textarea name="content" rows="6"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('content', $lesson->content) }}</textarea>
                    @error('content')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Current File --}}
                @if($lesson->hasFile())
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-blue-900">File saat ini:
                                        {{ strtoupper($lesson->file_type) }}</p>
                                    <p class="text-xs text-blue-700">{{ round($lesson->file_size / 1024, 2) }} MB</p>
                                </div>
                            </div>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="remove_file" value="1" class="rounded">
                                <span class="text-sm text-blue-900">Hapus file</span>
                            </label>
                        </div>
                    </div>
                @endif

                {{-- File Upload --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $lesson->hasFile() ? 'Ganti File (Opsional)' : 'Upload File (PDF, Word, PPT)' }}
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                        <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx" class="w-full"
                            onchange="document.getElementById('fileName').textContent = this.files[0]?.name || 'Tidak ada file dipilih'">
                        <p class="text-sm text-gray-600 mt-2" id="fileName">Tidak ada file dipilih</p>
                        <p class="text-xs text-gray-500 mt-1">Max 10MB. Format: PDF, Word (.doc, .docx), PowerPoint
                            (.ppt, .pptx)</p>
                    </div>
                    @error('file')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Video URL --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Link Video (YouTube / Google
                        Drive)</label>
                    <input type="url" name="video_url" value="{{ old('video_url', $lesson->video_url) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="https://www.youtube.com/watch?v=...">
                    <p class="text-xs text-gray-500 mt-1">Hanya link dari YouTube atau Google Drive yang diperbolehkan
                    </p>
                    @error('video_url')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Order --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Urutan *</label>
                    <input type="number" name="order" value="{{ old('order', $lesson->order) }}" required min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    @error('order')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Buttons --}}
                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                        Update Materi
                    </button>
                    <a href="{{ route('teacher.lessons.index') }}"
                        class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.teacher>