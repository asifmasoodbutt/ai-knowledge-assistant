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
        // "message_sources" table purpose:
        // Maps AI responses to retrieved document chunks.
        // This enables:
        // - source attribution
        // - explainability
        // - RAG traceability
        // One of the most important AI-production concepts.

        // Without this:
        // - you cannot explain AI answers
        // - no traceability
        // - no debugging
        // - no source citations

        Schema::create('message_sources', function (Blueprint $table) {
            $table->id()->comment('Unique ID for each message source mapping');

            $table->foreignId('message_id')
                ->constrained()
                ->cascadeOnDelete()
                ->comment('AI response message');

            $table->foreignId('document_chunk_id')
                ->constrained()
                ->cascadeOnDelete()
                ->comment('Retrieved chunk');

            // Shows:
            // - retrieval confidence
            // - chunk relevance
            // - debugging information
            // Example:
            // 0.95 = highly relevant
            // 0.40 = weak match
            $table->decimal('similarity_score', 8, 5)->nullable()->comment('Vector similarity score');

            $table->timestamps();

            $table->index('message_id');
            $table->index('document_chunk_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_sources');
    }
};
