<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teaching_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->date('attendance_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('activity_notes'); // Required
            $table->text('student_notes')->nullable(); // Optional
            $table->string('screenshot_path');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable(); // If rejected
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['teacher_id', 'attendance_date']);
            $table->index('lesson_id');
            $table->index('status');
            
            // Unique constraint: one attendance per lesson per day per teacher
            $table->unique(['teacher_id', 'lesson_id', 'attendance_date'], 'unique_attendance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teaching_attendances');
    }
};
