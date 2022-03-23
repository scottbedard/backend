<?php

namespace Bedard\Backend;

use HaydenPierce\ClassFinder\ClassFinder;
use ReflectionClass;

class Backend
{
    /**
     * Get backend resources.
     *
     * @return string[]
     */
    public function resources()
    {
        return ClassFinder::getClassesInNamespace('App\\Backend\\Resources');
    }

    /**
     * Get static properties from resources.
     */
    public function resourceConfig()
    {
        return collect($this->resources())
            ->map(function (string $className) {
                return new ReflectionClass($className);
            })
            ->reduce(function (array $acc, ReflectionClass $class) {
                $acc[$class->name] = $class->getStaticProperties();

                return $acc;
            }, []);
    }
}