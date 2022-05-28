<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Backend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResourcesTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_only_access_authorized_areas()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'posts', 'all');

        $this
            ->actingAs($user)
            ->get('/backend/resources/posts')
            ->assertSuccessful();

        $this
            ->actingAs($user)
            ->get('/backend/resources/users')
            ->assertUnauthorized();
    }
}
