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
        // "ai_request_logs" table purpose:
        // Logs communication between Laravel and Python AI service.

        // Why This Table Exists
        // Critical for:
        // - debugging
        // - monitoring
        // - AI observability
        // - troubleshooting

        Schema::create('ai_request_logs', function (Blueprint $table) {
            $table->id()->comment('Unique log ID');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->comment('User associated with this AI request');

            $table->string('endpoint')->comment('AI service endpoint called');
            $table->longText('request_payload')->nullable()->comment('Request payload sent to AI service');
            $table->longText('response_payload')->nullable()->comment('Response payload received from AI service');
            $table->unsignedInteger('status_code')->nullable()->comment('HTTP status code of the request');
            $table->unsignedInteger('duration_ms')->nullable()->comment('Request duration in milliseconds');
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
        Schema::dropIfExists('ai_request_logs');
    }
};
