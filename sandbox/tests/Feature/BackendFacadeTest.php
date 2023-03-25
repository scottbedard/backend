<?php

namespace Tests\Feature;

use App\Models\User;
use Bedard\Backend\Facades\Backend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BackendFacadeTest extends TestCase
{
    use RefreshDatabase;

    public function test_backend_check_with_invalid_params(): void
    {
        $this->assertFalse(Backend::check(1));
        $this->assertFalse(Backend::check(null));
        $this->assertFalse(Backend::check(true));
        $this->assertFalse(Backend::check(false));
        $this->assertFalse(Backend::check('string'));
        $this->assertFalse(Backend::check(new class { }));
    }

    public function test_backend_check_super_admin()
    {
        $role = Role::firstOrCreate(['name' => config('backend.super_admin_role')]);
        
        $user = User::factory()->create();

        $this->assertFalse(Backend::check($user));

        $user->assignRole(config('backend.super_admin_role'));

        $this->assertTrue(Backend::check($user));
        $this->assertTrue(Backend::check($user, 'some permission nobody has'));
    }

    public function test_backend_check_for_explicit_permission()
    {
        $permission = Permission::create(['name' => 'edit articles']);
        
        $user = User::factory()->create();

        $this->assertFalse(Backend::check($user, 'edit articles'));

        $user->givePermissionTo($permission);

        $this->assertTrue(Backend::check($user, 'edit articles'));
    }

    public function test_backend_check_for_permission_via_role()
    {
        Permission::create(['name' => 'edit articles']);

        $role = Role::create(['name' => 'editor']);
        
        $role->givePermissionTo('edit articles');
        
        $user = User::factory()->create();

        $this->assertFalse(Backend::check($user, 'edit articles'));

        $user->assignRole('editor');

        $this->assertTrue(Backend::check($user, 'edit articles'));
    }
}
