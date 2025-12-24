<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'tahsin_class_id',
        'assigned_teacher_id',
        'program_type',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the user (student) that owns the subscription.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tahsin class associated with the subscription.
     */
    public function tahsinClass(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TahsinClass::class);
    }

    /**
     * Get the assigned teacher for this subscription.
     */
    public function assignedTeacher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_teacher_id');
    }

    /**
     * Get the evaluations for this subscription.
     */
    public function evaluations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StudentEvaluation::class);
    }

    /**
     * Scope to get subscriptions that need teacher assignment.
     */
    public function scopeNeedsTeacher($query)
    {
        return $query->whereNull('assigned_teacher_id')
                     ->whereIn('status', ['active', 'pending']);
    }

    /**
     * Scope to get subscriptions for a specific teacher.
     */
    public function scopeForTeacher($query, $teacherId)
    {
        return $query->where('assigned_teacher_id', $teacherId);
    }
}
