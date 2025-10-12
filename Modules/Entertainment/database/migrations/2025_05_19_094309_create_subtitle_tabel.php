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
        Schema::create('subtitles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entertainment_id')->nullable()->constrained('entertainments')->onDelete('cascade');
            $table->string('type')->default('movie'); // 'movie' or 'episode'
            $table->string('language');
            $table->string('language_code');
            $table->string('subtitle_file');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('');
    }
};
