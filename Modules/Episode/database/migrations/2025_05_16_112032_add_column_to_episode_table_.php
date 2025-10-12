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
        Schema::table('episodes', function (Blueprint $table) {
            $table->boolean('enable_subtitle')->default(false);
            $table->string('subtitle_file')->nullable();
            $table->string('subtitle_language')->nullable();
            $table->boolean('is_default_subtitle')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('episodes', function (Blueprint $table) {
            
        });
    }
};
