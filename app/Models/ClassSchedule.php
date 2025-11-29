<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSchedule extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'tahsin_class_id',
        'day_of_week',
        'time_start',
        'time_end',
        'is_active',
        'week_start_date',
        'created_by',
        'notes'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'week_start_date' => 'date',
        'time_start' => 'datetime',
        'time_end' => 'datetime',
    ];
    
    public function tahsinClass()
    {
        return $this->belongsTo(TahsinClass::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function getDayIndonesianAttribute()
    {
        $days = [
            'senin' => 'Senin',
            'selasa' => 'Selasa',
            'rabu' => 'Rabu',
            'kamis' => 'Kamis',
            'jumat' => 'Jumat',
            'sabtu' => 'Sabtu',
            'minggu' => 'Minggu'
        ];
        return $days[$this->day_of_week] ?? $this->day_of_week;
    }
}
