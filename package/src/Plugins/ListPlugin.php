<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\Paginator;
use Bedard\Backend\Classes\Plugin;
use Bedard\Backend\Facades\Backend;
use Illuminate\View\View;

class ListPlugin extends Plugin
{
    /**
     * Create a list plugin
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
     * Plugin data
     *
     * @return array
     */
    public function data(): array
    {
        $model = $this->controller['model'];

        $paginator = new Paginator($model::query()->paginate(20));

        return [
            'config' => $this->config,
            'data' => $paginator->data(),
        ];
    }

    /**
     * Render the plugin
     *
     * @return Illuminate\View\View
     */
    public function render(): View
    {
        $data = $this->data();

        return Backend::view(
            data: $data,
            view: 'backend::list', 
        );
    }

    /**
     * Validate config
     *
     * @throws Exception
     */
    public function validate(): void
    {
        // $validator = Validator::make($this->config, [
        //     // ...
        // ]);
        
        // if ($validator->fails()) {
        //     throw new \Exception('Invalid plugin config: ' . $validator->errors()->first());
        // }
    }
}
