<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\UserProgress;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Get enrolled class
        $enrolledClass = $user->tahsinClass;
        
        // Initialize variables
        $lessons = collect();
        $currentLesson = null;
        $lessonsWithStatus = collect();
        
        if ($enrolledClass) {
            // Get all lessons for this class
            $lessons = $enrolledClass->lessons()->orderBy('order')->get();
            
            // Get user's completed lessons
            $completedLessonIds = UserProgress::where('user_id', $user->id)
                ->where('is_completed', true)
                ->pluck('lesson_id')
                ->toArray();
            
            // Determine lesson status and find current lesson
            $foundCurrent = false;
            $lessonsWithStatus = $lessons->map(function ($lesson, $index) use ($completedLessonIds, &$currentLesson, &$foundCurrent) {
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
        }
        
        // Load schedules if enrolled
        $classSchedules = collect();
        $classInactive = false;
        
        if ($enrolledClass) {
            // Load active schedules
            $classSchedules = $enrolledClass->activeSchedules()->orderBy('day_of_week')->get();
            
            // Check if class is inactive (no active schedules)
            if (!$enrolledClass->isActive()) {
                $classInactive = true;
            }
        }
        
        return view('dashboard', [
            'enrolledClass' => $enrolledClass,
            'lessons' => $lessonsWithStatus,
            'currentLesson' => $currentLesson,
            'classSchedules' => $classSchedules,
            'classInactive' => $classInactive,
        ]);
    }
}
