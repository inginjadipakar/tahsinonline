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
        Schema::table('lessons', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('lessons', 'video_url')) {
                $table->string('video_url')->nullable()->after('content');
            }
            if (!Schema::hasColumn('lessons', 'video_platform')) {
                $table->enum('video_platform', ['youtube', 'vimeo', 'none'])->default('none')->after('video_url');
            }
            if (!Schema::hasColumn('lessons', 'pdf_file')) {
                $table->string('pdf_file')->nullable()->after('video_platform');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['video_url', 'video_platform', 'pdf_file']);
        });
    }
};
