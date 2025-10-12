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
        Schema::create('continue_watch', function (Blueprint $table) {
            $table->id();
            $table->integer('entertainment_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('profile_id')->nullable();
            $table->string('entertainment_type')->nullable();
            $table->string('watched_time')->nullable();
            $table->string('total_watched_time')->nullable();

            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('continue_watch');
    }
};
