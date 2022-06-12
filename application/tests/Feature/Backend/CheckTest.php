<?php

namespace Tests\Feature\Backend;

use App\Models\User;
use Backend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckTest extends TestCase
{
    use RefreshDatabase;

    public function test_checking_for_a_permission()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'foo');
        
        $this->assertTrue(Backend::check($user, 'foo'));

        $this->assertFalse(Backend::check($user, 'bar'));
    }

    public function test_super_admins_always_have_permission()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'super admin');

        $this->assertTrue(Backend::check($user, 'foo'));
    }

    public function test_managers_can_access_their_resource()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'manage books');

        $this->assertTrue(Backend::check($user, 'create books'));
    }

    public function test_access_permission_action()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'manage posts');

        $this->assertTrue(Backend::check($user, 'access posts'));
    }

    public function test_falsey_values_return_true()
    {
        $user = User::factory()->create();

        $this->assertTrue(Backend::check($user, ''));
        $this->assertTrue(Backend::check($user, null));
    }
}
