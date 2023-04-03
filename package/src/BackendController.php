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
        $req = request();

        $routeName = $req->route()->getName();

        $config = Backend::config($routeName);

        $controllers = Backend::controllers();

        $id = str_starts_with($routeName, 'backend.')
            ? Str::of($routeName)->ltrim('backend.')->explode('.')->first()
            : null;

        // render plugin data
        $aliases = config('backend.plugins');

        $constructor = data_get($aliases, $config['plugin'], $config['plugin']);

        $controller = data_get($controllers, $id);

        $plugin = new $constructor(
            config: $config,
            controller: $controller,
            controllers: $controllers,
            id: $id,
            route: $routeName,
        );

        return $plugin->render();
    }
}
