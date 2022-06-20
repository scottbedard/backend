<?php

namespace Tests\Feature\Http;

use App\Models\User;
use Backend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminsTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admins_can_access_admins()
    {
        $admin = User::factory()->create();

        Backend::authorize($admin, 'super admin');

        $this
            ->actingAs($admin)
            ->get(route('backend.admins.index'))
            ->assertSuccessful();
    }

    public function test_lesser_admins_cannot_access_admins()
    {
        $admin = User::factory()->create();

        Backend::authorize($admin, 'foo bar');

        $this
            ->actingAs($admin)
            ->get(route('backend.admins.index'))
            ->assertForbidden();
    }
}
