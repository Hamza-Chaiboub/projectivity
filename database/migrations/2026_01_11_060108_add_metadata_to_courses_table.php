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
        Schema::table('courses', function (Blueprint $table) {
            $table->string('thumbnail_path')->nullable()->after('description');
            $table->string('intro_video_url')->nullable()->after('thumbnail_path');
            $table->jsonb('prerequisites')->nullable()->after('intro_video_url');
            $table->unsignedInteger('duration')->nullable()->after('prerequisites');
            $table->longText('description')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['thumbnail_path', 'intro_video_url', 'prerequisites', 'duration', 'description']);
        });
    }
};
