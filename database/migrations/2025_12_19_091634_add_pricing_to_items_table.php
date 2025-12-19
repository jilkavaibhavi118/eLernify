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
        Schema::table('materials', function (Blueprint $table) {
            $table->boolean('is_free')->default(false)->after('description');
            $table->decimal('price', 10, 2)->nullable()->after('is_free');
            $table->string('short_description')->nullable()->after('title');
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->boolean('is_free')->default(false)->after('instructions');
            $table->decimal('price', 10, 2)->nullable()->after('is_free');
            $table->string('short_description')->nullable()->after('title');
        });

        Schema::table('lectures', function (Blueprint $table) {
            $table->boolean('is_free')->default(false)->after('description');
            $table->string('short_description')->nullable()->after('title');
            // Price already exists in lectures
        });

        Schema::table('order_items', function (Blueprint $table) {
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
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['material_id']);
            $table->dropForeign(['lecture_id']);
            $table->dropForeign(['quiz_id']);
            $table->dropColumn(['material_id', 'lecture_id', 'quiz_id']);
            $table->unsignedBigInteger('course_id')->nullable(false)->change();
        });

        Schema::table('lectures', function (Blueprint $table) {
            $table->dropColumn(['is_free', 'short_description']);
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn(['is_free', 'price', 'short_description']);
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['is_free', 'price', 'short_description']);
        });
    }
};
