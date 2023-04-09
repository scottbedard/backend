<?php

namespace Bedard\Backend;

use Bedard\Backend\Classes\Plugin;
use Bedard\Backend\Facades\Backend;
use Exception;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class BackendController extends BaseController
{
    /**
     * Render backend route
     *
     * @param string $name
     * @param array $args
     *
     * @return mixed
     */
    public function __call($name, $args)
    {
        $routeName = request()->route()->getName();

        $route = Backend::route($routeName);

        $plugin = new $route['plugin']($routeName);

        dd($plugin);
        // $name = data_get($config, 'plugin');

        // $constructor = data_get(config('backend.plugins'), $name, $name);

        // // create plugin and return view
        // $plugin = new $constructor($route);

        // return $plugin->view();
    }
}
