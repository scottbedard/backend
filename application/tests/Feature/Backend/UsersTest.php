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

        Backend::authorize($alice, 'all', 'all');

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

        Backend::authorize($alice, 'all', 'all');
        Backend::authorize($bob, 'foo', 'all');
        Backend::authorize($sally, 'bar', 'all');

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

        Backend::authorize($alice, 'foo', 'all');
        Backend::authorize($bob, 'foo', 'create');
        Backend::authorize($sally, 'foo', 'delete');
        Backend::authorize($john, 'bar', 'delete');
        Backend::authorize($mary, 'bar', 'all');

        $users = Backend::users('foo', 'create')->get();

        $this->assertEquals(2, $users->count());
        $this->assertTrue($users->contains('id', $alice->id));
        $this->assertTrue($users->contains('id', $bob->id));
    }
}
