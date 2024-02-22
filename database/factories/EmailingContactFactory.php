<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\EmailingContact>
 */
class EmailingContactFactory extends Factory{

    public function definition(): array{
        return [
            'name' => fake()->name(),
            'full_name' => fake()->name() . ' ' . fake()->lastName(),
            'email' => fake()->email(),
            'company' => fake()->company(),
            'position' => fake()->title(),
            'additional' => fake()->sentence(),
            'phone' => fake()->phoneNumber(),
            'website' => fake()->url(),
            'country' => fake()->country(),
            'company_foa' => fake()->text(6),
            'lang' => 'en',
            'error_log' => null
        ];
    }

    public function simple(): array{
        return [
            'name' => fake()->name(),
            'full_name' => null,
            'email' => fake()->email(),
            'company' => null,
            'position' => null,
            'additional' => null,
            'phone' => null,
            'website' => null,
            'country' => null,
            'company_foa' => null,
            'lang' => 'en',
            'error_log' => null
        ];
    }

}
