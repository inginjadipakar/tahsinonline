<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $teacher = $request->user();

        // Get all classes assigned to this teacher
        $teacherClasses = $teacher->getTeacherClasses();

        if ($teacherClasses->isEmpty()) {
            return view('teacher.dashboard', [
                'hasClass' => false,
                'message' => 'Anda belum ditugaskan ke kelas manapun. Hubungi admin untuk assignment.'
            ]);
        }

        // Determine selected class (from session or default to first)
        $selectedClassId = session('selected_class_id');

        // Validate selected class belongs to teacher
        $assignedClass = null;
        if ($selectedClassId) {
            $assignedClass = $teacherClasses->find($selectedClassId);
        }

        // Fallback if not set or invalid
        if (!$assignedClass) {
            $assignedClass = $teacherClasses->first();
            session(['selected_class_id' => $assignedClass->id]);
        }

        // Check if teacher is globally assigned to this class
        $isGlobalTeacher = $teacherClasses->where('id', $assignedClass->id)->first()->pivot ?? false; 
        // Note: Pivot check might be tricky if getTeacherClasses returned from Subscription query (no pivot).
        // Better check:
        $isDirectlyAssigned = $teacher->assignedClasses->contains('id', $assignedClass->id) || $teacher->assigned_class_id == $assignedClass->id;

        // Get students in the assigned class
        $studentsQuery = \App\Models\User::where('tahsin_class_id', $assignedClass->id)
            ->where('role', 'student');
            
        // If not a global teacher for this class, restrict to assigned students only
        if (!$isDirectlyAssigned) {
            $studentsQuery->whereHas('subscriptions', function($q) use ($teacher) {
                $q->where('assigned_teacher_id', $teacher->id)
                  ->whereIn('status', ['active', 'pending']);
            });
        }
        
        $students = $studentsQuery->get();

        // Get total materials for THIS CLASS
        // If lessons are strictly tied to class, use $assignedClass->lessons()
        // If lessons are shared but we want to show count for this class:
        $totalMaterials = $assignedClass->lessons()->count();

        // Calculate average completion rate
        $totalLessons = $totalMaterials;
        $completionRates = [];

        foreach ($students as $student) {
            $completedCount = \App\Models\UserProgress::where('user_id', $student->id)
                ->where('is_completed', true)
                ->whereHas('lesson', function ($q) use ($assignedClass) {
                    $q->where('tahsin_class_id', $assignedClass->id);
                })
                ->count();

            if ($totalLessons > 0) {
                $completionRates[] = ($completedCount / $totalLessons) * 100;
            } else {
                $completionRates[] = 0;
            }
        }

        $avgCompletionRate = count($completionRates) > 0
            ? round(array_sum($completionRates) / count($completionRates), 1)
            : 0;

        // Get recent materials for THIS class
        $recentMaterials = $assignedClass->lessons()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get recent student activities for THIS class
        $recentActivities = \App\Models\UserProgress::whereHas('lesson', function ($query) use ($assignedClass) {
            $query->where('tahsin_class_id', $assignedClass->id);
        })
            ->where('is_completed', true)
            ->with(['user', 'lesson'])
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        return view('teacher.dashboard', [
            'hasClass' => true,
            'assignedClass' => $assignedClass,
            'teacherClasses' => $teacherClasses, // Pass all classes for the switcher
            'totalStudents' => $students->count(),
            'totalMaterials' => $totalMaterials,
            'avgCompletionRate' => $avgCompletionRate,
            'recentMaterials' => $recentMaterials,
            'recentActivities' => $recentActivities,
        ]);
    }

    public function switchClass(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:tahsin_classes,id'
        ]);

        $teacher = $request->user();

        // Verify teacher has access to this class
        if (!$teacher->getTeacherClasses()->contains('id', $request->class_id)) {
            abort(403, 'Unauthorized access to this class.');
        }

        session(['selected_class_id' => $request->class_id]);

        return redirect()->route('teacher.dashboard');
    }
}
