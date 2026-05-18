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
        // "failed_ai_requests" table purpose:
        // Stores failed AI communications.

        // Why This Table Exists
        // AI systems fail often because:
        // - model crashes
        // - timeouts
        // - memory limits
        // - invalid input

        // This table helps recovery and debugging.

        Schema::create('failed_ai_requests', function (Blueprint $table) {
            $table->id()->comment('Unique ID for each failed AI request');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->comment('User associated with the failed AI request');

            $table->string('endpoint')->comment('AI service endpoint that failed');
            $table->text('error_message')->comment('Error message for the failed request');
            $table->longText('payload')->nullable()->comment('Request payload sent to AI service');
            $table->unsignedInteger('retry_count')->default(0)->comment('Number of times the request was retried');
            $table->timestamps();

            $table->index('user_id');
            $table->index('endpoint');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_ai_requests');
    }
};
