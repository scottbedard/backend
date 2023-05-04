<?php

namespace Bedard\Backend\Configuration;

use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Exceptions\InvalidConfigurationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class Configuration
{
    /**
     * Child configuration
     *
     * @var array
     */
    public array $children = [];

    /**
     * Normalized yaml data
     *
     * @var array
     */
    public array $config = [];

    /**
     * Default configuration
     *
     * @var array
     */
    public array $default = [];

    /**
     * Child property definitions
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
                if (!array_key_exists($key, $config)) {
                    $config[$key] = [];
                }

                if (count($val) === 2) {
                    [$class, $id] = $val;

                    $config[$key] = collect(KeyedArray::from($config[$key], $id))
                        ->sortBy('order')
                        ->values()
                        ->toArray();
                }
            }
        }

        $this->config = $config;
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
        return data_get($this->config, $path, $default);
    }

    /**
     * Get a child property
     *
     * @param string $key
     *
     * @return Illuminate\Support\Collection|self|null
     */
    public function prop(string $key): Collection|self|null
    {
        return data_get($this->children, $key);
    }

    /**
     * Validate configuration
     *
     * @throws Exception
     *
     * @return void
     */
    public function validate(): void
    {
        $validator = Validator::make($this->config, $this->rules);
        
        if ($validator->fails()) {
            throw new InvalidConfigurationException('Invalid backend configuration: ' . $validator->errors()->first());
        }
    }
}
