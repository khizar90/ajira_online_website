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
        Schema::create('paid_survey_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->references('uuid')->on('users')->onDelete('cascade');
            $table->string('what_car');
            $table->string('where_gas_buy');
            $table->string('color');
            $table->string('age');
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
        Schema::dropIfExists('paid_survey_requests');
    }
};
