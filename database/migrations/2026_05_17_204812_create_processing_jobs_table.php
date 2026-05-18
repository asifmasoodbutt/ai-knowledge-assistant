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
        // "processing_jobs" table purpose:
        // Tracks asynchronous document processing.
        // Helpful because AI workflows are multi-step.

        // Why This Table Exists
        // AI pipelines fail often.
        // This helps:
        // - debugging
        // - retries
        // - monitoring
        // - observability

        // Example Workflow
        // PDF Upload
        // → Extraction
        // → Chunking
        // → Embedding
        // → Indexing

        // Each can be tracked independently.

        Schema::create('processing_jobs', function (Blueprint $table) {
            $table->id()->comment('Unique job ID');

            $table->foreignId('document_id')
                ->constrained()
                ->cascadeOnDelete()
                ->comment('Related document');

            $table->enum('job_type', [
                'extraction',
                'chunking',
                'embedding',
                'indexing'
            ])->comment('Type of AI processing job');

            $table->enum('status', [
                'pending',
                'running',
                'completed',
                'failed'
            ])->default('pending')
                ->comment('Current job status');

            $table->timestamp('started_at')->nullable()->comment('When job started');
            $table->timestamp('completed_at')->nullable()->comment('When job completed');
            $table->text('error_message')->nullable()->comment('Error message if job failed');
            $table->timestamps();

            $table->index('document_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processing_jobs');
    }
};
