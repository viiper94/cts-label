<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory{

    public function definition(): array{
        return [
            'sort_id' => null,
            'release_id' => null,
            'feedback_title' => fake()->title,
            'archive_name' => fake()->file(),
            'description_en' => fake()->text,
            'description_ua' => fake()->text,
            'description_ru' => fake()->text,
            'visible' => fake()->boolean,
            'slug' => fake()->slug,
            'image' => fake()->file,
            'emailing_sent' => false,
        ];
    }

}
