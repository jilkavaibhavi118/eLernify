<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->integer('duration')->nullable()->after('description');
            // duration in hours

            $table->foreignId('instructor_id')
                  ->nullable()
                  ->after('image')
                  ->constrained('instructors')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['instructor_id']);
            $table->dropColumn(['duration', 'instructor_id']);
        });
    }
};
