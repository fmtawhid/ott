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
        Schema::table('entertainments', function (Blueprint $table) {
            $table->decimal('price')->nullable();
            $table->string('purchase_type')->nullable();
            $table->integer('access_duration')->nullable();
            $table->string('discount')->nullable();
            $table->integer('available_for')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entertainments', function (Blueprint $table) {
            
        });
    }
};
