<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\Config\Backend;
use Illuminate\Support\Facades\Route;

class To
{
    public static function href($to, ?Backend $backend = null)
    {
        if (!is_string($to)) {
            return $to;
        }

        if (Route::has($to)) {
            return route($to);
        }

        if ($backend && str($to)->is('backend.*.*')) {
            [, $controllerId, $routeId] = explode('.', $to);

            $controller = $backend->controller($controllerId);

            if ($controller) {
                $route = $controller->route($routeId);

                if ($route) {
                    return route('backend.controller.route', [
                        'controllerOrRoute' => $controller->path,
                        'route' => $route->path,
                    ]);
                }
            }
        }

        return $to;
    }
}
