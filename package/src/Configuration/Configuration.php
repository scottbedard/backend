<?php

namespace Bedard\Backend\Configuration;

use Bedard\Backend\Exceptions\InvalidConfigurationException;
use Illuminate\Support\Facades\Validator;

class Configuration
{
    /**
     * Normalized configuration
     *
     * @var array
     */
    protected array $config = [];

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

        $this->normalize();

        $this->validate();
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
        return new self($yaml);
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
     * Normalize configuration
     *
     * @return void
     */
    protected function normalize(): void
    {
        $config = $this->yaml;

        data_fill($config, 'foo', 'bar');

        $this->config = $config;
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
