<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\Exceptions\PluginValidationException;
use Bedard\Backend\Facades\Backend;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

abstract class Plugin
{
    /**
     * Yaml configuration for the current controller
     *
     * @var array
     */
    public readonly array $config;

    /**
     * The current controller
     *
     * @var array
     */
    public readonly array $controller;

    /**
     * Complete config data for all controllers
     *
     * @var array
     */
    public readonly array $controllers;

    /**
     * The current controller id
     *
     * @var array
     */
    public readonly string $id;

    /**
     * The current route name
     * 
     * @var string
     */
    public readonly string $route;

    /**
     * Create a plugin
     *
     * @param string $route
     */
    public function __construct(string $route) {
        $controllers = Backend::controllers();

        $id = str_starts_with($route, 'backend.')
            ? Str::of($route)->ltrim('backend.')->explode('.')->first()
            : null;

        $this->config = $this->normalize(Backend::config($route));

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
