@props(['lesson'])

@if($lesson->hasZoomLink())
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl shadow-lg border-2 border-blue-300 overflow-hidden">
        <div class="p-6 md:p-8">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-14 h-14 bg-white rounded-xl flex items-center justify-center shadow-md">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-white mb-2">🎥 Kelas Online via Zoom</h3>
                    <p class="text-blue-100 text-sm mb-4">
                        Klik tombol di bawah untuk bergabung ke kelas online Zoom. Pastikan Anda sudah install aplikasi Zoom atau gunakan browser.
                    </p>
                    
                    <a href="{{ $lesson->zoom_link }}" 
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-blue-600 font-bold py-3 px-6 rounded-xl transition-all shadow-lg hover:shadow-xl hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Gabung Kelas Zoom
                    </a>
                    
                    <p class="text-xs text-blue-100 mt-3">
                        💡 Tips: Pastikan mic dan kamera sudah siap sebelum join
                    </p>
                </div>
            </div>
        </div>
    </div>
@else
    {{-- Empty State --}}
    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl shadow-sm border border-indigo-200 overflow-hidden">
        <div class="p-8 md:p-12 text-center">
            <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Link Zoom Belum Tersedia</h3>
            <p class="text-sm text-gray-500 max-w-md mx-auto">
                Materi ini tidak memerlukan kelas online via Zoom. 
                Silakan pelajari materi melalui video atau teks yang tersedia.
            </p>
        </div>
    </div>
@endif
