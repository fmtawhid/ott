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
        Schema::table('user_multi_profiles', function (Blueprint $table) {
            $table->boolean('is_child_profile')->default(0)->after('avatar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_multi_profiles', function (Blueprint $table) {
            Schema::dropColumn('is_child_profile');
        });
    }
};
