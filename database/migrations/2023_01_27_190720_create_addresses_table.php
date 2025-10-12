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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();

            $table->string('postal_code')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country');

            $table->double('latitude')->default();
            $table->double('longitude')->default();

            $table->boolean('is_primary')->default(0);
            $table->morphs('addressable');

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
        Schema::dropIfExists('addresses');
    }
};
