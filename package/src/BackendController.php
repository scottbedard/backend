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
        return view('backend::backend');
        // // find constructor from alias, or use explicit class name
        // $route = request()->route()->getName();

        // $config = Backend::config($route);
        
        // $name = data_get($config, 'plugin');

        // $constructor = data_get(config('backend.plugins'), $name, $name);

        // // create plugin and return view
        // $plugin = new $constructor($route);

        // return $plugin->view();
    }
}
