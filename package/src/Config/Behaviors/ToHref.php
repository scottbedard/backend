<?php

namespace Bedard\Backend\Config\Behaviors;

use Bedard\Backend\Config\Behavior;
use Bedard\Backend\Config\Config;

class ToHref extends Behavior
{
    /**
     * Construct
     *
     * @param Config $config
     * @param array $raw
     * @param string $for
     *
     * @return void
     */
    public function __construct(Config $config, array $raw)
    {
        parent::__construct($config, $raw);
    }

    /**
     * Get default href
     *
     * @return string|null
     */
    public function getHrefAttribute(): string|null
    {
        return 'hello';
    }
}