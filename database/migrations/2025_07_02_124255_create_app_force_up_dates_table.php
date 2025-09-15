<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_force_up_dates', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('platform')->default(0);
            $table->string('app_min_version');
            $table->string('app_latest_version');
            $table->string('update_message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_force_up_dates');
    }
};
