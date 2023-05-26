<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\Configuration\Configuration;
use Illuminate\Support\Facades\Route;

class Href
{
    /**
     * Format href
     *
     * @param string $to
     * @param string $controller
     * @param \Bedard\Backend\Configuration\Configuration $config
     *
     * @return ?string
     */
    public static function format(string $to = null, string $controller = null, Configuration $config = null): ?string
    {
        if ($to === null) {
            return null;
        }

        if (Route::has($to)) {
            return route($to);
        }

        $backendPath = str(config('backend.path'))->trim('/');

        if ($config && str($to)->is('backend.*.*')) {
            $route = $config->route($to);

            if ($route) {
                return route('backend.controller.route', [
                    'controller' => $route->controller()->path(),
                    'route' => $route->path(),
                ]);
            }
        }

        $to = str($to)->replace('{backend}', $backendPath);

        if (is_string($controller)) {
            $to = str($to)->replace('{controller}', $controller);
        } elseif (is_null($controller)) {
            $to = str($to)
                ->replace('{controller}/', '')
                ->replace('/{controller}', '')
                ->replace('{controller}', '');
        }

        return $to;
    }
}