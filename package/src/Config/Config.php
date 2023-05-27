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
        $this->config = array_merge($this->getDefaultAttributes(), $config);

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