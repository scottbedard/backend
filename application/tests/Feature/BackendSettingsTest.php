<?php

namespace Tests\Feature;

use Tests\TestCase;

class BackendSettingsTest extends TestCase
{
    public function test_toggling_a_boolean_setting()
    {
        $user = $this->createSuperAdmin();

        $route = route('backend.settings.toggle', [], false);

        // first request should create the setting with a value of '1'
        $req1 = $this
            ->actingAs($user)
            ->post($route, ['key' => 'foo']);

        $req1->assertSuccessful();

        $this->assertEquals(1, $user->backendSettings()->count());

        $this->assertTrue((bool) $user->backendSettings()->where('key', 'foo')->first()->value);

        // second request should create the setting with a value of '0'
        $req2 = $this
            ->actingAs($user)
            ->post($route, ['key' => 'foo', 'debug' => true]);

        $req2->assertSuccessful();

        $this->assertEquals(1, $user->backendSettings()->count());
        
        $this->assertFalse((bool) $user->backendSettings()->where('key', 'foo')->first()->value);
    }
}
