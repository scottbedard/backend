<?php

namespace Tests\Feature;

use App\Models\User;
use Bedard\Backend\Models\BackendSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BackendSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_backend_settings_user_relationship()
    {
        $user = User::factory()->create();

        $setting = BackendSetting::factory()->create([
            'key' => 'foo',
            'user_id' => $user->id,
            'value' => 'bar',
        ]);

        $this->assertEquals(1, $user->backendSettings()->count());

        $this->assertEquals($setting->id, $user->backendSettings()->first()->id);
    }
}
