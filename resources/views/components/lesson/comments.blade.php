@props(['lesson'])

<div class="lesson-comments-section mt-8 bg-white rounded-lg shadow-sm border border-slate-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-islamic-emerald" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414zM11 12a1 1 0 100 2h3a1 1 0 100-2h-3z"/>
        </svg>
        Diskusi & Pertanyaan
    </h3>

    <!-- Comment Form -->
    <form action="{{ route('comments.store') }}" method="POST" class="mb-6">
        @csrf
        <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
        <div class="mb-3">
            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Tulis Komentar</label>
            <textarea name="comment" id="comment" rows="3" required
                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-islamic-emerald focus:ring-islamic-emerald"
                      placeholder="Tulis pertanyaan atau komentar Anda di sini..."></textarea>
            @error('comment')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>
        <button type="submit" class="btn-primary">
            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"/>
            </svg>
            Kirim Komentar
        </button>
    </form>

    <!-- Comments List -->
    <div class="space-y-4">
        @forelse($lesson->comments as $comment)
            <div class="comment-item border-l-4 border-islamic-emerald pl-4 py-2">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-semibold text-gray-900">{{ $comment->user->name }}</span>
                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            @if($comment->user->role === 'teacher')
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded">Guru</span>
                            @endif
                        </div>
                        <p class="text-gray-700 text-sm leading-relaxed">{{ $comment->comment }}</p>
                    </div>
                    @if(auth()->id() === $comment->user_id || auth()->user()->role === 'teacher')
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="ml-2" onsubmit="return confirm('Hapus komentar ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                        </form>
                    @endif
                </div>

                <!-- Replies -->
                @if($comment->replies->count() > 0)
                    <div class="mt-3 ml-4 space-y-3">
                        @foreach($comment->replies as $reply)
                            <div class="border-l-2 border-gray-300 pl-3 py-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-medium text-sm text-gray-800">{{ $reply->user->name }}</span>
                                    <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                    @if($reply->user->role === 'teacher')
                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded">Guru</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-700">{{ $reply->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Reply Form -->
                <button onclick="toggleReplyForm({{ $comment->id }})" class="text-islamic-emerald text-sm mt-2 hover:underline">
                    💬 Balas
                </button>
                <form id="reply-form-{{ $comment->id }}" action="{{ route('comments.store') }}" method="POST" class="mt-2 hidden">
                    @csrf
                    <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <div class="flex gap-2">
                        <textarea name="comment" rows="2" required
                                  class="flex-1 text-sm rounded-md border-gray-300 shadow-sm focus:border-islamic-emerald focus:ring-islamic-emerald"
                                  placeholder="Tulis balasan..."></textarea>
                        <button type="submit" class="px-3 py-1 bg-islamic-emerald text-white rounded-md hover:bg-islamic-emerald-dark text-sm">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        @empty
            <p class="text-gray-500 text-center py-8">Belum ada komentar. Jadilah yang pertama!</p>
        @endforelse
    </div>
</div>

<script>
function toggleReplyForm(commentId) {
    const form = document.getElementById(`reply-form-${commentId}`);
    form.classList.toggle('hidden');
}
</script>
