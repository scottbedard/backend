<?php

namespace Bedard\Backend;

use Bedard\Backend\Facades\Backend;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BackendController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

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

        dd($routeName);

        $route = Backend::route($routeName);

        $plugin = new $route['plugin']($routeName);

        return $plugin->view();
    }
}
