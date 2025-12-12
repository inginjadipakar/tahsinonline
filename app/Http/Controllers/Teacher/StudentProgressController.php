<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Http\Request;

class StudentProgressController extends Controller
{
    private function getSelectedClass($teacher)
    {
        $teacherClasses = $teacher->getTeacherClasses();
        $selectedClassId = session('selected_class_id');
        return $selectedClassId ? $teacherClasses->find($selectedClassId) : $teacherClasses->first();
    }

    public function index(Request $request)
    {
        $teacher = $request->user();
        $assignedClass = $this->getSelectedClass($teacher);

        if (!$assignedClass) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Anda belum ditugaskan ke kelas manapun.');
        }

        // Get students in assigned class with completion stats
        $students = User::where('tahsin_class_id', $assignedClass->id)
            ->where('role', 'student')
            ->get()
            ->map(function ($student) use ($assignedClass) {
                // Get total lessons for THIS CLASS
                $totalLessons = $assignedClass->lessons()->count();

                // Count completed lessons only for THIS CLASS
                $completedLessons = UserProgress::where('user_id', $student->id)
                    ->where('is_completed', true)
                    ->whereHas('lesson', function ($q) use ($assignedClass) {
                    $q->where('tahsin_class_id', $assignedClass->id);
                })
                    ->count();

                $completionPercentage = $totalLessons > 0
                    ? round(($completedLessons / $totalLessons) * 100, 1)
                    : 0;

                return [
                    'student' => $student,
                    'total_lessons' => $totalLessons,
                    'completed_lessons' => $completedLessons,
                    'completion_percentage' => $completionPercentage,
                ];
            });

        return view('teacher.students.index', compact('students', 'assignedClass'));
    }

    public function show(Request $request, User $student)
    {
        $teacher = $request->user();
        $assignedClass = $this->getSelectedClass($teacher);

        if (!$assignedClass) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Anda belum ditugaskan ke kelas manapun.');
        }

        // Check if student is in teacher's SELECTED class
        if ($student->tahsin_class_id !== $assignedClass->id) {
            // Check if student is in ANY of teacher's classes to give better error message
            if ($teacher->getTeacherClasses()->contains('id', $student->tahsin_class_id)) {
                // Optionally: auto-switch class? For now, just error.
                return redirect()->route('teacher.students.index')
                    ->with('error', 'Siswa tersebut berada di kelas lain yang Anda ajar. Silakan ganti kelas terlebih dahulu.');
            }

            abort(403, 'Siswa ini bukan bagian dari kelas yang Anda pilih.');
        }

        // Get all lessons for the class
        $lessons = $assignedClass->lessons()->orderBy('order')->get();

        // Get student's progress
        $completedLessonIds = UserProgress::where('user_id', $student->id)
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();

        // Map lessons with completion status
        $lessonsWithStatus = $lessons->map(function ($lesson) use ($completedLessonIds) {
            return [
                'lesson' => $lesson,
                'is_completed' => in_array($lesson->id, $completedLessonIds),
            ];
        });

        // Calculate statistics
        $totalLessons = $lessons->count();
        $completedCount = count($completedLessonIds);
        $completionPercentage = $totalLessons > 0
            ? round(($completedCount / $totalLessons) * 100, 1)
            : 0;

        return view('teacher.students.progress', [
            'student' => $student,
            'assignedClass' => $assignedClass,
            'lessons' => $lessonsWithStatus,
            'totalLessons' => $totalLessons,
            'completedCount' => $completedCount,
            'completionPercentage' => $completionPercentage,
        ]);
    }
}
