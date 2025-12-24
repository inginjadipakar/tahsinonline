<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentEvaluation extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id',
        'lesson_id',
        'subscription_id',
        'makhraj_accuracy',
        'tajweed_accuracy',
        'fluency',
        'strengths',
        'areas_for_improvement',
        'homework_notes',
        'recommendation',
    ];

    /**
     * Get the student being evaluated.
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the teacher who made the evaluation.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the lesson being evaluated.
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get the subscription this evaluation belongs to.
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Calculate the overall rating (average of all ratings).
     */
    public function getOverallRatingAttribute()
    {
        $ratings = array_filter([
            $this->makhraj_accuracy,
            $this->tajweed_accuracy,
            $this->fluency,
        ]);

        return count($ratings) > 0 ? round(array_sum($ratings) / count($ratings), 1) : null;
    }

    /**
     * Get recommendation label in Indonesian.
     */
    public function getRecommendationLabelAttribute()
    {
        return match($this->recommendation) {
            'repeat' => 'Ulangi Materi',
            'continue' => 'Lanjut ke Materi Berikutnya',
            'accelerate' => 'Percepat (Lewati Materi)',
            default => '-',
        };
    }
}
