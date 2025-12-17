<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->string('type')->default('file')->after('description'); // file, video, url
            $table->string('content_url')->nullable()->after('file_path');
        });

        // Make file_path nullable to support URL-only materials
        DB::statement('ALTER TABLE materials MODIFY file_path VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['type', 'content_url']);
        });
        
        // Revert file_path to not null (warning: will fail if nulls exist)
        // DB::statement('ALTER TABLE materials MODIFY file_path VARCHAR(255) NOT NULL');
    }
};
