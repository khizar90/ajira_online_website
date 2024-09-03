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
        Schema::create('apprenticeship_opportunities', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->references('uuid')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('country_code');
            $table->string('phone');
            $table->string('email');
            $table->string('city');
            $table->string('country');
            $table->string('date');
            $table->string('department');
            $table->text('skill');
            $table->integer('status')->default(0);
            $table->string('change_by')->default('');
            $table->text('reason');
            $table->string('approve_time')->default('');
            $table->string('cancel_time')->default('');
            $table->string('time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apprenticeship_opportunities');
    }
};
