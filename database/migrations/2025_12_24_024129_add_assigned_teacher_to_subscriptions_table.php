<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreignId('assigned_teacher_id')
                  ->nullable()
                  ->after('tahsin_class_id')
                  ->constrained('users')
                  ->onDelete('set null');
            
            $table->index('assigned_teacher_id');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['assigned_teacher_id']);
            $table->dropIndex(['assigned_teacher_id']);
            $table->dropColumn('assigned_teacher_id');
        });
    }
};
