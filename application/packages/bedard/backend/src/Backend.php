<?php

namespace Bedard\Backend;

use Bedard\Backend\Util;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Backend
{
    /**
     * Assign a user to a role.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param string $name
     *
     * @return \Illuminate\Foundation\Auth\User
     */
    public function assign(User $user, string $name)
    {
        try {
            $user->assignRole($name);
        } catch (RoleDoesNotExist $e) {};
    }

    /**
     * Grant permission to a user.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param string $name
     *
     * @return \Illuminate\Foundation\Auth\User
     */
    public function authorize(User $user, string $name)
    {
        $permission = Permission::findOrCreate($name);

        return $user->givePermissionTo($permission);
    }

    /**
     * Check for any permission.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param array $permissions
     *
     * @return bool
     */
    public function check($user, ...$permissions): bool
    {
        if (!$user) {
            return false;
        }

        $checks = array_filter($permissions, fn ($p) => $p);

        // check for super admin
        if (empty($checks) || Util::attempt(fn () => $user->hasPermissionTo('super admin'))) {
            return true;
        }

        // check for explicit permission
        if (Util::attempt(fn () => $user->hasAnyPermission($checks))) {
            return true;
        }

        // process special permissions
        $special = collect($permissions)
            ->filter(function ($permission) {
                return is_string($permission) && preg_match('/^[a-zA-Z]+ [a-zA-Z]+$/i', $permission);
            })
            ->map(function ($permission) {
                return  explode(' ', $permission);
            });
            
        $processed = [];

        foreach ($special as $permission) {
            if (in_array($permission, $processed)) {
                continue;
            }
            
            [$action, $resource] = $permission;

            // access only requires one resource permission
            if ($action === 'access') {
                $instance = Backend::resource($resource);

                return Util::attempt(fn () => $user->hasAnyPermission($instance->permissions()));
            }

            // managers can access all areas of their resource
            if (Util::attempt(fn () => $user->hasPermissionTo("manage {$resource}"))) {
                return true;
            }

            array_push($processed, $permission);
        }
        
        return false;
    }

    /**
     * Revoke backend permission from a user.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param string $name
     *
     * @return void
     */
    public function deauthorize(User $user, string $name)
    {
        try {
            $user->revokePermissionTo($name);
        } catch (PermissionDoesNotExist $e) {}
    }

    /**
     * Test if a user's backend setting is disabled
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param string $key
     * 
     * @return boolean
     */
    public function disabled($user, string $key)
    {
        return ! $this->enabled($user, $key);
    }

    /**
     * Test if a user's backend setting is enabled
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param string $key
     *
     * @return boolean
     */
    public function enabled(User $user, string $key)
    {
        return (bool) $user->backendSettings()->where('key', $key)->where('value', true)->count();
    }

    /**
     * Get a backend resource by ID
     *
     * @param string $id
     *
     * @return \Bedard\Backend\Resource
     */
    public function resource(string $id)
    {
        $resource = self::resources()->firstOrFail(function ($resource) use ($id) {
            return $resource::$id === $id;
        });

        return new $resource();
    }

    /**
     * Get collection of backend resources
     *
     * @return \Illuminate\Support\Collection
     */
    public function resources()
    {
        return collect(ClassFinder::getClassesInNamespace('App\\Backend\\Resources'))
            ->sortBy([
                function ($a, $b) {
                    return $a::$order <=> $b::$order;
                },
                function ($a, $b) {
                    return $a::$title <=> $b::$title;
                },
            ]);
    }

    /**
     * Unassign a user to a role.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param string $name
     *
     * @return void
     */
    public function unassign(User $user, string $name): void
    {
        try {
            $user->removeRole($name);
        } catch (RoleDoesNotExist $e) {}
    }

    /**
     * Query backend users.
     *
     * @param string $area
     * @param string $code
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function users(string $area = '', string $code = ''): Builder
    {
        return config('backend.user')::query()
            ->whereHas('backendPermissions', function (Builder $query) use ($area, $code) {
                if ($area) {
                    $query->where(function ($q) use ($area) {
                        $q->area('all')->orWhere->area($area);
                    });
                }

                if ($code) {
                    $query->where(function ($q) use ($code) {
                        $q->code('all')->orWhere->code($code);
                    });
                }
            });
    }
}