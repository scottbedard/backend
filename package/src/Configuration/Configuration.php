<?php

namespace Bedard\Backend\Configuration;

use Bedard\Backend\Exceptions\InvalidConfigurationException;
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
        $this->yaml = $yaml;

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
            if (array_key_exists($key, $this->properties)) {
                $children[$key] = $this->properties[$key]::create($data);
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
        $this->config = $this->yaml;
    }

    /**
     * Get a child property
     *
     * @param string $key
     *
     * @return self|array|null
     */
    public function property(string $key): self | array | null
    {
        if (array_key_exists($key, $this->children)) {
            return $this->children[$key];
        }

        return null;
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
