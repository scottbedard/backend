<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Backend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResourcesTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_only_access_authorized_areas()
    {
        $user = User::factory()->create();
        
        Backend::authorize($user, 'read posts');

        $this
            ->actingAs($user)
            ->get('/backend/resources/posts')
            ->assertSuccessful();

        $this
            ->actingAs($user)
            ->get('/backend/resources/users')
            ->assertForbidden();
    }

    public function test_deleting_records()
    {
        $admin = User::factory()->create();

        $bob = User::factory()->create();

        $sally = User::factory()->create();

        Backend::authorize($admin, 'delete users');

        $this
            ->actingAs($admin)
            ->post('/backend/resources/users/action', [
                '_action' => 'delete',
                'models' => [$bob->id],
            ])
            ->assertRedirect();
        
        $this->assertFalse(User::where('id', $bob->id)->exists());
        $this->assertTrue(User::where('id', $sally->id)->exists());
    }

    public function test_unauthorized_deleting_records()
    {
        $hacker = User::factory()->create();

        Backend::authorize($hacker, 'create users');

        $this
            ->actingAs($hacker)
            ->post('/backend/resources/users/action', [
                '_action' => 'delete',
                'models' => [],
            ])
            ->assertForbidden();
    }

    // @todo: this should probably be tested using dusk
    public function test_users_only_see_authorized_toolbar_items()
    {
        $john = User::factory()->create();
        $mary = User::factory()->create();
        
        Backend::authorize($john, 'create users');
        Backend::authorize($mary, 'delete users');

        $this
            ->actingAs($john)
            ->get('/backend/resources/users')
            ->assertDontSee('Delete users');

        $this
            ->actingAs($mary)
            ->get('/backend/resources/users')
            ->assertSee('Delete users');
    }
}
