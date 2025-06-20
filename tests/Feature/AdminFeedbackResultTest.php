<?php

namespace Tests\Feature;

use App\Feedback;
use App\FeedbackResult;
use App\FeedbackTrack;
use App\Track;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminFeedbackResultTest extends TestCase{
    use RefreshDatabase;

    public User $user;

    protected function setUp(): void{
        parent::setUp();

        $this->user = User::factory()->create([
            'is_admin' => true
        ]);
    }

    public function test_process_review_button_action(): void{
        $tracks = Track::factory(10)->create();
        $feedback = Feedback::factory()->create();
        $rates = array();
        foreach($tracks as $track){
            $name = $track->getFullTitle();
            FeedbackTrack::factory()->create([
                'track_id' => $track->id,
                'feedback_id' => $feedback->id,
                'name' => $name
            ]);
            $rates[$name] = fake()->numberBetween(1, 10);
        }
        $result = FeedbackResult::factory()->create([
            'feedback_id' => $feedback->id,
            'best_track' => $tracks[0]->getFullTitle(),
            'rates' => $rates
        ]);

        $response = $this->actingAs($this->user)
            ->ajaxGet(route('feedback.result.add', $result->id));

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonSeeInOrder($response->getContent(), 'html', [
            'name="track_id"',
            'name="author"',
            'name="review"',
            'name="score"',
            'name="result_accept"'
        ]);
    }

    public function test_saving_reply_as_review(){
        $track = Track::factory()->simple()->create();
        $result = FeedbackResult::factory()->create([
            'feedback_id' => 0,
            'rates' => ['1' => 1]
        ]);

        $response = $this->actingAs($this->user)
            ->ajaxPost(route('reviews.store'), [
                'result_accept' => $result->id,
                'track_id' => (string) $track->id,
                'author' => fake()->name,
                'location' => fake()->country,
                'score' => fake()->numberBetween(1, 10),
                'review' => fake()->sentence(),
                'source' => 'Feedback',
            ]);

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonStructure(['message', 'url']);
        $response->assertJsonFragment(['message' => trans('reviews.added_successfully')]);
    }

}
