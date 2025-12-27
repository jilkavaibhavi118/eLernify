<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'duration')) {
                $table->integer('duration')->nullable()->after('description');
            }

            if (!Schema::hasColumn('courses', 'instructor_id')) {
                $table->foreignId('instructor_id')
                      ->nullable()
                      ->after('image')
                      ->constrained('instructors')
                      ->nullOnDelete();
            }
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
