<?php

namespace Bedard\Backend\Http\Controllers;

use Bedard\Backend\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    /**
     * Backend single page application
     *
     * @param \Illuminate\Http\Request $request
     * @param string $route
     */
    public function show(Request $request, string $route)
    {
        return view('backend::resources-show');
    }
}
