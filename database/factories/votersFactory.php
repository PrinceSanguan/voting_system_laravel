<?php

namespace Database\Factories;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voter>
 */
class VotersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'device_id' => $this->faker->uuid, // Random unique identifier for the device
            'email' => $this->faker->unique()->safeEmail, // Unique email
            'pin' => Crypt::encryptString('12345678'), // Random 8-digit PIN    
            'first_name' => $this->faker->firstName, // Random first name
            'middle_name' => $this->faker->middleName//Pceholder for middle name
            'last_name' => $this->faker->lastName, // Random last name
            'age' => $this->faker->numberBetween(18, 60), // Random age within a range
            'gender' => $this->faker->randomElement(['Male', 'Female']), // Random gender
            'course' => $this->faker->word, // Random course name
            'year_lvl' => $this->faker->randomElement(['1', '2', '3', '4']), // Random year level
            'address' => $this->faker->address, // Random address
            'phone_number' => $this->faker->phoneNumber, // Random phone number
            'organization' => 'CSC', // Random organization name
            
            'status' => 'registered', // Random status
        ];
    }
}
