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
        // "chats" table purpose:
        // Represents a conversation session.
        // Example:
        // Chat #1 → “Laravel Documentation Questions”
        // Chat #2 → “Fintech PDF Analysis”
        // A user can have multiple chats.

        Schema::create('chats', function (Blueprint $table) {
            $table->id()->comment('Unique chat ID');

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete()
                ->comment('ID of the user who owns this chat');

            $table->string('title')->nullable()->comment('Chat title');

            // Why last_message_at Exists
            // Useful for:
            // - sorting recent chats
            // - chat sidebar ordering
            // - activity tracking
            $table->timestamp('last_message_at')->nullable()->comment('Latest activity tracking');
            $table->timestamps();

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
