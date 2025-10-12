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
        Schema::create('custom_ads_setting', function (Blueprint $table) {
            $table->id();
            
            $table->string('name');                   
            $table->string('type'); 
            $table->string('url_type');                    
            $table->string('placement')->nullable();                           
            $table->string('media')->nullable();                          
            $table->string('redirect_url')->nullable();   
            $table->string('duration')->nullable();
            $table->boolean('skip_enabled')->default(0);
            $table->string('skip_after')->nullable();  
            $table->string('target_content_type')->nullable();
            $table->longText('target_categories')->nullable();      
            $table->integer('max_views')->nullable();
            $table->boolean('is_enable')->default(0);     
            $table->boolean('status')->default(0);     
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
