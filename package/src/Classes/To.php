<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\Config\Backend;
use Illuminate\Support\Facades\Route;

class To
{
    /**
     * Create href
     *
     * @param mixed $to
     * @param ?Backend $backend
     * @param ?string $controller
     * @param ?string $route
     * @param array $data
     *
     * @return string
     */
    public static function href(
        $to,
        ?Backend $backend = null,
        ?string $controller = null,
        ?string $route = null,
        $data = null,
    )
    {
        if (!is_string($to)) {
            return $to;
        }

        if (Route::has($to)) {
            return route($to);
        }

        if ($backend && str($to)->is('backend.*.*')) {
            [, $controllerId, $routeId] = explode('.', $to);

            $ctrl = $backend->controller($controllerId);

            if ($ctrl) {
                $route = $ctrl->route($routeId);

                if ($route) {
                    return route('backend.controller.route', [
                        'controllerOrRoute' => $ctrl->path,
                        'route' => $route->path,
                    ]);
                }
            }
        }
        
        return url(
            str($to)
                ->replace([
                    ':backend',
                    ':controller',
                    ':route',
                ], [
                    config('backend.path', ''),
                    $controller ?? '',
                    $route ?? '',
                ])
                ->explode('/')
                ->map(function ($part) use ($data) {
                    $str = trim($part, '/ ');
            
                    switch ($str) {
                        case ':backend': return config('backend.path', '');
                        case ':controller': return $controller;
                        case ':route': return $route;
                    }

                    $param = preg_match('/^{(\w+)}$/', $part, $matches);

                    if ($param && $data) {
                        return data_get($data, $matches[1], '');
                    }

                    return $part;
                })
                ->filter(fn ($part) => trim($part) !== '')
                ->implode('/')
        );
    }
}
