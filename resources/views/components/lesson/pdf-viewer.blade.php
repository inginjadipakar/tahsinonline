@props(['lesson'])

@if($lesson->hasPdf())
    <div class="lesson-pdf-container mb-6">
        <div class="bg-white rounded-lg shadow-lg border border-slate-200">
            <!-- PDF Header -->
            <div class="px-4 py-3 bg-slate-50 border-b border-slate-200 rounded-t-lg flex items-center justify-between">
                <div class="flex items-center gap-2 text-sm font-medium text-slate-700">
                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                    </svg>
                    PDF Document
                </div>
                <a href="{{ Storage::url($lesson->pdf_file) }}" 
                   download 
                   class="text-sm text-islamic-emerald hover:text-islamic-emerald-dark font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download
                </a>
            </div>

            <!-- PDF Viewer (Simple embed method) -->
            <div class="relative bg-slate-100">
                <embed 
                    src="{{ Storage::url($lesson->pdf_file) }}" 
                    type="application/pdf" 
                    class="w-full"
                    style="min-height: 600px; height: 70vh;"
                />
            </div>

            <!-- Alternative: For browsers that don't support embed -->
            <noscript>
                <div class="p-6 text-center">
                    <p class="text-slate-600 mb-4">Your browser doesn't support PDF viewing.</p>
                    <a href="{{ Storage::url($lesson->pdf_file) }}" 
                       download 
                       class="btn-primary">
                        Download PDF
                    </a>
                </div>
            </noscript>
        </div>
    </div>
@endif
