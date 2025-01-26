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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('email')->nullable();
            $table->string('pin')->nullable();
            $table->string('name')->unique()->nullable();
            $table->string('role')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('Designation')->nullable();
            $table->string('Organization')->nullable();
            $table->string('Status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
