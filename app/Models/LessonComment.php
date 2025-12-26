<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonComment extends Model
{
    protected $fillable = ['lesson_id', 'user_id', 'parent_id', 'comment'];
    
    protected $with = ['user']; // Eager load user for every comment
    
    /**
     * Comment belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Comment belongs to a lesson
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
    
    /**
     * Comment may have a parent comment (for replies)
     */
    public function parent()
    {
        return $this->belongsTo(LessonComment::class, 'parent_id');
    }
    
    /**
     * Comment may have many replies
     */
    public function replies()
    {
        return $this->hasMany(LessonComment::class, 'parent_id')->orderBy('created_at');
    }
    
    /**
     * Check if comment is a reply
     */
    public function isReply()
    {
        return !is_null($this->parent_id);
    }
}
