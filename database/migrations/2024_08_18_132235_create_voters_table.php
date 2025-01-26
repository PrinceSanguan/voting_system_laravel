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
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('fingerprint')->nullable();
            $table->string('device_id')->nullable();
            $table->string('email')->nullable();
            $table->string('pin')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('course')->nullable();
            $table->string('year_lvl')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('organization')->nullable();
            $table->string('status')->nullable();
          
            $table->string('otp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voters');
    }
};
