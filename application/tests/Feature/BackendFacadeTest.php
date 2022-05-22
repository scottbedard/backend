<?php

namespace Tests\Feature;

use App\Models\User;
use Backend;
use Tests\TestCase;

class BackendFacadeTest extends TestCase
{
    public function test_enabled_setting()
    {
        $user = $this->createSuperAdmin();

        $this->assertFalse(Backend::enabled($user, 'foo'));

        $user->backendSettings()->create(['key' => 'foo', 'value' => false]);

        $this->assertFalse(Backend::enabled($user, 'foo'));

        $user->backendSettings()->where('key', 'foo')->update(['value' => true]);

        $this->assertTrue(Backend::enabled($user, 'foo'));
    }

    public function test_disabled_setting()
    {
        $user = $this->createSuperAdmin();

        $this->assertTrue(Backend::disabled($user, 'foo'));

        $user->backendSettings()->create(['key' => 'foo', 'value' => false]);

        $this->assertTrue(Backend::disabled($user, 'foo'));

        $user->backendSettings()->where('key', 'foo')->update(['value' => true]);

        $this->assertFalse(Backend::disabled($user, 'foo'));
    }
}
