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
            // Class Enrollment
            $table->foreignId('tahsin_class_id')->nullable()->constrained('tahsin_classes')->onDelete('set null');
            
            // Personal Data
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->integer('age')->nullable();
            $table->text('address')->nullable();
            $table->string('occupation')->nullable();
            
            // For Child Accounts (Kelas Anak)
            $table->boolean('is_child_account')->default(false);
            $table->string('parent_name')->nullable(); // Nama orang tua/wali
            $table->string('child_name')->nullable();  // Nama anak (peserta sebenarnya)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tahsin_class_id']);
            $table->dropColumn([
                'tahsin_class_id',
                'gender',
                'age',
                'address',
                'occupation',
                'is_child_account',
                'parent_name',
                'child_name',
            ]);
        });
    }
};
