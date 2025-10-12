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
        Schema::table('entertainments', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable(); // SEO-friendly URL
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('seo_image')->nullable(); // SEO Image
            $table->string('google_site_verification')->nullable(); // Google Site Verification
            $table->string('canonical_url')->nullable(); // Global Canonical URL
            $table->text('short_description')->nullable(); // Short description
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entertainments', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'meta_title',
                'meta_keywords',
                'meta_description',
                'seo_image',
                'google_site_verification',
                'canonical_url',
                'short_description',
            ]);
        });
    }
};
