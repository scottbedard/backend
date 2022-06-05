<?php

namespace Bedard\Backend;

use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User;
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
     * Revoke backend permission from a user.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param string $name
     *
     * @return void
     */
    public function deauthorize(User $user, string $area = 'all', string $code = 'all')
    {
        // ...
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