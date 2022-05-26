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
}
