<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\Config\Config;
use Illuminate\Support\Facades\Route;

class To
{
    public static function href($to, Config $config)
    {
        if (!is_string($to)) {
            return $to;
        }

        if (Route::has($to)) {
            return route($to);
        }

        if (str($to)->is('backend.*.*')) {
            [, $controllerId, $routeId] = explode('.', $to);

            $controller = $config->root()->controller($controllerId);

            if ($controller) {
                $route = $controller
                    ->routes
                    ->first(fn ($r) => $r->id === $routeId);

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