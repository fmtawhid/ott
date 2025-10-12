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
        Schema::create('pay_per_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('movie_id')->constrained('entertainments')->onDelete('cascade');
            $table->string('type'); // e.g., 'movie', 'series'
            $table->decimal('content_price', 10, 2);
            $table->decimal('price', 10, 2);
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->datetime('first_play_date')->nullable();
            $table->timestamp('view_expiry_date')->nullable();
            $table->integer('access_duration')->nullable(); // in hours or minutes
            $table->string('available_for')->nullable(); // e.g., 'everyone', 'region:US'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_per_views');
    }
};
