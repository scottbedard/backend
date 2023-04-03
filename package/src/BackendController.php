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
        $req = request();

        $routeName = $req->route()->getName();

        $config = Backend::config($routeName);

        $controllers = Backend::controllers();

        $id = Str::of($routeName)->ltrim('backend.')->explode('.')->first();

        // render plugin
        if ($req->header('X-Backend') && array_key_exists('plugin', $config)) {
            $aliases = config('backend.plugins');
            $constructor = data_get($aliases, $config['plugin'], $config['plugin']);

            $plugin = new $constructor(
                config: $config,
                controllers: $controllers,
                id: $id,
                route: $routeName,
            );

            return $plugin->render();
        }

        // render client app
        return Backend::view([
            'config' => $config,
            'route' => $routeName,
        ]);
    }
}
