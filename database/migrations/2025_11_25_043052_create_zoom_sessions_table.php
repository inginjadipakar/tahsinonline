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
        Schema::create('zoom_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahsin_class_id')->constrained('tahsin_classes')->onDelete('cascade');
            $table->string('title');
            $table->string('zoom_link');
            $table->string('meeting_id')->nullable();
            $table->string('passcode')->nullable();
            $table->dateTime('scheduled_at');
            $table->integer('duration_minutes')->default(60); // durasi dalam menit
            $table->enum('status', ['scheduled', 'live', 'completed', 'cancelled'])->default('scheduled');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoom_sessions');
    }
};
