<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\Exceptions\FluentException;
use Bedard\Backend\Util;

class Fluent
{
    /**
     * Constructors.
     * 
     * @var array
     */
    public static array $constructors = [
        // ...
    ];

    /**
     * Set class properties.
     *
     * @param string $name
     * @param array $args
     */
    public function __call($name, array $args = [])
    {
        if (!method_exists($this, $name)) {
            if (property_exists($this, $name)) {
                $this->{$name} = $args[0];
            } else {
                throw $this->propertyException($name);
            }
        }

        return $this;
    }

    /**
     * Static fluent constructor.
     *
     * @param string $key
     * @param array $args
     *
     * @return \Bedard\Backend\Column
     */
    public static function __callStatic(string $key, array $args = [])
    {
        if (array_key_exists($key, static::$constructors)) {
            return new (static::$constructors[$key])(...$args);
        }

        throw static::constructorException($key);
    }

    /**
     * Fluent constructor exception.
     *
     * @param string $key
     *
     * @return \Bedard\Backend\Exceptions\FluentException
     */
    private static function constructorException(string $key)
    {
        if (empty(static::$constructors)) {
            return new FluentException("Unknown constructor \"$key\".");
        }

        $suggestion = Util::suggest($key, array_keys(static::$constructors));

        return new FluentException("Unknown constructor \"{$key}\", did you mean \"{$suggestion}\"?");
    }

    /**
     * Construct a generic fluent instance.
     *
     * @param array $args
     *
     * @return \Bedard\Backend\Classes\Fluent
     */
    public static function make(...$args)
    {
        return new static(...$args);
    }

    /**
     * Fluent exception.
     *
     * @return \Bedard\Backend\Exceptions\FluentException
     */
    private function propertyException(string $name)
    {
        $properties = get_object_vars($this);
        
        if (empty($properties)) {
            return new FluentException("Unknown property \"{$name}\".");
        }

        $suggestion = Util::suggest($name, array_keys(get_object_vars($this)));

        return new FluentException("Unknown property \"{$name}\", did you mean \"{$suggestion}\"?");
    }
}
