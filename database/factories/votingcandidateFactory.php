<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VotingCandidate>
 */
class VotingCandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->middleName, // Using lastName as a placeholder for middle name
            'last_name' => $this->faker->lastName,
            'partylist' => '',
            'position' => 'Secretary',
            'organization' => 'CSC',
            'election_title' => 'CSC 2025',
            'election_year' => 2025,
            'candidate_image' => $this->faker->imageUrl(640, 480, 'people', true, 'Candidate'),
            'cert_of_candidacy' => $this->faker->boolean, // Assume this is a boolean (true/false) field
            'vote' => 0, // Number of votes
        ];
    }
}
