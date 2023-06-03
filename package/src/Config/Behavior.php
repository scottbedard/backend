<?php

namespace Bedard\Backend\Config;
;
use Bedard\Backend\Exceptions\RejectConfigException;

class Behavior
{
    /**
     * Config instance
     *
     * @var array
     */
    protected Config $config;

    /**
     * Raw yaml data
     *
     * @var array
     */
    protected array $raw;

    /**
     * Construct
     *
     * @param \Bedard\Backend\Config $config
     * @param array $raw
     */
    public function __construct(Config $config, array $raw)
    {
        $this->config = $config;

        $this->raw = $raw;
    }

    /**
     * Get validation rules
     *
     * @return array
     */
    public function defineValidation(): array
    {
        return [];
    }

    /**
     * Eject the config
     * 
     * @throws \Bedard\Backend\Exceptions\EjectConfigException
     *
     * @return void
     */
    public function reject(): void
    {
        throw new RejectConfigException;
    }
}