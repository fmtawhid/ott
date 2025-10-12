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

        Schema::table('genres', function(Blueprint $table)
        {
            $table->index(['id','deleted_at']);
        });

        Schema::table('continue_watch', function(Blueprint $table)
        {
            $table->index(['user_id','profile_id','deleted_at']);
        });

        if (!$this->indexExists('media', 'media_model_type_model_id_index')) {
            Schema::table('media', function (Blueprint $table) {
                $table->index(['model_type', 'model_id']);
            });
        }

        Schema::table('plan', function(Blueprint $table)
        {
            $table->index(['level','deleted_at']);
        });

        Schema::table('planlimitation_mapping', function(Blueprint $table)
        {
            $table->index(['plan_id','deleted_at']);
        });

        Schema::table('episodes', function(Blueprint $table)
        {
            $table->index(['id','deleted_at']);
        });

        Schema::table('entertainments', function(Blueprint $table)
        {
            $table->index(['id','deleted_at']);
        });


        Schema::table('mobile_settings', function(Blueprint $table)
        {
            $table->index(['slug','deleted_at']);
        });

        Schema::table('banners', function(Blueprint $table)
        {
            $table->index(['status','deleted_at']);
        });

        Schema::table('entertainments', function(Blueprint $table)
        {
            $table->index(['id','status', 'release_date', 'deleted_at']);
        });

        Schema::table('entertainment_gener_mapping', function(Blueprint $table)
        {
            $table->index(['entertainment_id','deleted_at']);
        });

        Schema::table('plan', function(Blueprint $table)
        {
            $table->index(['id','deleted_at']);
        });

        Schema::table('watchlists', function(Blueprint $table)
        {
            $table->index(['id','deleted_at']);
        });
    }
    private function indexExists(string $table, string $indexName): bool
    {
        return DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]) ? true : false;
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('genres', function(Blueprint $table)
        {
            $table->dropIndex(['id_deleted_at']);
        });

        Schema::table('continue_watch', function(Blueprint $table)
        {
            $table->dropIndex(['user_id_profile_id_deleted_at']);
        });

        Schema::table('media', function(Blueprint $table)
        {
            $table->dropIndex(['model_type_model_id']);
        });

        Schema::table('plan', function(Blueprint $table)
        {
            $table->dropIndex(['level_deleted_at']);
        });

        Schema::table('planlimitation_mapping', function(Blueprint $table)
        {
            $table->dropIndex(['plan_id_deleted_at']);
        });

        Schema::table('episodes', function(Blueprint $table)
        {
            $table->dropIndex(['id_deleted_at']);
        });

        Schema::table('entertainments', function(Blueprint $table)
        {
            $table->dropIndex(['id_deleted_at']);
        });

        Schema::table('mobile_settings', function(Blueprint $table)
        {
            $table->dropIndex(['slug_deleted_at']);
        });

        Schema::table('banners', function(Blueprint $table)
        {
            $table->dropIndex(['status_deleted_at']);
        });

        Schema::table('entertainments', function(Blueprint $table)
        {
            $table->dropIndex(['id_status_release_date_deleted_at']);
        });

        Schema::table('entertainment_gener_mapping', function(Blueprint $table)
        {
            $table->dropIndex(['entertainment_id_deleted_at']);
        });

        Schema::table('plan', function(Blueprint $table)
        {
            $table->dropIndex(['id_deleted_at']);
        });

        Schema::table('watchlists', function(Blueprint $table)
        {
            $table->dropIndex(['id_deleted_at']);
        });
    }
};
