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
        // Try to drop foreign keys if they still exist
        try {
            Schema::table('messages', function (Blueprint $table) {
                $table->dropForeign(['sender_id']);
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('messages', function (Blueprint $table) {
                $table->dropForeign(['receiver_id']);
            });
        } catch (\Exception $e) {}

        // Modify column types to match user.id (which is INT 11)
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE messages MODIFY sender_id INT(11) NOT NULL");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE messages MODIFY receiver_id INT(11) NULL");

        // Add correct foreign keys
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE messages ADD CONSTRAINT messages_sender_id_foreign FOREIGN KEY (sender_id) REFERENCES user (id) ON DELETE CASCADE");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE messages ADD CONSTRAINT messages_receiver_id_foreign FOREIGN KEY (receiver_id) REFERENCES user (id) ON DELETE CASCADE");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['sender_id']);
            $table->dropForeign(['receiver_id']);
            
            $table->foreign('sender_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('receiver_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};
