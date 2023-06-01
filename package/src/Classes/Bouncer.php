<?php

namespace Bedard\Backend\Classes;

use Illuminate\Foundation\Auth\User;
use Traversable;

class Bouncer
{
    /**
     * Test if a user has all permissions
     *
     * @param iterable $user
     * @param Traversable $permissions
     *
     * @return bool
     */
    public static function check(User $user, iterable $permissions): bool
    {
        $permissions = is_iterable($permissions) ? $permissions : [$permissions];
        
        foreach ($permissions as $permission) {
            if (!$user->can($permission)) {
                return false;
            }
        }

        return true;
    }
}