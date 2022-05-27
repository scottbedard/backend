<?php

namespace Tests\Feature;

use App\Backend\Resources\UserResource;
use App\Models\User;
use Backend;
use Tests\TestCase;

class BackendFacadeTest extends TestCase
{
    public function test_disabled_setting()
    {
        $user = $this->createSuperAdmin();

        $this->assertTrue(Backend::disabled($user, 'foo'));

        $user->backendSettings()->create(['key' => 'foo', 'value' => false]);

        $this->assertTrue(Backend::disabled($user, 'foo'));

        $user->backendSettings()->where('key', 'foo')->update(['value' => true]);

        $this->assertFalse(Backend::disabled($user, 'foo'));
    }

    public function test_enabled_setting()
    {
        $user = $this->createSuperAdmin();

        $this->assertFalse(Backend::enabled($user, 'foo'));

        $user->backendSettings()->create(['key' => 'foo', 'value' => false]);

        $this->assertFalse(Backend::enabled($user, 'foo'));

        $user->backendSettings()->where('key', 'foo')->update(['value' => true]);

        $this->assertTrue(Backend::enabled($user, 'foo'));
    }

    public function test_get_resources()
    {
        $resources = Backend::resources();

        $this->assertTrue($resources->contains(UserResource::class));
    }

    public function test_get_resource_by_id()
    {
        $this->assertInstanceOf(UserResource::class, Backend::resource('users'));
    }

    public function test_authorizing_backend_permissions()
    {
        $user = User::factory()->create();

        $permission1 = Backend::authorize($user, 'all', 'super');
        $this->assertEquals('all', $permission1->area);
        $this->assertEquals('super', $permission1->code);
        $this->assertEquals(1, $user->backendPermissions()->count());

        // re-authorizing should have no effect
        $permission2 = Backend::authorize($user, 'all', 'super');
        $this->assertEquals($permission1->id, $permission2->id);
        $this->assertEquals(1, $user->backendPermissions()->count());
    }
}
