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
        Schema::create('contributor_paper', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('contributor_id')->constrained('contributors')->onDelete('cascade');
            $table->foreignUuid('paper_id')->constrained('papers')->onDelete('cascade');
            $table->string('role')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributor_paper');
    }
};
