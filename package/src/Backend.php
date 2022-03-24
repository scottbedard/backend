<?php

namespace Bedard\Backend;

use Bedard\Backend\Classes\ResourceInfo;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Database\Eloquent\Builder;

class Backend
{
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
            ->values()
            ->toArray();
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