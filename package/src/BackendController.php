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

        $id = Str::of($routeName)->ltrim('backend.')->explode('.')->first();

        $aliases = config('backend.plugins');

        dd('hello', $aliases);

        $plugin = Plugin::create(
            config: $config,
            controllers: $controllers,
            id: $id,
            route: $routeName,
        );

        return Backend::view([
            'config' => $config,
            'plugin' => $plugin,
            'route' => $routeName,
        ]);
    }
}
