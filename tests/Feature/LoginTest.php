<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase{

    use RefreshDatabase;

    public User $user;

    protected function setUp(): void{
        parent::setUp();

        $this->user = User::factory()->create([
            'is_admin' => true
        ]);
    }

    public function test_login_form_data(): void{
        $response = $this->post(route('login'), [
            'email' => $this->user->email,
            'password' => 'password',
            'remember' => 'on'
        ]);

        $response->assertRedirectToRoute('admin');
        $this->assertAuthenticatedAs($this->user);
    }

    public function test_authenticated_admin_user_skips_login(){
        $response = $this->actingAs($this->user)
            ->get(route('releases.index'));

        $response->assertStatus(200);
        $response->assertSee(trans('shared.admin.sidebar.header'));
        $response->assertDontSee(trans('user.login_header'));
    }

    public function test_user_logout(){
        $response = $this->actingAs($this->user)
            ->post(route('logout'));

        $response->assertRedirectToRoute('home');
        $this->assertGuest();
    }

}
