<?php

namespace Bedard\Backend;

use HaydenPierce\ClassFinder\ClassFinder;
use ReflectionClass;
use Bedard\Backend\Classes\ResourceInfo;

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
}