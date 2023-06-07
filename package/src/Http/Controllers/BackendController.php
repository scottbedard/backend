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
     * @param \Illuminate\Http\Request $request
     * @param ?string $controller
     * @param ?string $routeName
     */
    public function route(Request $request, ?string $controller = null, ?string $route = null, ?string $params = null)
    {
        // redirect users who aren't authenticated
        $user = auth()->user();

        if (!$user) {
            return redirect(config('backend.guest_redirect'));
        }

        $backend = Backend::create(config('backend.backend_directories'));
        
        $routeConfig = $backend->route($controller, $route);

        dd($routeConfig);

        // // find the route
        // $id = $controller === null
        //     ? null
        //     : ($route === null
        //         ? "backend.{$controller}"
        //         : "backend.{$controller}.{$route}");

        // $route = Backend::route($id);

        // // ensure user has permission to access the route
        // foreach ($route->get('permissions', []) as $permission) {
        //     if ($permission) {
        //         dd('perm', $permission);
        //     }
        //     if (!$user->can($permission)) {
        //         return redirect(config('backend.unauthorized_redirect'));
        //     }
        // }

        // if ($request->method() === 'GET') {
        //     return $route->plugin()->render($request);
        // }

        // throw new \Exception('Not implemented yet');
    }
}
