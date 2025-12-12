<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'tahsin_class_id',
        'title',
        'description',
        'content',
        'video_url',
        'file_path',
        'file_type',
        'file_size',
        'created_by',
        'order',
    ];

    public function tahsinClass(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TahsinClass::class);
    }

    public function userProgress(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    public function isCompletedBy($userId): bool
    {
        return $this->userProgress()->where('user_id', $userId)->where('is_completed', true)->exists();
    }

    /**
     * Get the teacher who created this lesson.
     */
    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check if lesson has uploaded file.
     */
    public function hasFile(): bool
    {
        return !empty($this->file_path);
    }

    /**
     * Scope to filter lessons by teacher.
     */
    public function scopeByTeacher($query, $teacherId)
    {
        return $query->where('created_by', $teacherId);
    }
}
