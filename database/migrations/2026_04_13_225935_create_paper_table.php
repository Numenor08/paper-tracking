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
        Schema::create('papers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('status', ['DRAFT', 'READY-TO-SUBMITTED', 'SUBMITTED', 'UNDER-REVIEW', 'REVISION-REQUESTED', 'ACCEPTED', 'REJECTED', 'PUBLISHED'])->default('DRAFT');
            $table->text('abstract');
            $table->string('title');
            $table->string('publication');
            $table->string('note')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('publication_index_id')->constrained('publication_indexes')->onDelete('cascade');
            // $table->foreignId('file_attachment')->constrained('file_attachments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('papers');
    }
};
