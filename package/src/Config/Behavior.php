<?php

namespace Bedard\Backend\Config;

class Behavior
{
    /**
     * Config instance
     *
     * @var \Bedard\Backend\Config\Config
     */
    protected Config $config;

    /**
     * Construct
     *
     * @param \Bedard\Backend\Config\Config $config
     *
     * @return self
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }
}