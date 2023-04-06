<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\Exceptions\PluginValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

abstract class Plugin
{
    /**
     * Yaml configuration for the current controller
     *
     * @var array
     */
    protected array $config;

    /**
     * The current controller
     *
     * @var array
     */
    protected array $controller;

    /**
     * Complete set of data for all controllers
     *
     * @var array
     */
    protected array $controllers;

    /**
     * The current controller's id
     *
     * @var array
     */
    protected string $id;

    /**
     * The current route name
     * 
     * @var string
     */
    protected string $route;

    /**
     * Construct
     *
     * @param array $config
     * @param array $controllers
     * @param string $id
     * @param string $route
     */
    public function __construct(
        array $config,
        array $controllers,
        string $id,
        string $route,
    ) {
        $this->config = $this->normalize($config);
        $this->controller = data_get($controllers, $id, []);
        $this->controllers = $controllers;
        $this->id = $id;
        $this->route = $route;

        $this->validate();
    }

    /**
     * Normalize plugin config
     *
     * @param array $config
     *
     * @return array
     */
    protected function normalize(array $config): array
    {
        return $config;
    }

    /**
     * Render the plugin
     *
     * @return Illuminate\View\View
     */
    abstract public function render(): View;

    /**
     * Validate config
     *
     * @throws \Bedard\Backend\Exceptions\PluginValidationException
     */
    public function validate(): void
    {
        // $validator = Validator::make($this->config, [
        //     // ...
        // ]);
        
        // if ($validator->fails()) {
        //     throw new PluginValidationException('Invalid plugin config: ' . $validator->errors()->first());
        // }
    }
}
