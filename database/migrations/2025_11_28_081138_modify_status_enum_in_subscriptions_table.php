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
        // Using raw SQL to modify ENUM column as it's the most reliable way for MySQL
        DB::statement("ALTER TABLE subscriptions MODIFY COLUMN status ENUM('active', 'expired', 'pending') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        // Note: This might fail if there are records with 'pending' status
        DB::statement("ALTER TABLE subscriptions MODIFY COLUMN status ENUM('active', 'expired') NOT NULL");
    }
};
