<?php

namespace Bedard\Backend;

use Bedard\Backend\Classes\ResourceInfo;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;

class Backend
{
    /**
     * Test if a user's backend setting is disabled
     */
    public function disabled($user, string $key)
    {
        return ! $this->enabled($user, $key);
    }

    /**
     * Test if a user's backend setting is enabled
     */
    public function enabled($user, string $key)
    {
        return (bool) $user->backendSettings()->where('key', $key)->where('value', true)->count();
    }

    /**
     * Get a backend resource by ID
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
     * Query application users.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function userQuery(): Builder
    {
        return config('backend.user')::query();
    }
}