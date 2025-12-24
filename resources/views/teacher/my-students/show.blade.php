<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('teacher.my-students.index') }}" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                        {{ $subscription->user?->name }}
                    </h2>
                </div>
                <p class="text-sm text-gray-500">{{ $subscription->tahsinClass?->name ?? 'Kelas Tahsin' }} • {{ $subscription->status }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-6">
                {{-- Student Info Card --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Info Siswa</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500">Nama</p>
                            <p class="font-medium text-gray-900">{{ $subscription->user?->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">No. HP</p>
                            <p class="font-medium text-gray-900">{{ $subscription->user?->phone }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Kelas</p>
                            <p class="font-medium text-gray-900">{{ $subscription->tahsinClass?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Periode</p>
                            <p class="font-medium text-gray-900">{{ $subscription->start_date?->format('d M Y') }} - {{ $subscription->end_date?->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Status</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $subscription->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ ucfirst($subscription->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Progress Card --}}
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Progress Pembelajaran</h3>
                    
                    @if($progress->count() > 0)
                    <div class="space-y-3">
                        @foreach($progress as $p)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                @if($p->completed_at)
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900">{{ $p->lesson?->title ?? 'Lesson' }}</p>
                                    <p class="text-xs text-gray-500">
                                        @if($p->completed_at)
                                            Selesai {{ $p->completed_at->diffForHumans() }}
                                            @if(!$p->is_unlocked)
                                                <span class="text-amber-600">• Menunggu evaluasi</span>
                                            @endif
                                        @else
                                            Belum dikerjakan
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            @if($p->completed_at && !$p->is_unlocked)
                            <form action="{{ route('teacher.my-students.unlock', $subscription) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="lesson_id" value="{{ $p->lesson_id }}">
                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-islamic-emerald text-white text-sm font-medium rounded-lg hover:bg-islamic-emerald-dark transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                    </svg>
                                    Buka
                                </button>
                            </form>
                            @elseif($p->is_unlocked)
                            <span class="text-xs text-green-600 font-medium">✓ Dibuka</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-8">Belum ada progress pembelajaran</p>
                    @endif
                </div>
            </div>

            {{-- Evaluation Form --}}
            <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Tambah Evaluasi</h3>
                
                <form action="{{ route('teacher.my-students.evaluation', $subscription) }}" method="POST">
                    @csrf
                    
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Makhraj (1-5)</label>
                            <select name="makhraj_accuracy" class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald">
                                <option value="">-</option>
                                @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? '(Perlu Banyak Perbaikan)' : ($i == 5 ? '(Sangat Baik)' : '') }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tajwid (1-5)</label>
                            <select name="tajweed_accuracy" class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald">
                                <option value="">-</option>
                                @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kelancaran (1-5)</label>
                            <select name="fluency" class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald">
                                <option value="">-</option>
                                @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rekomendasi</label>
                            <select name="recommendation" class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald">
                                <option value="">-</option>
                                <option value="repeat">Ulangi Materi</option>
                                <option value="continue">Lanjut Materi Berikutnya</option>
                                <option value="accelerate">Percepat (Lewati)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kelebihan</label>
                            <textarea name="strengths" rows="2" class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald" placeholder="Catat kelebihan siswa..."></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Perlu Ditingkatkan</label>
                            <textarea name="areas_for_improvement" rows="2" class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald" placeholder="Hal-hal yang perlu diperbaiki..."></textarea>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan PR / Tugas</label>
                        <textarea name="homework_notes" rows="2" class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald" placeholder="Tugas rumah untuk siswa..."></textarea>
                    </div>

                    <button type="submit" class="inline-flex items-center gap-2 bg-islamic-emerald hover:bg-islamic-emerald-dark text-white font-medium py-2.5 px-5 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Evaluasi
                    </button>
                </form>
            </div>

            {{-- Evaluation History --}}
            @if($evaluations->count() > 0)
            <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Riwayat Evaluasi</h3>
                
                <div class="space-y-4">
                    @foreach($evaluations as $eval)
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-900">{{ $eval->created_at->format('d M Y H:i') }}</p>
                            @if($eval->overall_rating)
                            <span class="px-2 py-0.5 bg-islamic-emerald/10 text-islamic-emerald rounded text-sm font-medium">
                                Rating: {{ $eval->overall_rating }}/5
                            </span>
                            @endif
                        </div>
                        <div class="grid grid-cols-3 gap-2 text-sm mb-2">
                            <div><span class="text-gray-500">Makhraj:</span> {{ $eval->makhraj_accuracy ?? '-' }}/5</div>
                            <div><span class="text-gray-500">Tajwid:</span> {{ $eval->tajweed_accuracy ?? '-' }}/5</div>
                            <div><span class="text-gray-500">Kelancaran:</span> {{ $eval->fluency ?? '-' }}/5</div>
                        </div>
                        @if($eval->recommendation)
                        <p class="text-sm"><span class="text-gray-500">Rekomendasi:</span> {{ $eval->recommendation_label }}</p>
                        @endif
                        @if($eval->strengths)
                        <p class="text-sm mt-1"><span class="text-gray-500">Kelebihan:</span> {{ $eval->strengths }}</p>
                        @endif
                        @if($eval->areas_for_improvement)
                        <p class="text-sm mt-1"><span class="text-gray-500">Perbaikan:</span> {{ $eval->areas_for_improvement }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
