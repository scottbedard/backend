<?php

namespace Bedard\Backend\Config;

use ArrayAccess;
use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Exceptions\ConfigurationArrayAccessException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class Config implements ArrayAccess, Arrayable
{
    /**
     * Raw yaml config
     *
     * @var array
     */
    public readonly array $__config;

    /**
     * Normalized config data
     *
     * @var array
     */
    public readonly array $__data;

    /**
     * Create config instance
     *
     * @param array $__config
     */
    public function __construct(array $config = [])
    {
        // set default attributes
        $defaults = $this->getDefaultAttributes();

        foreach (get_class_methods($this) as $method) {
            if (str($method)->is('getDefault*Attribute')) {
                $attr = str(substr($method, 10, -9))->snake()->toString();

                data_fill($defaults, $attr, $this->$method());
            }
        }

        $this->__config = array_merge($defaults, $config);

        // iterate over config and create child instances
        $data = [];

        $children = $this->children();
        
        foreach ($this->__config as $configKey => $childValue) {

            // prefer custom setters over anything else
            $setter = str('set_' . $configKey . '_attribute')->camel()->toString();

            if (method_exists($this, $setter)) {
                $data[$configKey] = $this->$setter($childValue);
            }

            // otherwise convert array into collections
            elseif (array_key_exists($configKey, $children)) {
                $child = $children[$configKey];

                // map strings directly to their class names
                if (is_string($child)) {
                    $data[$configKey] = $child::create($childValue);
                }

                // map one-dimensional arrays to their class name
                elseif (is_array($child) && count($child) === 1) {
                    [$childClass] = $child;

                    $data[$configKey] = collect($childValue)->map(fn ($m) => $childClass::create($m));
                }

                // map two-dimensional array to their class name and keyed value
                elseif (is_array($child) && count($child) === 2) {
                    [$childClass, $childKey] = $child;

                    $data[$configKey] = collect(KeyedArray::from($childValue, $childKey))
                        ->map(fn ($child) => $childClass::create($child))
                        ->sortBy('order')
                        ->values();
                }
            }

            // finally, set all other static data
            else {
                $data[$configKey] = $childValue;
            }
        }
        
        $this->__data = $data;
    }

    /**
     * Get a piece of data
     *
     * 
     */
    public function __get(string $name): mixed
    {
        return $this->get($name);
    }

    /**
     * Get children definition
     *
     * @return array
     */
    public function children(): array
    {
        return [];
    }

    /**
     * Static constructor
     *
     * @param mixed ...$args
     *
     * @return static
     */
    public static function create(...$args): static
    {
        return new static(...$args);
    }

    /**
     * Get config value
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return data_get($this->__data, $key, $default);
    }

    /**
     * Get default attributes
     *
     * @return array
     */
    public function getDefaultAttributes(): array
    {
        return [];
    }

    /**
     * Check offset existence
     *
     * @param $offset
     */
    public function offsetExists($offset) {
        return isset($this->__data[$offset]);
    }

    /**
     * Get data
     *
     * @param $offset
     */
    public function offsetGet($offset) {
        return isset($this->__data[$offset]) ? $this->__data[$offset] : null;
    }

    /**
     * Set data
     *
     * @param $offset
     * @param $value
     *
     * @throws Bedard\Backend\Exceptions\ConfigurationArrayAccessException
     */
    public function offsetSet($offset, $value)
    {
        throw new ConfigurationArrayAccessException;
    }

    /**
     * Unset data
     *
     * @param $offset
     *
     * @throws Bedard\Backend\Exceptions\ConfigurationArrayAccessException
     */
    public function offsetUnset($offset) {
        throw new ConfigurationArrayAccessException;
    }

    /**
     * Cast to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return collect($this->__data)->toArray();
    }
}