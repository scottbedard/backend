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
        $read = Permission::create(['name' => 'read roles']);

        $user = User::factory()->create();

        $req = $this
            ->actingAs($user)
            ->get(config('backend.path') . '/roles')
            ->assertStatus(302);

        $user->givePermissionTo($read);

        $this
            ->actingAs($user)
            ->get(config('backend.path') . '/roles')
            ->assertStatus(200);
    }
}
