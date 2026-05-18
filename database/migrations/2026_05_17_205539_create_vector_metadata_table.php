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
        // "vector_metadata" table purpose:
        // Stores metadata about vectors inside FAISS.

        // Why This Table Exists
        // Helpful for:
        // - future migrations
        // - vector debugging
        // - multi-model support
        // - vector management

        Schema::create('vector_metadata', function (Blueprint $table) {
            $table->id()->comment('Unique ID for each vector metadata entry');

            $table->foreignId('document_chunk_id')
                ->constrained()
                ->cascadeOnDelete()
                ->comment('References the document chunk this vector represents');

            $table->string('vector_id')->comment('FAISS vector ID unique for each vector');
            $table->string('embedding_model')->nullable()->comment('Model used to generate the vector embedding');
            $table->unsignedInteger('vector_dimensions')->nullable()->comment('Embedding size');
            $table->timestamps();

            $table->index('document_chunk_id');
            $table->index('vector_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vector_metadata');
    }
};
