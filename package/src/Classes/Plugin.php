<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\Facades\Backend;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class Plugin
{
    /**
     * Controller definition
     *
     * @var array
     */
    protected array $controller;

    /**
     * Route definition
     *
     * @var array
     */
    protected array $route;

    /**
     * Validation rules
     *
     * @var array
     */
    protected array $rules = [];

    /**
     * Create a plugin
     *
     * @param string $routeName
     *
     * @return void
     */
    public function __construct(string $routeName)
    {
        $this->controller = Backend::controller($routeName);

        $this->route = Backend::route($routeName);

        $this->normalize();

        $this->validate();
    }

    /**
     * Normalize route config
     *
     * @return void
     */
    public function normalize(): void
    {
    }

    /**
     * Validate config
     *
     * @throws \Exception
     *
     * @return void
     */
    public function validate(): void
    {
        $validator = Validator::make($this->route, $this->rules);
        
        if ($validator->fails()) {
            throw new Exception('Invalid plugin config: ' . $validator->errors()->first());
        }
    }
}
