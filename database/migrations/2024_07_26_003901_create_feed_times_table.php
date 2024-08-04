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
        Schema::create('feed_times', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->time('feed_time', 0);
            // $table->foreignId('pet_id')->references('id')->on('pets');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed_times');
    }
};
