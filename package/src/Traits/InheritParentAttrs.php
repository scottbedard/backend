<?php

namespace Bedard\Backend\Traits;

use ReflectionClass;

trait InheritParentAttrs
{
    public function __construct()
    {
        $instance = new ReflectionClass(static::class);

        $attributes = [];

        while ($instance) {
            $props = $instance->getDefaultProperties();

            $attributes = array_merge(array_key_exists('attributes', $props) ? $props['attributes'] : [], $attributes);

            $instance = $instance->getParentClass();
        }

        $this->attributes = $attributes;
    }
}