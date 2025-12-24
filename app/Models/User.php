<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'phone',
        'password',
        'role',
        'tahsin_class_id',
        'assigned_class_id',
        'gender',
        'age',
        'address',
        'occupation',
        'is_child_account',
        'parent_name',
        'child_name',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_child_account' => 'boolean',
        ];
    }

    /**
     * Get the subscriptions associated with the user.
     */
    public function subscriptions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the latest/primary subscription associated with the user (Backward Compatibility).
     */
    public function subscription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Subscription::class)->latestOfMany();
    }

    /**
     * Get the payments associated with the user.
     */
    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the user progress records.
     */
    public function userProgress(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Get the tahsin class enrolled by the user.
     */
    public function tahsinClass(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TahsinClass::class);
    }

    /**
     * Get the tahsin class assigned to teacher.
     */
    /**
     * Get the tahsin class assigned to teacher.
     */
    public function assignedClass(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TahsinClass::class, 'assigned_class_id');
    }

    /**
     * Get the tahsin classes assigned to teacher (Many-to-Many).
     */
    public function assignedClasses(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(TahsinClass::class, 'teacher_classes');
    }

    /**
     * Helper to get all teacher classes (backward compatible).
     */
    public function getTeacherClasses(): \Illuminate\Support\Collection
    {
        // Priority: pivot table (with count check to avoid executing query if not loaded/needed, 
        // but for safety we should just load it or check count)
        // If we want to return a collection of models:
        $classes = $this->assignedClasses;

        if ($classes->isNotEmpty()) {
            return $classes;
        }

        // Fallback: assigned_class_id
        if ($this->assigned_class_id && $this->assignedClass) {
            return collect([$this->assignedClass]);
        }

        return collect();
    }

    /**
     * Get lessons created by this teacher.
     */
    public function createdLessons(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Lesson::class, 'created_by');
    }

    /**
     * Check if user is a teacher.
     */
    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    /**
     * Get students assigned to this teacher (via subscriptions).
     */
    public function assignedStudents(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            Subscription::class,
            'assigned_teacher_id', // Foreign key on subscriptions table
            'id', // Foreign key on users table
            'id', // Local key on users table (teacher)
            'user_id' // Local key on subscriptions table
        );
    }

    /**
     * Get subscriptions where this teacher is assigned.
     */
    public function teacherSubscriptions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Subscription::class, 'assigned_teacher_id');
    }

    /**
     * Get evaluations given by this teacher.
     */
    public function givenEvaluations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StudentEvaluation::class, 'teacher_id');
    }

    /**
     * Get evaluations received by this student.
     */
    public function receivedEvaluations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StudentEvaluation::class, 'student_id');
    }

    /**
     * Scope for active teachers.
     */
    public function scopeActiveTeachers($query)
    {
        return $query->where('role', 'teacher');
    }
}
