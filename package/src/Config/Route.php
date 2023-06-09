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
     * Get controller
     *
     * @return \Bedard\Backend\Config\Controller
     */
    public function getControllerAttribute(): Controller
    {
        return $this->closest(Controller::class);
    }

    /**
     * Get default config
     *
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'id' => null,
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
                config: data_get($this->__config, 'options', []),
                parent: $this,
            );
        }

        $aliases = config('backend.plugins');

        foreach ($aliases as $alias => $class) {
            if ($plugin === $alias) {
                return $class::create(
                    config: data_get($this->__config, 'options', []),
                    parent: $this,
                );
            }
        }
        
        throw new ConfigException("Plugin [{$plugin}] not found");
    }

    /**
     * Set path
     *
     * @return ?string
     */
    public function setPathAttribute(): ?string
    {
        if (array_key_exists('path', $this->__config)) {
            return $this->__config['path'];
        }
        
        return str($this->__config['id'])->slug()->toString();
    }
}
