@props(['lesson'])

@if($lesson->hasPdf())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Dokumen PDF
                </h3>
                <a href="{{ Storage::url($lesson->pdf_file) }}" 
                   download 
                   class="text-sm text-emerald-600 hover:text-emerald-700 font-semibold flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download
                </a>
            </div>
            
            <div class="border border-gray-200 rounded-lg overflow-hidden" style="height: 600px;">
                <embed 
                    src="{{ Storage::url($lesson->pdf_file) }}" 
                    type="application/pdf" 
                    width="100%" 
                    height="100%">
                
                <p class="p-4 text-sm text-gray-500">
                    Browser Anda tidak support PDF viewer. 
                    <a href="{{ Storage::url($lesson->pdf_file) }}" download class="text-emerald-600 hover:underline">Download PDF</a> untuk melihat.
                </p>
            </div>
        </div>
    </div>
@else
    {{-- Empty State --}}
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl shadow-sm border border-blue-200 overflow-hidden">
        <div class="p-8 md:p-12 text-center">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Dokumen PDF Belum Tersedia</h3>
            <p class="text-sm text-gray-500 max-w-md mx-auto">
                Materi tambahan dalam bentuk PDF akan segera ditambahkan oleh pengajar.
            </p>
        </div>
    </div>
@endif
