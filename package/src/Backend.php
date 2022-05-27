<?php

namespace Bedard\Backend;

use Bedard\Backend\Exceptions\AlreadyAuthorizedException;
use Bedard\Backend\Models\BackendPermission;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User;

class Backend
{
    /**
     * Grant backend permission to a user.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param string $area
     * @param string $code
     *
     * @return \Bedard\Backend\Models\BackendPermission
     */
    public function authorize(User $user, string $area, string $code)
    {
        if (self::test($user, $area, $code)) {
            throw new AlreadyAuthorizedException;
        }
        
        return $user->backendPermissions()->create([
            'area' => BackendPermission::normalize($area),
            'code' => BackendPermission::normalize($code),
        ]);
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
     * @return string[]
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
     * Test if a user has a given backend permission.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param string $area
     * @param string $code
     *
     * @return bool
     */
    public function test(User $user, string $area, string $code)
    {
        return $user
            ->backendPermissions()
            ->where(function ($query) use ($area, $code) {
                $query
                    ->where(function ($q) use ($area) {
                        $q->area('all')->orWhere->area($area);
                    })
                    ->where(function ($q) use ($code) {
                        $q->code('super')->orWhere->code($code);
                    });
            })
            ->exists();
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
                        $q->code('super')->orWhere->code($code);
                    });
                }
            });
    }
}