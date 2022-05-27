<?php

namespace Tests\Feature\Backend;

use App\Models\User;
use Backend;
use Bedard\Backend\Exceptions\AlreadyAuthorizedException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizeTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorize_admin()
    {
        $user = User::factory()->create();

        $permission = Backend::authorize($user, 'all', 'super');

        $this->assertEquals('all', $permission->area);
        $this->assertEquals('super', $permission->code);
        $this->assertEquals(1, $user->backendPermissions()->count());
    }

    public function test_authorizing_a_redundant_permission()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'foo', 'create');

        $this->expectException(AlreadyAuthorizedException::class);

        Backend::authorize($user, 'foo', 'create');
    }

    public function test_under_promoting_a_super_admin()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'all', 'super');

        $this->expectException(AlreadyAuthorizedException::class);

        Backend::authorize($user, 'foo', 'create');
    }

    public function test_under_promoting_an_area_super_admin()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'foo', 'super');

        $this->expectException(AlreadyAuthorizedException::class);

        Backend::authorize($user, 'foo', 'create');
    }
}
