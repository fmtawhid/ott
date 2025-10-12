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
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->string('tmdb_id')->nullable();
            $table->string('season_index')->nullable();
            $table->string('name')->nullable();
            $table->text('poster_url')->nullable();
            $table->unsignedBigInteger('entertainment_id')->nullable();
            $table->string('trailer_url_type')->nullable();
            $table->text('trailer_url')->nullable();
            $table->string('access')->nullable();
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->longText('short_desc')->nullable();
            $table->longText('description')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
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
        Schema::dropIfExists('seasons');
    }
};
