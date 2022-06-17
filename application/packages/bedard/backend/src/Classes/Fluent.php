<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\Exceptions\FluentException;
use Bedard\Backend\Util;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use ReflectionClass;

abstract class Fluent implements Arrayable
{
    /**
     * All of the attributes set on the fluent instance
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Data
     *
     * @var array
     */
    protected $data = [];

    /**
     * Subclass constructor aliases
     *
     * @var array
     */
    public static $subclasses = [];

    /**
     * Call
     *
     * @param string $key
     * @param array $value
     *
     * @return \Bedard\Backend\Fluent
     */
    public function __call(string $key, array $value)
    {
        $this->setAttribute($key, $value);

        return $this;
    }

    /**
     * Call static
     */
    public static function __callStatic(string $key, array $args)
    {
        if (array_key_exists($key, static::$subclasses)) {
            return count($args)
                ? static::$subclasses[$key]::make($args[0])
                : static::$subclasses[$key]::make();
        }

        if (count($args) > 0) {
            return static::make()->{$key}($args[0]);
        }
        
        return static::make()->{$key}();
    }

    /**
     * Construct
     *
     * @return void
     */
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

    /**
     * Get
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        if (property_exists($this, $key)) {
            return $this->{$key};
        }

        $getter = Str::camel('get_' . $key . '_attribute');

        if (method_exists($this, $getter)) {
            return $this->{$getter}();
        }
        
        elseif (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
        
        return null;
    }

    /**
     * Set
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function __set(string $key, $value): void
    {
        $this->setAttribute($key, [$value]);
    }

    /**
     * Test for attribute precense
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasAttribute(string $key): bool
    {
        return array_key_exists($key, $this->attributes);
    }
    
    /**
     * Initialize
     *
     * @return void
     */
    public function init()
    {
    }

    /**
     * Make new instance
     *
     * @param array $args
     *
     * @return \Bedard\Backend\Classes\Fluent
     */
    public static function make(...$args)
    {
        $instance = new static;
    
        $instance->init(...$args);

        return $instance;
    }

    /**
     * Set attribute
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function setAttribute(string $key, $args): void
    {
        if (property_exists($this, $key)) {
            if (count($args) > 0) {
                $this->{$key} = $args[0];
            }

            return;
        }

        $setter = Str::camel('set_' . $key . '_attribute');
        
        if (method_exists($this, $setter)) {
            $this->{$setter}(...$args);
        }

        elseif (array_key_exists($key, $this->attributes)) {
            if (count($args)) {
                $this->attributes[$key] = $args[0];
            } elseif (is_bool($this->attributes[$key])) {
                $this->attributes[$key] = true;
            } else {
                $this->throwUnknownPropertyException($key);
            }
        }

        else {
            $this->throwUnknownPropertyException($key);
        }
    }


    
    /**
     * Provide data to child items
     *
     * @param mixed $data
     *
     * @return \Bedard\Backend\Components\Block
     */
    final public function provide($data)
    {
        $this->data = $data;

        foreach ($this->attributes as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $descendent) {
                    if (is_a($descendent, self::class)) {
                        $descendent->provide($data);
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Throw unknown property acception.
     *
     * @param string $key
     *
     * @throws \Bedard\Backend\Exceptions\FluentException
     */
    private function throwUnknownPropertyException(string $key): void
    {
        $properties = array_keys($this->attributes);

        if (count($properties) > 0) {
            $suggestion = Util::suggest($key, $properties);

            throw new FluentException("Unknown property \"{$key}\", did you mean \"{$suggestion}\"?");
        }

        throw new FluentException("Unknown property \"{$key}\".");
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }
}
