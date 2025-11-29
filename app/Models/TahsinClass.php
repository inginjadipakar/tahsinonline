<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahsinClass extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function lessons(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function zoomSessions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ZoomSession::class);
    }
    
    public function schedules(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ClassSchedule::class);
    }
    
    public function activeSchedules(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ClassSchedule::class)
            ->where('is_active', true)
            ->orderBy('day_of_week');
    }
    
    public function currentWeekSchedules(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        $weekStart = now()->startOfWeek();
        return $this->hasMany(ClassSchedule::class)
            ->where('is_active', true)
            ->where('week_start_date', $weekStart)
            ->orderBy('day_of_week');
    }
    
    public function isActive(): bool
    {
        return $this->activeSchedules()->exists();
    }
}
