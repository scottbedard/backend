<?php

namespace Bedard\Backend;

use Bedard\Backend\Util;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
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
        $role = Role::findOrCreate($name);

        $user->assignRole($role);
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
    public function check(User $user, ...$permissions): bool
    {
        if (Util::attempt(fn () => $user->hasPermissionTo('super admin'))) {
            return true;
        }

        $resources = [];

        foreach ($permissions as $permission) {
            if (Util::attempt(fn () => $user->hasPermissionTo($permission))) {
                return true;
            }

            if (Str::of($permission)->match('/^^[a-zA-Z]+ [a-zA-Z]+$$/i')) {
                $parts = explode(' ', trim($permission));

                if (count($parts) === 2) {
                    [$action, $resource] = $parts;
                    
                    if (
                        !in_array($resource, $resources) && 
                        Util::attempt(fn () => $user->hasPermissionTo("manage {$resource}"))
                    ) {
                        return true;
                    }

                    array_push($resources, $resource);
                }
            }
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
        $permission = Permission::findOrCreate($name);

        $user->revokePermissionTo($permission);
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
        $role = Role::findOrCreate($name);

        $user->removeRole($role);
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