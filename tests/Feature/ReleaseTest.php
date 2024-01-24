<?php

namespace Tests\Feature;

use App\Release;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReleaseTest extends TestCase{

    use RefreshDatabase;

    public function test_release_pagination(): void
    {
        Release::factory(20)->create();

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('prev-btn');
    }

    public function test_simple_release_page(){
        $release = Release::factory()->simple()->create();

        $response = $this->get(route('release', $release->id));

        $response->assertStatus(200);
        $response->assertSee($release->title);
        $response->assertDontSee(trans('releases.release_date'));
//        $response->assertDontSee(trans('releases.release_number'));
        $response->assertDontSee(trans('releases.tracklist'));
        $response->assertViewHas('release', $release);
    }

}
