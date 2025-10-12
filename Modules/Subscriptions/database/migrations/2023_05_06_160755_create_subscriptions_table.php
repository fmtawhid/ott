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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->Integer('plan_id')->nullable();
            $table->Integer('user_id')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('status')->nullable();
            $table->double('amount')->nullable();
            $table->double('discount_percentage')->nullable();
            $table->double('tax_amount')->nullable();
            $table->double('total_amount')->nullable();
            $table->string('name')->nullable();
            $table->string('identifier')->nullable();
            $table->string('type')->nullable();
            $table->Integer('duration')->nullable();
            $table->bigInteger('level')->default(0);
            $table->longText('plan_type')->nullable();
            $table->Integer('payment_id')->nullable();
            $table->string('device_id')->nullable();
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
        Schema::dropIfExists('subscriptions');
    }
};
