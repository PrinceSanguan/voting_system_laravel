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
        Schema::create('votingcomponents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('partylist')->nullable()->unique();
            $table->string('position')->nullable();
            $table->string('organization')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votingcomponents');
    }
};
