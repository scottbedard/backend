<?php

namespace Bedard\Backend;

use Bedard\Backend\Facades\Backend;
use Illuminate\Routing\Controller as BaseController;

class BackendController extends BaseController
{
    /**
     * Load a backend route
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
        
        return $config;
    }
}
