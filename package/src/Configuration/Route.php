<?php

namespace Bedard\Backend\Configuration;

use Bedard\Backend\Exceptions\ConfigurationException;
use Bedard\Backend\Plugins\BladePlugin;
use Bedard\Backend\Plugins\Plugin;
use Bedard\Backend\Traits\Permissions;

class Route extends Configuration
{
    use Permissions;

    /**
     * Default data
     *
     * @var array
     */
    public static array $defaults = [
        'model' => null,
        'options' => [],
        'permissions' => [],
        'plugin' => BladePlugin::class,
    ];

    /**
     * Inherited data
     *
     * @var array
     */
    public array $inherits = [
        'model',
    ];

    /**
     * Get the route's controller
     *
     * @return \Bedard\Backend\Configuration\Controller
     */
    public function controller(): Controller
    {
        return $this->closest(Controller::class);
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
        if ($path === 'path') {
            return $this->path();
        }

        return parent::get($path, $default);
    }

    /**
     * Get validation rules
     *
     * @return array
     */
    public function getValidationRules(): array
    {
        return [
            'model' => ['nullable', 'string'],
            'options' => ['present', 'array'],
            'path' => ['nullable', 'string'],
            'permissions.*' => ['string'],
            'permissions' => ['present', 'array'],
            'plugin' => ['nullable', 'string'],
        ];
    }

    /**
     * Path
     *
     * @return ?string
     */
    public function path(): ?string
    {
        if (array_key_exists('path', $this->config)) {
            return $this->config['path'];
        }

        return str($this->get('id'))->slug()->toString();
    }

    /**
     * Create plugin instance
     *
     * @return \Bedard\Backend\Plugins\Plugin
     */
    public function plugin(): Plugin
    {
        $plugins = config('backend.plugins', []);

        $plugin = $this->get('plugin');

        $class = data_get($plugins, $plugin, $plugin);

        if ($class !== Plugin::class && !is_subclass_of($class, Plugin::class)) {
            throw new ConfigurationException('Invalid plugin class "' . $class . '"');
        }

        return $class::create($this->config['options'], $this, $this->get('id'));
    }
}
