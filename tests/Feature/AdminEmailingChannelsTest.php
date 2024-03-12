<?php

namespace Tests\Feature;

use App\EmailingChannel;
use App\EmailingContact;
use App\EmailingQueue;
use App\Mail\Emailing;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminEmailingChannelsTest extends TestCase{

    use RefreshDatabase;

    public User $user;

    protected function setUp(): void{
        parent::setUp();

        $this->user = User::factory()->create([
            'is_admin' => true
        ]);
    }

    private function attachContacts(int $contactsCount = 100, int $channelsCount = 10): void{
        $contacts = EmailingContact::factory($contactsCount)->create();
        foreach($contacts as $contact){
            $contact->channels()->attach(fake()->numberBetween(1, $channelsCount));
        }
    }

    public function test_channels_index_page_with_no_channels(): void{
        $response = $this
            ->actingAs($this->user)
            ->get(route('emailing.channels.index'));

        $response->assertStatus(200);
        $response->assertSee(trans('emailing.channels.new_emailing_channel'));
        $response->assertViewHas('channels');
    }

    public function test_channels_index_page_with_channels_and_subscribers(): void{
        EmailingChannel::factory(10)->create();
        EmailingChannel::factory()->simple()->create();
        $this->attachContacts(channelsCount: 11);

        $response = $this
            ->actingAs($this->user)
            ->get(route('emailing.channels.index'));

        $response->assertStatus(200);
        $response->assertDontSee(route('emailing.channels.edit', 1));
        $response->assertSee(trans('emailing.channels.new_emailing_channel'));
        $response->assertSee('fa-solid fa-bug');
        $response->assertViewHas('channels');
    }

    public function test_channels_index_page_with_no_test_channel(): void{
        EmailingChannel::factory(10)->create();
        $channel_with_first_id = EmailingChannel::find(1);
        $channel_with_first_id->delete();

        $response = $this
            ->actingAs($this->user)
            ->get(route('emailing.channels.index'));

        $response->assertStatus(200);
        $response->assertDontSee('fa-solid fa-bug');
        $response->assertDontSee(route('emailing.channels.edit', 1));
        $response->assertViewHas('channels');
    }

    public function test_channels_index_page_with_active_emailing(): void{
        EmailingChannel::factory(10)->create();
        $this->attachContacts();

        $channel_id_to_test = fake()->numberBetween(2, 10);
        $response = $this
            ->actingAs($this->user)
            ->post(route('emailing.channels.start'), [
                'id' => $channel_id_to_test
            ])->assertStatus(302);

        $response = $this
            ->actingAs($this->user)
            ->followRedirects($response);

        $response->assertStatus(200);
        $response->assertSee(route('emailing.channels.stop'));

        $channel = EmailingChannel::withCount('subscribers')->find($channel_id_to_test);
        $this->assertDatabaseCount('email_queue', $channel->subscribers_count);

        $this->assertDatabaseHas('email_queue', [
            'channel_id' => $channel_id_to_test,
            'subject' => $channel->subject,
            'from' => $channel->from,
            'from_name' => $channel->from_name,
            'template' => $channel->template ?? 'custom',
            'unsubscribe' => $channel->unsubscribe ? 1 : 0,
            'smtp_host' => $channel->smtp_host,
            'smtp_port' => $channel->smtp_port,
            'smtp_username' => $channel->smtp_username,
            'smtp_password' => $channel->smtp_password,
            'smtp_encryption' => $channel->smtp_encryption,
        ]);

        $queueItem = EmailingQueue::first();
        $mailable = new Emailing($queueItem);
        $mailable->assertFrom($channel->from, $channel->from_name);
        $mailable->assertHasSubject($channel->subject);

    }

    public function test_create_channel_page(){
        $response = $this
            ->actingAs($this->user)
            ->get(route('emailing.channels.create'));

        $response->assertStatus(200);
        $response->assertSee('action="'.route('emailing.channels.store'). '"', false);
    }

    public function test_creating_channel_request(){
        EmailingChannel::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->post(route('emailing.channels.store'), [
                'title' => fake()->title(),
                'lang' => 'en',
                'subject' => fake()->sentence(),
                'from' => fake()->email(),
                'from_name' => fake()->name(),
                'unsubscribe' => true,
                'description' => fake()->text(),
                'smtp_host' => fake()->ipv4(),
                'smtp_port' => fake()->numberBetween(99, 1000),
                'smtp_username' => fake()->userName(),
                'smtp_password' => fake()->password(),
                'smtp_encryption' => 'tsl',
                'template' => \Illuminate\Support\Str::slug(fake()->name()),
            ])->assertStatus(302);

        $response = $this
            ->actingAs($this->user)
            ->followRedirects($response);

        $response->assertStatus(200);
        $response->assertDontSee(route('emailing.channels.edit', 1));
        $response->assertSee(trans('emailing.channels.new_emailing_channel'));
        $response->assertSee('fa-solid fa-bug');
    }

    public function test_creating_simple_channel_request(){
        EmailingChannel::factory()->create(['id' => 1]);

        $response = $this
            ->actingAs($this->user)
            ->post(route('emailing.channels.store'), [
                'title' => fake()->title(),
                'lang' => 'en',
                'subject' => fake()->sentence(),
                'from' => fake()->email(),
                'from_name' => fake()->name(),
            ])->assertStatus(302);

        $response = $this
            ->actingAs($this->user)
            ->followRedirects($response);

        $response->assertStatus(200);
        $response->assertDontSee(route('emailing.channels.edit', 1));
        $response->assertSee(trans('emailing.channels.new_emailing_channel'));
        $response->assertSee('fa-solid fa-bug');
    }

    public function test_creating_simple_channel_with_all_contacts_request(){
        EmailingChannel::factory(['id' => 1])->create();
        EmailingContact::factory(100)->create();

        $response = $this
            ->actingAs($this->user)
            ->post(route('emailing.channels.store'), [
                'title' => fake()->title(),
                'lang' => 'en',
                'subject' => fake()->sentence(),
                'from' => fake()->email(),
                'from_name' => fake()->name(),
                'add_all' => 1,
            ])->assertStatus(302);

        $response = $this
            ->actingAs($this->user)
            ->followRedirects($response);

        $response->assertStatus(200);
        $response->assertDontSee(route('emailing.channels.edit', 1));
        $response->assertSee(trans('emailing.channels.new_emailing_channel'));
        $response->assertSeeInOrder([
            '<a',
            route('emailing.contacts.index', ['channel' => 2]),
            '>',
            '100',
            '</a>'
        ], false);
        $response->assertSee('fa-solid fa-bug');
    }

    public function test_updating_channel_page(){
        EmailingChannel::factory()->create(['id' => 1]);
        $channel_to_test = EmailingChannel::factory()->simple()->create();

        $response = $this
            ->actingAs($this->user)
            ->get(route('emailing.channels.edit', $channel_to_test->id));

        $response->assertStatus(200);
        $response->assertSee(trans('shared.admin.export_xlsx'));
        $response->assertViewHas('channel', $channel_to_test);
        $response->assertSeeInOrder([
            '<input', 'name="title"', 'value="'.$channel_to_test->title.'"', '>',
            '<select', 'name="lang"', 'value="en"', 'selected', '>',
            '<input', 'name="subject"', 'value="'.$channel_to_test->subject.'"', '>',
            '<input', 'name="from"', 'value="'.$channel_to_test->from.'"', '>',
            '<input', 'name="from_name"', 'value="'.$channel_to_test->from_name.'"', '>',
        ], false);
    }

    public function test_updating_channel_request(){
        EmailingChannel::factory()->create(['id' => 1]);
        $channel_to_test = EmailingChannel::factory()->simple()->create();

        $channel_data = [
            'title' => $channel_to_test->title.'1',
            'lang' => $channel_to_test->lang.'1',
            'subject' => $channel_to_test->subject.'1',
            'from' => $channel_to_test->from,
            'from_name' => $channel_to_test->from_name.'1',
            'unsubscribe' => '1',
            'description' => fake()->text(),
            'smtp_host' => fake()->ipv4(),
            'smtp_port' => fake()->numberBetween(99, 1000),
            'smtp_username' => fake()->userName(),
            'smtp_password' => fake()->password(),
            'smtp_encryption' => 'tsl',
            'template' => \Illuminate\Support\Str::slug(fake()->name()),
        ];
        $response = $this
            ->actingAs($this->user)
            ->post(route('emailing.channels.store'), $channel_data)->assertStatus(302);

        $response = $this
            ->actingAs($this->user)
            ->followRedirects($response);

        $response->assertStatus(200);
        $response->assertSee(trans('emailing.channels.new_emailing_channel'));
        $response->assertDontSee(route('emailing.channels.edit', 1));
        $response->assertSeeText($channel_to_test->title.'1');
        $response->assertSee(route('emailing.channels.edit', $channel_to_test->id));
        $this->assertDatabaseHas('email_channels', $channel_data);

    }

    public function test_deleting_channel(){
        EmailingChannel::factory()->create(['id' => 1]);
        $channel_to_test = EmailingChannel::factory()->simple()->create();

        $response = $this
            ->actingAs($this->user)
            ->post(route('emailing.channels.destroy', $channel_to_test->id), [
                '_method' => 'DELETE'
            ])->assertStatus(302);

        $response = $this
            ->actingAs($this->user)
            ->followRedirects($response);

        $response->assertStatus(200);
        $response->assertSee(trans('emailing.channels.new_emailing_channel'));
        $response->assertDontSee(route('emailing.channels.edit', 1));
        $response->assertDontSeeText($channel_to_test->title.'1');
        $response->assertDontSee(route('emailing.channels.edit', $channel_to_test->id));
        $this->assertDatabaseMissing('email_channels', $channel_to_test->toArray());
    }

    public function test_stop_emailing(): void{
        EmailingChannel::factory(10)->create();
        $this->attachContacts();

        $channel_id_to_test = fake()->numberBetween(2, 10);
        $response = $this
            ->actingAs($this->user)
            ->post(route('emailing.channels.start'), [
                'id' => $channel_id_to_test
            ])->assertStatus(302);

        $this->actingAs($this->user)
            ->followRedirects($response)
            ->assertStatus(200)
            ->assertSee(route('emailing.channels.stop'));

        $channel = EmailingChannel::withCount('subscribers')->find($channel_id_to_test);
        $this->assertDatabaseCount('email_queue', $channel->subscribers_count);

        $response = $this
            ->actingAs($this->user)
            ->post(route('emailing.channels.stop'), [
                'id' => $channel_id_to_test
            ])->assertStatus(302);

        $response = $this
            ->actingAs($this->user)
            ->followRedirects($response);

        $response->assertStatus(200);
        $response->assertSee(trans('emailing.channels.new_emailing_channel'));
        $response->assertDontSee(route('emailing.channels.edit', 1));
        $response->assertDontSee(route('emailing.channels.stop'));

        $this->assertDatabaseCount('email_queue', 0);
    }

    public function test_channel_export_to_xlsx(){
        EmailingChannel::factory(2)->create();

        $response = $this
            ->actingAs($this->user)
            ->get(route('emailing.channels.export', 2))
            ->assertHeader('Content-Type', 'text/xlsx; charset=UTF-8');
    }

}
