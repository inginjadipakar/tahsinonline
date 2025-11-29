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
}
