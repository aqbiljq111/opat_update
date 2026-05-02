<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('messages')) {
            Schema::create('messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
                // Jika receiver_id null, artinya pesan ke forum general admin
                $table->foreignId('receiver_id')->nullable()->constrained('users')->cascadeOnDelete();
                $table->text('message');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
