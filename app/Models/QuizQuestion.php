<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = ['quiz_id', 'question', 'order'];
    
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
    
    public function options()
    {
        return $this->hasMany(QuizOption::class, 'question_id')->orderBy('order');
    }
    
    /**
     * Get the correct answer option
     */
    public function correctOption()
    {
        return $this->options()->where('is_correct', true)->first();
    }
}
