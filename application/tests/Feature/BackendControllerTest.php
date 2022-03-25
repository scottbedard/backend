<?php

namespace Tests\Feature;

use App\Models\User;
use Bedard\Backend\Models\BackendPermission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BackendControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_the_backend()
    {
        $this
            ->get(config('backend.path'))
            ->assertRedirect(config('backend.guest_redirect'));
    }

    public function test_users_must_have_atleast_one_backend_permission()
    {
        $user = User::factory()->create();
        
        $this
            ->actingAs($user)
            ->get(config('backend.path'))
            ->assertRedirect(config('backend.unauthorized_redirect'));

        BackendPermission::grant($user->id, 'all', 'super');
        
        $this
            ->actingAs($user)
            ->get(config('backend.path'))
            ->assertStatus(200);
    }
}
