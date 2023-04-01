<?php

namespace Bedard\Backend;

use Bedard\Backend\Classes\Plugin;
use Bedard\Backend\Facades\Backend;
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
        $config = Backend::config($routeName);
        $controllers = Backend::controllers();
        $controllerName = Str::of($routeName)->ltrim('backend.')->explode('.')->first();
        
        $plugin = new Plugin();
        
        // dd([
        //     'config' => $config,
        //     'controller' => $controller,
        //     'controllers' => $controllers,
        //     'routeName' => $routeName,
        // ]);
        // $page = Backend::page($config, [
        //     'config' => $config,
        //     'controller' => $controller,
        //     'controllers' => $controllers,
        //     'route' => $routeName,
        // ]);

        // return Backend::view([
        //     'config' => $config,
        //     'page' => $page,
        //     'route' => $routeName,
        // ]);
    }
}
