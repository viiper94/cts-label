<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmailingChannelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'description' => fake()->text(),
            'from' => fake()->email(),
            'from_name' => fake()->name(),
            'subject' => fake()->sentence(),
            'template' => null,
            'lang' => 'en',
            'unsubscribe' => fake()->boolean(50),
            'smtp_host' => null,
            'smtp_port' => null,
            'smtp_username' => null,
            'smtp_password' => null,
            'smtp_encryption' => null,
        ];
    }

    public function simple() :Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => fake()->title(),
                'subject' => fake()->sentence(),
                'description' => null,
            ];
        });
    }

}
