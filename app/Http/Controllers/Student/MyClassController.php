<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\UserProgress;
use Illuminate\Http\Request;

class MyClassController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Check subscription
        $subscription = $user->subscription;
        if (!$subscription || $subscription->status !== 'active') {
            return redirect()->route('student.subscription.index')
                ->with('error', 'Anda perlu berlangganan untuk mengakses kelas.');
        }
        
        // Get enrolled class
        $enrolledClass = $user->tahsinClass;
        
        if (!$enrolledClass) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda belum terdaftar di kelas manapun.');
        }
        
        // Get all lessons for this class with order
        $lessons = $enrolledClass->lessons()->orderBy('order')->get();
        
        // Get user's completed lessons
        $completedLessonIds = UserProgress::where('user_id', $user->id)
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();
        
        // Determine lesson status and find current lesson
        $foundCurrent = false;
        $currentLesson = null;
        $lessonsWithStatus = $lessons->map(function ($lesson) use ($completedLessonIds, &$currentLesson, &$foundCurrent) {
            $isCompleted = in_array($lesson->id, $completedLessonIds);
            
            // Determine status
            if ($isCompleted) {
                $status = 'completed';
            } elseif (!$foundCurrent) {
                // First incomplete lesson is current
                $status = 'current';
                $currentLesson = $lesson;
                $foundCurrent = true;
            } else {
                // All subsequent lessons are locked
                $status = 'locked';
            }
            
            return [
                'lesson' => $lesson,
                'status' => $status,
                'isCompleted' => $isCompleted,
                'isCurrent' => $status === 'current',
                'isLocked' => $status === 'locked',
            ];
        });
        
        // Calculate progress
        $totalLessons = $lessons->count();
        $completedCount = count($completedLessonIds);
        $progress = $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100) : 0;
        
        // Get active schedules
        $activeSchedules = $enrolledClass->activeSchedules()
            ->orderBy('day_of_week')
            ->get();
        
        // Check if class is active
        $classActive = $enrolledClass->isActive();
        
        return view('student.my-class', [
            'enrolledClass' => $enrolledClass,
            'lessons' => $lessonsWithStatus,
            'currentLesson' => $currentLesson,
            'progress' => $progress,
            'completedCount' => $completedCount,
            'totalLessons' => $totalLessons,
            'activeSchedules' => $activeSchedules,
            'classActive' => $classActive,
            'subscription' => $subscription,
        ]);
    }
}
