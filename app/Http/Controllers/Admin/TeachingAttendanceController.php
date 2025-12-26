<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeachingAttendance;
use App\Models\User;
use App\Models\TahsinClass;
use Illuminate\Http\Request;

class TeachingAttendanceController extends Controller
{
    /**
     * Display a listing of teaching attendances.
     */
    public function index(Request $request)
    {
        $query = TeachingAttendance::with(['teacher', 'lesson.tahsinClass', 'students'])
            ->orderBy('attendance_date', 'desc')
            ->orderBy('created_at', 'desc');

        // Filters
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->filled('class_id')) {
            $query->whereHas('lesson.tahsinClass', function($q) use ($request) {
                $q->where('id', $request->class_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('attendance_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('attendance_date', '<=', $request->date_to);
        }

        $attendances = $query->paginate(20);

        // Get filters data
        $teachers = User::where('role', 'teacher')->orderBy('name')->get();
        $classes = TahsinClass::orderBy('name')->get();

        // Statistics
        $stats = [
            'total' => TeachingAttendance::count(),
            'pending' => TeachingAttendance::where('status', 'pending')->count(),
            'approved' => TeachingAttendance::where('status', 'approved')->count(),
            'rejected' => TeachingAttendance::where('status', 'rejected')->count(),
            'total_hours' => TeachingAttendance::approved()->get()->sum('duration'),
        ];

        return view('admin.attendances.index', compact('attendances', 'teachers', 'classes', 'stats'));
    }

    /**
     * Display the specified attendance.
     */
    public function show(TeachingAttendance $attendance)
    {
        $attendance->load(['teacher', 'lesson.tahsinClass', 'students']);
        
        return view('admin.attendances.show', compact('attendance'));
    }

    /**
     * Approve attendance.
     */
    public function approve(TeachingAttendance $attendance)
    {
        $attendance->update([
            'status' => 'approved',
            'admin_notes' => null,
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil disetujui!');
    }

    /**
     * Reject attendance.
     */
    public function reject(Request $request, TeachingAttendance $attendance)
    {
        $request->validate([
            'admin_notes' => 'required|string|min:5',
        ], [
            'admin_notes.required' => 'Alasan penolakan wajib diisi',
            'admin_notes.min' => 'Alasan minimal 5 karakter',
        ]);

        $attendance->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Absensi ditolak. Teacher akan menerima notifikasi.');
    }

    /**
     * Export to Excel.
     */
    public function export(Request $request)
    {
        $filters = $request->only(['teacher_id', 'class_id', 'status', 'date_from', 'date_to']);
        
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\AttendanceExport($filters),
            'absensi-mengajar-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
