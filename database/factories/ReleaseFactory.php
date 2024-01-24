<?php

namespace Database\Factories;

use App\Release;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Release>
 */
class ReleaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array{
        return [
            'sort_id' => fake()->randomNumber(3),
            'title' => fake()->sentence(),
            'release_number' => Release::generateReleaseNumber(),
            'release_date' => fake()->date(),
            'image' => fake()->imageUrl(),
            'image_270' => fake()->imageUrl(),
            'beatport' => fake()->url(),
            'youtube' => fake()->url(),
            'description_en' => fake()->text(),
            'description_ru' => fake()->text(),
            'description_ua' => fake()->text(),
            'visible' => fake()->boolean(95),
            'genre' => fake()->word(),
            'tracklist_show_artist' => fake()->boolean(),
            'tracklist_show_title' => fake()->boolean(),
            'tracklist_show_mix' => fake()->boolean(),
            'tracklist_show_custom' => fake()->boolean(5),
            'label_copy_zip' => fake()->filePath(),
            'exclusive_period' => fake()->numberBetween(0, 2),
            'uploaded_on_beatport' => fake()->boolean(70),
            'uploaded_on_believe' => fake()->boolean(),
            'uploaded_on_juno' => fake()->boolean(),
            'uploaded_on_google_drive' => fake()->boolean(),
            'promo_upload' => fake()->boolean(99),
            'uploaded_on_zip_dj' => fake()->boolean(),
            'uploaded_on_music_worx' => fake()->boolean(),
            'uploaded_on_release_promo' => fake()->boolean(),
            'label_copy_uploaded' => fake()->boolean(),
            'is_emailing_done' => fake()->boolean(10),
        ];
    }

    public function simple() :Factory{
        return $this->state(function (array $attributes) {
            return [
                'release_number' => null,
                'release_date' => null,
                'image' => null,
                'image_270' => null,
                'beatport' => null,
                'youtube' => null,
                'description_en' => null,
                'description_ru' => null,
                'description_ua' => null,
                'visible' => false,
                'genre' => null,
                'tracklist_show_artist' => false,
                'tracklist_show_title' => false,
                'tracklist_show_mix' => false,
                'tracklist_show_custom' => false,
                'label_copy_zip' => null,
                'exclusive_period' => null,
                'uploaded_on_beatport' => false,
                'uploaded_on_believe' => false,
                'uploaded_on_juno' => false,
                'uploaded_on_google_drive' => false,
                'promo_upload' => false,
                'uploaded_on_zip_dj' => false,
                'uploaded_on_music_worx' => false,
                'uploaded_on_release_promo' => false,
                'label_copy_uploaded' => false,
                'is_emailing_done' => false,
            ];
        });
    }

}
