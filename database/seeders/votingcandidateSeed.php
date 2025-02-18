<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\votingcandidate;

class votingcandidateSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        votingcandidate::factory()->count(2)->create();
    }
}
