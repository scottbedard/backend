<?php

namespace Bedard\Backend\Config;

use ArrayAccess;
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

        // set normalized data
        $children = $this->children();
        
        $data = [];

        foreach ($this->__config as $key => $value) {
            $setter = str('set_' . $key . '_attribute')->camel()->toString();

            if (method_exists($this, $setter)) {
                $data[$key] = $this->$setter($value);
            }

            elseif (array_key_exists($key, $children)) {
                $child = $children[$key];

                // map strings directly to their class names
                if (is_string($child)) {
                    $data[$key] = $child::create($value);
                }

                if (is_array($child) && count($child) === 1) {
                    [$childClass] = $child;

                    $data[$key] = collect($this->__config[$key])->map(fn ($m) => $childClass::create($m));
                }
                
                // // create associative arrays by their key
                // $keyed = is_array($this->children[$key]) && count($this->children[$key]) === 1;

                // if ($keyed) {

                // } else {
                //     dd('not keyed', $key);
                // }
            }

            else {
                $data[$key] = $value;
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