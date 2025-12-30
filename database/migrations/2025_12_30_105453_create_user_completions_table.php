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
        Schema::create('user_completions', function (Blueprint $col) {
            $col->id();
            $col->foreignId('user_id')->constrained()->onDelete('cascade');
            $col->foreignId('course_id')->constrained()->onDelete('cascade');
            $col->foreignId('material_id')->nullable()->constrained()->onDelete('cascade');
            $col->foreignId('quiz_id')->nullable()->constrained()->onDelete('cascade');
            $col->timestamp('completed_at')->nullable();
            $col->timestamps();

            // Index for faster lookups
            $col->index(['user_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_completions');
    }
};
