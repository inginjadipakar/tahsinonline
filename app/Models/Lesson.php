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
        'video_platform',
        'pdf_file',
        'zoom_link',
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

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\LessonComment::class)->whereNull('parent_id')->orderBy('created_at', 'desc');
    }

    public function quiz(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\Quiz::class);
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

    /**
     * Get embeddable video URL for YouTube/Vimeo.
     */
    public function getEmbedUrl(): ?string
    {
        if ($this->video_platform === 'none' || empty($this->video_url)) {
            return null;
        }

        if ($this->video_platform === 'youtube') {
            // Convert various YouTube URL formats to embed
            // https://www.youtube.com/watch?v=VIDEO_ID
            // https://youtu.be/VIDEO_ID
            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]+)/', $this->video_url, $matches)) {
                return 'https://www.youtube.com/embed/' . $matches[1];
            }
            \Log::warning("Invalid YouTube URL format: {$this->video_url} for lesson ID {$this->id}");
        }

        if ($this->video_platform === 'vimeo') {
            // Convert Vimeo URL to embed
            // https://vimeo.com/VIDEO_ID
            if (preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $matches)) {
                return 'https://player.vimeo.com/video/' . $matches[1];
            }
            \Log::warning("Invalid Vimeo URL format: {$this->video_url} for lesson ID {$this->id}");
        }

        return null;
    }

    /**
     * Check if lesson has valid video embed URL.
     */
    public function hasValidVideo(): bool
    {
        return $this->hasVideo() && !is_null($this->getEmbedUrl());
    }

    /**
     * Check if lesson has video.
     */
    public function hasVideo(): bool
    {
        return $this->video_platform !== 'none' && !empty($this->video_url);
    }

    /**
     * Check if lesson has PDF.
     */
    public function hasPdf(): bool
    {
        return !empty($this->pdf_file);
    }

    /**
     * Check if lesson has Zoom link.
     */
    public function hasZoomLink(): bool
    {
        return !empty($this->zoom_link) && filter_var($this->zoom_link, FILTER_VALIDATE_URL);
    }
}
