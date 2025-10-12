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
        Schema::table('users', function (Blueprint $table) {
            $table->index('deleted_at');
        });

        Schema::table('entertainment_gener_mapping', function (Blueprint $table) {
            $table->index('genre_id');
            $table->index('deleted_at');
        });

        Schema::table('entertainment_talent_mapping', function (Blueprint $table) {
            $table->index('entertainment_id');
            $table->index('deleted_at');
        });

        Schema::table('cast_crew', function (Blueprint $table) {
            $table->index('deleted_at');
        });

        Schema::table('episodes', function (Blueprint $table) {
            $table->index('entertainment_id');
            $table->index('status');
            $table->index('deleted_at');
            $table->index('season_id');
        });

        Schema::table('episode_stream_content_mapping', function (Blueprint $table) {
            $table->index('episode_id');
            $table->index('deleted_at');
        });

        Schema::table('seasons', function (Blueprint $table) {
            $table->index('entertainment_id');
            $table->index('deleted_at');
        });

        Schema::table('entertainments', function (Blueprint $table) {
            $table->index('type');
            $table->index('release_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['deleted_at']);
        });

        Schema::table('entertainment_gener_mapping', function (Blueprint $table) {
            $table->dropIndex(['genre_id']);
            $table->dropIndex(['deleted_at']);
        });

        Schema::table('entertainment_talent_mapping', function (Blueprint $table) {
            $table->dropIndex(['entertainment_id']);
            $table->dropIndex(['deleted_at']);
        });

        Schema::table('cast_crew', function (Blueprint $table) {
            $table->dropIndex(['deleted_at']);
        });

        Schema::table('episodes', function (Blueprint $table) {
            $table->dropIndex(['entertainment_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['deleted_at']);
            $table->dropIndex(['season_id']);
        });

        Schema::table('episode_stream_content_mapping', function (Blueprint $table) {
            $table->dropIndex(['episode_id']);
            $table->dropIndex(['deleted_at']);
        });

        Schema::table('seasons', function (Blueprint $table) {
            $table->dropIndex(['entertainment_id']);
            $table->dropIndex(['deleted_at']);
        });

        Schema::table('entertainments', function (Blueprint $table) {
            $table->dropIndex(['type']);
            $table->dropIndex(['release_date']);
            $table->dropIndex(['status']);
        });
    }
};
