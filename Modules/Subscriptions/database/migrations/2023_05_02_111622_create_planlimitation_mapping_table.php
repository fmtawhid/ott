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
        Schema::create('planlimitation_mapping', function (Blueprint $table) {
            $table->id();
            $table->Integer('plan_id')->nullable();
            $table->Integer('planlimitation_id')->nullable();
            $table->string('limitation_slug')->nullable();
            $table->Integer('limitation_value')->nullable();
            $table->longtext('limit')->nullable();
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
        Schema::dropIfExists('planlimitation_mapping');
    }
};
