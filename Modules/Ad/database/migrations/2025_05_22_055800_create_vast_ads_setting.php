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
        Schema::create('vast_ads_setting', function (Blueprint $table) {
            $table->id();
             $table->string('name');
            $table->string('type')->nullable();
            $table->string('url')->nullable();
            $table->string('duration')->nullable();
            $table->string('target_type')->nullable();
            $table->longText('target_selection')->nullable();
            $table->boolean('enable_skip')->default(0);
            $table->string('skip_after')->nullable();
            $table->integer('frequency')->nullable();
            $table->boolean('is_enable')->default(0);
            $table->boolean('status')->default(0);
            $table->timestamps();
             $table->softDeletes();
            
            // Add index for better performance
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vast_ads_setting');
    }
};
