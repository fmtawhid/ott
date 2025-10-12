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
        Schema::create('plan', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('identifier');
            $table->string('android_identifier')->nullable(); 
            $table->string('apple_identifier')->nullable(); 
            $table->double('price')->nullable();
            $table->boolean('discount')->default(0); 
            $table->double('discount_percentage')->nullable(); 
            $table->double('total_price')->nullable(); 
            $table->bigInteger('level')->default(0);
            $table->string('duration')->nullable();
            $table->bigInteger('duration_value')->default(1);
            $table->boolean('status')->default(1);
            $table->text('description')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan');
    }
};
