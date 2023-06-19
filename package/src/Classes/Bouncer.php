<?php

namespace Bedard\Backend\Classes;

use Illuminate\Foundation\Auth\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Bouncer
{
    /**
     * Test if a user has all permissions
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param string|iterable $permissions
     *
     * @return bool
     */
    public static function check(?User $user, string|iterable $permissions): bool
    {
        if (!$user && count($permissions) > 0) {
            return false;
        }

        if (is_string($permissions) && !$user->can($permissions)) {
            return false;
        }

        $permissions = is_iterable($permissions) ? $permissions : [$permissions];
        
        foreach ($permissions as $permission) {
            if (!$user->can($permission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Generate resource role and permissions
     */
    public static function crud(string $resource, string $role = null)
    {
        $create = Permission::create(['name' => "{$resource}.create"]);
        $read = Permission::create(['name' => "{$resource}.read"]);
        $update = Permission::create(['name' => "{$resource}.update"]);
        $delete = Permission::create(['name' => "{$resource}.delete"]);

        if ($role) {
            $role = Role::create(['name' => $role]);

            $role->syncPermissions([$create, $read, $update, $delete]);
        }

        return [
            'role' => $role,
            'create' => $create,
            'read' => $read,
            'update' => $update,
            'delete' => $delete,
        ];
    }
}