<?php

namespace Bedard\Backend\Classes;

use Illuminate\Support\Facades\Route;

class Href
{
    /**
     * Format href
     *
     * @param string|null $to
     * @param string|null $controller
     *
     * @return ?string
     */
    public static function format(string $to = null, string $controller = null): ?string
    {
        if ($to === null) {
            return null;
        }

        if (Route::has($to)) {
            return route($to);
        }

        $to = str($to)->replace('{backend}', str(config('backend.path'))->trim('/'));

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