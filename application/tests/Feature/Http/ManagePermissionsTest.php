<?php

namespace Tests\Feature\Http;

use App\Models\User;
use Backend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagePermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admins_can_access_manage_permissions()
    {
        $admin = User::factory()->create();

        Backend::authorize($admin, 'super admin');

        $this
            ->actingAs($admin)
            ->get(route('backend.manage.permissions'))
            ->assertSuccessful();
    }

    public function test_lesser_admins_cannot_access_manage_permissions()
    {
        $admin = User::factory()->create();

        Backend::authorize($admin, 'foo bar');

        $this
            ->actingAs($admin)
            ->get(route('backend.manage.permissions'))
            ->assertForbidden();
    }
}
