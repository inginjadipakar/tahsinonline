<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TeachingAttendance;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeachingAttendanceController extends Controller
{
    /**
     * Store a newly created attendance.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'attendance_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:users,id',
            'activity_notes' => 'required|string|min:10',
            'student_notes' => 'nullable|string',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB max
        ], [
            'end_time.after' => 'Jam selesai harus lebih besar dari jam mulai',
            'student_ids.required' => 'Pilih minimal 1 murid yang diajar',
            'screenshot.required' => 'Screenshot pembelajaran wajib diupload',
            'activity_notes.min' => 'Catatan aktivitas minimal 10 karakter',
        ]);

        $lesson = Lesson::findOrFail($validated['lesson_id']);

        // Authorization check
        if ($lesson->tahsin_class_id !== $this->getSelectedClass(auth()->user())->id) {
            return back()->with('error', 'Anda tidak berhak mengisi absensi untuk lesson ini.');
        }

        // Check for duplicate attendance
        $exists = TeachingAttendance::where([
            ['teacher_id', auth()->id()],
            ['lesson_id', $validated['lesson_id']],
            ['attendance_date', $validated['attendance_date']],
        ])->exists();

        if ($exists) {
            return back()->with('error', 'Absensi untuk lesson ini pada tanggal tersebut sudah ada.');
        }

        // Upload screenshot
        $screenshotPath = $request->file('screenshot')->store('attendance-screenshots', 'public');

        // Create attendance
        $attendance = TeachingAttendance::create([
            'teacher_id' => auth()->id(),
            'lesson_id' => $validated['lesson_id'],
            'attendance_date' => $validated['attendance_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'activity_notes' => $validated['activity_notes'],
            'student_notes' => $validated['student_notes'],
            'screenshot_path' => $screenshotPath,
            'status' => 'pending',
        ]);

        // Attach students
        $attendance->students()->attach($validated['student_ids']);

        return redirect()->route('teacher.lessons.show', $lesson)
            ->with('success', 'Absensi berhasil dikirim! Menunggu persetujuan admin.');
    }

    /**
     * Get selected class helper.
     */
    private function getSelectedClass($teacher)
    {
        $teacherClasses = $teacher->getTeacherClasses();
        $selectedClassId = session('selected_class_id');
        return $selectedClassId ? $teacherClasses->firstWhere('id', $selectedClassId) : $teacherClasses->first();
    }
}
