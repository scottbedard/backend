<?php

namespace Tests\Feature\Backend;

use App\Models\User;
use Backend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'all', 'all');

        $this->assertTrue(Backend::test($user, 'foo', 'all'));
        $this->assertTrue(Backend::test($user, 'foo', 'create'));
    }

    public function test_super_area_admin()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'foo', 'all');

        $this->assertTrue(Backend::test($user, 'foo', 'all'));
        $this->assertTrue(Backend::test($user, 'foo', 'create'));
        $this->assertFalse(Backend::test($user, 'bar', 'create'));
    }

    public function test_area_admin_code()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'foo', 'create');

        $this->assertTrue(Backend::test($user, 'foo', 'create'));
        $this->assertFalse(Backend::test($user, 'foo', 'delete'));
        $this->assertFalse(Backend::test($user, 'bar', 'create'));
    }
}
