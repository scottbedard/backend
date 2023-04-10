<?php

namespace Bedard\Backend;

use Bedard\Backend\Classes\Plugin;
use Bedard\Backend\Facades\Backend;
use Exception;
use Illuminate\Support\Str;

class RootController extends Controller
{
    // /**
    //  * Render backend route
    //  *
    //  * @param string $name
    //  * @param array $args
    //  *
    //  * @return mixed
    //  */
    // public function __call($name, $args)
    // {
    //     $routeName = request()->route()->getName();

    //     $route = Backend::route($routeName);

    //     $plugin = new $route['plugin']($routeName);

    //     return $plugin->view();
    // }

    public function index()
    {
        return 'Hello world';
    }
}
