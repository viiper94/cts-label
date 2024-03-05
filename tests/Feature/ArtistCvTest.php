<?php

namespace Tests\Feature;

use App\ArtistContact;
use App\ArtistCv;
use Faker\Provider\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtistCvTest extends TestCase{

    use RefreshDatabase;

    public function test_artist_form_page(): void{
        $response = $this->get(route('artists.public.info.create'));

        $response->assertStatus(200);
        $response->assertSeeInOrder([
            trans('artists.cv.not_public'),
            trans('artists.cv.main_contact'),
            trans('artists.cv.tracks_to_sign'),
            trans('artists.cv.artists_info'),
            trans('artists.cv.no_artist_yet'),
            'add-artist-info-btn',
            'button type="submit"',
        ], false);
    }

    public function test_artist_info_modal_html_request(){
        $response = $this->ajaxGet(route('artists.public.contact.create'));

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonStructure(['html', 'locale']);
        $response->assertJsonSeeInOrder($response->getContent(), 'html', [
            trans('artists.cv.new_info'),
            'save-artist-info-btn',
            'data-url="'.route('artists.public.contact.store').'"',
        ], false);
    }

    public function test_artist_info_modal_create_request(){
        $response = $this->ajaxPost(route('artists.public.contact.store'), [
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
            'passport_number' => ''.fake()->numberBetween('99999', '99999999999'),
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseCount(ArtistContact::class, 1);
        $response->assertJsonCount(2);
        $response->assertJsonStructure(['html', 'id']);
        $response->assertJsonSeeInOrder($response->getContent(), 'html', [
            '<input type="hidden" name="info[]"',
            'add-artist-info-btn',
            'data-url="'.route('artists.public.contact.edit', 1).'"',
        ], false);
    }

    public function test_tracks_to_sign_request_html(){
        $response = $this->ajaxPost(route('artists.public.info.track'), [
            'index' => 2
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonStructure(['html']);
        $response->assertJsonSeeInOrder($response->getContent(), 'html', [
            'track-to-sign-item',
            'data-index="3"',
            'remove-track-to-sign-btn',
        ], false);
    }

    public function test_artist_form_submit(){
        ArtistContact::factory(2)->create();

        $response = $this->post(route('artists.public.info.store'), [
            'main_contact_name' => fake()->name(),
            'main_contact_email' => fake()->safeEmail(),
            'main_contact_phone' => fake()->phoneNumber(),
            'tracks_to_sign' => [
                '0' => [
                    'name' => fake()->title(),
                    'mix' =>  fake()->sentence(3),
                ]
            ],
            'info' => [
                '1', '2'
            ]
        ])->assertRedirectToRoute('home');

        $this->assertDatabaseCount(ArtistCv::class, 1);
        $response = $this->followRedirects($response);

        $response->assertStatus(200);
        $response->assertSee(trans('artists.cv.cv_created'));

    }

}
