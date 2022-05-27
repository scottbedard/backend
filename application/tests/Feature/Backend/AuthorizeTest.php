<?php

namespace Tests\Feature\Backend;

use App\Models\User;
use Backend;
use Bedard\Backend\Exceptions\AlreadyAuthorizedException;
use Bedard\Backend\Models\BackendPermission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizeTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorize_admin()
    {
        $user = User::factory()->create();

        $permission = Backend::authorize($user, 'all', 'all');

        $this->assertEquals('all', $permission->area);
        $this->assertEquals('all', $permission->code);
        $this->assertEquals(1, $user->backendPermissions()->count());
    }

    public function test_area_and_code_normalizing()
    {
        $user = User::factory()->create();
        $area = 'fooBar';
        $code = 'bazQux';

        $permission = Backend::authorize($user, $area, $code);

        $this->assertEquals(BackendPermission::normalize($area), $permission->area);
        $this->assertEquals(BackendPermission::normalize($code), $permission->code);
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

        Backend::authorize($user, 'all', 'all');

        $this->expectException(AlreadyAuthorizedException::class);

        Backend::authorize($user, 'foo', 'create');
    }

    public function test_under_promoting_an_area_super_admin()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'foo', 'all');

        $this->expectException(AlreadyAuthorizedException::class);

        Backend::authorize($user, 'foo', 'create');
    }

    public function test_promoting_area_admin_to_area_super_admin()
    {
        $user = User::factory()->create();

        $foo = Backend::authorize($user, 'foo', 'create');
        $bar = Backend::authorize($user, 'bar', 'create');
        
        $permission = Backend::authorize($user, 'foo', 'all');
        
        $this->assertEquals(2, $user->backendPermissions()->count());
        $this->assertTrue($user->backendPermissions()->where('id', $bar->id)->exists());
        $this->assertTrue($user->backendPermissions()->where('id', $permission->id)->exists());
    }

    public function test_promoting_area_admin_to_super_admin()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'foo', 'create');
        
        $permission = Backend::authorize($user, 'all', 'all');
        
        $this->assertEquals(1, $user->backendPermissions()->count());
        $this->assertEquals($permission->id, $user->backendPermissions()->first()->id);
    }
}
