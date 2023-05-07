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
    public array $defaults = [
        'model' => null,
        'options' => [],
        'path' => null,
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
    public array $rules = [
        'model' => ['nullable', 'string'],
        'options' => ['present', 'array'],
        'path' => ['nullable', 'string'],
        'plugin' => ['nullable', 'string'],
    ];

    /**
     * Construct
     *
     * @param array $args
     */
    public function __construct(...$args)
    {
        parent::__construct(...$args);

        // set data to plugin instance
        $plugins = config('backend.plugins', []);

        $plugin = data_get($plugins, $this->config['plugin'], $this->config['plugin']);

        if ($plugin !== Plugin::class && !is_subclass_of($plugin, Plugin::class)) {
            throw new ConfigurationException('Invalid plugin class "' . $plugin . '"');
        }

        $this->data['plugin'] = $plugin::create($this->config['options'], $this);
    }

    /**
     * Get the route's controller
     *
     * @return \Bedard\Backend\Configuration\Controller
     */
    public function controller(): Controller
    {
        return $this->closest(Controller::class);
    }
}
