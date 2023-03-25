<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\BackendController;
use Bedard\Backend\Classes\UrlPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Backend
{
    /**
     * Check if a user has access to a permission. If no permission
     * is specified, the user will be checked for _any_ backend permission.
     *
     * @param mixed $user
     * @param ?string $permission
     * @return bool
     */
    public function check(mixed $user, ?string $permission = null): bool
    {
        if (!$user || !is_a($user, config('backend.user'))) {
            return false;
        }

        if ($user->hasRole(config('backend.super_admin_role'))) {
            return true;
        }

        if ($permission === null) {
            return $user->permissions()->count() > 0;
        }
    
        return $user->hasPermissionTo($permission);
    }

    /**
     * Return the controller for a request
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Bedard\Backend\BackendController
     */
    public function controller(Request $request): BackendController
    {
        $path = new UrlPath($request->path());

        // ...

        return new BackendController;
    }
}
