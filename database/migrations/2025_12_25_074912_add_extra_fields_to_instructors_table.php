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
        Schema::table('instructors', function (Blueprint $table) {
            $table->string('designation')->nullable()->after('bio');
            $table->string('specialty')->nullable()->after('designation');
            $table->string('linkedin_url')->nullable()->after('specialty');
            $table->string('twitter_url')->nullable()->after('linkedin_url');
            $table->string('github_url')->nullable()->after('twitter_url');
            $table->string('instagram_url')->nullable()->after('github_url');
            $table->string('website_url')->nullable()->after('instagram_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instructors', function (Blueprint $table) {
            $table->dropColumn(['designation', 'specialty', 'linkedin_url', 'twitter_url', 'github_url', 'instagram_url', 'website_url']);
        });
    }
};
