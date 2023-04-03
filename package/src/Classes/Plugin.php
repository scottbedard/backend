<?php

namespace Bedard\Backend\Classes;

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
     * @param array $controller
     * @param array $controllers
     * @param string $id
     * @param string $route
     */
    public function __construct(
        array $config,
        array $controller,
        array $controllers,
        string $id,
        string $route,
    ) {
        $this->config = $config;
        $this->controller = $controller;
        $this->controllers = $controllers;
        $this->id = $id;
        $this->route = $route;
    }

    /**
     * Render the plugin
     *
     * @return Illuminate\View\View
     */
    abstract public function render(): View;
}
