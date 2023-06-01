<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function login(User $user)
    {
        auth()->login($user);

        return $user;
    }

    public function assignRole(User $user, string $name)
    {
        $user->assignRole($this->getRole($name));
    }

    public function getPermission(string $name): Permission
    {
        return Permission::where('name', $name)->first() ?: Permission::create(['name' => $name]);
    }

    public function getRole(string $name): Role
    {
        return Role::where('name', $name)->first() ?: Role::create(['name' => $name]);
    }

    public function givePermissionTo(User $user, string $name)
    {
        $user->givePermissionTo($this->getPermission($name));
    }

    public function loginAsSuperAdmin()
    {
        return $this->login($this->makeSuperAdmin());
    }

    public function loginAsUserThatCan(...$permissions)
    {
        return $this->login($this->makeUserThatCan(...$permissions));
    }

    public function makeUserThatCan(...$permissions)
    {
        $user = User::factory()->create();

        foreach ($permissions as $permission) {
            $this->givePermissionTo($user, $permission);
        }

        return $user;
    }

    public function makeSuperAdmin(array $data = [])
    {
        $user = User::factory()->create($data);

        $this->assignRole($user, config('backend.super_admin_role'));

        return $user;
    }
}
