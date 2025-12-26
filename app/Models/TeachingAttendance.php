<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TeachingAttendance extends Model
{
    protected $fillable = [
        'teacher_id',
        'lesson_id',
        'attendance_date',
        'start_time',
        'end_time',
        'activity_notes',
        'student_notes',
        'screenshot_path',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * Get the teacher who submitted this attendance.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the lesson for this attendance.
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get the students who attended.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'attendance_students', 'attendance_id', 'student_id')
            ->withTimestamps();
    }

    /**
     * Get formatted duration in hours.
     */
    public function getDurationAttribute(): float
    {
        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);
        return round($start->diffInMinutes($end) / 60, 1);
    }

    /**
     * Get attendance number (for display).
     */
    public function getAttendanceNumberAttribute(): string
    {
        return 'ATT-' . $this->attendance_date->format('Y') . '-' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Scope: Get attendances by teacher.
     */
    public function scopeByTeacher($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }

    /**
     * Scope: Get attendances by lesson.
     */
    public function scopeByLesson($query, $lessonId)
    {
        return $query->where('lesson_id', $lessonId);
    }

    /**
     * Scope: Get attendances by date range.
     */
    public function scopeDateRange($query, $from, $to)
    {
        return $query->whereBetween('attendance_date', [$from, $to]);
    }

    /**
     * Scope: Get pending attendances.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Get approved attendances.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Check if can be edited.
     */
    public function canBeEdited(): bool
    {
        return $this->status === 'pending';
    }
}
