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
        // 1. Change ENUM to VARCHAR temporarily to allow any string
        Schema::table('announcements', function (Blueprint $table) {
            $table->string('category', 50)->change();
        });

        // 2. Update existing data to match the new values
        DB::table('announcements')->where('category', 'weekly')->update(['category' => 'mingguan']);
        DB::table('announcements')->where('category', 'monthly')->update(['category' => 'bulanan']);
        DB::table('announcements')->where('category', 'yearly')->update(['category' => 'tahunan']);

        // 3. Change VARCHAR back to the new ENUM
        Schema::table('announcements', function (Blueprint $table) {
            $table->enum('category', ['mingguan', 'bulanan', 'tahunan'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->enum('category', ['weekly', 'monthly', 'yearly'])->change();
        });
    }
};
