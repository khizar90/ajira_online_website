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
        Schema::create('app_test_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->references('uuid')->on('users')->onDelete('cascade');
            $table->string('full_name');
            $table->string('email');
            $table->string('country_code');
            $table->string('phone');
            $table->string('smart_phone');
            $table->string('tested')->default('');
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
        Schema::dropIfExists('app_test_requests');
    }
};
