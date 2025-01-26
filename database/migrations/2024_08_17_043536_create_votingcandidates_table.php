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
        Schema::create('votingcandidates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('partylist')->nullable();
            $table->string('position')->nullable();
            $table->string('organization')->nullable();
            $table->string('election_title')->nullable();
            $table->string('election_year')->nullable();
            $table->string('candidate_image')->nullable();
            $table->string('cert_of_candidacy')->nullable();
            $table->string('vote')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votingcandidates');
    }
};
