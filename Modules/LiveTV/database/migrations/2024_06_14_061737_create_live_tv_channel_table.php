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
        Schema::create('live_tv_channel', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('poster_url')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->text('thumb_url')->nullable();
            $table->string('access')->nullable();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('live_tv_channel');
    }
};
