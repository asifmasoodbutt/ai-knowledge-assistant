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
        // "usage_logs" table purpose:
        // Tracks AI consumption and analytics.
        // Very important in real SaaS AI systems.

        // Why This Table Exists
        // Useful for:
        // - analytics
        // - AI monitoring
        // - optimization
        // - future billing systems

        Schema::create('usage_logs', function (Blueprint $table) {
            $table->id()->comment('Unique log ID');

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete()
                ->comment('User associated with this usage log');

            $table->foreignId('chat_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->comment('Chat associated with this usage log');

            $table->foreignId('message_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->comment('Message associated with this usage log');

            $table->string('model_name')->nullable()->comment('AI model used (e.g., gpt-4, gpt-3.5-turbo)');
            $table->unsignedInteger('prompt_tokens')->nullable()->comment('Number of tokens in the prompt');
            $table->unsignedInteger('completion_tokens')->nullable()->comment('Number of tokens in the completion');
            $table->unsignedInteger('total_tokens')->nullable()->comment('Total number of tokens used');
            $table->decimal('estimated_cost', 10, 4)->nullable()->comment('Estimated cost of the request');
            $table->string('request_type')->nullable()->comment('Type of request (e.g., embedding, chat, query)');
            $table->timestamps();

            $table->index('user_id');
            $table->index('chat_id');
            $table->index('message_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usage_logs');
    }
};
