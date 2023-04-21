<?php

namespace Bedard\Backend\Classes;

use Illuminate\Support\Facades\Route;

class Href
{
    /**
     * Format href
     *
     * @param string $to
     * @param string|null $controller
     *
     * @return string
     */
    public static function format(string $to, string $controller = null): string
    {
        if (Route::has($to)) {
            return route($to);
        }

        $to = str($to)->replace('{backend}', str(config('backend.path'))->trim('/'));

        if (is_string($controller)) {
            $to = str($to)->replace('{controller}', $controller);
        }

        return $to;
    }
}