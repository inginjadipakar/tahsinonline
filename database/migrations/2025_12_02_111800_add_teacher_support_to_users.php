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
        Schema::table('users', function (Blueprint $table) {
            // Add column for teacher's assigned class
            $table->foreignId('assigned_class_id')
                ->nullable()
                ->after('tahsin_class_id')
                ->constrained('tahsin_classes')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['assigned_class_id']);
            $table->dropColumn('assigned_class_id');
        });
    }
};
