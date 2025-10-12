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
        Schema::create('entertainment_downloads', function (Blueprint $table) {
            $table->id();
            $table->integer('entertainment_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('entertainment_type')->nullable();
            $table->boolean('is_download')->default(0);
            $table->string('type')->nullable();
            $table->string('quality')->nullable();
            $table->string('device_id')->nullable();
            $table->text('url')->nullable();
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
        Schema::dropIfExists('entertainment_downloads');
    }
};
