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
        // "messages" table purpose:
        // Stores all chat messages.
        // This includes:
        // - user prompts
        // - AI responses
        // - system prompts

        Schema::create('messages', function (Blueprint $table) {
            $table->id()->comment('Unique message ID');

            $table->foreignId('chat_id')
                ->constrained()
                ->cascadeOnDelete()
                ->comment('Parent chat ID');

            // Why role Exists
            // Possible values:
            // - user
            // - assistant
            // - system
            // This allows conversational reconstruction.
            // Example:
            // User: What is Laravel?
            // Assistant: Laravel is a PHP framework...
            $table->enum('role', [
                'user',
                'assistant',
                'system'
            ])->comment('Message sender role');

            $table->longText('content')->comment('Actual message content');

            // Why Token Columns Exist
            // Important for:
            // - monitoring
            // - analytics
            // - future SaaS billing
            // - optimization
            $table->unsignedInteger('prompt_tokens')->nullable()->comment('Input token count');
            $table->unsignedInteger('completion_tokens')->nullable()->comment('Output token count');
            $table->unsignedInteger('total_tokens')->nullable()->comment('Total token usage');

            // Why response_time_ms Exists
            // Useful for:
            // - performance tracking
            // - AI latency monitoring
            // - debugging slow responses
            $table->unsignedInteger('response_time_ms')->nullable()->comment('AI response duration in milliseconds');
            $table->timestamps();

            $table->index('chat_id');
            $table->index('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
