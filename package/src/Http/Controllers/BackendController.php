<?php

namespace Bedard\Backend\Http\Controllers;

use Backend;
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
        dd(Backend::resourceConfig());
    }
}