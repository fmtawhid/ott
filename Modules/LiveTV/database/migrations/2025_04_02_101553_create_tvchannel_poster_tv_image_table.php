<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Constant\Models\Constant;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('live_tv_channel', function (Blueprint $table) {
            $table->text('poster_tv_url')->nullable();
        });
        Constant::create([
            'type' => 'STREAM_TYPE',
            'name' => 'x265',
            'value' => 'x265',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_tv_channel');
    }
};
