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
        Schema::table('lectures', function (Blueprint $table) {
            $table->string('zoom_meeting_id')->nullable()->after('live_class_available');
            $table->string('zoom_meeting_password')->nullable()->after('zoom_meeting_id');
            $table->text('zoom_meeting_link')->nullable()->after('zoom_meeting_password');
            $table->date('live_date')->nullable()->after('zoom_meeting_link');
            $table->time('live_time')->nullable()->after('live_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lectures', function (Blueprint $table) {
            $table->dropColumn(['zoom_meeting_id', 'zoom_meeting_password', 'zoom_meeting_link', 'live_date', 'live_time']);
        });
    }
};
