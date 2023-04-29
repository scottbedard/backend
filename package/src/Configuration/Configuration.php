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
    protected array $children = [];

    /**
     * Normalized configuration data
     *
     * @var array
     */
    protected array $config = [];

    /**
     * List of keyed arrays to be converted on instantiation
     *
     * @var array
     */
    protected array $keyed = [];

    /**
     * Child properties
     *
     * @var array
     */
    protected array $properties = [];

    /**
     * Validation rules
     *
     * @var array
     */
    protected array $rules = [];

    /**
     * Raw yaml data
     *
     * @var array
     */
    protected array $yaml;

    /**
     * Create a config
     *
     * @param array $yaml
     */
    public function __construct(array $yaml = [])
    {
        $config = $yaml;

        foreach ($this->keyed as $property => $key) {
            if (Arr::has($config, $property) && Arr::isAssoc($config[$property])) {
                $config[$property] = collect(KeyedArray::from($config[$property], $key))
                    ->sortBy('order')
                    ->values()
                    ->toArray();
            }
        }

        $this->config = $config;

        $this->yaml = $config;

        $this->build();
    }

    /**
     * Build configuration tree
     *
     * @return void
     */
    protected function build(): void
    {
        // normalize yaml data
        $this->normalize();

        // validate configuration
        $this->validate();

        // instantiate child properties
        $children = [];
        
        foreach ($this->config as $key => $data) {
            $prop = data_get($this->properties, $key);

            if (!$prop) {
                continue;
            } elseif (is_array($data) && Arr::isList($data)) {
                $children[$key] = collect($data)->map(fn ($d) => $prop::create($d));
            } elseif (is_array($data) && Arr::isAssoc($data)) {
                $children[$key] = $prop::create($data);
            }
        }

        $this->children = $children;
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
     * Normalize config data
     *
     * @param array $config
     *
     * @return void
     */
    protected function normalize(): void
    {
    }

    /**
     * Get a child property
     *
     * @param string $key
     *
     * @return Illuminate\Support\Collection|self|null
     */
    public function property(string $key): Collection|self|null
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
    protected function validate(): void
    {
        $validator = Validator::make($this->config, $this->rules);
        
        if ($validator->fails()) {
            throw new InvalidConfigurationException('Invalid backend configuration: ' . $validator->errors()->first());
        }
    }
}
