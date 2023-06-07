<?php

namespace Bedard\Backend\Config;

use Bedard\Backend\Config\Behaviors\Permissions;
use Bedard\Backend\Config\Plugins\Plugin;
use Bedard\Backend\Exceptions\ConfigException;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
            // 'options' => ['array'],
            // 'plugin' => ['string'],
        ];
    }

    /**
     * Get default options
     *
     * @return array
     */
    public function getDefaultOptions(): array
    {
        return [
            'plugin' => null,
        ];
    }

    /**
     * Create plugin instance
     *
     * @return \Bedard\Backend\Config\Plugins\Plugin
     */
    public function setPluginAttribute(): Plugin
    {
        $plugin = data_get($this->__config, 'plugin');

        if (!$plugin) {
            return new Plugin;
        }

        if (class_exists($plugin)) {
            return $plugin::create(
                config: $this->__config['options'],
                parent: $this,
            );
        }

        $aliases = config('backend.plugins');

        foreach ($aliases as $alias => $class) {
            if ($plugin === $alias) {
                return $class::create(
                    config: $this->__config['options'],
                    parent: $this,
                );
            }
        }
        
        throw new ConfigException("Plugin [{$plugin}] not found");
    }
}
