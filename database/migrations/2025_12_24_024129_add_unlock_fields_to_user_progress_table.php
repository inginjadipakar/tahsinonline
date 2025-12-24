<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_progress', function (Blueprint $table) {
            $table->boolean('is_unlocked')->default(false)->after('completed_at');
            $table->foreignId('unlocked_by')->nullable()->after('is_unlocked')->constrained('users')->onDelete('set null');
            $table->timestamp('unlocked_at')->nullable()->after('unlocked_by');
        });
    }

    public function down(): void
    {
        Schema::table('user_progress', function (Blueprint $table) {
            $table->dropForeign(['unlocked_by']);
            $table->dropColumn(['is_unlocked', 'unlocked_by', 'unlocked_at']);
        });
    }
};
