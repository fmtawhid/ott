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
        Schema::create('cast_crew', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('file_url')->nullable();
            $table->string('type')->nullable();
            $table->string('tmdb_id')->nullable();
            $table->longText('bio')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('dob')->nullable();
            $table->string('designation')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->softDeletes();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cast_crew');
    }
};
