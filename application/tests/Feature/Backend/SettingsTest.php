<?php

namespace Tests\Feature\Backend;

use App\Models\User;
use Backend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_enabled_setting()
    {
        $user = User::factory()->create();

        $this->assertFalse(Backend::enabled($user, 'foo'));

        $user->backendSettings()->create(['key' => 'foo', 'value' => false]);

        $this->assertFalse(Backend::enabled($user, 'foo'));

        $user->backendSettings()->where('key', 'foo')->update(['value' => true]);

        $this->assertTrue(Backend::enabled($user, 'foo'));
    }

    public function test_disabled_setting()
    {
        $user = User::factory()->create();

        $this->assertTrue(Backend::disabled($user, 'foo'));

        $user->backendSettings()->create(['key' => 'foo', 'value' => false]);

        $this->assertTrue(Backend::disabled($user, 'foo'));

        $user->backendSettings()->where('key', 'foo')->update(['value' => true]);

        $this->assertFalse(Backend::disabled($user, 'foo'));
    }
}
