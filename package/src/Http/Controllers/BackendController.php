<?php

namespace Bedard\Backend\Http\Controllers;

use Bedard\Backend\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BackendController extends Controller
{
    /**
     * Backend single page application
     *
     * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
        return 'Hello from the backend!';
    }
}