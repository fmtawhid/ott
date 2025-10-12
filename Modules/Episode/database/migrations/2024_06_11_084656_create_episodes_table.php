<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('poster_url')->nullable();
            $table->unsignedBigInteger('entertainment_id')->nullable();
            $table->unsignedBigInteger('season_id')->nullable();
            $table->string('trailer_url_type')->nullable();
            $table->text('trailer_url')->nullable();
            $table->string('access')->nullable();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->string('IMDb_rating')->nullable();
            $table->longtext('content_rating')->nullable();
            $table->string('duration')->nullable();
            $table->date('release_date')->nullable();
            $table->boolean('is_restricted')->default(0);
            $table->longText('short_desc')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('enable_quality')->default(0);
            $table->string('video_upload_type')->nullable();
            $table->text('video_url_input')->nullable();
            $table->boolean('download_status')->default(0);
            $table->string('download_type')->nullable();
            $table->text('download_url')->nullable();
            $table->boolean('enable_download_quality')->default(0);
            $table->boolean('status')->default(0);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->text('video_quality_url')->nullable();
            $table->string('tmdb_id')->nullable();
            $table->string('tmdb_season')->nullable();
            $table->string('episode_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episodes');
    }
};
