<?php

namespace Tests\Feature;

use App\Models\User;
use Backend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BackendMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_redirect()
    {
        $this
            ->get(config('backend.path'))
            ->assertRedirect(config('backend.guest_redirect'));
    }

    public function test_unauthorized_redirect()
    {
        $user = User::factory()->create();

        $request = $this
            ->actingAs($user)
            ->get(config('backend.path'));
        
        $request->assertRedirect(config('backend.unauthorized_redirect'));
    }

    public function test_permitting_admin_user()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'anything');

        $request = $this
            ->actingAs($user)
            ->get(config('backend.path'));
        
        $request->assertStatus(200);
    }
}
