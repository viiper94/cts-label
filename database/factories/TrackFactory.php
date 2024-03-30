<?php

namespace Database\Factories;

use App\Track;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackFactory extends Factory{

    public function definition(): array{
        return [
            'artists' => fake()->name,
            'name' => fake()->title,
            'mix_name' => 'Original Mix',
            'remixers' => null,
            'composer' => fake()->name,
            'isrc' => Track::generateISRCCode(),
            'bpm' => fake()->numberBetween(60, 200),
            'genre' => fake()->title,
            'length' => fake()->numberBetween(400000, 2000000),
            'youtube' => fake()->url,
            'beatport_id' => fake()->numberBetween(),
            'beatport_slug' => fake()->slug,
            'beatport_release_id' => fake()->numberBetween(),
            'beatport_wave' => fake()->url,
            'beatport_sample' => fake()->url,
            'beatport_sample_start' => fake()->numberBetween(400000, 2000000),
            'beatport_sample_end' => fake()->numberBetween(400000, 2000000),
            'show_reviews' => true,
        ];
    }

    public function simple(): array{
        return [
            'artists' => fake()->name,
            'name' => fake()->title,
        ];
    }

}
