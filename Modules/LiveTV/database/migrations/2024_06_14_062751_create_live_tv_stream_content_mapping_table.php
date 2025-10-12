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
        Schema::create('live_tv_stream_content_mapping', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tv_channel_id')->unsigned();
            $table->string('type')->nullable(); 
            $table->string('stream_type')->nullable(); 
            $table->longText('embedded')->nullable();
            $table->text('server_url')->nullable();
            $table->text('server_url1')->nullable();
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
        Schema::dropIfExists('live_tv_stream_content_mapping');
    }
};
