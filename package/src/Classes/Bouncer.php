<?php

namespace Bedard\Backend\Classes;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Collection;

class Bouncer
{
    /**
     * Test if a user has all permissions
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param array|Collection $permissions
     *
     * @return bool
     */
    public static function check(User $user, array|Collection $permissions): bool
    {
        $permissions = is_a($permissions, Collection::class)
            ? $permissions
            : collect($permissions);
        
        foreach ($permissions as $permission) {
            if (!$user->can($permission)) {
                return false;
            }
        }

        return true;
    }
}