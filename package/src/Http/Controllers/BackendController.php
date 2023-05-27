<?php

namespace Bedard\Backend\Http\Controllers;

use Bedard\Backend\Facades\Backend;
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
    public function route(Request $request, ?string $controller = null, ?string $route = null)
    {
        // redirect users who aren't authenticated
        $user = auth()->user();

        if (!$user) {
            return redirect(config('backend.guest_redirect'));
        }

        $id = $controller === null
            ? null
            : ($route === null
                ? "backend.{$controller}"
                : "backend.{$controller}.{$route}");
            
        $route = Backend::route($id);

        // redirect users who lack authorization
        $permissions = $route->get('permissions');

        if ($request->method() === 'GET') {
            return $route->plugin()->render($request);
        }

        throw new \Exception('Not implemented yet');
    }
}
