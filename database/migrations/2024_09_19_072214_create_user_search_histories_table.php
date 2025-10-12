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
        Schema::create('user_search_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Nullable if users aren't authenticated
            $table->unsignedBigInteger('profile_id')->nullable(); // Nullable if users aren't authenticated
            $table->string('search_query')->nullable(); //movie name
            $table->unsignedBigInteger('search_id')->nullable(); // movie id
            $table->string('type')->nullable(); //movie,tvshow,
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_search_histories');
    }
};
