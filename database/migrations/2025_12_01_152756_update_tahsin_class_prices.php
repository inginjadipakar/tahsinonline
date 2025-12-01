<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('tahsin_classes')
            ->where('name', 'Tahsin Anak Privat')
            ->update(['price' => 350000]);

        DB::table('tahsin_classes')
            ->where('name', 'Tahsin Reguler (Dewasa)')
            ->update(['price' => 120000]);

        DB::table('tahsin_classes')
            ->where('name', 'Tahsin Privat (Dewasa)')
            ->update(['price' => 300000]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback to previous prices
        DB::table('tahsin_classes')
            ->where('name', 'Tahsin Anak Privat')
            ->update(['price' => 300000]);

        DB::table('tahsin_classes')
            ->where('name', 'Tahsin Reguler (Dewasa)')
            ->update(['price' => 200000]);

        DB::table('tahsin_classes')
            ->where('name', 'Tahsin Privat (Dewasa)')
            ->update(['price' => 400000]);
    }
};
