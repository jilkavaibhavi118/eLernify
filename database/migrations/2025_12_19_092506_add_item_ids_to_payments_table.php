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
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('material_id')->nullable()->constrained()->onDelete('cascade')->after('course_id');
            $table->foreignId('lecture_id')->nullable()->constrained()->onDelete('cascade')->after('material_id');
            $table->foreignId('quiz_id')->nullable()->constrained()->onDelete('cascade')->after('lecture_id');
            $table->unsignedBigInteger('course_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['material_id']);
            $table->dropForeign(['lecture_id']);
            $table->dropForeign(['quiz_id']);
            $table->dropColumn(['material_id', 'lecture_id', 'quiz_id']);
            $table->unsignedBigInteger('course_id')->nullable(false)->change();
        });
    }
};
