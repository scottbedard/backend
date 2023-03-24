<?php

namespace Bedard\Backend\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        // $user = auth()->user();

        // if (!$user) {
        //     // return redirect(config('backend.guest_redirect'));
        // }
        
        return $next($request);
    }
}
