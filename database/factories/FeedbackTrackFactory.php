<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackTrackFactory extends Factory{

    public function definition(): array{
        return [
            'name' => fake()->title,
            'file_320' => fake()->slug . '.mp3',
            'file_96' => fake()->slug . 'LOFI.mp3',
            'track_id' => fake()->randomDigitNotNull,
            'feedback_id' => fake()->randomDigitNotNull,
            'peaks' => null
        ];
    }

}
