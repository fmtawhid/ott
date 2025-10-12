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
        Schema::create('user_reminder', function (Blueprint $table) {
            $table->id();
            $table->integer('entertainment_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('profile_id')->nullable();
            $table->date('release_date')->nullable();
            $table->boolean('is_remind')->default(0);
            
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
        Schema::dropIfExists('user_reminder');
    }
};
