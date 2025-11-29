<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\TahsinClass;
use Illuminate\Http\Request;

class ClassScheduleController extends Controller
{
    public function index()
    {
        $schedules = ClassSchedule::with(['tahsinClass', 'creator'])
            ->latest()
            ->paginate(20);
        
        $classes = TahsinClass::all();
        
        // Calculate statistics
        $stats = [
            'total_schedules' => ClassSchedule::count(),
            'active_schedules' => ClassSchedule::where('is_active', true)->count(),
            'inactive_schedules' => ClassSchedule::where('is_active', false)->count(),
            'classes_with_schedules' => TahsinClass::whereHas('activeSchedules')->count(),
        ];
        
        return view('admin.schedules.index', compact('schedules', 'classes', 'stats'));
    }
    
    public function create()
    {
        $classes = TahsinClass::all();
        return view('admin.schedules.create', compact('classes'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahsin_class_id' => 'required|exists:tahsin_classes,id',
            'day_of_week' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after:time_start',
            'week_start_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);
        
        $validated['created_by'] = auth()->id();
        $validated['week_start_date'] = $validated['week_start_date'] ?? now()->startOfWeek();
        
        ClassSchedule::create($validated);
        
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dibuat!');
    }
    
    public function edit(ClassSchedule $schedule)
    {
        $classes = TahsinClass::all();
        return view('admin.schedules.edit', compact('schedule', 'classes'));
    }
    
    public function update(Request $request, ClassSchedule $schedule)
    {
        $validated = $request->validate([
            'tahsin_class_id' => 'required|exists:tahsin_classes,id',
            'day_of_week' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after:time_start',
            'week_start_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);
        
        $schedule->update($validated);
        
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diupdate!');
    }
    
    public function destroy(ClassSchedule $schedule)
    {
        $schedule->delete();
        
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }
    
    public function activate(ClassSchedule $schedule)
    {
        $schedule->update(['is_active' => true]);
        
        return back()->with('success', 'Jadwal berhasil diaktifkan!');
    }
    
    public function deactivate(ClassSchedule $schedule)
    {
        $schedule->update(['is_active' => false]);
        
        return back()->with('success', 'Jadwal berhasil dinonaktifkan!');
    }
    
    public function copyLast(TahsinClass $tahsinClass)
    {
        $lastSchedules = $tahsinClass->schedules()
            ->whereNotNull('week_start_date')
            ->latest('week_start_date')
            ->limit(2)
            ->get();
        
        if ($lastSchedules->isEmpty()) {
            return back()->with('error', 'Tidak ada jadwal sebelumnya untuk disalin.');
        }
        
        $newWeekStart = now()->startOfWeek();
        
        foreach ($lastSchedules as $schedule) {
            ClassSchedule::create([
                'tahsin_class_id' => $schedule->tahsin_class_id,
                'day_of_week' => $schedule->day_of_week,
                'time_start' => $schedule->time_start,
                'time_end' => $schedule->time_end,
                'is_active' => false,
                'week_start_date' => $newWeekStart,
                'created_by' => auth()->id(),
                'notes' => 'Copied from previous schedule',
            ]);
        }
        
        return back()->with('success', 'Jadwal berhasil disalin! Aktifkan untuk menggunakan.');
    }
}
