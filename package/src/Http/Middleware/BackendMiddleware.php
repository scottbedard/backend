<?php

namespace Bedard\Backend\Http\Middleware;

use Backend;
use Closure;
use Illuminate\Support\Facades\Auth;

class BackendMiddleware
{
    /**
     * Ensure users have permission to access backend routes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect(config('backend.guest_redirect'));
        }

        if (!Backend::check($user)) {
            return redirect(config('backend.unauthorized_redirect'));
        }

        // if ($user->backendPermissions()->count() === 0) {
        //     return redirect(config('backend.unauthorized_redirect'));
        // }

        return $next($request);
    }
}