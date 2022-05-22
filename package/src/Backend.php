<?php

namespace Bedard\Backend;

use Bedard\Backend\Classes\ResourceInfo;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;

class Backend
{
    /**
     * Test if a user has a backend setting enabled
     */
    public function enabled($user, string $key)
    {
        return (bool) $user->backendSettings->where('key', $key)->where('value', '1')->count();
    }

    /**
     * Get backend resources with static configuration.
     *
     * @return string[]
     */
    public function resources()
    {
        $classes = ClassFinder::getClassesInNamespace('App\\Backend\\Resources');

        return collect($classes)
            ->map(function (string $className) {
                return (new ResourceInfo($className))->toArray();
            })
            ->sortBy([
                ['order', 'asc'],
                ['title', 'asc'],
            ])
            ->values();
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