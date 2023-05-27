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

        // set normalized data
        $data = [];

        foreach ($this->config as $key => $value) {
            $setter = str('set_' . $key . '_attribute')->camel()->toString();

            if (method_exists($this, $setter)) {
                $data[$key] = $this->$setter($value);
            }
        }
        
        $this->data = $data;
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
        return data_get($this->data, $key, $default);
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