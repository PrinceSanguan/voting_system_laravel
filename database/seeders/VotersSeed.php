<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\voters;

class VotersSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        voters::factory()->count(2)->create();
    }
}
