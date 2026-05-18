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
        // "document_chunks" table purpose:
        // Stores chunked pieces of document text.
        // This is one of the most important tables in the system.
        // Large documents cannot directly be sent to LLMs because:
        // - token limits
        // - performance
        // - relevance issues
        // So documents are split into smaller chunks.

        Schema::create('document_chunks', function (Blueprint $table) {
            $table->id()->comment('Unique chunk ID');

            $table->foreignId('document_id')
                ->constrained()
                ->cascadeOnDelete()
                ->comment('References the original document');

            // Why chunk_index Exists?
            // It maintains:
            // - original ordering
            // - context reconstruction
            // - debugging
            $table->unsignedInteger('chunk_index')->comment('Chunk order inside document');
            $table->longText('chunk_text')->comment('Actual chunk content');
            $table->unsignedInteger('token_count')->nullable()->comment('Number of tokens in the chunk');

            // Why embedding_reference Exists?
            // FAISS stores vectors separately in memory/indexes.
            // This field maps:
            // database chunk → FAISS vector
            $table->string('embedding_reference')->nullable()->comment('FAISS/vector reference for this chunk');

            // Why metadata Exists
            // Future flexibility.
            // Can store:
            // - page number
            // - section title
            // - chunk strategy
            // - model used
            // - confidence score
            $table->json('metadata')->nullable()->comment('Additional AI metadata for this chunk');
            $table->timestamps();

            $table->index('document_id');
            $table->index('chunk_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_chunks');
    }
};
