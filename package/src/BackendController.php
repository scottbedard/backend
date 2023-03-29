<?php

namespace Bedard\Backend;

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

        $controllers = Backend::controllers();

        $controller = Str::of($routeName)->ltrim('backend.')->explode('.')->first();
        
        $config = Backend::config($routeName);
        
        $page = Backend::page($config, [
            'config' => $config,
            'controller' => $controller,
            'controllers' => $controllers,
            'route' => $routeName,
        ]);

        return Backend::view([
            'page' => $page,
        ]);
    }
}
