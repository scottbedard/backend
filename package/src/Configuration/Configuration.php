<?php

namespace Bedard\Backend\Configuration;

use ArrayAccess;
use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Exceptions\ConfigurationArrayAccessException;
use Bedard\Backend\Exceptions\InvalidConfigurationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class Configuration implements ArrayAccess
{
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
    public array $default = [];

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
     * Raw yaml data
     *
     * @var array
     */
    public array $yaml;

    /**
     * Create a config
     *
     * @param array $yaml
     */
    public function __construct(array $yaml = [])
    {
        $this->yaml = $yaml;

        // fill default values
        $config = $yaml;

        foreach ($this->default as $key => $value) {
            data_fill($config, $key, $value);
        }

        // normalize arrays
        foreach ($this->props as $key => $val) {
            if (!is_array($val)) {
                data_fill($config, $key, null);
            } else {
                data_fill($config, $key, []);

                if (count($val) === 2) {
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
            throw new InvalidConfigurationException('Invalid backend configuration: ' . $validator->errors()->first());
        }

        $this->config = $config;

        // finalize data and instantiate props
        $data = [];

        foreach ($this->config as $key => $val) {
            $prop = data_get($this->props, $key);

            if (is_array($prop)) {
                $data[$key] = collect($config[$key])->map(fn ($item) => $prop[0]::create($item));
            } else {
                $data[$key] = $config[$key];
            }
        }

        $this->data = $data;
    }

    /**
     * Static constructor
     *
     * @param array $yaml
     *
     * @return self
     */
    public static function create(array $yaml = []): self
    {
        $config = get_called_class();
        
        return new $config($yaml);
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
}