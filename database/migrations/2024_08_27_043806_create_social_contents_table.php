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
        Schema::create('social_contents', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('name');
            $table->string('job_count');
            $table->string('price_per_job');
            $table->longText('instructions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_contents');
    }
};
