<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase{

    use RefreshDatabase;

    public function test_non_authenticated_user_cannot_access_admin(): void{
        $user = User::factory()->create();

        $response = $this->get('/cts-admin/releases');
        $response->assertRedirectToRoute('login');

        $response = $this->actingAs($user)->get('/cts-admin/releases');
        $response->assertStatus(403);
    }

    public function test_authenticated_user_can_access_admin(): void{
        $user = User::factory()->create([
            'is_admin' => true
        ]);

        $response = $this->actingAs($user)->get('/cts-admin/releases');
        $response->assertStatus(200);
        $response->assertSee(trans('shared.admin.sidebar.header'));
    }

}
