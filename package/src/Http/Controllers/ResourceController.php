<?php

namespace Bedard\Backend\Http\Controllers;

use Bedard\Backend\Backend;
use Bedard\Backend\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    /**
     * Backend single page application
     *
     * @param \Illuminate\Http\Request $request
     * @param string $route
     */
    public function show(Request $request, string $route)
    {
        $resource = Backend::resources()->first(function ($value) use ($route) {
            return strtolower(trim($value['route'])) === strtolower(trim($route));
        });

        dd(config('backend.user'));

        $permission = \App\Models\User::query()->hasBackendPermission('foo', 'bar');
    }
}
