<?php

namespace Bedard\Backend\Http\Middleware;

use Bedard\Backend\Facades\Backend as BackendFacade;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class Backend
{
    /**
     * Ensure user has access to the backend.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect(config('backend.guest_redirect'));
        }
        
        $controllers = BackendFacade::controllers();

        $routeName = Str::of($request->route()->getName())->ltrim('backend.')->toString();

        if ($routeName === 'index' && !BackendFacade::check($user)) {
            return redirect(config('backend.unauthorized_redirect'));
        }

        if ($routeName === 'index') {
            if (!BackendFacade::check($user)) {
                return redirect(config('backend.unauthorized_redirect'));
            }

            return $next($request);
        }
        
        list($namespace, $method) = explode('.', $routeName);

        $config = BackendFacade::config($routeName);

        $permissions = array_merge($config['permissions'], data_get($controllers, "{$namespace}.permissions", []));

        if (!BackendFacade::check($user, $permissions)) {
            return redirect(config('backend.unauthorized_redirect'));
        }

        return $next($request);
    }
}
