<?php

namespace App\Http\Controllers;

use App\Models\LessonComment;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonCommentController extends Controller
{
    /**
     * Store a new comment or reply
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'parent_id' => 'nullable|exists:lesson_comments,id',
            'comment' => 'required|string|max:2000',
        ]);

        $validated['user_id'] = auth()->id();

        $comment = LessonComment::create($validated);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Update comment (only owner can edit)
     */
    public function update(Request $request, LessonComment $comment)
    {
        // Authorization
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk edit komentar ini.');
        }

        $validated = $request->validate([
            'comment' => 'required|string|max:2000',
        ]);

        $comment->update($validated);

        return back()->with('success', 'Komentar berhasil diupdate!');
    }

    /**
     * Delete comment (owner or teacher can delete)
     */
    public function destroy(LessonComment $comment)
    {
        $user = auth()->user();
        
        // Allow deletion if: owner, teacher, or admin
        if ($comment->user_id !== $user->id && !in_array($user->role, ['teacher', 'admin'])) {
            abort(403, 'Anda tidak memiliki akses untuk hapus komentar ini.');
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus!');
    }
}
