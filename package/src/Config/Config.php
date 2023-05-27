<?php

namespace Bedard\Backend\Config;

class Config
{
    /**
     * Raw yaml config
     *
     * @var array
     */
    public readonly array $config;

    /**
     * Normalized config data
     *
     * @var array
     */
    public readonly array $data;

    /**
     * Create config instance
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        // set default attributes
        $defaults = $this->getDefaultAttributes();

        foreach (get_class_methods($this) as $method) {
            if (str_starts_with($method, 'getDefault') && str_ends_with($method, 'Attribute')) {
                $attr = str(substr($method, 10, -9))->snake()->toString();

                data_fill($defaults, $attr, $this->$method());
            }
        }

        $this->config = array_merge($defaults, $config);
        
        $this->data = [];
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
     */
    public function get($key, $default = null)
    {
        return $key;
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
}