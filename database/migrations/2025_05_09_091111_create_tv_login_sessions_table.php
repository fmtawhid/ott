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
        Schema::create('tv_login_sessions', function (Blueprint $table) {
            $table->id();
            $table->uuid('session_id')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tv_login_sessions');
    }
};
