<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZoomSession extends Model
{
    protected $fillable = [
        'tahsin_class_id',
        'title',
        'zoom_link',
        'meeting_id',
        'passcode',
        'scheduled_at',
        'duration_minutes',
        'status',
        'description',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function tahsinClass()
    {
        return $this->belongsTo(TahsinClass::class);
    }

    public function isLive()
    {
        return $this->status === 'live' || 
               ($this->status === 'scheduled' && 
                $this->scheduled_at->isPast() && 
                $this->scheduled_at->addMinutes($this->duration_minutes)->isFuture());
    }

    public function isUpcoming()
    {
        return $this->status === 'scheduled' && $this->scheduled_at->isFuture();
    }
}
