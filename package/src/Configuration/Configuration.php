<?php

namespace Bedard\Backend\Configuration;

use ArrayAccess;
use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Exceptions\ConfigurationArrayAccessException;
use Bedard\Backend\Exceptions\ConfigurationException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class Configuration implements ArrayAccess, Arrayable
{
    /**
     * Auto-create child instances
     *
     * @var bool
     */
    public static bool $autocreate = true;

    /**
     * Normalized yaml data
     *
     * @var array
     */
    public array $config = [];

    /**
     * Configuration data
     *
     * @var array
     */
    public array $data = [];

    /**
     * Default data
     *
     * @var array
     */
    public array $defaults = [];

    /**
     * Inherited data
     *
     * @var array
     */
    public array $inherits = [];

    /**
     * Parent
     *
     * @var self|null
     */
    public ?self $parent;

    /**
     * Child properties
     *
     * @var array
     */
    public array $props = [];

    /**
     * Validation rules
     *
     * @var array
     */
    public array $rules = [];

    /**
     * Construct
     *
     * @param array $yaml
     * @param ?self $parent
     */
    public function __construct(array $yaml = [], ?self $parent = null)
    {
        // inherit config and fill default values
        $config = $yaml;

        $this->parent = $parent;

        foreach ($this->inherits as $key) {
            $ancestor = $parent;

            while ($ancestor) {
                if (array_key_exists($key, $ancestor->config)) {
                    data_fill($config, $key, $ancestor->config[$key]);

                    break;
                }

                $ancestor = $ancestor->parent;
            }
        }

        foreach ($this->defaults as $key => $value) {
            data_fill($config, $key, $value);
        }

        // normalize arrays
        foreach ($this->props as $key => $val) {
            if (!is_array($val)) {
                data_fill($config, $key, null);
            } else {
                data_fill($config, $key, []);

                if (count($val) === 1 && Arr::isAssoc($config[$key])) {
                    $config[$key] = [$config[$key]];
                } elseif (count($val) === 2) {
                    [$class, $id] = $val;

                    $config[$key] = collect(KeyedArray::from($config[$key], $id))
                        ->sortBy('order')
                        ->values()
                        ->toArray();
                }
            }
        }

        // validate and store the config
        $validator = Validator::make($config, $this->rules);
        
        if ($validator->fails()) {
            throw new ConfigurationException(get_called_class() . ' validation error: ' . $validator->errors()->first());
        }

        $this->config = $config;

        // finalize data and instantiate child props
        $data = [];

        foreach ($this->config as $key => $val) {
            $prop = data_get($this->props, $key);

            if (is_array($prop)) {
                $data[$key] = collect($config[$key])->map(fn ($item) => $prop[0]::$autocreate ? $prop[0]::create($item, $this) : $item);
            } elseif ($prop && is_array($val)) {
                $data[$key] = $prop::$autocreate ? $prop::create($val, $this) : $val;
            } else {
                $data[$key] = $val;
            }
        }

        $this->data = $data;
    }

    /**
     * Find the closest ancestor
     *
     * @return ?self
     */
    public function closest(string $class): ?self
    {
        if ($this->parent) {
            return get_class($this->parent) === $class
                ? $this->parent
                : $this->parent->closest($class);
        }

        return null;
    }

    /**
     * Static constructor
     *
     * @param $args
     *
     * @return self
     */
    public static function create(...$args): self
    {
        $config = get_called_class();
        
        return new $config(...$args);
    }

    /**
     * Get config data
     *
     * @param string $path
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $path, $default = null)
    {
        return data_get($this->data, $path, $default);
    }

    /**
     * Check offset existence
     *
     * @param $offset
     */
    public function offsetExists($offset) {
        return isset($this->data[$offset]);
    }

    /**
     * Get data
     *
     * @param $offset
     */
    public function offsetGet($offset) {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
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
     * Get the root ancestor
     *
     * @return self
     */
    public function root(): self
    {
        return $this->parent ? $this->parent->root() : $this;
    }

    /**
     * Cast to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return collect($this->data)->toArray();
    }
}
