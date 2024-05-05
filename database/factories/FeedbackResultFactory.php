<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackResultFactory extends Factory{

    public function definition(): array{
        return [
            'feedback_id' => fake()->numberBetween(),
            'name' => fake()->name,
            'email' => fake()->safeEmail,
            'comment' => fake()->sentence,
            'rates' => array(),
            'best_track' => fake()->title,
            'status' => fake()->numberBetween(0, 2),
        ];
    }

}
