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
        Schema::table('entertainments', function(Blueprint $table)
        {
            $table->index(['id','status', 'release_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entertainments', function(Blueprint $table)
        {
            $table->dropIndex(['id_status_release_date']);
        });
    }
};
