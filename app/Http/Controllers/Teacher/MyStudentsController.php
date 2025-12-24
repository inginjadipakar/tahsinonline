<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\StudentEvaluation;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Http\Request;

class MyStudentsController extends Controller
{
    /**
     * Display list of students assigned to this teacher.
     */
    public function index()
    {
        $teacher = auth()->user();
        
        $subscriptions = Subscription::with(['user', 'tahsinClass'])
            ->where('assigned_teacher_id', $teacher->id)
            ->whereIn('status', ['active', 'pending'])
            ->latest()
            ->get();

        // Count pending unlocks (students waiting for next lesson)
        $pendingUnlocks = UserProgress::whereHas('user.subscription', function ($q) use ($teacher) {
                $q->where('assigned_teacher_id', $teacher->id);
            })
            ->where('completed_at', '!=', null)
            ->where('is_unlocked', false)
            ->count();

        return view('teacher.my-students.index', compact('subscriptions', 'pendingUnlocks'));
    }

    /**
     * Show student detail with progress and evaluations.
     */
    public function show(Subscription $subscription)
    {
        $teacher = auth()->user();
        
        // Ensure teacher is assigned to this student
        if ($subscription->assigned_teacher_id !== $teacher->id) {
            abort(403, 'Anda tidak memiliki akses ke siswa ini.');
        }

        $subscription->load(['user', 'tahsinClass.lessons', 'evaluations']);
        
        // Get student progress
        $progress = UserProgress::where('user_id', $subscription->user_id)
            ->with('lesson')
            ->orderBy('created_at')
            ->get();

        // Get evaluations by this teacher
        $evaluations = StudentEvaluation::where('student_id', $subscription->user_id)
            ->where('teacher_id', $teacher->id)
            ->with('lesson')
            ->latest()
            ->get();

        return view('teacher.my-students.show', compact('subscription', 'progress', 'evaluations'));
    }

    /**
     * Store attendance for a student.
     */
    public function storeAttendance(Request $request, Subscription $subscription)
    {
        $teacher = auth()->user();
        
        if ($subscription->assigned_teacher_id !== $teacher->id) {
            abort(403);
        }

        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'status' => 'required|in:present,absent,sick,excused',
            'notes' => 'nullable|string',
        ]);

        // Update or create user progress with attendance
        UserProgress::updateOrCreate(
            [
                'user_id' => $subscription->user_id,
                'lesson_id' => $request->lesson_id,
            ],
            [
                'attendance_status' => $request->status,
                'attendance_notes' => $request->notes,
                'attendance_by' => $teacher->id,
                'attendance_at' => now(),
            ]
        );

        return back()->with('success', 'Kehadiran berhasil dicatat.');
    }

    /**
     * Store evaluation for a student.
     */
    public function storeEvaluation(Request $request, Subscription $subscription)
    {
        $teacher = auth()->user();
        
        if ($subscription->assigned_teacher_id !== $teacher->id) {
            abort(403);
        }

        $request->validate([
            'lesson_id' => 'nullable|exists:lessons,id',
            'makhraj_accuracy' => 'nullable|integer|min:1|max:5',
            'tajweed_accuracy' => 'nullable|integer|min:1|max:5',
            'fluency' => 'nullable|integer|min:1|max:5',
            'strengths' => 'nullable|string',
            'areas_for_improvement' => 'nullable|string',
            'homework_notes' => 'nullable|string',
            'recommendation' => 'nullable|in:repeat,continue,accelerate',
        ]);

        StudentEvaluation::create([
            'student_id' => $subscription->user_id,
            'teacher_id' => $teacher->id,
            'subscription_id' => $subscription->id,
            'lesson_id' => $request->lesson_id,
            'makhraj_accuracy' => $request->makhraj_accuracy,
            'tajweed_accuracy' => $request->tajweed_accuracy,
            'fluency' => $request->fluency,
            'strengths' => $request->strengths,
            'areas_for_improvement' => $request->areas_for_improvement,
            'homework_notes' => $request->homework_notes,
            'recommendation' => $request->recommendation,
        ]);

        return back()->with('success', 'Evaluasi berhasil disimpan.');
    }

    /**
     * Unlock next lesson for a student.
     */
    public function unlockLesson(Request $request, Subscription $subscription)
    {
        $teacher = auth()->user();
        
        if ($subscription->assigned_teacher_id !== $teacher->id) {
            abort(403);
        }

        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        UserProgress::updateOrCreate(
            [
                'user_id' => $subscription->user_id,
                'lesson_id' => $request->lesson_id,
            ],
            [
                'is_unlocked' => true,
                'unlocked_by' => $teacher->id,
                'unlocked_at' => now(),
            ]
        );

        return back()->with('success', 'Lesson berhasil dibuka untuk siswa.');
    }

    /**
     * Batch unlock lessons for multiple students.
     */
    public function batchUnlock(Request $request)
    {
        $teacher = auth()->user();
        
        $request->validate([
            'progress_ids' => 'required|array',
            'progress_ids.*' => 'exists:user_progress,id',
        ]);

        $updated = UserProgress::whereIn('id', $request->progress_ids)
            ->whereHas('user.subscription', function ($q) use ($teacher) {
                $q->where('assigned_teacher_id', $teacher->id);
            })
            ->update([
                'is_unlocked' => true,
                'unlocked_by' => $teacher->id,
                'unlocked_at' => now(),
            ]);

        return back()->with('success', "{$updated} lesson berhasil dibuka.");
    }

    /**
     * Show pending unlocks for this teacher.
     */
    public function pendingUnlocks()
    {
        $teacher = auth()->user();
        
        $pendingProgress = UserProgress::with(['user', 'lesson'])
            ->whereHas('user.subscription', function ($q) use ($teacher) {
                $q->where('assigned_teacher_id', $teacher->id);
            })
            ->where('completed_at', '!=', null)
            ->where('is_unlocked', false)
            ->get();

        return view('teacher.my-students.pending-unlocks', compact('pendingProgress'));
    }
}
