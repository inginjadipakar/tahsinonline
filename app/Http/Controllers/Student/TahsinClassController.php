<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\TahsinClass;
use App\Models\Lesson;
use App\Models\UserProgress;
use Illuminate\Http\Request;

class TahsinClassController extends Controller
{
    public function index()
    {
        // Check if user has active subscription
        $subscription = auth()->user()->subscription;
        if (!$subscription || $subscription->status !== 'active') {
            return redirect()->route('dashboard')->with('error', 'Anda perlu langganan aktif untuk mengakses kelas.');
        }

        $classes = TahsinClass::where('is_active', true)
            ->withCount('lessons')
            ->orderBy('order')
            ->get();

        return view('student.tahsin-classes.index', compact('classes'));
    }

    public function show(TahsinClass $tahsinClass)
    {
        // Check subscription
        $subscription = auth()->user()->subscription;
        if (!$subscription || $subscription->status !== 'active') {
            return redirect()->route('dashboard')->with('error', 'Anda perlu langganan aktif untuk mengakses kelas.');
        }

        $tahsinClass->load('lessons');
        
        // Get user progress for all lessons in this class
        $userProgress = auth()->user()->userProgress()
            ->whereIn('lesson_id', $tahsinClass->lessons->pluck('id'))
            ->get()
            ->keyBy('lesson_id');

        return view('student.tahsin-classes.show', compact('tahsinClass', 'userProgress'));
    }

    public function showLesson(Lesson $lesson)
    {
        // Check subscription
        $subscription = auth()->user()->subscription;
        if (!$subscription || $subscription->status !== 'active') {
            return redirect()->route('dashboard')->with('error', 'Anda perlu langganan aktif untuk mengakses lesson.');
        }

        $lesson->load([
            'tahsinClass.lessons' => function($q) {
                $q->orderBy('order');
            }, 
            'tahsinClass.lessons.userProgress' => function($query) {
                $query->where('user_id', auth()->id());
            },
            // LMS Features
            'quiz.questions.options', // Quiz dengan questions dan options
            'quiz.attempts' => function($query) {
                $query->where('user_id', auth()->id())->orderBy('created_at', 'desc');
            },
            'comments.user', // Comments dengan user info
            'comments.replies.user', // Nested replies
        ]);
        
        // Get or create user progress for CURRENT lesson
        $progress = UserProgress::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'lesson_id' => $lesson->id,
            ],
            [
                'is_completed' => false,
            ]
        );

        return view('student.tahsin-classes.lesson', compact('lesson', 'progress'));
    }

    public function markComplete(Request $request, Lesson $lesson)
    {
        $progress = UserProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'lesson_id' => $lesson->id,
            ],
            [
                'is_completed' => true,
                'completed_at' => now(),
                'notes' => $request->notes,
            ]
        );

        return redirect()->back()->with('success', 'Lesson ditandai selesai!');
    }
}
