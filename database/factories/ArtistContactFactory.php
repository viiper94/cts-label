<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class ArtistContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->name(),
            'surname' => fake()->lastName(),
            'artist_name' => fake()->title(),
            'publisher' => fake()->company(),
            'pro' => fake()->company(),
            'date_of_birth' => fake()->date(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'zip' => fake()->postcode(),
            'country' => fake()->country(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'bank' => fake()->company(),
            'place_of_bank' => fake()->city(),
            'account_holder' => fake()->firstName() . ' ' . fake()->lastName(),
            'passport_number' => (string) fake()->numberBetween('99999', '99999999999'),
        ];
    }
}
