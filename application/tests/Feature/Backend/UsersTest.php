<?php

namespace Tests\Feature\Backend;

use App\Models\User;
use Backend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetching_all_backend_users()
    {
        $alice = User::factory()->create();
        $bob = User::factory()->create();

        Backend::authorize($alice, 'all', 'super');

        $users = Backend::users()->get();

        $this->assertEquals(1, $users->count());
        $this->assertEquals($alice->id, $users->first()->id);
    }

    public function test_fetching_backend_users_by_area_alone()
    {
        $alice = User::factory()->create();
        $bob = User::factory()->create();
        $sally = User::factory()->create();
        $john = User::factory()->create();

        Backend::authorize($alice, 'all', 'super');
        Backend::authorize($bob, 'foo', 'super');
        Backend::authorize($sally, 'bar', 'super');

        $users = Backend::users('foo')->get();

        $this->assertEquals(2, $users->count());
        $this->assertTrue($users->contains('id', $alice->id));
        $this->assertTrue($users->contains('id', $bob->id));
    }

    public function test_fetching_backend_users_by_area_and_code()
    {
        $alice = User::factory()->create();
        $bob = User::factory()->create();
        $sally = User::factory()->create();
        $john = User::factory()->create();
        $mary = User::factory()->create();

        Backend::authorize($alice, 'foo', 'super');
        Backend::authorize($bob, 'foo', 'create');
        Backend::authorize($sally, 'foo', 'delete');
        Backend::authorize($john, 'bar', 'delete');
        Backend::authorize($mary, 'bar', 'super');

        $users = Backend::users('foo', 'create')->get();

        $this->assertEquals(2, $users->count());
        $this->assertTrue($users->contains('id', $alice->id));
        $this->assertTrue($users->contains('id', $bob->id));
    }
}
