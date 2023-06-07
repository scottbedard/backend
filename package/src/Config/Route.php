<?php

namespace Bedard\Backend\Config;

use Bedard\Backend\Config\Behaviors\Permissions;
use Bedard\Backend\Config\Plugins\Plugin;

class Route extends Config
{
    /**
     * Define behaviors
     *
     * @return array
     */
    public function defineBehaviors(): array
    {
        return [
            Permissions::class,
        ];
    }

    /**
     * Define validation rules
     *
     * @return array
     */
    public function defineValidation(): array
    {
        return [
            'options' => ['present', 'array'],
            'plugin' => ['required', 'string'],
        ];
    }

    /**
     * Get default options
     *
     * @return array
     */
    public function getDefaultOptions(): array
    {
        return [];
    }

    /**
     * Create plugin instance
     *
     * @return \Bedard\Backend\Config\Plugins\Plugin
     */
    public function setPluginAttribute(): Plugin
    {
        
        return Plugin::create(
            config: $this->__config['options'],
            parent: $this,
        );
    }
}
