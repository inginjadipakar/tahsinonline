<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            // File upload fields
            $table->string('file_path')->nullable()->after('content');
            $table->string('file_type', 50)->nullable()->after('file_path');
            $table->integer('file_size')->nullable()->after('file_type')->comment('File size in KB');

            // Track who created the lesson
            $table->foreignId('created_by')
                ->nullable()
                ->after('file_size')
                ->constrained('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['file_path', 'file_type', 'file_size', 'created_by']);
        });
    }
};
