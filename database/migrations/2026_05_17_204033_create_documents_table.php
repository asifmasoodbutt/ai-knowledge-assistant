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
        // "documents" table purpose:
        // Stores uploaded file metadata.
        // This is the main entry point of our RAG pipeline.
        // Each uploaded document:
        // belongs to a user
        // gets processed
        // gets chunked
        // gets embedded
        // becomes searchable

        Schema::create('documents', function (Blueprint $table) {
            $table->id()->comment('Unique identifier for each document');

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete()
                ->comment('References the user who uploaded the document');

            $table->string('title')->nullable()->comment('Optional title for the document');
            $table->string('original_name')->comment('Original name of the uploaded file');
            $table->string('stored_name')->comment('Name of the file as stored in the filesystem');
            $table->string('file_path')->comment('Path to the stored file');
            $table->string('file_extension', 20)->comment('Extension of the uploaded file: pdf, docx, txt, etc.');
            $table->string('mime_type')->comment('MIME type of the uploaded file for MIME type validation');
            $table->unsignedBigInteger('file_size')->comment('Size of the uploaded file in bytes');

            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed'
            ])->default('pending')
            ->comment('Processing status of the document in the RAG pipeline');

            $table->longText('extracted_text')->nullable()->comment('Optional cached extracted text');
            $table->timestamp('processed_at')->nullable()->comment('When AI processing completed');
            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
