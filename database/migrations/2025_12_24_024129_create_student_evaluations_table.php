<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lesson_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('subscription_id')->constrained()->onDelete('cascade');
            
            // Rating 1-5
            $table->tinyInteger('makhraj_accuracy')->unsigned()->nullable();
            $table->tinyInteger('tajweed_accuracy')->unsigned()->nullable();
            $table->tinyInteger('fluency')->unsigned()->nullable();
            
            // Notes
            $table->text('strengths')->nullable();
            $table->text('areas_for_improvement')->nullable();
            $table->text('homework_notes')->nullable();
            
            // Recommendation
            $table->enum('recommendation', ['repeat', 'continue', 'accelerate'])->nullable();
            
            $table->timestamps();
            
            // One evaluation per lesson per student per teacher
            $table->unique(['student_id', 'teacher_id', 'lesson_id', 'subscription_id'], 'unique_evaluation');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_evaluations');
    }
};
