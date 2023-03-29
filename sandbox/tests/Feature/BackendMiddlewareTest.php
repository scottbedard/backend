<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BackendMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected(): void
    {
        $this
            ->get(config('backend.path'))
            ->assertRedirect(config('backend.guest_redirect'));
    }

    public function test_super_admin_access()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get(config('backend.path'))
            ->assertStatus(302);

        $user->assignRole(config('backend.super_admin_role'));

        $this
            ->actingAs($user)
            ->get(config('backend.path'))
            ->assertStatus(200);
    }

    public function test_permission_access()
    {
        $view = Permission::create(['name' => 'read roles']);

        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get(config('backend.path') . '/roles')
            ->assertStatus(302);

        $user->givePermissionTo($view);

        $this
            ->actingAs($user)
            ->get(config('backend.path') . '/roles')
            ->assertStatus(200);
    }

    public function test_role_access()
    {
        $user = User::factory()->create();
        $create = Permission::create(['name' => 'create roles']);
        $read = Permission::create(['name' => 'read roles']);
        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo($create);
        $manager->givePermissionTo($read);

        $this
            ->actingAs($user)
            ->get(config('backend.path') . '/roles/create')
            ->assertStatus(302);

        $user->assignRole($manager);

        $this
            ->actingAs($user)
            ->get(config('backend.path') . '/roles/create')
            ->assertStatus(200);
    }
}
