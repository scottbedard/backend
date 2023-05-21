<?php

namespace Bedard\Backend\Configuration;

use Bedard\Backend\Exceptions\ConfigurationException;
use Bedard\Backend\Plugins\BladePlugin;
use Bedard\Backend\Plugins\Plugin;

class Route extends Configuration
{
    /**
     * Default data
     *
     * @var array
     */
    public static array $defaults = [
        'model' => null,
        'options' => [],
        'path' => null,
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
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
        'model' => ['nullable', 'string'],
        'options' => ['present', 'array'],
        'path' => ['nullable', 'string'],
        'permissions.*' => ['string'],
        'permissions' => ['present', 'array'],
        'plugin' => ['nullable', 'string'],
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
     * Path
     *
     * @return ?string
     */
    public function path(): ?string
    {
        if (array_key_exists('path', $this->data)) {
            return $this->data['path'];
        }

        $id = $this->get('id');

        return str_starts_with($id, '_')
            ? null
            : str($id)->slug()->toString();
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
