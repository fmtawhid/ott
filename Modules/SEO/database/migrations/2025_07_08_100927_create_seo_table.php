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
        Schema::create('seo', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->nullable(); // Optional: For SEO-friendly URL
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();

            // Fields based on the image
            $table->string('seo_image')->nullable(); // SEO Image
            $table->string('google_site_verification')->nullable(); // Google Site Verification
            $table->string('canonical_url')->nullable(); // Global Canonical URL
            $table->text('short_description')->nullable(); // Short description

            $table->timestamps(); // To track when it was created/updated
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo');
    }
};
