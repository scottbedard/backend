<?php

namespace Bedard\Backend\Classes;

use ReflectionClass;

class ResourceInfo
{
    /**
     * Resource class name.
     *
     * @var string
     */
    protected string $className;

    /**
     * Create a resource info instance.
     *
     * @param string $className
     *
     * @return void
     */
    public function __construct(string $className)
    {
        $this->className = $className;
    }

    /**
     * Convert info to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $class = new ReflectionClass($this->className);

        return array_merge($class->getStaticProperties(), [
            'className' => $this->className,
        ]);
    }
}
