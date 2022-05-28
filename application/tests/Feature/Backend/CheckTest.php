<?php

namespace Tests\Feature\Backend;

use App\Models\User;
use Backend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'all', 'all');

        $this->assertTrue(Backend::check($user, 'foo', 'all'));
        $this->assertTrue(Backend::check($user, 'foo', 'create'));
    }

    public function test_super_area_admin()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'foo', 'all');

        $this->assertTrue(Backend::check($user, 'foo', 'all'));
        $this->assertTrue(Backend::check($user, 'foo', 'create'));
        $this->assertFalse(Backend::check($user, 'bar', 'create'));
    }

    public function test_area_admin_code()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'foo', 'create');

        $this->assertTrue(Backend::check($user, 'foo', 'create'));
        $this->assertFalse(Backend::check($user, 'foo', 'delete'));
        $this->assertFalse(Backend::check($user, 'bar', 'create'));
    }

    public function test_area_any_code()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'foo', 'create');

        $this->assertTrue(Backend::check($user, 'foo', 'any'));
    }
}
