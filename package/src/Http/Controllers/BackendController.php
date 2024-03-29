<?php

namespace Bedard\Backend\Http\Controllers;

use Bedard\Backend\Config\Backend;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BackendController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Handle a backend request
     *
     * @param  \Illuminate\Http\Request  $req
     * @param  ?string  $controller
     * @param  ?string  $routeName
     */
    public function route(Request $req, ?string $controllerOrRoute = null, ?string $route = null)
    {
        // redirect users who aren't authenticated
        $user = auth()->user();

        if (!$user) {
            return redirect(config('backend.guest_redirect'));
        }

        $backend = Backend::create(config('backend.backend_directories'));

        if ($backend->currentRoute) {
            return $backend->currentRoute->plugin->handle($req);
        }

        throw new \Exception('Backend 404: ' . ($controllerOrRoute ?: '-') . ' . ' . ($route ?: '-'));
    }
}
