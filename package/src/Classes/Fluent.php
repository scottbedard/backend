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
    public static array $constructors = [];

    /**
     * Set class properties.
     *
     * @param string $name
     * @param array $args
     */
    public function __call($name, array $args = [])
    {
        if (!method_exists($this, $name)) {
            $prop = property_exists($this, $name);

            if ($prop && count($args) === 0 && is_bool($this->{$name})) {
                $this->{$name} = ! $this->{$name};
            } elseif ($prop) {
                $this->{$name} = $args[0];
            } else {
                $this->throwFluentException($name);
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
        
        return (new static)->{$key}(...$args);
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
     * Throw fluent exception.
     *
     * @throws \Bedard\Backend\Exceptions\FluentException
     */
    private function throwFluentException(string $name)
    {
        $properties = get_object_vars($this);
        
        if (empty($properties)) {
            return new FluentException("Unknown property \"{$name}\".");
        }

        $suggestion = Util::suggest($name, array_keys($properties));

        throw new FluentException("Unknown property \"{$name}\", did you mean \"{$suggestion}\"?");
    }
}
