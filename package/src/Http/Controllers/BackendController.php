<?php

namespace Bedard\Backend\Http\Controllers;

// use Bedard\Backend\Facades\Backend;
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
     */
    public function handle(Request $request)
    {
        // $route = Backend::route($request->route()->getName());
        
        // if ($request->method() === 'GET') {
        //     return $route->plugin()->render($request);
        // }

        throw new \Exception('Not implemented yet');
    }
}
