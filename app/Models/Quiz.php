<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['lesson_id', 'title', 'description', 'passing_score', 'is_active'];
    
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
    
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }
    
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
    
    /**
     * Get user's best attempt for this quiz
     */
    public function bestAttempt($userId)
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->orderBy('score', 'desc')
            ->first();
    }
    
    /**
     * Check if user has passed this quiz
     */
    public function hasPassed($userId)
    {
        $bestAttempt = $this->bestAttempt($userId);
        return $bestAttempt && $bestAttempt->passed;
    }
}
