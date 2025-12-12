<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teacher_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tahsin_class_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'tahsin_class_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_classes');
    }
};
